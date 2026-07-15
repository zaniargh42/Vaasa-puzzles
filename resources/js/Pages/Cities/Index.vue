<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    cities: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <AppLayout
        title="انتخاب شهر"
        subtitle="ابتدا شهری را که می‌خواهید در آن بازی کنید انتخاب کنید."
    >
        <div v-if="cities.length === 0" class="rounded-xl bg-white p-6 text-stone-600">
            هنوز شهری فعال نشده است.
        </div>

        <div v-else class="grid gap-4">
            <Link
                v-for="city in cities"
                :key="city.slug"
                :href="`/cities/${city.slug}`"
                class="block rounded-2xl border border-stone-200 bg-white p-6 shadow-sm transition hover:border-amber-300 hover:shadow-md"
            >
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-stone-900">
                            {{ city.name_fa }}
                        </h2>
                        <p class="mt-1 text-sm text-stone-500">
                            {{ city.name_en }}
                        </p>
                        <p
                            v-if="city.description_fa"
                            class="mt-3 text-sm leading-7 text-stone-600"
                        >
                            {{ city.description_fa }}
                        </p>
                    </div>
                    <span
                        class="shrink-0 rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-800"
                    >
                        {{ city.games_count }} بازی
                    </span>
                </div>
            </Link>
        </div>
    </AppLayout>
</template>
