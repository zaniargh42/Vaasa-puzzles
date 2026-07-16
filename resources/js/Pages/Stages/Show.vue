<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CopyableCode from '@/Components/CopyableCode.vue';
import HistoricMapAligner from '@/Components/maps/HistoricMapAligner.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import PuzzleSuccessOverlay from '@/Components/PuzzleSuccessOverlay.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useI18n } from '@/composables/useI18n';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    city: {
        type: Object,
        required: true,
    },
    game: {
        type: Object,
        required: true,
    },
    stage: {
        type: Object,
        required: true,
    },
    progress: {
        type: Object,
        required: true,
    },
    navigation: {
        type: Object,
        required: true,
    },
    bag: {
        type: Array,
        default: () => [],
    },
    stage1: {
        type: Object,
        default: null,
    },
    code_unlocked: {
        type: Boolean,
        default: true,
    },
    directions: {
        type: Object,
        default: null,
    },
});

const { t } = useI18n();
const page = usePage();

const form = useForm({
    code: '',
});

const collectForm = useForm({});
const alignForm = useForm({
    center_lat: 0,
    center_lng: 0,
    rotation_deg: 0,
    width_meters: 0,
});

const currentPlacement = ref(null);
const showSuccessEffect = ref(false);

const actLabel = computed(() => t(`stages.acts.${props.stage.act}`));

const stageUrl = (order) =>
    `/cities/${props.city.slug}/games/${props.game.slug}/stages/${order}`;

const previousStageUrl = computed(() =>
    props.navigation.previous_stage
        ? stageUrl(props.navigation.previous_stage)
        : null,
);

const nextStageUrl = computed(() =>
    props.navigation.next_stage
        ? stageUrl(props.navigation.next_stage)
        : null,
);

const currentStageUrl = computed(() => stageUrl(props.progress.current));

const isStage1 = computed(() => props.stage.order === 1 && props.stage1);

const alignmentError = computed(
    () => page.props.errors?.alignment ?? null,
);

const directionsLabel = computed(() => {
    if (! props.directions?.label_key) {
        return null;
    }

    return t(props.directions.label_key);
});

const collectMap = () => {
    collectForm.post(
        `/cities/${props.city.slug}/games/${props.game.slug}/bag/setterberg-plan`,
        { preserveScroll: true },
    );
};

const onPlacementUpdate = (placement) => {
    currentPlacement.value = placement;
};

const submitAlignment = (placement = currentPlacement.value) => {
    if (! placement || alignForm.processing) {
        return;
    }

    alignForm.center_lat = placement.center_lat;
    alignForm.center_lng = placement.center_lng;
    alignForm.rotation_deg = placement.rotation_deg;
    alignForm.width_meters = placement.width_meters;

    alignForm.post(
        `/cities/${props.city.slug}/games/${props.game.slug}/puzzles/stage1/align`,
        { preserveScroll: true },
    );
};

const onAlignmentLocked = (placement) => {
    currentPlacement.value = placement;
    showSuccessEffect.value = true;
    submitAlignment(placement);
};

const submitCode = () => {
    form.post(
        `/cities/${props.city.slug}/games/${props.game.slug}/stages/${props.stage.order}`,
        {
            preserveScroll: true,
            onSuccess: () => form.reset('code'),
        },
    );
};
</script>

