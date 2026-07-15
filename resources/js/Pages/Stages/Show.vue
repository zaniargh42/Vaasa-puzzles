<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CopyableCode from '@/Components/CopyableCode.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useI18n } from '@/composables/useI18n';
import { Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

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
});

const { t } = useI18n();

const form = useForm({
    code: '',
});

const actLabel = computed(() => t(`stages.acts.${props.stage.act}`));

const previousStageUrl = computed(() => {
    if (! props.navigation.previous_stage) {
        return null;
    }

    return `/cities/${props.city.slug}/games/${props.game.slug}/stages/${props.navigation.previous_stage}`;
});

const currentStageUrl = computed(() =>
    `/cities/${props.city.slug}/games/${props.game.slug}/stages/${props.progress.current}`,
);

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
    >
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

                <Link v-if="previousStageUrl" :href="previousStageUrl">
                    <SecondaryButton type="button">
                        {{ t('stages.previous') }}
                    </SecondaryButton>
                </Link>
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

            <CopyableCode :code="stage.code" />

            <p
                v-if="stage.next_destination"
                class="text-sm text-stone-500"
            >
                {{ t('stages.next_destination', { name: stage.next_destination }) }}
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
                v-else
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
