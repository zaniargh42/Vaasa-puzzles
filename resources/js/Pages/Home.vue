<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    cityCount: {
        type: Number,
        required: true,
    },
});
</script>

<template>
    <AppLayout
        title="بازی‌های شهری"
        subtitle="یک شهر انتخاب کنید، سپس بازی موردنظر را آغاز کنید."
    >
        <div
            class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8"
        >
            <p class="leading-8 text-stone-700">
                این نسخهٔ اولیه برای آزمایش جریان اپ است: انتخاب شهر، انتخاب
                بازی، خواندن مراحل و رفتن به مرحلهٔ بعد با وارد کردن رمز.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <Link v-if="cityCount > 0" href="/cities">
                    <PrimaryButton>شروع — انتخاب شهر</PrimaryButton>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
