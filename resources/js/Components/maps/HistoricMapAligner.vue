<script setup>
import { useI18n } from '@/composables/useI18n';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';

const props = defineProps({
    imageUrl: {
        type: String,
        required: true,
    },
    tileUrl: {
        type: String,
        required: true,
    },
    attribution: {
        type: String,
        default: '',
    },
    initial: {
        type: Object,
        required: true,
    },
    mode: {
        type: String,
        default: 'puzzle', // puzzle | calibrate | locked
    },
    target: {
        type: Object,
        default: null,
    },
    tolerance: {
        type: Object,
        default: null,
    },
    autoSnap: {
        type: Boolean,
        default: false,
    },
    showPreview: {
        type: Boolean,
        default: true,
    },
    showDebug: {
        type: Boolean,
        default: true,
    },
    compact: {
        type: Boolean,
        default: false,
    },
    markers: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['update:placement', 'locked']);

const { t } = useI18n();

const IMAGE_ASPECT = 756 / 1024;

const isLockedMode = computed(
    () => props.mode === 'locked' || locked.value,
);

const locked = ref(props.mode === 'locked');
const hasSnapped = ref(props.mode === 'locked');

const placement = ref({
    center_lat: Number(
        props.mode === 'locked' && props.target
            ? props.target.center_lat
            : props.initial.center_lat,
    ),
    center_lng: Number(
        props.mode === 'locked' && props.target
            ? props.target.center_lng
            : props.initial.center_lng,
    ),
    rotation_deg: Number(
        props.mode === 'locked' && props.target
            ? props.target.rotation_deg
            : props.initial.rotation_deg,
    ),
    width_meters: Number(
        props.mode === 'locked' && props.target
            ? props.target.width_meters
            : props.initial.width_meters,
    ),
    opacity: Number(props.initial.opacity ?? 0.7),
});

const mapEl = ref(null);

let map = null;
let overlayRoot = null;
let overlayImg = null;
let markerLayer = null;
let dragging = false;
let dragStart = null;

const corners = computed(() => computeCorners(placement.value));

const liveMatch = computed(() => {
    if (! props.target || ! props.tolerance || isLockedMode.value) {
        return null;
    }

    return evaluateMatch(placement.value, props.target, props.tolerance);
});

onMounted(async () => {
    await nextTick();

    map = L.map(mapEl.value, {
        zoomControl: true,
        attributionControl: true,
    }).setView(
        [placement.value.center_lat, placement.value.center_lng],
        15,
    );

    L.tileLayer(props.tileUrl, {
        attribution: props.attribution,
        maxZoom: 19,
    }).addTo(map);

    const pane = map.getPanes().overlayPane;
    overlayRoot = L.DomUtil.create(
        'div',
        'leaflet-zoom-animated historic-overlay-root',
        pane,
    );
    overlayImg = L.DomUtil.create('img', 'historic-map-overlay', overlayRoot);
    overlayImg.src = props.imageUrl;
    overlayImg.alt = 'Setterberg plan';
    overlayImg.draggable = false;

    Object.assign(overlayRoot.style, {
        position: 'absolute',
        top: '0',
        left: '0',
        width: '0',
        height: '0',
        zIndex: '500',
    });

    Object.assign(overlayImg.style, {
        position: 'absolute',
        left: '0',
        top: '0',
        transformOrigin: 'center center',
        cursor: isLockedMode.value ? 'default' : 'grab',
        userSelect: 'none',
        pointerEvents: isLockedMode.value ? 'none' : 'auto',
        border: isLockedMode.value
            ? '2px solid #15803d'
            : '2px solid #b45309',
        boxShadow: '0 0 0 1px rgba(0,0,0,0.35)',
        maxWidth: 'none',
    });

    overlayImg.addEventListener('pointerdown', onPointerDown);
    window.addEventListener('pointermove', onPointerMove);
    window.addEventListener('pointerup', onPointerUp);

    overlayImg.addEventListener('load', () => {
        syncOverlay();
        map.invalidateSize();
    });

    map.on('zoom move zoomend viewreset', syncOverlay);

    // Above historic image overlay so bag/stage markers stay visible.
    if (! map.getPane('stageMarkers')) {
        const pane = map.createPane('stageMarkers');
        pane.style.zIndex = '650';
        pane.style.pointerEvents = 'none';
    }
    markerLayer = L.layerGroup([], { pane: 'stageMarkers' }).addTo(map);
    renderMarkers();

    const refreshMap = () => {
        map?.invalidateSize();
        syncOverlay();
        renderMarkers();
        fitMarkersIfNeeded();
    };

    requestAnimationFrame(() => {
        refreshMap();
        emitPlacement();
    });

    setTimeout(refreshMap, 150);
    setTimeout(refreshMap, 400);
});

onBeforeUnmount(() => {
    if (overlayImg) {
        overlayImg.removeEventListener('pointerdown', onPointerDown);
    }
    window.removeEventListener('pointermove', onPointerMove);
    window.removeEventListener('pointerup', onPointerUp);
    markerLayer?.clearLayers();
    overlayRoot?.remove();
    map?.remove();
    map = null;
    overlayRoot = null;
    overlayImg = null;
    markerLayer = null;
});

watch(
    () => props.markers,
    () => {
        renderMarkers();
        fitMarkersIfNeeded();
    },
    { deep: true },
);

watch(
    placement,
    () => {
        syncOverlay();
        emitPlacement();
    },
    { deep: true },
);

watch(liveMatch, (match) => {
    if (
        ! props.autoSnap ||
        hasSnapped.value ||
        ! match?.ok ||
        ! props.target
    ) {
        return;
    }

    snapToTarget();
});

function snapToTarget() {
    if (! props.target || hasSnapped.value) {
        return;
    }

    hasSnapped.value = true;
    locked.value = true;

    placement.value = {
        ...placement.value,
        center_lat: Number(props.target.center_lat),
        center_lng: Number(props.target.center_lng),
        rotation_deg: Number(props.target.rotation_deg),
        width_meters: Number(props.target.width_meters),
    };

    if (overlayImg) {
        overlayImg.style.cursor = 'default';
        overlayImg.style.pointerEvents = 'none';
        overlayImg.style.border = '2px solid #15803d';
    }

    if (map) {
        map.panTo([
            placement.value.center_lat,
            placement.value.center_lng,
        ]);
    }

    renderMarkers();
    fitMarkersIfNeeded();

    emit('locked', {
        center_lat: placement.value.center_lat,
        center_lng: placement.value.center_lng,
        rotation_deg: placement.value.rotation_deg,
        width_meters: placement.value.width_meters,
    });
}

function renderMarkers() {
    if (! map || ! markerLayer) {
        return;
    }

    markerLayer.clearLayers();

    (props.markers || []).forEach((marker) => {
        const style = marker.style === 'next' ? 'next' : 'done';
        const icon = L.divIcon({
            className: 'stage-marker-wrap',
            html: `<div class="stage-marker stage-marker--${style}"></div>`,
            iconSize: [22, 22],
            iconAnchor: [11, 11],
        });

        L.marker([marker.lat, marker.lng], {
            icon,
            pane: 'stageMarkers',
            interactive: false,
            keyboard: false,
            zIndexOffset: 1000,
        }).addTo(markerLayer);
    });
}

function fitMarkersIfNeeded() {
    if (! map || ! props.markers?.length || ! isLockedMode.value) {
        return;
    }

    const bounds = L.latLngBounds(
        props.markers.map((marker) => [marker.lat, marker.lng]),
    );

    map.fitBounds(bounds.pad(0.35), { maxZoom: 16, animate: true });
}

function emitPlacement() {
    emit('update:placement', { ...placement.value, corners: corners.value });
}

function onPointerDown(event) {
    if (! map || isLockedMode.value) {
        return;
    }

    dragging = true;
    overlayImg.style.cursor = 'grabbing';
    const centerPoint = map.latLngToContainerPoint([
        placement.value.center_lat,
        placement.value.center_lng,
    ]);
    dragStart = {
        x: event.clientX,
        y: event.clientY,
        centerX: centerPoint.x,
        centerY: centerPoint.y,
    };
    event.preventDefault();
    event.stopPropagation();
}

function onPointerMove(event) {
    if (! dragging || ! map || ! dragStart || isLockedMode.value) {
        return;
    }

    const dx = event.clientX - dragStart.x;
    const dy = event.clientY - dragStart.y;
    const next = map.containerPointToLatLng([
        dragStart.centerX + dx,
        dragStart.centerY + dy,
    ]);

    placement.value.center_lat = Number(next.lat.toFixed(7));
    placement.value.center_lng = Number(next.lng.toFixed(7));
}

function onPointerUp() {
    dragging = false;
    if (overlayImg && ! isLockedMode.value) {
        overlayImg.style.cursor = 'grab';
    }
    dragStart = null;
}

function syncOverlay() {
    if (! map || ! overlayRoot || ! overlayImg) {
        return;
    }

    const center = L.latLng(
        placement.value.center_lat,
        placement.value.center_lng,
    );
    const point = map.latLngToLayerPoint(center);
    const metersPerPixel =
        (40075016.686 * Math.cos((center.lat * Math.PI) / 180)) /
        Math.pow(2, map.getZoom() + 8);

    if (! Number.isFinite(metersPerPixel) || metersPerPixel <= 0) {
        return;
    }

    const widthPx = Math.max(40, placement.value.width_meters / metersPerPixel);
    const heightPx = widthPx * IMAGE_ASPECT;

    L.DomUtil.setPosition(overlayRoot, point);

    overlayImg.style.width = `${widthPx}px`;
    overlayImg.style.height = `${heightPx}px`;
    overlayImg.style.opacity = String(placement.value.opacity);
    overlayImg.style.transform = `translate(-50%, -50%) rotate(${placement.value.rotation_deg}deg)`;
}

function computeCorners(p) {
    const halfW = p.width_meters / 2;
    const halfH = (p.width_meters * IMAGE_ASPECT) / 2;
    const rad = (p.rotation_deg * Math.PI) / 180;
    const cos = Math.cos(rad);
    const sin = Math.sin(rad);

    const cornersLocal = [
        { key: 'nw', x: -halfW, y: halfH },
        { key: 'ne', x: halfW, y: halfH },
        { key: 'se', x: halfW, y: -halfH },
        { key: 'sw', x: -halfW, y: -halfH },
    ];

    const metersPerDegLat = 111320;
    const metersPerDegLng = 111320 * Math.cos((p.center_lat * Math.PI) / 180);

    return Object.fromEntries(
        cornersLocal.map(({ key, x, y }) => {
            const east = x * cos - y * sin;
            const north = x * sin + y * cos;

            return [
                key,
                {
                    lat: Number((p.center_lat + north / metersPerDegLat).toFixed(7)),
                    lng: Number((p.center_lng + east / metersPerDegLng).toFixed(7)),
                },
            ];
        }),
    );
}

function evaluateMatch(p, target, tolerance) {
    const centerMeters = haversineMeters(
        p.center_lat,
        p.center_lng,
        target.center_lat,
        target.center_lng,
    );
    const rotationDelta = Math.abs(
        normalizeAngle(p.rotation_deg - target.rotation_deg),
    );
    const widthRatio = Math.abs(
        (p.width_meters - target.width_meters) / target.width_meters,
    );

    return {
        centerMeters: Math.round(centerMeters),
        rotationDelta: Number(rotationDelta.toFixed(1)),
        widthRatio: Number((widthRatio * 100).toFixed(1)),
        ok:
            centerMeters <= tolerance.center_meters &&
            rotationDelta <= tolerance.rotation_deg &&
            widthRatio <= tolerance.width_ratio,
    };
}

function haversineMeters(lat1, lng1, lat2, lng2) {
    const r = 6371000;
    const dLat = ((lat2 - lat1) * Math.PI) / 180;
    const dLng = ((lng2 - lng1) * Math.PI) / 180;
    const a =
        Math.sin(dLat / 2) ** 2 +
        Math.cos((lat1 * Math.PI) / 180) *
            Math.cos((lat2 * Math.PI) / 180) *
            Math.sin(dLng / 2) ** 2;

    return 2 * r * Math.asin(Math.min(1, Math.sqrt(a)));
}

function normalizeAngle(degrees) {
    const n = ((((degrees + 180) % 360) + 360) % 360);

    return n - 180;
}

function nudge(latDelta, lngDelta) {
    if (isLockedMode.value) {
        return;
    }

    placement.value.center_lat = Number(
        (placement.value.center_lat + latDelta).toFixed(7),
    );
    placement.value.center_lng = Number(
        (placement.value.center_lng + lngDelta).toFixed(7),
    );
}

defineExpose({
    placement,
    corners,
    liveMatch,
});
</script>

<style>
.stage-marker-wrap {
    background: transparent;
    border: 0;
}

.leaflet-div-icon.stage-marker-wrap {
    background: transparent !important;
    border: 0 !important;
}

.stage-marker {
    width: 18px;
    height: 18px;
    border-radius: 9999px;
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.45);
}

