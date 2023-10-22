<template>
    <div class="flex flex-wrap items-center justify-between gap-2 sticky top-0 z-50 transition duration-300 p-4 mb-4" :class="baseClasses">
      <h3>Translations </h3>
      <div class="flex items-center divide-x-2">
        <Tooltip v-for="locale in availableLocales" :position="positionToptip">
          <template #button>
            <button
              @click="currentLocale = locale"
              class="flex min-w-[72px] items-center px-3 text-sm uppercase leading-5 hover:cursor-pointer"
              :class="[
                locale === currentLocale
                  ? 'font-semibold text-indigo-600'
                  : 'font-normal text-slate-500 hover:text-slate-900',
              ]"
            >
              <LocaleFlag :locale="locale" />
            </button>
          </template>
          <template #content> {{ locale }} </template>
        </Tooltip>
      </div>
    </div>
</template>

<script setup lang="ts">
import { computed,ref, onMounted, onBeforeUnmount } from "vue";
import { Card, Tooltip, LocaleFlag } from "kingcms/Components";
import { useFormLocale } from "kingcms/hooks/useFormLocale";

const props = defineProps(["modelValue"]);
const emit = defineEmits(["update:modelValue"]);

const currentLocale = computed({
  get() {
    return props.modelValue;
  },
  set(value) {
    emit("update:modelValue", value);
  },
});

const { availableLocales } = useFormLocale();

const isSticky = ref(false);
const isPosition = ref(false);

const handleScroll = () => {
  const element = document.getElementById('cardlocale'); 
  if (element) {
    const rect = element.getBoundingClientRect();
    if (rect.top <= 0) {
      isSticky.value = true;
      isPosition.value = true;
    } else {
      isSticky.value = false;
      isPosition.value = false;
    }
  }
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll);
});

const baseClasses = computed(() => ({
  'bg-white rounded shadow': !isSticky.value,
  'mb-0 bg-gray-50 rounded shadow': isSticky.value
}));


const positionToptip = computed(() => {
  return isSticky.value ? 'bottom' : 'top';
});

</script>
