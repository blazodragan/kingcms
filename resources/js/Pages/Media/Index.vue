<template>
  <MediaPage v-bind="props" />
</template>

<script lang="ts" setup>
import type { Media } from "kingcms/Pages/Media/types";
import MediaPage from "kingcms/Pages/Media/Index.vue";
import { PaginatedCollection } from "kingcms/types/pagination";

interface Props {
  data: PaginatedCollection<Media>;
  filterOptions: {
    model_type: string[];
    collection_name: string[];
    mime_type: string[];
  };
}

const props = defineProps<Props>();
</script>
