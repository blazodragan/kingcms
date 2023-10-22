<template>
  <RoleIndexPage v-bind="props" />
</template>

<script setup lang="ts">
import RoleIndexPage from "kingcms/Pages/Roles/Index.vue";
import { PaginatedCollection } from "kingcms/types/pagination";
import type { Role } from "kingcms/types/models";

interface Props {
  roles: PaginatedCollection<Role>;
}

const props = defineProps<Props>();

</script>
