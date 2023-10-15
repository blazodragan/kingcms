<template>
  <AppLayout title="Translations">
  <PageHeader :title="'Translations'">
    <div class="flex">
      <ExportModal
        @toggle-open="exportModalOpened = !exportModalOpened"
        :open="exportModalOpened"
        :locales="locales"
        v-can="'sanctum.translation.export'"
      />
      <ImportModal
        @toggle-open="importModalOpened = !importModalOpened"
        :open="importModalOpened"
        :locales="locales"
        v-can="'sanctum.translation.import'"
      />
      <ButtonGroup>
        <Button
        @click="publishTranslations"
          v-can="'sanctum.translation.publish'"
        >Publish translations
        </Button>
        <Dropdown
          noContentPadding
          v-can:any="[
            'sanctum.translation.export',
            'sanctum.translation.import',
            'sanctum.translation.rescan',
          ]"
        >
          <template #button>
            <IconButton :icon="ChevronDownIcon" class="rounded-l-none" />
          </template>

          <template #content>
            <div class="py-1">
              <DropdownItem
               @click="rescanTranslations"
                v-can="'sanctum.translation.rescan'"
              >Re-scan translations
              </DropdownItem>
              <DropdownItem
                @click="exportModalOpened = true"
                v-can="'sanctum.translation.export'"
              >Export
              </DropdownItem>
              <DropdownItem
                @click="importModalOpened = true"
                v-can="'sanctum.translation.import'"
              >Import
              </DropdownItem>
            </div>
          </template>
        </Dropdown>
      </ButtonGroup>
    </div>
  </PageHeader>

  <PageContent>
    <Listing
      :data="data"
      :baseUrl="route('translations.index')"
      :withBulkSelect="false"
    >
      <template #actions>
        <FiltersDropdown
          :activeFiltersCount="activeFiltersCount"
          :resetFilters="resetFilters"
        >
          <Multiselect
            v-model="filtersForm.group"
            :options="groups"
            :label="'Groups'"
            mode="tags"
            name="groups"
          />
        </FiltersDropdown>
      </template>
      <template #tableHead>
        <ListingHeaderCell sortBy="group">
          {{ $t("kingcms", "Group") }}
        </ListingHeaderCell>

        <ListingHeaderCell sortBy="key">
          {{ $t("kingcms", "Default") }}
        </ListingHeaderCell>
        <ListingHeaderCell>
          {{ ($page.props as PageProps).auth.user.locale }}
        </ListingHeaderCell>

        <ListingHeaderCell>
          {{ $t("kingcms", "Last update") }}
        </ListingHeaderCell>

        <ListingHeaderCell></ListingHeaderCell>
      </template>
      <template #tableRow="{ item, action }">
        <ListingDataCell>
          {{ item.group }}
        </ListingDataCell>

        <ListingDataCell>
          <div class="max-w-sm overflow-hidden text-ellipsis">
            {{ item.key }}
          </div>
        </ListingDataCell>

        <ListingDataCell>
          <div class="max-w-sm overflow-hidden text-ellipsis">
            {{ item.text[($page.props as PageProps).auth.user.locale] }}
          </div>
        </ListingDataCell>

        <ListingDataCell>
          {{ dayjs(item.updated_at).format("DD.MM.YYYY HH:mm") }}
        </ListingDataCell>

        <ListingDataCell>
          <div class="flex items-center justify-end gap-3">
            <EditTranslationModal
              :language-line="item"
              :locales="locales"
              v-can="'sanctum.translation.edit'"
            ></EditTranslationModal>
          </div>
        </ListingDataCell>
      </template>
    </Listing>
  </PageContent>
</AppLayout>
</template>

<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { EllipsisVerticalIcon } from "@heroicons/vue/24/solid";
import {
  Button,
  Listing,
  ListingDataCell,
  ListingHeaderCell,
  Multiselect,
  PageHeader,
  PageContent,
  IconButton,
  Dropdown,
  FiltersDropdown,
  DropdownItem,
  ButtonGroup,
} from "craftable-pro/Components";
import { PaginatedCollection } from "craftable-pro/types/pagination";
import type { LanguageLine } from "craftable-pro/types/models";
import type { PageProps } from "craftable-pro/types/page";
import { useAction } from "craftable-pro/hooks/useAction";
import EditTranslationModal from "@/Pages/Translations/Components/EditTranslationModal.vue";
import ExportModal from "@/Pages/Translations/Components/ExportModal.vue";
import ImportModal from "@/Pages/Translations/Components/ImportModal.vue";
import { useToast } from "@brackets/vue-toastification";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useListingFilters } from "craftable-pro/hooks/useListingFilters";
import dayjs from "dayjs";
import { ChevronDownIcon } from "@heroicons/vue/24/outline";

interface Props {
  data: PaginatedCollection<LanguageLine>;
  groups: string[];
  locales: string[];
}

const toast = useToast();
const { action } = useAction();
const exportModalOpened = ref<boolean>(false);
const importModalOpened = ref<boolean>(false);

defineProps<Props>();

const { filtersForm, resetFilters, activeFiltersCount } = useListingFilters(
  route("translations.index"),
  {
    group: (usePage().props as PageProps)?.filter?.group ?? null,
  }
);

// Initialize the adminPath ref with your value
const adminPath = ref((usePage().props as PageProps).admin_path);

// Define a function to rescan translations
const rescanTranslations = () => {
  const url = `/${adminPath.value}/translations/rescan`;
  action('post', url);
  toast.warning('Scanning translations...');
};

const publishTranslations = () => {
  const url = `/${adminPath.value}/translations/publish`;
  action('post', url);
  toast.warning('Scanning translations...');
};

const reload = () => {
  window.location.reload();
};
</script>
