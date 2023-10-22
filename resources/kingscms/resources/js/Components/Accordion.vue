<template>
  <div class="w-full">
    <div class="rounded-md bg-white shadow p-5">
      <Disclosure as="div" v-slot="{ open }" :defaultOpen="defaultOpen">
        <DisclosureButton
          class="flex w-full justify-between rounded-md bg-gray-100 px-4 py-2 text-left text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus-visible:ring focus-visible:ring-gray-500 focus-visible:ring-opacity-75">
          <slot name="title" />
          <ChevronUpIcon :class="{ 'rotate-180 transform': open }"
            class="h-5 w-5 text-gray-400 group-hover:text-gray-700" />
        </DisclosureButton>
        <div v-show="open">
          <DisclosurePanel class="mt-4 text-gray-700" static>
            <slot name="content" />
          </DisclosurePanel>
        </div>
      </Disclosure>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { ChevronUpIcon } from "@heroicons/vue/20/solid";

interface Props {
  defaultOpen?: boolean;
}

withDefaults(defineProps<Props>(), {
  defaultOpen: false,
});
</script>
