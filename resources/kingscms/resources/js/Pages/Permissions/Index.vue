<template>
<AppLayout title="Permissions">
  <PageHeader sticky :title="'Manage permissions'">
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      v-can="'sanctum.permission.edit'"
    >Save</Button>
  </PageHeader>

  <PageContent>
    <Card noPadding>
      <div class="overflow-x-auto sm:rounded-t-md sm:rounded-b-md">
        <div class="inline-block min-w-full align-middle">
          <div class="relative overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <ListingHeaderCell class="bg-white">
                    <div class="text-xs font-medium text-slate-500">User
                    </div>
                    <div class="text-sm font-normal text-slate-900">Permission
                    </div>
                  </ListingHeaderCell>

                  <ListingHeaderCell
                    v-for="role in roles"
                    :key="role.name"
                    class="w-60 border-l bg-white"
                  >
                    <div class="w-60">
                      <div class="text-xs font-medium text-slate-500">Role
                      </div>
                      <div class="text-sm font-normal text-slate-900">
                        {{ role.name }}
                      </div>
                    </div>
                  </ListingHeaderCell>
                </tr>
              </thead>

              <tbody>
                <PermissionTableRow
                  v-for="(permission, name) in permissions"
                  v-model="form.roles"
                  :permission="permission"
                  :permissionName="name"
                />
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </Card>
  </PageContent>
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import {
  ListingHeaderCell,
  ListingDataCell,
  PageHeader,
  PageContent,
  Button,
  Card,
} from "kingcms/Components";
import type { Role } from "kingcms/types/models";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { useForm } from "kingcms/hooks/useForm";
import PermissionTableRow from "./Components/PermissionTableRow.vue";

interface Permission {
  [key: string]: Permission | string;
}

interface Props {
  roles: Role[];
  permissions: Permission;
}

const props = defineProps<Props>();

const { form, submit } = useForm<any>(
  {
    roles: props.roles,
  },
  route("permissions.update")
);
</script>
