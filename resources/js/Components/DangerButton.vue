<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center justify-center px-4 py-2 bg-rose-500 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-rose-500 focus:outline-none focus:border-rose-700 focus:ring focus:ring-rose-200 active:bg-rose-500 disabled:opacity-25 transition">
        <slot />
    </button>
</template>
