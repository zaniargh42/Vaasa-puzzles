<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CopyableCode from '@/Components/CopyableCode.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    city: {
        type: Object,
        required: true,
    },
    game: {
        type: Object,
        required: true,
    },
    stage: {
        type: Object,
        required: true,
    },
    progress: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    code: '',
});

const actLabel = computed(() => {
    const labels = {
        1: 'پردهٔ اول: سایهٔ چاقوکشان',
        2: 'پردهٔ دوم: نام‌های محترم شهر',
        3: 'پردهٔ سوم: اعداد و حافظه',
    };

    return labels[props.stage.act] ?? '';
});

const submitCode = () => {
    form.post(
        `/cities/${props.city.slug}/games/${props.game.slug}/stages/${props.stage.order}`,
        {
            preserveScroll: true,
            onSuccess: () => form.reset('code'),
        },
    );
};
</script>

<template>
    <AppLayout
        :title="stage.title_fa"
        :subtitle="stage.location_fa"
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
            <Link
                :href="`/cities/${city.slug}/games/${game.slug}`"
                class="hover:text-stone-800"
            >
                {{ game.title_fa }}
            </Link>
        </p>

        <div class="mb-6 flex items-center justify-between text-sm text-stone-500">
            <span>{{ actLabel }}</span>
            <span dir="ltr">
                {{ progress.current }} / {{ progress.total }}
            </span>
        </div>

        <div class="space-y-6 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <div>
                <p class="text-xs font-medium text-stone-500">
                    مرحله {{ stage.order }}
                </p>
                <h2 class="mt-1 text-xl font-semibold text-stone-900">
                    {{ stage.title_fa }}
                </h2>
                <p class="mt-1 text-sm text-stone-600">
                    {{ stage.location_fa }}
                </p>
            </div>

            <div
                class="leading-8 text-stone-700 whitespace-pre-line"
            >
                {{ stage.intro_text }}
            </div>

            <CopyableCode :code="stage.code" />

            <p
                v-if="stage.next_destination_fa"
                class="text-sm text-stone-500"
            >
                مقصد بعدی: {{ stage.next_destination_fa }}
            </p>

            <form class="space-y-4 border-t border-stone-100 pt-6" @submit.prevent="submitCode">
                <div>
                    <label
                        for="code"
                        class="mb-2 block text-sm font-medium text-stone-700"
                    >
                        رمز مرحله را وارد کنید
                    </label>
                    <TextInput
                        id="code"
                        v-model="form.code"
                        type="text"
                        class="mt-1 block w-full font-mono"
                        dir="ltr"
                        autocomplete="off"
                        placeholder="مثلاً VANKILA"
                    />
                    <InputError class="mt-2" :message="form.errors.code" />
                </div>

                <PrimaryButton :disabled="form.processing">
                    {{
                        stage.order === progress.total
                            ? 'پایان بازی'
                            : 'رفتن به مرحله بعد'
                    }}
                </PrimaryButton>
            </form>
        </div>
    </AppLayout>
</template>
