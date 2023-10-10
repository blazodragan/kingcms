<template>
  <div>
    <Head :title="'Register'" />

    <div
      class="bg-white py-8 px-4 space-y-3 shadow sm:rounded-lg sm:px-10"
      v-auto-animate
    >
      <form class="space-y-6" @submit.prevent="submit">
        <TextInput
          v-model="form.name"
          name="name"
          :label="'name'"
          class="col-span-6 sm:col-span-3"
          :required="true"
        />
        <TextInput
          v-model="form.last_name"
          name="last_name"
          :label="'Last name'"
          class="col-span-6 sm:col-span-3"
          :required="true"
        />
        <TextInput
          v-model="form.email"
          name="email"
          :label="'E-mail'"
          type="email"
          class="col-span-6 sm:col-span-3"
          :disabled="true"
        />
        <TextInput
          v-model="form.password"
          name="password"
          :label="'Password'"
          type="password"
          autocomplete="new-password"
          class="col-span-6 sm:col-span-3 sm:col-start-1"
          :required="true"
        />
        <TextInput
          v-model="form.password_confirmation"
          name="password_confirmation"
          :label="'Password confirmation'"
          type="password"
          autocomplete="new-password"
          class="col-span-6 sm:col-span-3 sm:col-start-1"
          :required="true"
        />
        <Multiselect
          v-model="form.locale"
          name="locale"
          :label="'Locale'"
          mode="single"
          :options="locales"
          options-value-prop="key"
          options-label="value"
          class="col-span-6 sm:col-span-3 sm:col-start-1"
          :canDeselect="false"
          :required="true"
        />

        <Button class="w-full" type="submit" :disabled="form.processing">Save
        </Button>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Button, TextInput, Multiselect } from "craftable-pro/Components";
import { useForm, Head } from "@inertiajs/vue3";
import { useToast } from "@brackets/vue-toastification";
import { trans } from "craftable-pro/plugins/laravel-vue-i18n";
interface Props {
  locales?: string[];
  defaultLocale: string;
  email: string;
}

const props = withDefaults(defineProps<Props>(), {
  locales: () => ["en"],
  defaultLocale: "en",
});

const form = useForm({
  email: props.email,
  first_name: "",
  last_name: "",
  password: "",
  password_confirmation: "",
  locale: "",
});

const toast = useToast();

const submit = () => {
  form.post(route("craftable-pro.invite-user.store"), {
    onSuccess: () => {
      toast.success(
        trans(
          "craftable-pro",
          "Your account was succesfully created and you can log in now."
        )
      );
    },
    onFinish: () => {
      form.reset("password");
    },
  });
};
</script>
