<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        default: '',
    },
    subtitle: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <div class="min-h-screen bg-stone-100 text-stone-900" dir="rtl">
        <header class="border-b border-stone-200 bg-white/90 backdrop-blur">
            <div
                class="mx-auto flex max-w-3xl items-center justify-between px-4 py-4 sm:px-6"
            >
                <Link
                    href="/"
                    class="text-lg font-semibold tracking-tight text-stone-800"
                >
                    بازی‌های شهری
                </Link>
                <nav class="text-sm text-stone-500">
                    <Link href="/cities" class="hover:text-stone-800">
                        شهرها
                    </Link>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-3xl px-4 py-8 sm:px-6">
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