.stage-marker--done {
    background: #78716c;
}

.stage-marker--next {
    background: #c2410c;
    animation: stage-marker-blink 1s ease-in-out infinite;
}

@keyframes stage-marker-blink {
    0%,
    100% {
        transform: scale(1);
        opacity: 1;
        box-shadow:
            0 0 0 1px rgba(0, 0, 0, 0.35),
            0 0 0 0 rgba(194, 65, 12, 0.55);
    }
    50% {
        transform: scale(1.35);
        opacity: 0.7;
        box-shadow:
            0 0 0 1px rgba(0, 0, 0, 0.35),
            0 0 0 10px rgba(194, 65, 12, 0);
    }
}
</style>

<template>
    <div class="space-y-4">
        <div
            v-if="showPreview && ! isLockedMode"
            class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 p-3"
            dir="ltr"
        >
            <img
                :src="imageUrl"
                alt="Setterberg plan preview"
                class="h-28 w-auto rounded border border-amber-300 bg-white object-contain"
            />
            <p class="text-sm leading-6 text-amber-950">
                {{ t('stage1.align_hint') }}
            </p>
        </div>

        <div
            ref="mapEl"
            class="relative z-0 w-full overflow-hidden rounded-xl border border-stone-300 bg-stone-200"
            :class="compact ? 'h-[320px]' : 'h-[480px]'"
            dir="ltr"
        />

        <div class="grid gap-3 sm:grid-cols-2" dir="ltr">
            <template v-if="! isLockedMode">
                <label class="text-sm text-stone-700">
                    <span class="mb-1 block font-medium">{{ t('stage1.rotation') }}</span>
                    <input
                        v-model.number="placement.rotation_deg"
                        type="range"
                        min="-180"
                        max="180"
                        step="0.5"
                        class="w-full"
                    />
                    <input
                        v-model.number="placement.rotation_deg"
                        type="number"
                        step="0.5"
                        class="mt-1 w-full rounded border-stone-300 text-sm"
                    />
                </label>

                <label class="text-sm text-stone-700">
                    <span class="mb-1 block font-medium">{{ t('stage1.width') }}</span>
                    <input
                        v-model.number="placement.width_meters"
                        type="range"
                        min="800"
                        max="6000"
                        step="10"
                        class="w-full"
                    />
                    <input
                        v-model.number="placement.width_meters"
                        type="number"
                        step="10"
                        class="mt-1 w-full rounded border-stone-300 text-sm"
                    />
                </label>
            </template>

            <label class="text-sm text-stone-700" :class="isLockedMode ? 'sm:col-span-2' : ''">
                <span class="mb-1 block font-medium">{{ t('stage1.opacity') }}</span>
                <input
                    v-model.number="placement.opacity"
                    type="range"
                    min="0.1"
                    max="1"
                    step="0.05"
                    class="w-full"
                />
            </label>

            <div v-if="! isLockedMode" class="text-sm text-stone-700">
                <span class="mb-1 block font-medium">{{ t('stage1.nudge') }}</span>
                <div class="flex flex-wrap gap-2">
                    <button
                        type="button"
                        class="rounded bg-stone-200 px-2 py-1"
                        @click="nudge(0.0003, 0)"
                    >
                        N
                    </button>
                    <button
                        type="button"
                        class="rounded bg-stone-200 px-2 py-1"
                        @click="nudge(-0.0003, 0)"
                    >
                        S
                    </button>
                    <button
                        type="button"
                        class="rounded bg-stone-200 px-2 py-1"
                        @click="nudge(0, 0.0006)"
                    >
                        E
                    </button>
                    <button
                        type="button"
                        class="rounded bg-stone-200 px-2 py-1"
                        @click="nudge(0, -0.0006)"
                    >
                        W
                    </button>
                </div>
            </div>
        </div>

        <div
            v-if="showDebug && ! isLockedMode"
            class="rounded-lg bg-stone-50 p-3 font-mono text-xs leading-6 text-stone-700"
            dir="ltr"
        >
            <div>
                center: {{ placement.center_lat }}, {{ placement.center_lng }}
            </div>
            <div>rotation_deg: {{ placement.rotation_deg }}</div>
            <div>width_meters: {{ placement.width_meters }}</div>
            <div v-for="(corner, key) in corners" :key="key">
                {{ key }}: {{ corner.lat }}, {{ corner.lng }}
            </div>
            <div v-if="liveMatch" class="mt-2 text-stone-900">
                delta: {{ liveMatch.centerMeters }}m /
                {{ liveMatch.rotationDelta }}° /
                {{ liveMatch.widthRatio }}%
                <span :class="liveMatch.ok ? 'text-green-700' : 'text-amber-700'">
                    ({{ liveMatch.ok ? 'snapping…' : 'not yet' }})
                </span>
            </div>
        </div>
    </div>
</template>
