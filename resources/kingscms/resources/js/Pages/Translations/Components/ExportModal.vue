<template>
  <Modal :open="open" @toggle-open="toggleOpen" :external-open="true">
    <template #title>Export translations</template>
    <template #content>
      <div class="space-y-6">
        <Multiselect
          v-model="form.exportLanguages"
          :options="locales"
          :label="'Languages'"
          mode="tags"
          name=""
        />
      </div>
    </template>

    <template #buttons="{ setIsOpen }">
      <Button :loading="form.processing" @click.prevent="submit(setIsOpen)">
        Export
      </Button>
      <Button color="gray" variant="outline" @click.prevent="() => setIsOpen()">
        Cancel
      </Button>
    </template>
  </Modal>
</template>

<script lang="ts" setup>
import { Button, Modal, Multiselect } from "kingcms/Components";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import type { PageProps } from "kingcms/types/page";

interface Props {
  locales: string[];
  open: boolean;
}

const props = defineProps<Props>();

const form = useForm({
  exportLanguages: [],
});

const adminPath = ref((usePage().props as PageProps).admin_path);

const submit = (setIsOpen: Function) => {
  window.location.href ="/"+adminPath.value+"/translations/export?exportLanguages[]=" + form.exportLanguages.join("&exportLanguages[]=");
  setIsOpen();
};

const emit = defineEmits(["toggleOpen"]);

const toggleOpen = () => {
  emit("toggleOpen");
};
</script>
