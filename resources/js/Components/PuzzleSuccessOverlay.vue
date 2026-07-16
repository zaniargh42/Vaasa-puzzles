<script setup>
import { useI18n } from '@/composables/useI18n';
import { onBeforeUnmount, ref, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['done']);
const { t } = useI18n();
const visible = ref(false);
let timer = null;

watch(
    () => props.show,
    (value) => {
        if (! value) {
            return;
        }

        visible.value = true;

        if (timer) {
            clearTimeout(timer);
        }

        timer = setTimeout(() => {
            visible.value = false;
            emit('done');
        }, 2800);
    },
);

onBeforeUnmount(() => {
    if (timer) {
        clearTimeout(timer);
    }
});
</script>

<template>
    <Teleport to="body">
        <div
            v-if="visible"
            class="success-veil fixed inset-0 z-[80] flex items-center justify-center"
            role="status"
            aria-live="polite"
        >
            <div class="success-glow" />
            <div class="relative flex flex-col items-center gap-5 px-6 text-center">
                <div class="seal" aria-hidden="true">
                    <div class="seal-ring" />
                    <div class="seal-core">
                        <span class="seal-mark">1867</span>
                    </div>
                </div>
                <p class="max-w-sm text-lg font-semibold tracking-wide text-amber-50 drop-shadow">
                    {{ t('stage1.success_title') }}
                </p>
                <p class="max-w-md text-sm leading-7 text-amber-100/90">
                    {{ t('stage1.success_body') }}
                </p>
            </div>
        </div>
    </Teleport>
</template>

<style scoped>
.success-veil {
    background:
        radial-gradient(ellipse at center, rgba(69, 26, 3, 0.35) 0%, rgba(28, 25, 23, 0.82) 55%, rgba(12, 10, 9, 0.92) 100%);
    animation: veil-in 0.35s ease-out;
}

.success-glow {
    position: absolute;
    inset: 20%;
    background: radial-gradient(circle, rgba(245, 158, 11, 0.28), transparent 65%);
    filter: blur(8px);
    animation: glow-pulse 2.4s ease-in-out infinite;
}

.seal {
    position: relative;
    width: 132px;
    height: 132px;
    animation: seal-stamp 0.7s cubic-bezier(0.2, 0.9, 0.2, 1.2) both;
}

.seal-ring {
    position: absolute;
    inset: 0;
    border-radius: 9999px;
    border: 3px dashed rgba(251, 191, 36, 0.75);
    animation: seal-spin 8s linear infinite;
}

.seal-core {
    position: absolute;
    inset: 14px;
    border-radius: 9999px;
    display: grid;
    place-items: center;
    background:
        radial-gradient(circle at 30% 30%, #b45309, #78350f 55%, #451a03 100%);
    box-shadow:
        0 0 0 4px rgba(120, 53, 15, 0.8),
        0 12px 40px rgba(0, 0, 0, 0.45),
        inset 0 0 20px rgba(0, 0, 0, 0.35);
}

.seal-mark {
    font-family: ui-serif, Georgia, Cambria, 'Times New Roman', Times, serif;
    font-size: 1.35rem;
    letter-spacing: 0.12em;
    color: #fef3c7;
    text-shadow: 0 1px 0 rgba(0, 0, 0, 0.45);
}

@keyframes veil-in {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes seal-stamp {
    0% {
        transform: scale(1.6) rotate(-12deg);
        opacity: 0;
        filter: blur(4px);
    }
    55% {
        transform: scale(0.92) rotate(2deg);
        opacity: 1;
        filter: blur(0);
    }
    100% {
        transform: scale(1) rotate(0deg);
        opacity: 1;
    }
}

@keyframes seal-spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

@keyframes glow-pulse {
    0%,
    100% {
        opacity: 0.55;
    }
    50% {
        opacity: 1;
    }
}
</style>
