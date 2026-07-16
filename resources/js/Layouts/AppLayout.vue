<script setup>
import GameBagPanel from '@/Components/GameBagPanel.vue';
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue';
import { Link } from '@inertiajs/vue3';
import { useI18n } from '@/composables/useI18n';

defineProps({
    title: {
        type: String,
        default: '',
    },
    subtitle: {
        type: String,
        default: '',
    },
    bag: {
        type: Array,
        default: null,
    },
    wide: {
        type: Boolean,
        default: false,
    },
});

const { t, direction } = useI18n();
</script>

<template>
    <div class="min-h-screen bg-stone-100 text-stone-900" :dir="direction">
        <header class="border-b border-stone-200 bg-white/90 backdrop-blur">
            <div
                class="mx-auto flex items-center justify-between gap-4 px-4 py-4 sm:px-6"
                :class="wide ? 'max-w-5xl' : 'max-w-3xl'"
            >
                <Link
                    href="/"
                    class="text-lg font-semibold tracking-tight text-stone-800"
                >
                    {{ t('name') }}
                </Link>

                <div class="flex items-center gap-4">
                    <nav class="text-sm text-stone-500">
                        <Link href="/cities" class="hover:text-stone-800">
                            {{ t('nav.cities') }}
                        </Link>
                    </nav>
                    <GameBagPanel v-if="bag !== null" :items="bag" />
                    <LanguageSwitcher />
                </div>
            </div>
        </header>

        <main
            class="mx-auto px-4 py-8 sm:px-6"
            :class="wide ? 'max-w-5xl' : 'max-w-3xl'"
        >
            <div v-if="title" class="mb-8">
                <h1 class="text-2xl font-bold text-stone-900 sm:text-3xl">
                    {{ title }}
                </h1>
                <p
                    v-if="subtitle"
                    class="mt-2 text-sm leading-7 text-stone-600"
                >
                    {{ subtitle }}
                </p>
            </div>

            <slot />
        </main>
    </div>
</template>
