<template>
  <CraftableProUserPage v-bind="props" />
</template>

<script setup lang="ts">
import CraftableProUserPage from "kingcms/Pages/CraftableProUser/Index.vue";
import { PaginatedCollection } from "kingcms/types/pagination";
import type { CraftableProUser } from "kingcms/types/models";

interface Props {
  craftableProUsers: PaginatedCollection<CraftableProUser>;
  filterOptions: {
    roles: string[];
  };
}

const props = defineProps<Props>();
</script>
