<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useI18n } from '@/composables/useI18n';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    city: {
        type: Object,
        required: true,
    },
    game: {
        type: Object,
        required: true,
    },
});

const { t } = useI18n();
const form = useForm({});

const restartGame = () => {
    form.post(`/cities/${props.city.slug}/games/${props.game.slug}/reset`);
};
</script>

<template>
    <AppLayout
        :title="t('games.complete.title')"
        :subtitle="`${game.title} — ${city.name}`"
    >
        <div class="space-y-6 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-lg font-semibold text-stone-900">
                {{ t('games.complete.congrats') }}
            </p>

            <div class="leading-8 text-stone-700 whitespace-pre-line">
                <p>
                    {{ t('games.complete.truth') }}
                    <span class="font-mono text-sm" dir="ltr">
                        {{ t('games.complete.truth_code') }}
                    </span>
                </p>
                <p class="mt-4">
                    {{ t('games.complete.summary') }}
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <Link :href="`/cities/${city.slug}`">
                    <PrimaryButton>{{ t('games.complete.back') }}</PrimaryButton>
                </Link>
                <SecondaryButton :disabled="form.processing" @click="restartGame">
                    {{ t('games.complete.restart') }}
                </SecondaryButton>
            </div>
        </div>
    </AppLayout>
</template>
