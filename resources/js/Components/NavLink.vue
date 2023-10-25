<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'flex items-center px-6 py-3 border-l-4 bg-green-100 border-green-700 text-md font-medium text-black focus:outline-none focus:border-green-700 transition'
        : 'flex items-center px-6 py-3 border-l-4 border-transparent text-md font-medium text-black hover:text-black hover:bg-green-50 focus:outline-none focus:text-black focus:border-green-300 transition';
});
</script>

<template>

    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
