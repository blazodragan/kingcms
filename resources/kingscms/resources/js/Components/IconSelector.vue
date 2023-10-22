<template>
    <Listbox as="div" v-model="selectedIcon">
      <div class="relative">
        <ListboxButton
          class="relative w-24 cursor-pointer rounded-md py-1.5 pl-2 pr-6 text-left font-medium text-gray-700 hover:bg-gray-100 focus:outline-none sm:text-sm"
        >
          <span class="flex items-center">
            <img :src="selectedIcon ? selectedIcon : iconOptions[0]" alt="Selected Icon" class="w-6 h-6" />
          </span>
          <span
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
          >
            <ChevronUpDownIcon class="h-4 w-4 text-gray-400" aria-hidden="true" />
          </span>
        </ListboxButton>
  
        <ListboxOptions
          class="absolute z-10 mt-1 max-h-60 w-40 overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        >
          <ListboxOption
            as="template"
            v-for="iconPath in iconOptions"
            :key="iconPath"
            :value="iconPath"
            v-slot="{ active }"
          >
            <li
              :class="[
                active ? 'bg-primary-600 text-white' : 'text-gray-900',
                'relative cursor-default select-none py-2 px-3',
              ]"
            >
              <div class="flex items-center justify-between">
                <img :src="iconPath" alt="Icon" class="w-6 h-6" />
              </div>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </div>
    </Listbox>
  </template>
  
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { Listbox, ListboxButton, ListboxOption, ListboxOptions } from '@headlessui/vue';
import { ChevronUpDownIcon } from "@heroicons/vue/20/solid";


export default defineComponent({
  components: { Listbox, ListboxButton, ListboxOption, ListboxOptions, ChevronUpDownIcon },
  props: {
    modelValue: {
      type: String,
      default: '',
    },
    iconOptions: {
      type: Array as PropType<string[]>,
      required: true,
    },
  },
  computed: {
    selectedIcon: {
      get() {
        return this.modelValue;
      },
      set(value) {
        this.$emit('update:modelValue', value);
      },
    },
  },
});
</script>