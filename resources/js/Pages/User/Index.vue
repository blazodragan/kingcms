
<template>
  <AppLayout title="Users">
    <PageHeader :title="'Users'">


    <Modal alignButtons="right" size="sm">
      <template #trigger="{ setIsOpen }">
        <Button
      :leftIcon="PlusIcon"
      @click="() => setIsOpen(true)"
      v-can="'sanctum.news.create'"
    >Invite user
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
    <Listing
      :baseUrl="route('users.index')"
      :data="users"
      dataKey="users"
    >
      <template #actions>
        <FiltersDropdown
          :activeFiltersCount="activeFiltersCount"
          :resetFilters="resetFilters"
        >
          <Multiselect
            v-model="filtersForm.role"
            name="role"
            :label="'Role'"
            :options="filterOptions.roles"
          />
          <Multiselect
            v-model="filtersForm.status"
            name="status"
            :label="'Status'"
            :options="statusOptions"
            options-value-prop="id"
            options-label="label"
            mode="single"
          />
        </FiltersDropdown>
      </template>

      <template #bulkActions="{ baseUrl, bulkAction }">
        <!-- TODO: there was some kind of an idea to soft/force destroy? -->
        <Button
          @click="() => bulkAction('post', `${baseUrl}/bulk-activate`)"
          color="gray"
          variant="outline"
          size="sm"
          :leftIcon="ShieldCheckIcon"
        >
          Activate
        </Button>

        <Modal type="danger">
          <template #trigger="{ setIsOpen }">
            <Button
              @click="setIsOpen(true)"
              color="gray"
              variant="outline"
              size="sm"
              :leftIcon="NoSymbolIcon"
            >
              Deactivate
            </Button>
          </template>

          <template #title
            >Deactivate users
          </template>

          <template #content>Are you sure you want to deactivate selected users?</template>

          <template #buttons="{ setIsOpen }">
            <Button
              @click.prevent="
                () => bulkAction('post', `${baseUrl}/bulk-deactivate`)
              "
              color="danger"
            >
              Deactivate
            </Button>
            <Button
              @click.prevent="() => setIsOpen()"
              color="gray"
              variant="outline"
            >
              Cancel
            </Button>
          </template>
        </Modal>

        <Modal type="danger" >
          <template #trigger="{ setIsOpen }">
            <Button
              @click="() => setIsOpen(true)"
              color="gray"
              variant="outline"
              size="sm"
              :leftIcon="TrashIcon"
            >
              Delete
            </Button>
          </template>

          <template #title>Delete users</template>
          <template #content>"Are you sure you want to delete selected users? All of their data will be permanently removed from our servers forever. This action cannot be undone."</template>

          <template #buttons="{ setIsOpen }">
            <!-- TODO: disable button while submitting... (done in other PR) -->
            <Button
              @click.prevent="
                () => {
                  bulkAction('delete', `${baseUrl}/bulk-destroy`, {
                    onFinish: () => setIsOpen(false),
                  });
                }
              "
              color="danger"
            >
              Delete
            </Button>
            <Button
              @click.prevent="() => setIsOpen()"
              color="gray"
              variant="outline"
            >
              Cancel
            </Button>
          </template>
        </Modal>
      </template>

      <template #tableHead>
        <ListingHeaderCell sortBy="id" class="w-14">
          ID
        </ListingHeaderCell>

        <ListingHeaderCell sortBy="name">
          User
        </ListingHeaderCell>

        <ListingHeaderCell>
          Role
        </ListingHeaderCell>

        <ListingHeaderCell>
          Status
        </ListingHeaderCell>


        <ListingHeaderCell>
          <span class="sr-only">Actions</span>
        </ListingHeaderCell>
      </template>

      <template #tableRow="{ item, action }: any">
        <ListingDataCell>
          {{ item.id }}
        </ListingDataCell>

        <ListingDataCell>
          <div class="flex items-center">
            <Avatar
              :src="item.avatar_url"
              :name="`${item.name}`"
            />
            <div class="ml-4">
              <div class="font-medium text-gray-900">
                <!-- TODO: maybe have full_name attribute? -->
                {{ item.name }}
              </div>
              <div class="text-gray-500">{{ item.email }}</div>
            </div>
          </div>
        </ListingDataCell>

        <ListingDataCell>
          <span class="text-sm font-normal leading-5 text-slate-500">
            {{ item.roles.length > 0 ? item.roles[0].name : "" }}
          </span>
        </ListingDataCell>

        <ListingDataCell class="text-left">
          <template v-if="item.email_verified_at">
           <div v-if="item.active">
              <Tag :icon="CheckCircleIcon" color="success" rounded size="sm">
                Active
              </Tag>
            </div>

            <div v-else>
              <Tag :icon="XCircleIcon" color="gray" rounded size="sm">
                Inactive
              </Tag>
            </div>
          </template>

          <div v-else>
            <Tag
              :icon="ExclamationCircleIcon"
              color="warning"
              rounded
              size="sm"
            >
              Pending
            </Tag>
          </div>
        </ListingDataCell>


        <ListingDataCell>
          <div class="flex justify-end">
            <Dropdown
              noContentPadding
              :placement="isLastThreeItems(item) ? 'bottom-end' : 'top-end'"
            >
              <template #button>
                <IconButton
                  :icon="EllipsisVerticalIcon"
                  variant="outline"
                  color="gray"
                  size="sm"
                />
              </template>

              <template #content class="bg-red">
                <div class="py-1">
                  <DropdownItem
                    :href="`${item.resource_url}/edit`"
                    :icon="PencilSquareIcon"
                  >
                    Edit
                  </DropdownItem>

                  <template v-if="item.email_verified_at">
                    <DropdownItem
                      @click="changeActiveStatus(item)"
                      :icon="item.active ? NoSymbolIcon : ShieldCheckIcon"
                    >
                      {{ item.active ? "Deactivate" : "Activate" }}
                    </DropdownItem>
                  </template>

                  <DropdownItem
                    v-else
                    @click="
                      () => {
                        action(
                          'post',
                          `users/${item.id}/resend-verification-email`
                        );
                      }
                    "
                    :icon="EnvelopeIcon"
                  >
                    Resend invitation
                  </DropdownItem>

                  <div>
                    <Modal
                      type="danger"
                    >
                      <template #trigger="{ setIsOpen }">
                        <div
                          @click="() => setIsOpen(true)"
                          class="flex cursor-pointer gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                        >
                          <div class="flex flex-col justify-center">
                            <TrashIcon class="h-4 w-4" />
                          </div>
                          Delete
                        </div>
                      </template>

                      <template #title>
                        Delete user
                      </template>

                      <template #content>"Are you sure you want to delete selected user? All of his data will be permanently removed from our servers forever. This action cannot be undone."</template>

                      <template #buttons="{ setIsOpen }">
                        <Button
                          @click.prevent="
                            () => {
                              action('delete', item.resource_url, {
                                onFinish: () => setIsOpen(false),
                              });
                            }
                          "
                          color="danger"
                        >
                          Delete
                        </Button>
                        <Button
                          @click.prevent="() => setIsOpen()"
                          color="gray"
                          variant="outline"
                        >
                          Cancel
                        </Button>
                      </template>
                    </Modal>
                  </div>
