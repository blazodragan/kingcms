<template>
  <CraftableProUserEditPage v-bind="props" />
</template>

<script setup lang="ts">
import CraftableProUserEditPage from "kingcms/Pages/CraftableProUser/Edit.vue";
import type { CraftableProUser, Role } from "kingcms/types/models";

interface Props {
  craftableProUser: CraftableProUser;
  roles: Role[];
  locales: string[];
}

const props = defineProps<Props>();
</script>
