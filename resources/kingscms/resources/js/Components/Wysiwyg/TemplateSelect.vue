<template>
  <Listbox as="div" v-model="selectBlock">
    <div class="relative">
      <ListboxButton
        class="relative w-32 cursor-pointer rounded-md bg-white py-1.5 pl-2 pr-6 text-left font-medium text-gray-700 hover:bg-gray-100 focus:outline-none sm:text-sm"
      >
        <span class="flex items-center">
          <span class="block truncate">
            {{ selectBlock.label }}
          </span>
        </span>
        <span
          class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
        >
          <ChevronUpDownIcon class="h-4 w-4 text-gray-400" aria-hidden="true" />
        </span>
      </ListboxButton>

      <ListboxOptions
        class="absolute z-10 mt-1 max-h-60 w-80 overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
      >
        <ListboxOption
          as="template"
          v-for="textStyle in textStyles"
          :key="textStyle.label"
          :value="textStyle"
          v-slot="{ active, selected }"
        >
          <li
            :class="[
              active ? 'bg-primary-600 text-white' : 'text-gray-900',
              'relative cursor-default select-none py-2 px-3',
            ]"
          >
            <div class="flex items-center justify-between">
              <span
                :class="[
                  selected ? 'font-semibold' : 'font-normal',
                  'block truncate',
                ]"
              >
                {{ textStyle.label }}
              </span>
            </div>
          </li>
        </ListboxOption>
      </ListboxOptions>
    </div>
  </Listbox>
</template>
<script setup lang="ts">
import {
  Listbox,
  ListboxButton,
  ListboxOption,
  ListboxOptions,
} from "@headlessui/vue";
import { ChevronUpDownIcon } from "@heroicons/vue/20/solid";
import { Level } from "@tiptap/extension-heading";
import { Editor } from "@tiptap/vue-3";
import { computed } from "vue";

interface Props {
  editor: Editor | undefined;
}

const props = defineProps<Props>();

// Modifying the textStyles to cater for block templates
const textStyles: Array<{
  label: string;
  templateString?: string;
}> = [
{
    label: "Select HTML",
    templateString: ``,
  },
  {
    label: "Review Page Two Blocks",
    templateString: "<section class='asdasd'><div>Example Text</div></section>",
  },

];

const selectBlock = computed({
  get: () => {
    return textStyles[0];
  },
  set: (value) => {
    if (value.templateString) {
      // Insert block template into TipTap editor
      props.editor?.chain().focus().insertContent(value.templateString).run();
    }
  },
});
</script>
