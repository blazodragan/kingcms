<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const show = ref(true);
const style = computed(() => usePage().props.jetstream.flash?.messageStyle || 'success');
const message = computed(() => usePage().props.jetstream.flash?.message || '');
const duration = computed(() => usePage().props.jetstream.flash?.duration || '');

watch(message, async () => {
  show.value = true;
  setTimeout(() => show.value = false, duration.value);
});
</script>

<template>
    <TransitionGroup
    tag="div"
    enter-from-class="translate-x-full opacity-0"
    enter-active-class="duration-500"
    leave-active-class="duration-500"
    leave-to-class="translate-x-full opacity-0"
    class="fixed top-4 right-4 z-50 w-full max-w-xs space-y-4 rounded-lg"
    >
        <div v-if="show && message" :class="{ 'bg-green-300': style == 'success', 'bg-red-700': style == 'danger' }" class="rounded-lg">
            <div class="max-w-screen-xl mx-auto py-2 px-4">
                <div class="flex items-center justify-between flex-wrap">
                    <div class="w-0 flex-1 flex items-center min-w-0">
                        <span class="flex p-2 rounded-lg" :class="{ 'bg-green-400': style == 'success', 'bg-red-600': style == 'danger' }">
                            <svg
                                v-if="style == 'success'"
                                class="h-5 w-5 text-black"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>

                            <svg
                                v-if="style == 'danger'"
                                class="h-5 w-5 text-black"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                />
                            </svg>
                        </span>

                        <p class="ml-3 font-medium text-sm text-black truncate">
                            {{ message }}
                        </p>
                    </div>

                    <div class="shrink-0 sm:ml-3">
                        <button
                            type="button"
                            class="-mr-1 flex p-2 rounded-md focus:outline-none sm:-mr-2 transition"
                            :class="{ 'hover:bg-green-600 focus:bg-green-600': style == 'success', 'hover:bg-red-600 focus:bg-red-600': style == 'danger' }"
                            aria-label="Dismiss"
                            @click.prevent="show = false"
                        >
                            <svg
                                class="h-5 w-5 text-black"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </TransitionGroup>
</template>
