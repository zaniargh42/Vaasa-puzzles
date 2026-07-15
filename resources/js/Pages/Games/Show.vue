<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
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

const startGame = () => {
    form.post(`/cities/${props.city.slug}/games/${props.game.slug}/start`);
};
</script>

<template>
    <AppLayout
        :title="game.title"
        :subtitle="game.subtitle || game.description"
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
            <span>{{ game.title }}</span>
        </p>

        <div class="space-y-6 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <p
                v-if="game.description"
                class="leading-8 text-stone-700 whitespace-pre-line"
            >
                {{ game.description }}
            </p>

            <div class="rounded-xl bg-stone-50 p-4 text-sm leading-7 text-stone-600">
                {{ t('games.prototype_note', { count: game.stage_count }) }}
            </div>

            <PrimaryButton :disabled="form.processing" @click="startGame">
                {{ t('games.start') }}
            </PrimaryButton>
        </div>
    </AppLayout>
</template>