<template>
    <AppLayout
        :title="stage.title"
        :subtitle="stage.location"
        :bag="bag"
        :wide="Boolean(isStage1)"
    >
        <PuzzleSuccessOverlay :show="showSuccessEffect" />

        <p class="mb-4 text-sm text-stone-500">
            <Link href="/cities" class="hover:text-stone-800">
                {{ t('nav.cities') }}
            </Link>
            <span class="mx-2">/</span>
            <Link
                :href="`/cities/${city.slug}`"
                class="hover:text-stone-800"
            >
                {{ city.name }}
            </Link>
            <span class="mx-2">/</span>
            <Link
                :href="`/cities/${city.slug}/games/${game.slug}`"
                class="hover:text-stone-800"
            >
                {{ game.title }}
            </Link>
        </p>

        <div class="mb-6 flex items-center justify-between text-sm text-stone-500">
            <span>{{ actLabel }}</span>
            <span dir="ltr">
                {{ progress.current }} / {{ progress.total }}
            </span>
        </div>

        <a
            v-if="directions"
            :href="directions.directions_url"
            target="_blank"
            rel="noopener noreferrer"
            class="mb-4 flex items-center justify-between gap-3 rounded-xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-900 transition hover:bg-sky-100"
        >
            <span>
                <span class="font-medium">{{ t('stages.directions') }}</span>
                <span v-if="directionsLabel"> — {{ directionsLabel }}</span>
            </span>
            <span class="shrink-0 text-xs font-semibold uppercase tracking-wide text-sky-700">
                {{ t('stages.open_maps') }}
            </span>
        </a>

        <div class="space-y-6 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-medium text-stone-500">
                        {{ t('stages.stage', { order: stage.order }) }}
                    </p>
                    <h2 class="mt-1 text-xl font-semibold text-stone-900">
                        {{ stage.title }}
                    </h2>
                    <p class="mt-1 text-sm text-stone-600">
                        {{ stage.location }}
                    </p>
                </div>

                <div
                    v-if="previousStageUrl || nextStageUrl"
                    class="flex flex-wrap gap-2"
                >
                    <Link v-if="previousStageUrl" :href="previousStageUrl">
                        <SecondaryButton type="button">
                            {{ t('stages.previous') }}
                        </SecondaryButton>
                    </Link>
                    <Link v-if="nextStageUrl" :href="nextStageUrl">
                        <SecondaryButton type="button">
                            {{ t('stages.next') }}
                        </SecondaryButton>
                    </Link>
                </div>
            </div>

            <p
                v-if="navigation.is_review"
                class="rounded-lg bg-blue-50 px-4 py-3 text-sm text-blue-800"
            >
                {{ t('stages.review_note') }}
            </p>

            <div class="leading-8 text-stone-700 whitespace-pre-line">
                {{ stage.intro_text }}
            </div>

            <aside
                v-if="stage.puzzle_note"
                class="rounded-xl border border-amber-300 bg-amber-50 px-4 py-4 text-sm leading-7 text-amber-950"
                dir="rtl"
            >
                <p class="mb-2 text-xs font-semibold tracking-wide text-amber-800 uppercase">
                    {{ t('stages.dev_puzzle_title') }}
                </p>
                <p class="mb-3 text-xs text-amber-700">
                    {{ t('stages.dev_puzzle_hint') }}
                </p>
                <div class="whitespace-pre-line">
                    {{ stage.puzzle_note }}
                </div>
            </aside>

            <section
                v-if="isStage1 && ! navigation.is_review"
                class="space-y-4 border-t border-stone-100 pt-6"
            >
                <div>
                    <h3 class="text-base font-semibold text-stone-900">
                        {{ t('stage1.part1_title') }}
                    </h3>
                    <p class="mt-1 text-sm leading-7 text-stone-600">
                        {{ t('stage1.part1_help') }}
                    </p>
                </div>

                <div
                    v-if="! stage1.has_map"
                    class="flex flex-wrap items-center gap-3"
                >
                    <img
                        :src="stage1.image"
                        alt=""
                        class="h-24 w-32 rounded border border-stone-200 object-cover"
                    />
                    <PrimaryButton
                        type="button"
                        :disabled="collectForm.processing"
                        @click="collectMap"
                    >
                        {{ t('stage1.add_to_bag') }}
                    </PrimaryButton>
                </div>
                <p
                    v-else
                    class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800"
                >
                    {{ t('stage1.map_in_bag') }}
                </p>

                <div v-if="stage1.has_map && ! stage1.aligned" class="space-y-3">
                    <div>
                        <h3 class="text-base font-semibold text-stone-900">
                            {{ t('stage1.part2_title') }}
                        </h3>
                        <p class="mt-1 text-sm leading-7 text-stone-600">
                            {{ t('stage1.part2_help') }}
                        </p>
                    </div>

                    <HistoricMapAligner
                        :image-url="stage1.image"
                        :tile-url="stage1.map.tile_url"
                        :attribution="stage1.map.attribution"
                        :initial="stage1.initial"
                        :target="stage1.target"
                        :tolerance="stage1.tolerance"
                        auto-snap
                        :show-debug="false"
                        @update:placement="onPlacementUpdate"
                        @locked="onAlignmentLocked"
                    />

                    <InputError :message="alignmentError" />
                </div>

                <div v-if="stage1.aligned" class="space-y-3">
                    <p class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800">
                        {{ t('stage1.align_success') }}
                    </p>

                    <div class="flex flex-wrap gap-3 text-xs text-stone-600">
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
                        mode="locked"
                        :image-url="stage1.image"
                        :tile-url="stage1.map.tile_url"
                        :attribution="stage1.map.attribution"
                        :initial="{ ...stage1.target, opacity: 0.7 }"
                        :target="stage1.target"
                        :markers="stage1.markers"
                        :show-preview="false"
                        :show-debug="false"
                    />

                    <p class="text-sm text-stone-500">
                        {{ t('stage1.overlay_in_bag') }}
                    </p>
                </div>
            </section>

            <template v-if="code_unlocked">
                <CopyableCode :code="stage.code" />

                <p
                    v-if="stage.next_destination"
                    class="rounded-lg border border-orange-200 bg-orange-50 px-4 py-3 text-sm text-orange-950"
                >
                    {{ t('stages.next_destination', { name: stage.next_destination }) }}
                </p>
            </template>
            <p
                v-else
                class="rounded-lg bg-stone-50 px-4 py-3 text-sm text-stone-600"
            >
                {{ t('stage1.code_locked') }}
            </p>

            <div
                v-if="navigation.is_review"
                class="border-t border-stone-100 pt-6"
            >
                <Link :href="currentStageUrl">
                    <PrimaryButton type="button">
                        {{ t('stages.return_current') }}
                    </PrimaryButton>
                </Link>
            </div>

            <form
                v-else-if="code_unlocked"
                class="space-y-4 border-t border-stone-100 pt-6"
                @submit.prevent="submitCode"
            >
                <div>
                    <label
                        for="code"
                        class="mb-2 block text-sm font-medium text-stone-700"
                    >
                        {{ t('stages.code_input') }}
                    </label>
                    <TextInput
                        id="code"
                        v-model="form.code"
                        type="text"
                        class="mt-1 block w-full font-mono"
                        dir="ltr"
                        autocomplete="off"
                        :placeholder="t('stages.code_placeholder')"
                    />
                    <InputError class="mt-2" :message="form.errors.code" />
                </div>

                <PrimaryButton :disabled="form.processing">
                    {{
                        stage.order === progress.total
                            ? t('stages.submit_finish')
                            : t('stages.submit_next')
                    }}
                </PrimaryButton>
            </form>
        </div>
    </AppLayout>
</template>
