<template>
  <AppLayout title="Media">
  <PageHeader :title="'Media'">
    <ImageUploadModal @imageUploaded="imageUploaded">
      <template #button="{ setIsOpen }">
        <Button
          v-can="'sanctum.media.upload'"
          :left-icon="PlusIcon"
          as="button"
          @click="() => setIsOpen(true)"
        >Upload media
        </Button>
      </template>
    </ImageUploadModal>
  </PageHeader>

  <PageContent>
    <Card :no-padding="selectedView === 'list'">
      <template #tabs>
        <Tab
          :href="route('media.index')"
          :selected="routeIsActive(route('media.index'))"
        >
          All
        </Tab>
        <Tab
          :href="route('media.images')"
          :selected="routeIsActive(route('media.images'))"
        >
          Images
        </Tab>
        <Tab
          :href="route('media.files')"
          :selected="routeIsActive(route('media.files'))"
        >Files
        </Tab>
      </template>
      <template #actions>
        <div class="flex items-center gap-4 divide-x">
          <FiltersDropdown
            :active-filters-count="activeFiltersCount"
            :reset-filters="resetFilters"
          >
            <Multiselect
              v-if="filterOptions.model_type?.length"
              v-model="filtersForm.model_type"
              name="model_type"
              :label="'Model type'"
              :options="filterOptions.model_type"
            />
            <Multiselect
              v-if="filterOptions.collection_name?.length"
              v-model="filtersForm.collection_name"
              name="collection_name"
              :label="'Collection'"
              :options="filterOptions.collection_name"
            />
            <Multiselect
              v-if="filterOptions.mime_type?.length"
              v-model="filtersForm.mime_type"
              name="mime_type"
              :label="'Mime type'"
              :options="filterOptions.mime_type"
            />
            <Multiselect
              v-if="filterOptions.disk?.length"
              v-model="filtersForm.disk"
              name="disk"
              :label="'Disk'"
              :options="filterOptions.disk"
            />
          </FiltersDropdown>
          <div class="flex items-center gap-4 pl-4">
            <div class="relative flex gap-1 rounded-md bg-gray-100 p-0.5">
              <div
                class="absolute inset-0 right-auto w-1/2 p-0.5 transition-all"
                :class="{
                  'translate-x-0': selectedView === 'grid',
                  'translate-x-full': selectedView === 'list',
                }"
              >
                <div class="h-full w-full rounded-md bg-white shadow-sm" />
              </div>
              <IconButton
                v-for="view in ['grid', 'list']"
                :key="view"
                size="xs"
                :icon="view === 'grid' ? Squares2X2Icon : Bars3Icon"
                :variant="selectedView === view ? 'ghost' : 'ghost'"
                :color="selectedView === view ? 'primary' : 'gray'"
                :class="{
                  '!bg-transparent': selectedView === view,
                }"
                class="z-10"
                @click="selectedView = view"
              />
            </div>
          </div>
        </div>
      </template>

      <section>
        <EmptyListing v-if="!data.data.length" />

        <template v-else>
          <ul
            v-if="selectedView === 'grid'"
            role="list"
            class="3xl:grid-cols-5 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8"
            :class="[
              selectedImage
                ? 'xl:grid-cols-3 2xl:grid-cols-4'
                : 'xl:grid-cols-5 2xl:grid-cols-5',
            ]"
          >
            <li v-for="file in data.data" :key="file.id" class="relative">
              <div
                :class="[
                  selectedImage?.id === file.id
                    ? 'ring-primary-500 ring-2 ring-offset-2'
                    : ' focus-within:ring-primary-500 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100',
                  'group block w-full overflow-hidden rounded-md border border-gray-100',
                ]"
              >
                <FileThumbnail :file="file" />

                <button
                  type="button"
                  class="absolute inset-0 focus:outline-none"
                  @click="selectedImage = file"
                >
                  <span class="sr-only"> View details for {{ file.custom_properties?.name || file.file_name }}, 
                  </span>
                </button>
              </div>

              <p
                class="pointer-events-none mt-2 block truncate text-sm font-medium text-gray-900"
              >{{ file.custom_properties?.name || file.file_name }}
              </p>

              <p
                class="pointer-events-none block text-sm font-medium text-gray-500"
              >
                {{ formatBytes(file.size) }}
              </p>
            </li>
          </ul>

          <div v-if="selectedView === 'list'" class="overflow-x-auto">
            <Listing
              :base-url="baseUrl"
              :data="data"
              data-key="data"
              :with-pagination="false"
              :with-bulk-select="false"
              class="inline-block min-w-full align-middle"
            >
              <template #tableHead>
                <ListingHeaderCell>
                  Preview
                </ListingHeaderCell>

                <ListingHeaderCell sort-by="title">
                  Title
                </ListingHeaderCell>

                <ListingHeaderCell sort-by="size">
                  Size
                </ListingHeaderCell>
              </template>

              <template #tableRow="{ item, action }: any">
                <ListingDataCell @click="selectedImage = item">
                  <FileThumbnail
                    :file="item"
                    class="!w-14 cursor-pointer"
                    :class="[
                      selectedImage?.id === item.id
                        ? 'ring-primary-500 ring-2 ring-offset-2'
                        : ' focus-within:ring-primary-500 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100',
                      'group block w-full overflow-hidden rounded-md border border-gray-100',
                    ]"
                  />
                </ListingDataCell>
                <ListingDataCell>
                  {{ item.custom_properties?.name || item.file_name }}
                </ListingDataCell>
                <ListingDataCell>
                  {{ formatBytes(item.size) }}
                </ListingDataCell>
              </template>
            </Listing>
          </div>
        </template>
      </section>
      <template #footer>
        <CardFooter>
          <Pagination :pagination="pagination" data-key="data" />
        </CardFooter>
      </template>
    </Card>

    <template #aside>
      <!-- Details sidebar -->
      <Aside v-if="selectedImage" class="hidden xl:block">
        <div class="space-y-6 pb-16">
          <!-- Preview -->
          <div v-if="showFileInfo">
            <div class="mb-4 block w-full overflow-hidden rounded-lg">
              <FileThumbnail :file="selectedImage" />
            </div>
            <div class="flex items-start justify-between">
              <div class="overflow-auto">
                <h2 class="truncate text-lg font-medium text-gray-900">
                  <span class="sr-only"
                    >Details for
                  </span>
                  {{
                    selectedImage.custom_properties?.name ||
                    selectedImage.file_name
                  }}
                </h2>
                <p class="text-sm font-medium text-gray-500">
                  {{ formatBytes(selectedImage.size) }}
                </p>
              </div>
            </div>
          </div>

          <!-- Information -->
          <div v-if="showFileInfo">
            <h3 class="font-medium text-gray-900">
              Information
            </h3>

            <dl
              class="mt-2 divide-y divide-gray-200 border-t border-b border-gray-200"
            >
              <!-- Model type -->
              <div class="py-3 text-sm font-medium">
                <dt class="text-gray-500">
                  Model type
                </dt>
                <dd class="whitespace-nowrap text-gray-900">
                  {{ selectedImage.model_type }}
                </dd>
              </div>

              <!-- Model ID -->
              <div class="flex justify-between py-3 text-sm font-medium">
                <dt class="text-gray-500">
                  Model ID
                </dt>
                <dd class="whitespace-nowrap text-gray-900">
                  {{ selectedImage.model_id }}
                </dd>
              </div>

              <!-- Collection -->
              <div class="flex justify-between py-3 text-sm font-medium">
                <dt class="text-gray-500">
                  Collection
                </dt>
                <dd class="whitespace-nowrap text-gray-900">
                  {{ selectedImage.collection_name }}
                </dd>
              </div>

              <!-- Custom properties -->
              <template
                v-for="(property, key) in selectedImage.custom_properties"
              >
                <template v-if="key !== 'name'">
                  <CustomPropertyInput
                    :key="key"
                    v-model="selectedImage.custom_properties[key]"
                    :propertyName="key"
                    @saved="updateMedia"
                  />
                </template>
              </template>

              <!-- Mime Type -->
              <div class="flex justify-between py-3 text-sm font-medium">
                <dt class="text-gray-500">
                  Mime Type
                </dt>
                <dd class="whitespace-nowrap text-gray-900">
                  {{ selectedImage.mime_type }}
                </dd>
              </div>

              <!-- Uploaded at -->
              <div class="flex justify-between py-3 text-sm font-medium">
                <dt class="text-gray-500">
                  Uploaded at
                </dt>
                <dd class="whitespace-nowrap text-gray-900">
                  {{
                    dayjs(selectedImage.created_at).format("DD.MM.YYYY HH:mm")
                  }}
                </dd>
              </div>

              <!-- Last modified -->
              <div class="flex justify-between py-3 text-sm font-medium">
                <dt class="text-gray-500">
                  Last modified
                </dt>
                <dd class="whitespace-nowrap text-gray-900">
                  {{
                    dayjs(selectedImage.updated_at).format("DD.MM.YYYY HH:mm")
                  }}
                </dd>
              </div>
            </dl>
          </div>

          <!-- Buttons -->
          <div v-if="showFileInfo" class="flex gap-4">
            <Button
              as="a"
              :leftIcon="CloudArrowDownIcon"
              :href="selectedImage.original_url"
              :download="
                selectedImage.custom_properties?.name || selectedImage.file_name
              "
            >
              Download
            </Button>

            <Modal type="danger">
              <template #trigger="{ setIsOpen }">
                <Button
                  v-can="'sanctum.media.destroy'"
                  color="gray"
                  variant="outline"
                  :leftIcon="TrashIcon"
                  @click="() => setIsOpen(true)"
                >
                  Delete
                </Button>
              </template>

              <template #title>
                <div class="max-w-sm">
                  Delete

                  <p class="truncate text-gray-500">
                    {{
                      selectedImage.custom_properties?.name ||
                      selectedImage.file_name
                    }}
                  </p>
                </div>
              </template>

              <template #content>
                Confirm deletion? Data will be permanently removed and can't be undone.
              </template>

              <template #buttons="{ setIsOpen }">
                <Button
                  color="danger"
                  @click.prevent="
                    () => {
                      deleteMedia(selectedImage.id);
                    }
                  "
                >
                  Delete
                </Button>
                <Button
                  color="gray"
                  variant="outline"
                  @click.prevent="() => setIsOpen()"
                >
                  Cancel
                </Button>
              </template>
            </Modal>
          </div>
        </div>
      </Aside>
    </template>
  </PageContent>
