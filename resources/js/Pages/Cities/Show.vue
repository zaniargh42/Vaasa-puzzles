<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useI18n } from '@/composables/useI18n';
import { Link } from '@inertiajs/vue3';

defineProps({
    city: {
        type: Object,
        required: true,
    },
    games: {
        type: Array,
        required: true,
    },
});

const { t } = useI18n();
</script>

<template>
    <AppLayout
        :title="city.name"
        :subtitle="city.description || t('cities.choose_game')"
    >
        <p class="mb-4 text-sm text-stone-500">
            <Link href="/cities" class="hover:text-stone-800">
                {{ t('nav.cities') }}
            </Link>
            <span class="mx-2">/</span>
            <span>{{ city.name }}</span>
        </p>

        <div v-if="games.length === 0" class="rounded-xl bg-white p-6 text-stone-600">
            {{ t('cities.no_games') }}
        </div>

        <div v-else class="grid gap-4">
            <Link
                v-for="game in games"
                :key="game.slug"
                :href="`/cities/${city.slug}/games/${game.slug}`"
                class="block rounded-2xl border border-stone-200 bg-white p-6 shadow-sm transition hover:border-amber-300 hover:shadow-md"
            >
                <h2 class="text-xl font-semibold text-stone-900">
                    {{ game.title }}
                </h2>
                <p
                    v-if="game.subtitle"
                    class="mt-1 text-sm text-stone-600"
                >
                    {{ game.subtitle }}
                </p>
                <p
                    v-if="game.description"
                    class="mt-3 text-sm leading-7 text-stone-600"
                >
                    {{ game.description }}
                </p>
                <p class="mt-4 text-xs text-stone-500">
                    {{ t('games.stages', { count: game.stage_count }) }}
                </p>
            </Link>
        </div>
    </AppLayout>
</template>
