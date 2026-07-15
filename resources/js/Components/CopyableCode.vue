<script setup>
import { ref } from 'vue';
import { useI18n } from '@/composables/useI18n';

const props = defineProps({
    code: {
        type: String,
        required: true,
    },
});

const { t } = useI18n();
const copied = ref(false);

const copyCode = async () => {
    try {
        await navigator.clipboard.writeText(props.code);
        copied.value = true;
        window.setTimeout(() => {
            copied.value = false;
        }, 2000);
    } catch {
        copied.value = false;
    }
};
</script>

<template>
    <div class="rounded-xl border border-dashed border-amber-300 bg-amber-50 p-4">
        <div class="flex items-center justify-between gap-3">
            <div>
                <p class="text-xs font-medium text-amber-800">
                    {{ t('stages.code_label') }}
                </p>
                <p
                    class="mt-1 font-mono text-lg tracking-wide text-amber-950"
                    dir="ltr"
                >
                    {{ code }}
                </p>
            </div>
            <button
                type="button"
                class="rounded-lg bg-amber-700 px-3 py-2 text-sm font-medium text-white transition hover:bg-amber-800"
                @click="copyCode"
            >
                {{ copied ? t('stages.copied') : t('stages.copy') }}
            </button>
        </div>
        <p class="mt-3 text-xs leading-6 text-amber-900/80">
            {{ t('stages.code_hint') }}
        </p>
    </div>
</template>
