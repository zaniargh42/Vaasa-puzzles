<script setup>
import HistoricMapAligner from '@/Components/maps/HistoricMapAligner.vue';
import { useI18n } from '@/composables/useI18n';
import { computed, ref } from 'vue';

const props = defineProps({
    items: {
        type: Array,
        default: () => [],
    },
});

const { t } = useI18n();
const open = ref(false);
const viewing = ref(null);

const count = computed(() => props.items.length);

const labelFor = (item) =>
    item.label_key ? t(item.label_key) : item.id;

const openOverlay = (item) => {
    viewing.value = item;
    open.value = false;
};

const closeOverlay = () => {
    viewing.value = null;
};
</script>

<template>
    <div class="relative">
        <button
            type="button"
            class="relative rounded-lg bg-stone-100 px-2.5 py-1 text-xs font-medium text-stone-700 hover:bg-stone-200"
            @click="open = ! open"
        >
            {{ t('bag.title') }}
            <span
                v-if="count"
                class="ms-1 inline-flex min-w-5 items-center justify-center rounded-full bg-stone-800 px-1 text-[10px] text-white"
            >
                {{ count }}
            </span>
        </button>

        <div
            v-if="open"
            class="absolute end-0 z-30 mt-2 w-80 rounded-xl border border-stone-200 bg-white p-3 shadow-lg"
        >
            <div class="mb-2 flex items-center justify-between">
                <p class="text-sm font-semibold text-stone-800">
                    {{ t('bag.title') }}
                </p>
                <button
                    type="button"
                    class="text-xs text-stone-500"
                    @click="open = false"
                >
                    {{ t('bag.close') }}
                </button>
            </div>

            <p v-if="! items.length" class="text-sm text-stone-500">
                {{ t('bag.empty') }}
            </p>

            <ul v-else class="space-y-3">
                <li
                    v-for="item in items"
                    :key="item.id"
                    class="rounded-lg border border-stone-100 p-2"
                >
                    <p class="mb-2 text-sm font-medium text-stone-800">
                        {{ labelFor(item) }}
                    </p>
                    <img
                        v-if="item.image"
                        :src="item.image"
                        :alt="labelFor(item)"
                        class="mb-2 h-28 w-full rounded object-cover"
                    />
                    <button
                        v-if="item.type === 'map_overlay' && item.placement"
                        type="button"
                        class="w-full rounded-lg bg-stone-800 px-3 py-2 text-xs font-medium text-white hover:bg-stone-700"
                        @click="openOverlay(item)"
                    >
                        {{ t('bag.view_overlay') }}
                    </button>
                </li>
            </ul>
        </div>

        <Teleport to="body">
            <div
                v-if="viewing"
                class="fixed inset-0 z-50 flex items-center justify-center bg-stone-900/50 p-4"
                @click.self="closeOverlay"
            >
                <div
                    class="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-2xl bg-white p-4 shadow-xl sm:p-6"
                >
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-semibold text-stone-900">
                            {{ labelFor(viewing) }}
                        </h3>
                        <button
                            type="button"
                            class="text-sm text-stone-500 hover:text-stone-800"
                            @click="closeOverlay"
                        >
                            {{ t('bag.close') }}
                        </button>
                    </div>

                    <p class="mb-4 text-sm text-stone-600">
                        {{ t('bag.overlay_help') }}
                    </p>

                    <div
                        v-if="viewing.markers?.length"
                        class="mb-3 flex flex-wrap gap-3 text-xs text-stone-600"
                    >
                        <span class="inline-flex items-center gap-2">
                            <span class="inline-block h-3 w-3 rounded-full bg-stone-500" />
                            {{ t('stage1.legend_done') }}
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <span class="inline-block h-3 w-3 animate-pulse rounded-full bg-orange-600" />
                            {{ t('stage1.legend_next') }}
                        </span>
                    </div>

                    <HistoricMapAligner
                        :key="`bag-overlay-${viewing.id}-${viewing.markers?.length || 0}`"
                        mode="locked"
                        :image-url="viewing.image"
                        :tile-url="viewing.map.tile_url"
                        :attribution="viewing.map.attribution"
                        :initial="{ ...viewing.placement, opacity: 0.55 }"
                        :target="viewing.placement"
                        :markers="viewing.markers || []"
                        :show-preview="false"
                        :show-debug="false"
                        compact
                    />
                </div>
            </div>
        </Teleport>
    </div>
</template>
