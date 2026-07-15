<script setup>
import { router } from '@inertiajs/vue3';
import { useI18n } from '@/composables/useI18n';

const { t, locale, locales } = useI18n();

const switchLocale = (nextLocale) => {
    if (nextLocale === locale.value) {
        return;
    }

    router.post(route('locale.update'), { locale: nextLocale }, {
        preserveScroll: true,
    });
};
</script>

<template>
    <div class="flex items-center gap-2">
        <span class="sr-only">{{ t('language.label') }}</span>
        <button
            v-for="(meta, code) in locales"
            :key="code"
            type="button"
            class="rounded-lg px-2.5 py-1 text-xs font-medium transition"
            :class="
                code === locale
                    ? 'bg-stone-800 text-white'
                    : 'bg-stone-100 text-stone-600 hover:bg-stone-200'
            "
            @click="switchLocale(code)"
        >
            {{ meta.native }}
        </button>
    </div>
</template>
