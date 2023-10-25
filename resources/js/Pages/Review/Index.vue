<template>
  <AppLayout title="Reviews">
  <PageHeader :title="'Reviews'">
    <Button
      :leftIcon="PlusIcon"
      :as="Link"
      :href="route('reviews.create')"
      v-can="'sanctum.review.create'"
    >New Review
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
      :baseUrl="route('reviews.index')"
      :data="reviews"
      dataKey="reviews"
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
              v-can="'sanctum.review.destroy'"
            >Delete
            </Button>
          </template>

          <template #title>Delete Review
          </template>
          <template #content>
            Confirm deletion? Data will be permanently removed and can't be undone.
          </template>

          <template #buttons="{ setIsOpen }">
            <Button
              @click.prevent="
                () => {
                  bulkAction('post', route('reviews.bulk-destroy'), {
                    onFinish: () => setIsOpen(false),
                  });
                }
              "
              color="danger"
              v-can="'sanctum.review.destroy'"
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
        <ListingHeaderCell sortBy="active">
            Active
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
            <ListingToggle name="active" v-model="item.active" :updateUrl="route('reviews.update', item.id)" />
        </ListingDataCell> 
        <ListingDataCell>
             {{ item.user.name }}
        </ListingDataCell> 
        <ListingDataCell>
        <Publish :publishedAt="item.published_at" :updateUrl="route('reviews.update', item.id)" columnName="published_at" mode="dateTime"/>
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
              :href="route('review.edit', item)"
              variant="ghost"
              color="gray"
              :icon="PencilSquareIcon"
              v-can="'sanctum.review.edit'"
            />

            <Modal type="danger">
              <template #trigger="{ setIsOpen }">
                <IconButton
                  @click="() => setIsOpen(true)"
                  color="gray"
                  variant="ghost"
                  :icon="TrashIcon"
                  v-can="'sanctum.review.destroy'"
                />
              </template>

              <template #title>Delete Review
              </template>
              <template #content>
                Confirm deletion? Data will be permanently removed and can't be undone.
              </template>

              <template #buttons="{ setIsOpen }">
                <Button
                  @click.prevent="
                    () => {
                      action('delete', route('reviews.destroy', item), {
                        onFinish: () => setIsOpen(false),
                      });
                    }
                  "
                  color="danger"
                  v-can="'sanctum.review.destroy'"
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
import type { Review } from "./types";
import type { PageProps } from "kingcms/types/page";
import { useListingFilters } from "kingcms/hooks/useListingFilters";
import dayjs from "dayjs";


import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  reviews: PaginatedCollection<Review>;
  userOptions: Object[];
  statusOptions: Object[];
  categoriesOptions: Object[];

}
defineProps<Props>();



const { filtersForm, resetFilters, activeFiltersCount } = useListingFilters(
  route("reviews.index"),
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
      window.location = route('reviews.export', url.pop()).slice(0, -1);
    } else {
      window.location = route('reviews.export');
    }
}
</script>