<!-- 
                  <DropdownItem
                    v-if="item.id !== $page.props.auth.user.id"
                    :href="route('users.impersonalLogin',{User: item.id,})"
                    :icon="ArrowLeftOnRectangleIcon"
                  >
                    Log as user"
                  </DropdownItem> -->
                </div>
              </template>
            </Dropdown>
          </div>
        </ListingDataCell>
      </template>
    </Listing>
  </PageContent>

  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
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
import { InviteUserForm } from "./types";
import { useToast } from "@brackets/vue-toastification";

interface Props {
  users: PaginatedCollection<User>;
  filterOptions: {
    roles: string[];
  };
}

const { action } = useAction();

const changeActiveStatus = (item: User) => {
  action("patch", route("user.activate", item.id), {
    active: !item.active,
  });
};

const statusOptions = [
  { id: "true", label: "Active" },
  { id: "false", label: "Inactive" },
  { id: "pending", label: "Pending" },
];

const props = defineProps<Props>();

const path = "/"+(usePage().props as PageProps).admin_path+"/users";

const { filtersForm, resetFilters, activeFiltersCount } = useListingFilters(path,
  {
    role: (usePage().props as PageProps).filter?.role ?? null,
    status: (usePage().props as PageProps).filter?.status ?? null,
  }
);

const isLastThreeItems = (item: User) => {
  const arrLength = props.users.data.length;

  let lastElement = props.users.data[arrLength - 1];
  let beforeLastElement = props.users.data[arrLength - 2];

  return lastElement.id === item.id || beforeLastElement.id === item.id;
};

const toast = useToast();

const form = useForm({
  email: "",
  role_id: "",
});

const submit = (closeModal: CallableFunction) => {
  form.post(route("invite-user"), {
    onSuccess: () => {
      form.email = "";
      form.role_id = "";

      closeModal();

      toast.success(usePage().props?.message);
    },
  });
};
</script>
