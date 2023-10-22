<template>
  <Modal class="flex items-center justify-center">
    <template #trigger="{ setIsOpen }">
      <ToolbarButton @click="() => setIsOpen(true)" :icon="YouTube" />
    </template>
    <template #title>Add Youtube video</template>
    <template #content>
      <TextInput
        name="youtube_url"
        :label="'Youtube URL'"
        v-model="form.url"
      />
    </template>
    <template #buttons="{ setIsOpen }">
      <Button
        @click="
          () => {
            setIsOpen(false);
            submit();
          }
        "
      >Submit
      </Button>
      <Button variant="outline" @click="() => setIsOpen(false)">Cancel
      </Button>
    </template>
  </Modal>
</template>
<script setup lang="ts">
import ToolbarButton from "./ToolbarButton.vue";
import { Modal, Button, TextInput } from "craftable-pro/Components";
import { useForm } from "@inertiajs/vue3";
import { YouTube } from "./icons"

const emit = defineEmits(["youtubeAdded"]);

interface Props {
  url?: string;
}

const props = defineProps<Props>();

const form = useForm({
  url: props.url || "",
});

const submit = () => {
  emit("youtubeAdded", form.url);
  form.url = "";
};
</script>
