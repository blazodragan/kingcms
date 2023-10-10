<template>
    <AppLayout title="Settings">
  <PageHeader sticky :title="'Settings'">
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'sanctum.settings.edit'"
    >Save
    </Button>
  </PageHeader>

  <PageContent>
    <template #tabs>
      <TabGroup variant="underline">
        <Tab>
          General
        </Tab>
        <Tab>
          <div class="flex items-center gap-3">
            Other settings
            <!-- <Tag color="amber" size="sm">Coming soon...</Tag> -->
          </div>
        </Tab>
      </TabGroup>
    </template>

    <TabPanel>
      <div class="divide-y divide-slate-200 [&>*]:py-5 max-w-screen-lg mx-auto">
        <Multiselect
          v-model="form.available_locales"
          mode="tags"
          name="available_locales"
          :required="true"
          :label="'Available locales'"
          :options="availableLocales"
          :placeholder="'Type abbreviation and hit enter'"
          :createOption="true"
          labelPlacement="left"
          :leftIcon="MagnifyingGlassIcon"
        >
          <template #tag="{ option, handleTagRemove, disabled }">
            <Tag
              variant="outline"
              @dismiss="(event) => handleTagRemove(option, event)"
              :dissmisable="true"
            >
              <LocaleFlag :locale="option.label" />
            </Tag>
          </template>
          <template #option="{ option, search }">
            <LocaleFlag :locale="option.label" />
          </template>
        </Multiselect>
        <Multiselect
          v-model="form.default_locale"
          mode="single"
          name="default_locale"
          :label="'Default locale'"
          :options="form.available_locales"
          labelPlacement="left"
          inputClass="w-1/2"
        >
          <template #singlelabel="{ value }">
            <LocaleFlag :locale="value.label" />
          </template>
          <template #option="{ option, search }">
            <LocaleFlag :locale="option.label" />
          </template>
        </Multiselect>
        <Multiselect
          v-model="form.default_route"
          mode="single"
          name="default_route"
          :label="'Default route'"
          :options="availableRoutes"
          labelPlacement="left"
        />
      </div>
    </TabPanel>
    <TabPanel>We can add more general settings here</TabPanel>
  </PageContent>
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import {
  PageHeader,
  PageContent,
  Button,
  Multiselect,
  Tag,
  Tab,
  TabGroup,
  LocaleFlag,
} from "craftable-pro/Components";
import { useForm } from "craftable-pro/hooks/useForm";
import { GeneralSettings } from "craftable-pro/Pages/Settings/types";
import { TabPanel } from "@headlessui/vue";
import { MagnifyingGlassIcon } from "@heroicons/vue/24/solid";

interface Props {
  generalSettings: GeneralSettings;
  availableRoutes: string[];
}

const props = defineProps<Props>();

const availableLocales = props.generalSettings.available_locales;

const { form, submit } = useForm<GeneralSettings>(
  {
    available_locales: props.generalSettings.available_locales,
    default_locale: props.generalSettings.default_locale,
    default_route: props.generalSettings.default_route,
  },
  route("settings.update")
);
</script>
