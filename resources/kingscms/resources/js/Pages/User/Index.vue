<template>
  <PageHeader :title="'Users'">
    <Modal alignButtons="right" size="sm">
      <template #trigger="{ setIsOpen }">
        <Button @click="() => setIsOpen(true)" :leftIcon="PlusIcon">
          Invite user
        </Button>
      </template>
      <template #title>
        Invite user
      </template>
      <template #content>
        <div class="mt-4 flex flex-col gap-2">
          <TextInput
            v-model="form.email"
            name="email"
            :label="'Email'"
          />
          <Multiselect
            v-model="form.role_id"
            name="role"
            :label="'Role'"
            mode="single"
            :options="filterOptions.roles"
            optionsValueProp="id"
            optionsLabel="name"
          />
        </div>
      </template>
      <template #buttons="{ setIsOpen }">
        <Button size="sm" :loading="form.processing" @click="submit(setIsOpen)">
          Invite user
        </Button>
        <Button
          size="sm"
          color="gray"
          variant="outline"
          @click.prevent="() => setIsOpen()"
        >
          Cancel
        </Button>
      </template>
    </Modal>
  </PageHeader>

  <PageContent>
   
  </PageContent>
</template>

<script setup lang="ts">
import { Link, usePage, useForm } from "@inertiajs/vue3";

import {
  PlusIcon,
  TrashIcon,
  PencilSquareIcon,
  ClockIcon,
  ArrowLeftOnRectangleIcon,
  EllipsisVerticalIcon,
  EnvelopeIcon,
} from "@heroicons/vue/24/outline";
import { NoSymbolIcon, ShieldCheckIcon } from "@heroicons/vue/24/solid";
import {
  CheckCircleIcon,
  ExclamationCircleIcon,
  XCircleIcon,
} from "@heroicons/vue/20/solid";
import {
  PageHeader,
  PageContent,
  Button,
  Listing,
  Avatar,
  ListingHeaderCell,
  ListingDataCell,
  Modal,
  IconButton,
  FiltersDropdown,
  Multiselect,
  Tag,
  Dropdown,
  DropdownItem,
  TextInput,
} from "kingcms/Components";
import { PaginatedCollection } from "kingcms/types/pagination";
import type { User } from "kingcms/types/models";
import { useAction } from "kingcms/hooks/useAction";
import { useListingFilters } from "kingcms/hooks/useListingFilters";
import { PageProps } from "kingcms/types/page";
import { wTrans } from "kingcms/plugins/laravel-vue-i18n";
import dayjs from "dayjs";
import { CraftableProUserInviteUserForm } from "./types";
import { useToast } from "@brackets/vue-toastification";

interface Props {
  users: PaginatedCollection<User>;
  filterOptions: {
    roles: string[];
  };
}

const { action } = useAction();

// const changeActiveStatus = (item: User) => {
//   action("patch", route("sanctum.users.update", item.id), {
//     active: !item.active,
//   });
// };

const statusOptions = [
  { id: "true", label: "Active" },
  { id: "false", label: "Inactive" },
  { id: "pending", label: "Pending" },
];

const props = defineProps<Props>();

// const { filtersForm, resetFilters, activeFiltersCount } = useListingFilters(
//   "/admin/craftable-pro-users",
//   {
//     role: (usePage().props as PageProps).filter?.role ?? null,
//     status: (usePage().props as PageProps).filter?.status ?? null,
//   }
// );

// const isLastThreeItems = (item: User) => {
//   const arrLength = props.Users.data.length;

//   let lastElement = props.Users.data[arrLength - 1];
//   let beforeLastElement = props.Users.data[arrLength - 2];

//   return lastElement.id === item.id || beforeLastElement.id === item.id;
// };

// const toast = useToast();

// const form = useForm({
//   email: "",
//   role_id: "",
// });

// // const submit = (closeModal: CallableFunction) => {
// //   form.post(route("user.invite-user"), {
// //     onSuccess: () => {
// //       form.email = "";
// //       form.role_id = "";

// //       closeModal();

// //       toast.success(usePage().props?.message);
// //     },
// //   });
// // };
// </script>
