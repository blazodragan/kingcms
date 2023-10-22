<template>
    <PermissionIndexPage v-bind="props" />
</template>

<script setup lang="ts">
import PermissionIndexPage from "kingcms/Pages/Permissions/Index.vue";
import type { Role } from "kingcms/types/models";

interface Props {
    roles: Role[];
    permissions: [];
}

const props = defineProps<Props>();
</script>
