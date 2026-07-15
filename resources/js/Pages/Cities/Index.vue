<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useI18n } from '@/composables/useI18n';
import { Link } from '@inertiajs/vue3';

defineProps({
    cities: {
        type: Array,
        required: true,
    },
});

const { t } = useI18n();
</script>

<template>
    <AppLayout
        :title="t('cities.title')"
        :subtitle="t('cities.subtitle')"
    >
        <div v-if="cities.length === 0" class="rounded-xl bg-white p-6 text-stone-600">
            {{ t('cities.empty') }}
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
                            {{ city.name }}
                        </h2>
                        <p
                            v-if="city.description"
                            class="mt-3 text-sm leading-7 text-stone-600"
                        >
                            {{ city.description }}
                        </p>
                    </div>
                    <span
                        class="shrink-0 rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-800"
                    >
                        {{ t('cities.games_count', { count: city.games_count }) }}
                    </span>
                </div>
            </Link>
        </div>
    </AppLayout>
</template>
