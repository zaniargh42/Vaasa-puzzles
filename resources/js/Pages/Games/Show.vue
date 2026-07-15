<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
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

const startGame = () => {
    form.post(`/cities/${props.city.slug}/games/${props.game.slug}/start`);
};
</script>

<template>
    <AppLayout
        :title="game.title_fa"
        :subtitle="game.subtitle_fa || game.description_fa"
    >
        <p class="mb-4 text-sm text-stone-500">
            <Link href="/cities" class="hover:text-stone-800">شهرها</Link>
            <span class="mx-2">/</span>
            <Link
                :href="`/cities/${city.slug}`"
                class="hover:text-stone-800"
            >
                {{ city.name_fa }}
            </Link>
            <span class="mx-2">/</span>
            <span>{{ game.title_fa }}</span>
        </p>

        <div class="space-y-6 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm text-stone-500">{{ game.title_en }}</p>

            <p
                v-if="game.description_fa"
                class="leading-8 text-stone-700 whitespace-pre-line"
            >
                {{ game.description_fa }}
            </p>

            <div class="rounded-xl bg-stone-50 p-4 text-sm leading-7 text-stone-600">
                این بازی {{ game.stage_count }} مرحله دارد. در این نسخهٔ
                اولیه، فقط متن مراحل و رمزها نمایش داده می‌شود — بدون معما و
                بدون فعال‌سازی مکانی.
            </div>

            <PrimaryButton :disabled="form.processing" @click="startGame">
                شروع بازی
            </PrimaryButton>
        </div>
    </AppLayout>
</template>
