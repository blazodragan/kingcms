<template>
  <AppLayout title="Categories">
  <PageHeader :title="'Categories'">
    <Button
      :leftIcon="PlusIcon"
      :as="Link"
      :href="route('categories.create')"
      v-can="'sanctum.category.create'"
    >New Category
    </Button>
    <Button
      :leftIcon="ArrowDownTrayIcon"
      as="a"
      class="ml-2"
      @click="downloadFile"
    >Export
    </Button>
  </PageHeader>

  <PageContent>
    <Listing
      :baseUrl="route('categories.index')"
      :data="categories"
      dataKey="categories"
    >
    <template #actions>
        <FiltersDropdown
          :activeFiltersCount="activeFiltersCount"
          :resetFilters="resetFilters"
        >
          <Multiselect
            v-model="filtersForm.type"
            name="type"
            mode="tags"
            :label="'Type'"
            :options="categoryTypes"
            optionsLabel="label"
            optionsValueProp="value"
          />
        </FiltersDropdown>
      </template>
      <template #bulkActions="{ bulkAction }">
        <Modal type="danger">
          <template #trigger="{ setIsOpen }">
            <Button
              @click="() => setIsOpen(true)"
              color="gray"
              variant="outline"
              size="sm"
              :leftIcon="TrashIcon"
              v-can="'sanctum.category.destroy'"
            >Delete
            </Button>
          </template>

          <template #title>Delete Category
          </template>
          <template #content>Confirm deletion? Data will be permanently removed and can't be undone.
          </template>

          <template #buttons="{ setIsOpen }">
            <Button
              @click.prevent="
                () => {
                  bulkAction('post', route('categories.bulk-destroy'), {
                    onFinish: () => setIsOpen(false),
                  });
                }
              "
              color="danger"
              v-can="'sanctum.category.destroy'"
            >Delete
            </Button>
            <Button
              @click.prevent="() => setIsOpen()"
              color="gray"
              variant="outline"
            >Cancel
            </Button>
          </template>
        </Modal>
      </template>
      <template #tableHead>
        
        <ListingHeaderCell sortBy="id">
            Id
        </ListingHeaderCell> 
        <ListingHeaderCell sortBy="alias">
            Alias
        </ListingHeaderCell> 
        <ListingHeaderCell sortBy="slug">
            Slug
        </ListingHeaderCell> 
        <ListingHeaderCell sortBy="title">
            Title
        </ListingHeaderCell> 
        <ListingHeaderCell sortBy="type">
          type
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
              :src="item.cover_url"
              :name="`${item.alias}`"
            />
            <div class="ml-4">
              <div class="font-medium text-gray-900">
                <!-- TODO: maybe have full_name attribute? -->
                {{ item.alias }}
              </div>
            </div>
          </div>
        </ListingDataCell>

        <ListingDataCell>
             {{ item.slug?.[currentLocale] }}
        </ListingDataCell> 
        <ListingDataCell>
             {{ item.title?.[currentLocale] }}
        </ListingDataCell>
        <ListingDataCell class="text-left">
            <div v-if="item.type == 'location'">
              <Tag :icon="ExclamationCircleIcon" color="success" rounded size="sm">
                {{ item.type }}
              </Tag>
            </div>
            <div v-else-if="item.type == 'general'">
              <Tag :icon="TagIcon" color="gray" rounded size="sm">
                {{ item.type }}
              </Tag>
            </div>
            <div v-else>
            <Tag
              :icon="ExclamationCircleIcon"
              color="warning"
              rounded
              size="sm"
            >
            {{ item.type }}
            </Tag>
          </div>
        </ListingDataCell>

        <ListingDataCell>
          <div class="flex items-center justify-end gap-3">
            <IconButton
              :as="Link"
              :href="route('category.edit', item)"
              variant="ghost"
              color="gray"
              :icon="PencilSquareIcon"
              v-can="'sanctum.category.edit'"
            />

            <Modal type="danger">
              <template #trigger="{ setIsOpen }">
                <IconButton
                  @click="() => setIsOpen(true)"
                  color="gray"
                  variant="ghost"
                  :icon="TrashIcon"
                  v-can="'sanctum.category.destroy'"
                />
              </template>

              <template #title>Delete Category
              </template>
              <template #content>
                Confirm deletion? Data will be permanently removed and can't be undone.
              </template>

              <template #buttons="{ setIsOpen }">
                <Button
                  @click.prevent="
                    () => {
                      action('delete', route('categories.destroy', item), {
                        onFinish: () => setIsOpen(false),
                      });
                    }
                  "
                  color="danger"
                  v-can="'sanctum.category.destroy'"
                >Delete
                </Button>
                <Button
                  @click.prevent="() => setIsOpen()"
                  color="gray"
                  variant="outline"
                >Cancel
                </Button>
              </template>
            </Modal>
          </div>
        </ListingDataCell>
      </template>
    </Listing>
  </PageContent>
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, usePage } from "@inertiajs/vue3";
import {
    PlusIcon,
    TrashIcon,
    PencilSquareIcon,
    ArrowDownTrayIcon,
    ExclamationCircleIcon,
    TagIcon,
} from "@heroicons/vue/24/outline";
import {
    PageHeader,
    PageContent,
    Button,
    Listing,
    Avatar,
    ListingHeaderCell,
    ListingDataCell,
    Modal,
    Multiselect,
    IconButton,
    FiltersDropdown,
    Publish,
    ListingToggle,
    Tag
} from "kingcms/Components";
import { PaginatedCollection } from "kingcms/types/pagination";
import type { Category } from "./types";
import type { PageProps } from "kingcms/types/page";
import { useListingFilters } from "kingcms/hooks/useListingFilters";
import dayjs from "dayjs";


import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
      

interface Props {
  categories: PaginatedCollection<Category>;
  categoryTypes: Object[];
}
defineProps<Props>();

const { filtersForm, resetFilters, activeFiltersCount } = useListingFilters(
  route("categories.index"),
  {    
    type: usePage().props.filter?.type ?? null,
    
  }
);
const downloadFile = () => {
    const url = window.location.href.split("?");
    if(url.length > 1) {
      window.location = route('categories.export', url.pop()).slice(0, -1);
    } else {
      window.location = route('categories.export');
    }
}
</script>
