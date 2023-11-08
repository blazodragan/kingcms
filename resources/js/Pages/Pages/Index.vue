<template>
  <AppLayout title="Pages">
  <PageHeader :title="'Pages'">
    <Button
      :leftIcon="PlusIcon"
      :as="Link"
      :href="route('pages.create')"
      v-can="'sanctum.page.create'"
    >New Page
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
              v-can="'sanctum.page.destroy'"
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
              v-can="'sanctum.page.destroy'"
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
        <ListingHeaderCell>
            Slug
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
          <div class="flex items-center">
            <Avatar
              :src="item.cover_url"
              :name="`${item.alias}`"
            />
            <div class="ml-4">
              <div class="font-medium text-gray-900 truncate w-44">
                {{ item.title?.[currentLocale] }}
              </div>
            </div>
          </div>
  
        </ListingDataCell> 
        <ListingDataCell>
            {{ item.slug?.[currentLocale] }}
        </ListingDataCell>   
        <ListingDataCell>
             {{ item.user.name }}
        </ListingDataCell> 
        <ListingDataCell>
            <Publish :publishedAt="item.published_at" :updateUrl="route('pages.date', item.id)" columnName="published_at" mode="dateTime"/>
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
          <div class="flex items-center justify-end">
            
            <IconButton
              :as="Link"
              :href="route('page.edit', item)"
              variant="ghost"
              color="gray"
              :icon="PencilSquareIcon"
              v-can="'sanctum.page.edit'"
            />

            <Modal type="danger">
              <template #trigger="{ setIsOpen }">
                <IconButton
                  @click="() => setIsOpen(true)"
                  color="gray"
                  variant="ghost"
                  :icon="TrashIcon"
                  v-can="'sanctum.page.destroy'"
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
                  v-can="'sanctum.page.destroy'"
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
            <IconButton
              :as="Link"
              :href="route('page.clone', item)"
              variant="ghost"
              color="gray"
              :icon="DocumentDuplicateIcon"
              v-can="'sanctum.page.edit'"
            />
            <IconButton
              :as="Link"
              :href="item.parent_id ? route('showChild', { parentSlug: item.parent.slug?.[currentLocale], childSlug: item.slug?.[currentLocale]}) : route('showParent', { parentSlug: item.slug?.[currentLocale] })"
              variant="ghost"
              color="gray"
              :icon="EyeIcon"
              v-can="'sanctum.page.edit'"
            />

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
    XCircleIcon,
    EyeIcon,
    DocumentDuplicateIcon
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
}
defineProps<Props>();

const { filtersForm, resetFilters, activeFiltersCount } = useListingFilters(
  route("pages.index"),
  {
    user_id: usePage().props.filter?.user_id ?? null,
    published_at: usePage().props.filter?.published_at ?? null,
    status: usePage().props.filter?.status ?? null,
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
