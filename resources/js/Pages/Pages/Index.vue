<template>
  <AppLayout title="Pages">
  <PageHeader :title="'Pages'">
    <Button
      :leftIcon="PlusIcon"
      :as="Link"
      :href="route('pages.create')"
      v-can="'sanctum.news.create'"
    >New News
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
      :baseUrl="route('pages.index')"
      :data="pages"
      dataKey="pages"
    >
    <template #actions>
        <FiltersDropdown
          :activeFiltersCount="activeFiltersCount"
          :resetFilters="resetFilters"
        >
          <Multiselect
            v-model="filtersForm.user_id"
            name="user_id"
            mode="tags"
            :label="'User'"
            :options="userOptions"
            optionsLabel="label"
            optionsValueProp="value"
          />
          <Multiselect
            v-model="filtersForm.status"
            name="status"
            mode="tags"
            :label="'Status'"
            :options="statusOptions"
            optionsLabel="label"
            optionsValueProp="value"
          />
          <Multiselect
            v-model="filtersForm.category"
            name="category"
            mode="tags"
            :label="'Categories'"
            :options="categoriesOptions"
            optionsLabel="label"
            optionsValueProp="value"
          />
          <DatePicker
            v-model="filtersForm.published_at"
            name="published_at"
            :label="'Published at'"
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
              v-can="'sanctum.news.destroy'"
            >Delete
            </Button>
          </template>

          <template #title>Delete Pages
          </template>
          <template #content>Are you sure you want to delete selected Pages? All data will be permanently removed from our servers forever. This action cannot be undone.
          </template>

          <template #buttons="{ setIsOpen }">
            <Button
              @click.prevent="
                () => {
                  bulkAction('post', route('pages.bulk-destroy'), {
                    onFinish: () => setIsOpen(false),
                  });
                }
              "
              color="danger"
              v-can="'sanctum.news.destroy'"
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
        <ListingHeaderCell sortBy="title">
            Title
        </ListingHeaderCell> 
        <ListingHeaderCell sortBy="user_id">
            User
        </ListingHeaderCell> 
        <ListingHeaderCell sortBy="published_at">
            Published At
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
             {{ item.title?.[currentLocale] }}
        </ListingDataCell> 
        <ListingDataCell>
             {{ item.user.name }}
        </ListingDataCell> 
        <ListingDataCell>
            <Publish :publishedAt="item.published_at" :updateUrl="route('pages.update', item.id)" columnName="published_at" mode="dateTime"/>
        </ListingDataCell>
        <ListingDataCell class="text-left">
            <div v-if="item.status == 'Published'">
              <Tag :icon="CheckCircleIcon" color="success" rounded size="sm">
                {{ item.status }}
              </Tag>
            </div>
            <div v-else-if="item.status == 'Draft'">
              <Tag :icon="XCircleIcon" color="gray" rounded size="sm">
                {{ item.status }}
              </Tag>
            </div>
            <div v-else>
            <Tag
              :icon="ExclamationCircleIcon"
              color="warning"
              rounded
              size="sm"
            >
            {{ item.status }}
            </Tag>
          </div>
        </ListingDataCell>
        <ListingDataCell>
          <div class="flex items-center justify-end gap-3">
            <IconButton
              :as="Link"
              :href="route('pages.edit', item)"
              variant="ghost"
              color="gray"
              :icon="PencilSquareIcon"
              v-can="'sanctum.news.edit'"
            />

            <Modal type="danger">
              <template #trigger="{ setIsOpen }">
                <IconButton
                  @click="() => setIsOpen(true)"
                  color="gray"
                  variant="ghost"
                  :icon="TrashIcon"
                  v-can="'sanctum.news.destroy'"
                />
              </template>

              <template #title>Delete Pages
              </template>
              <template #content>Are you sure you want to delete selected Pages? All data will be permanently removed from our servers forever. This action cannot be undone
              </template>

              <template #buttons="{ setIsOpen }">
                <Button
                  @click.prevent="
                    () => {
                      action('delete', route('pages.destroy', item), {
                        onFinish: () => setIsOpen(false),
                      });
                    }
                  "
                  color="danger"
                  v-can="'sanctum.news.destroy'"
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
    CheckCircleIcon,
    ExclamationCircleIcon,
    XCircleIcon
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
    DatePicker,
    IconButton,
    FiltersDropdown,
    Publish,
    ListingToggle,
    Tag,
} from "kingcms/Components";
import { PaginatedCollection } from "kingcms/types/pagination";
import type { PageProps } from "kingcms/types/page";
import { useListingFilters } from "kingcms/hooks/useListingFilters";
import dayjs from "dayjs";


import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  pages: PaginatedCollection<Pages>;
  userOptions: Object[];
  statusOptions: Object[];
  categoriesOptions: Object[];
}
defineProps<Props>();

const { filtersForm, resetFilters, activeFiltersCount } = useListingFilters(
  route("pages.index"),
  {
    user_id: usePage().props.filter?.user_id ?? null,
    published_at: usePage().props.filter?.published_at ?? null,
    status: usePage().props.filter?.status ?? null,
    category: usePage().props.filter?.category ?? null,
  }
);


const downloadFile = () => {
    const url = window.location.href.split("?");
    if(url.length > 1) {
      window.location = route('pages.export', url.pop()).slice(0, -1);
    } else {
      window.location = route('pages.export');
    }
}
</script>
