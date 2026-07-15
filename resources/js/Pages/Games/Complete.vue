<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
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

const form = useForm({});

const restartGame = () => {
    form.post(`/cities/${props.city.slug}/games/${props.game.slug}/reset`);
};
</script>

<template>
    <AppLayout
        title="پایان بازی"
        :subtitle="`${game.title_fa} — ${city.name_fa}`"
    >
        <div class="space-y-6 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-lg font-semibold text-stone-900">
                تبریک! همهٔ مراحل را گذراندید.
            </p>

            <div class="leading-8 text-stone-700 whitespace-pre-line">
                <p>
                    غله دزدیده نشد؛ پنهان شد.
                    <span class="font-mono text-sm" dir="ltr">
                        EI VARASTETTU. KÄTKETTY.
                    </span>
                </p>
                <p class="mt-4">
                    Viktor Granholm مجرم اصلی بود. ۱۲ بشکه چاودار در انبار
                    فرعی کارخانهٔ پنبه پیدا شد.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <Link :href="`/cities/${city.slug}`">
                    <PrimaryButton>بازگشت به بازی‌های شهر</PrimaryButton>
                </Link>
                <SecondaryButton :disabled="form.processing" @click="restartGame">
                    بازی دوباره
                </SecondaryButton>
            </div>
        </div>
    </AppLayout>
</template>
