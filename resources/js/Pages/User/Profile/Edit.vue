<template>
  <PageHeader
    sticky
    :title="$t('craftable-pro', 'Profile')"
    :subtitle="
      $t('craftable-pro', 'Last updated at :updated_at', {
        updated_at: dayjs(User.updated_at).format(
          'DD.MM.YYYY HH:mm'
        ),
      })
    "
  >
    <div class="flex gap-3">
      <Button
        :leftIcon="ArrowDownTrayIcon"
        @click="submit"
        :loading="form.processing"
      >
        {{ $t("craftable-pro", "Save") }}
      </Button>
    </div>
  </PageHeader>

  <PageContent>
    <div class="mx-auto max-w-3xl 2xl:max-w-4xl">
      <ProfileCard :form="form" />
    </div>
  </PageContent>
</template>

<script setup lang="ts">
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import {
  PageHeader,
  PageContent,
  Button,
  Multiselect,
} from "craftable-pro/Components";
import type { User } from "craftable-pro/types/models";
import { useForm } from "craftable-pro/hooks/useForm";
import dayjs from "dayjs";
import ProfileCard from "../Components/ProfileCard.vue";

interface Props {
  User: User;
}

const props = defineProps<Props>();

const { form, submit } = useForm(
  {
    first_name: props.User.first_name ?? "",
    last_name: props.User.last_name ?? "",
    email: props.User.email ?? "",
    locale: props.User.locale ?? "",
    avatar: props.User.avatar ?? [],
  },
  route("craftable-pro.craftable-pro-users.profile.update")
);
</script>
