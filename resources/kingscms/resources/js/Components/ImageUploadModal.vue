<template>
  <Modal class="flex items-center justify-center">
    <template #trigger="{ setIsOpen }">
      <slot name="button" :setIsOpen="setIsOpen" />
    </template>

    <template #title>Upload media
    </template>

    <template #content>
      <Dropzone v-model="form.default" centered :maxNumberOfFiles="1">
        <template #icon>
          <PhotoIconOutline class="mb-2 h-10 w-10 stroke-1 text-gray-500" />
        </template>
      </Dropzone>
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
    </template>
  </Modal>
</template>
<script setup lang="ts">
import { Modal, Dropzone, Button } from "kingcms/Components";
import { useForm } from "@inertiajs/vue3";
import { PhotoIcon as PhotoIconOutline } from "@heroicons/vue/24/outline";
import axios from "axios";
import { PageProps } from "kingcms/types/page";
import { usePage } from "@inertiajs/vue3";

const emit = defineEmits(["imageUploaded"]);

const form = useForm({
  // Name of media collection
  default: [],
});

const path = "/"+(usePage().props as PageProps).admin_path+"/unassigned-media-upload";

const submit = () => {
  axios
    .post(path, form.data())
    .then((response: any) => {
      emit("imageUploaded", response.data.media);
      form.default = [];
      console.log(response.data.media);
    })
    .catch((error) => console.error(error));
};
</script>
