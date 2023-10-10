<template>
  <div>
    
    <label v-if="label" class="text-base font-medium text-gray-900">
      {{ label }}
    </label>
    <p class="text-sm leading-5 text-gray-500">
      <slot />
    </p>
    <fieldset class="mt-3">
      <legend v-if="label" class="sr-only">{{ label }}</legend>
      
      <div class="space-y-4">

<ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <li
          v-for="option in options"
          :key="option.value"
          class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600"
        ><div class="flex items-center pl-3">
          <input
            v-model="value"
            :id="option.value.toString()"
            :value="option.value.toString()"
            :name="name"
            type="radio"
            class="w-4 cursor-pointer h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
          />
            <slot name="option" :option="option">
              <label
                :for="option.value.toString()"
                class="w-full py-3 ml-2 cursor-pointer text-sm font-medium text-gray-900 dark:text-gray-300"
              >
                {{ option.label }}
              </label>
            </slot>
        </div>
        </li>
      </ul>
      </div>
    </fieldset>
  </div>
</template>

<script setup lang="ts">
import { useInput } from "../hooks/useInput";

type Option = {
  value: string | number;
  label: string;
  [x: string | number | symbol]: unknown;
};

interface Props {
  name: string;
  label?: string;
  options: Array<Option>;
  modelValue?: string;
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: "",
});

const emit = defineEmits(["update:modelValue"]);

const { value } = useInput(props, emit);
</script>
