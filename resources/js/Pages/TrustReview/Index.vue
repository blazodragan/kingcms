<template>
  <AppLayout title="Trust Review">
  <PageHeader :title="'Trust Review'">
    <Button
      :leftIcon="PlusIcon"
      :as="Link"
      :href="route('trust_reviews.create')"
      v-can="'sanctum.category.create'"
    >New Trust Review
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
      :baseUrl="route('trust_reviews.index')"
      :data="trustReviews"
      dataKey="trustReviews"
    >
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

          <template #title>Delete Trust Review
          </template>
          <template #content>Confirm deletion? Data will be permanently removed and can't be undone.
          </template>

          <template #buttons="{ setIsOpen }">
            <Button
              @click.prevent="
                () => {
                  bulkAction('post', route('trust_reviews.bulk-destroy'), {
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


        <ListingHeaderCell sortBy="title">
            Title
        </ListingHeaderCell> 
        <ListingHeaderCell sortBy="description">
            Description
        </ListingHeaderCell>
        <ListingHeaderCell sortBy="rating">
            Rating
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
             {{ item.description?.[currentLocale] }}
        </ListingDataCell>
        <ListingDataCell>
             {{ item.rating }}
        </ListingDataCell>
        <ListingDataCell>
          <div class="flex items-center justify-end gap-3">
            <IconButton
              :as="Link"
              :href="route('trust_reviews.edit', item)"
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
                  v-can="'sacntum.category.destroy'"
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
                      action('delete', route('trust_reviews.destroy', item), {
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
} from "kingcms/Components";
import { PaginatedCollection } from "kingcms/types/pagination";
import type { trustReview } from "./types";
import type { PageProps } from "kingcms/types/page";
import dayjs from "dayjs";


import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  trustReviews: PaginatedCollection<trustReview>;
}
defineProps<Props>();
const downloadFile = () => {
    const url = window.location.href.split("?");
    if(url.length > 1) {
      window.location = route('trust_reviews.export', url.pop()).slice(0, -1);
    } else {
      window.location = route('trust_reviews.export');
    }
}
</script>