</AppLayout>
</template>

<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, watch, computed } from "vue";
import dayjs from "dayjs";
import {
  Squares2X2Icon,
  Bars3Icon,
  PlusIcon,
  TrashIcon,
} from "@heroicons/vue/20/solid";
import {
  Button,
  Modal,
  IconButton,
  PageHeader,
  PageContent,
  Card,
  CardFooter,
  Aside,
  Multiselect,
  FileThumbnail,
  EmptyListing,
  FiltersDropdown,
  Listing,
  ListingDataCell,
  ListingHeaderCell,
  Pagination,
  ImageUploadModal,
  Tab,
} from "kingcms/Components";
import { formatBytes } from "kingcms/helpers";
import type { Media } from "./types";
import type { UploadedFile } from "kingcms/types";
import { PaginatedCollection } from "kingcms/types/pagination";
import { useListingFilters } from "kingcms/hooks/useListingFilters";
import { Link, usePage, router } from "@inertiajs/vue3";
import { PageProps } from "kingcms/types/page";
import axios from "axios";
import CustomPropertyInput from "./Components/CustomPropertyInput.vue";
import { CloudArrowDownIcon } from "@heroicons/vue/24/outline";

interface Props {
  data: PaginatedCollection<Media>;
  filterOptions: {
    model_type: string[];
    collection_name: string[];
    mime_type: string[];
    disk: string[];
  };
}

