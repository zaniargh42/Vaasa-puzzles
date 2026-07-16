<script setup>
import HistoricMapAligner from '@/Components/maps/HistoricMapAligner.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useI18n } from '@/composables/useI18n';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    image: { type: String, required: true },
    map: { type: Object, required: true },
    initial: { type: Object, required: true },
    target: { type: Object, required: true },
    tolerance: { type: Object, required: true },
});

const { t } = useI18n();
const aligner = ref(null);
const copied = ref(false);

const exportJson = computed(() => {
    const p = aligner.value?.placement ?? props.initial;
    const corners = aligner.value?.corners ?? {};

    return JSON.stringify(
        {
            target: {
                center_lat: p.center_lat,
                center_lng: p.center_lng,
                rotation_deg: p.rotation_deg,
                width_meters: p.width_meters,
            },
            corners,
            note: 'Paste target into config/puzzles/stage1_setterberg.php',
        },
        null,
        2,
    );
});

const copyExport = async () => {
    await navigator.clipboard.writeText(exportJson.value);
    copied.value = true;
    setTimeout(() => {
        copied.value = false;
    }, 2000);
};
</script>

<template>
    <Head :title="t('calibrator.title')" />

    <div class="min-h-screen bg-stone-100 px-4 py-6 text-stone-900 sm:px-8" dir="ltr">
        <div class="mx-auto max-w-5xl space-y-4">
            <header class="space-y-2">
                <p class="text-xs font-semibold uppercase tracking-wide text-amber-700">
                    {{ t('calibrator.badge') }}
                </p>
                <h1 class="text-2xl font-bold">
                    {{ t('calibrator.title') }}
                </h1>
                <p class="max-w-3xl text-sm leading-7 text-stone-600">
                    {{ t('calibrator.help') }}
                </p>
            </header>

            <HistoricMapAligner
                ref="aligner"
                mode="calibrate"
                :image-url="image"
                :tile-url="map.tile_url"
                :attribution="map.attribution"
                :initial="initial"
                :target="target"
                :tolerance="tolerance"
            />

            <div class="flex flex-wrap gap-3">
                <PrimaryButton type="button" @click="copyExport">
                    {{
                        copied
                            ? t('calibrator.copied')
                            : t('calibrator.copy_json')
                    }}
                </PrimaryButton>
                <a href="/">
                    <SecondaryButton type="button">
                        {{ t('calibrator.back') }}
                    </SecondaryButton>
                </a>
            </div>

            <pre
                class="overflow-x-auto rounded-xl border border-stone-200 bg-white p-4 text-xs leading-6 text-stone-800"
            >{{ exportJson }}</pre>
        </div>
    </div>
</template>
