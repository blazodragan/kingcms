<template>
  <AppLayout title="Roles">
  <PageHeader :title="'Roles'">
    <Button :as="Link" :href="`permissions`" v-can="'sanctum.role.edit'">Manage permissions
    </Button>
  </PageHeader>

  <PageContent>
    <Listing
      :baseUrl="route('roles.index')"
      :data="roles"
      dataKey="roles"
      :withBulkSelect="false"
    >
      <template #tableHead>
        <ListingHeaderCell sortBy="id" class="w-14">
          ID
        </ListingHeaderCell>
        <ListingHeaderCell sortBy="name">
          Name
        </ListingHeaderCell>
        <ListingHeaderCell>
          Users
        </ListingHeaderCell>
      </template>
      <template #tableRow="{ item, action }: any">
        <ListingDataCell>
          {{ item.id }}
        </ListingDataCell>
        <ListingDataCell>
          <div class="font-medium text-gray-900">
            {{ item.name }}
          </div>
        </ListingDataCell>
        <ListingDataCell>
          <AvatarGroup

          >
            <Avatar
              v-for="user in item.users.slice(0, avatarGroupLimit)"
              :key="user.id"
              :src="user.avatar_url"
              :name="`${user.first_name} ${user.last_name}`"
            />
          </AvatarGroup>
        </ListingDataCell>
      </template>
    </Listing>
  </PageContent>
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import {
  PageHeader,
  PageContent,
  Listing,
  ListingHeaderCell,
  ListingDataCell,
  IconButton,
  Button,
  Avatar,
  AvatarGroup,
} from "craftable-pro/Components";
import { PaginatedCollection } from "craftable-pro/types/pagination";
import type { Role } from "craftable-pro/types/models";
import { ref } from "vue";

interface Props {
  roles: PaginatedCollection<Role>;
}

defineProps<Props>();

const avatarGroupLimit = ref(7);
</script>
