<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
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
</script>

<template>
    <AppLayout
        :title="city.name_fa"
        :subtitle="city.description_fa || 'یک بازی را انتخاب کنید.'"
    >
        <p class="mb-4 text-sm text-stone-500">
            <Link href="/cities" class="hover:text-stone-800">شهرها</Link>
            <span class="mx-2">/</span>
            <span>{{ city.name_fa }}</span>
        </p>

        <div v-if="games.length === 0" class="rounded-xl bg-white p-6 text-stone-600">
            برای این شهر هنوز بازی‌ای منتشر نشده است.
        </div>

        <div v-else class="grid gap-4">
            <Link
                v-for="game in games"
                :key="game.slug"
                :href="`/cities/${city.slug}/games/${game.slug}`"
                class="block rounded-2xl border border-stone-200 bg-white p-6 shadow-sm transition hover:border-amber-300 hover:shadow-md"
            >
                <p class="text-xs font-medium uppercase tracking-wide text-amber-700">
                    {{ game.title_en }}
                </p>
                <h2 class="mt-2 text-xl font-semibold text-stone-900">
                    {{ game.title_fa }}
                </h2>
                <p
                    v-if="game.subtitle_fa"
                    class="mt-1 text-sm text-stone-600"
                >
                    {{ game.subtitle_fa }}
                </p>
                <p
                    v-if="game.description_fa"
                    class="mt-3 text-sm leading-7 text-stone-600"
                >
                    {{ game.description_fa }}
                </p>
                <p class="mt-4 text-xs text-stone-500">
                    {{ game.stage_count }} مرحله
                </p>
            </Link>
        </div>
    </AppLayout>
</template>
