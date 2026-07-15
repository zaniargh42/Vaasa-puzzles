<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useI18n } from '@/composables/useI18n';
import { Link } from '@inertiajs/vue3';

defineProps({
    cityCount: {
        type: Number,
        required: true,
    },
});

const { t } = useI18n();
</script>

<template>
    <AppLayout :title="t('home.title')" :subtitle="t('home.subtitle')">
        <div
            class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8"
        >
            <p class="leading-8 text-stone-700">
                {{ t('home.intro') }}
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <Link v-if="cityCount > 0" href="/cities">
                    <PrimaryButton>{{ t('home.start') }}</PrimaryButton>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
