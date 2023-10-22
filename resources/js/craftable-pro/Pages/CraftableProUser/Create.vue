<template>
  <CraftableProUserCreatePage v-bind="props" />
</template>

<script setup lang="ts">
import CraftableProUserCreatePage from "kingcms/Pages/CraftableProUser/Create.vue";
import type { Role } from "kingcms/types/models";

interface Props {
  roles: Role[];
  locales: string[];
  defaultLocale: string;
}

const props = defineProps<Props>();
</script>
