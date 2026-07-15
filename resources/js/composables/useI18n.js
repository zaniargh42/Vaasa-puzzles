import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function useI18n() {
    const page = usePage();

    const locale = computed(() => page.props.locale);
    const direction = computed(() => page.props.direction ?? 'ltr');
    const locales = computed(() => page.props.locales ?? {});

    const t = (key, replacements = {}) => {
        let text = page.props.translations?.[key] ?? key;

        Object.entries(replacements).forEach(([name, value]) => {
            text = text.replaceAll(`:${name}`, String(value));
        });

        return text;
    };

    return {
        t,
        locale,
        direction,
        locales,
    };
}
