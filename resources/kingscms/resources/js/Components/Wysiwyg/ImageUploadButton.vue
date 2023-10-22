<template>
  <ImageUploadModal>
    <template #button="{ setIsOpen }">
      <ToolbarButton @click="() => setIsOpen(true)" :icon="Image" />
    </template>
  </ImageUploadModal>
</template>
<script setup lang="ts">
import { Image } from "./icons";
import ToolbarButton from "./ToolbarButton.vue";
import { ImageUploadModal } from "craftable-pro/Components";
</script>