const routeIsActive = (url: string) => {
  const currentUrl = usePage().url.split("?")[0];
  return `${url}?`.indexOf(`${currentUrl}?`) !== -1;
};

const props = defineProps<Props>();

const showFileInfo = ref(true);

const selectedImage = ref<Media | null>(null);
const selectedView = ref("grid");

watch(
  () => selectedImage.value,
  () => {
    showFileInfo.value = false;
    setTimeout(() => {
      showFileInfo.value = true;
    }, 200);
  }
);

const pagination = computed(() => props.data);

const baseUrl = computed(() => {
  if (routeIsActive(route("media.images"))) {
    return route("media.images");
  }

  if (routeIsActive(route("media.files"))) {
    return route("media.files");
  }

  return route("media.index");
});

const { filtersForm, resetFilters, activeFiltersCount } = useListingFilters(
  baseUrl.value,
  {
    model_type: (usePage().props as PageProps).filter?.model_type
      ? [(usePage().props as PageProps).filter?.model_type]
      : [],
    collection_name: (usePage().props as PageProps).filter?.collection_name
      ? [(usePage().props as PageProps).filter?.collection_name]
      : [],
    mime_type: (usePage().props as PageProps).filter?.mime_type
      ? [(usePage().props as PageProps).filter?.mime_type]
      : [],
    disk: (usePage().props as PageProps).filter?.disk
      ? [(usePage().props as PageProps).filter?.disk]
      : [],
  }
);

const imageUploaded = (media: UploadedFile) => {
  if (media) {
    router.reload({ only: ["data"] });
  }
};

const path = "/"+(usePage().props as PageProps).admin_path+"/unassigned-media-destroy/";

const deleteMedia = (id: number) => {
  axios
    .delete(path + id)
    .then((response: any) => {
      selectedImage.value = null;

      // Update data
      router.reload({ only: ["data"] });
    })
    .catch((error) => console.error(error));
};

const updateMedia = () => {

  const pathUpload = "/"+(usePage().props as PageProps).admin_path+"/media/update/";

  axios.post(pathUpload + selectedImage.value.id, {
    custom_properties: selectedImage.value.custom_properties
  })
    .then((response: any) => {
      router.reload({only: ["data"]})
    })
    .catch((error) => console.error(error));
}
</script>
