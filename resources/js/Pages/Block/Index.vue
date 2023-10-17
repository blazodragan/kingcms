<template>
  <AppLayout title="Blocks">
  <PageHeader :title="'Blocks'">
    <Button
      :leftIcon="PlusIcon"
      :as="Link"
      :href="route('blocks.create')"
      v-can="'sanctum.category.create'"
    >New Block
    </Button>
  </PageHeader>

  <PageContent>
    <Listing
      :baseUrl="route('blocks.index')"
      :data="blocks"
      dataKey="blocks"
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

          <template #title>Delete Block
          </template>
          <template #content>Confirm deletion? Data will be permanently removed and can't be undone.
          </template>

          <template #buttons="{ setIsOpen }">
            <Button
              @click.prevent="
                () => {
                  bulkAction('post', route('blocks.bulk-destroy'), {
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
        <ListingHeaderCell sortBy="name">
            name
        </ListingHeaderCell> 
        <ListingHeaderCell sortBy="type">
            type
        </ListingHeaderCell> 
        <ListingHeaderCell sortBy="content">
            content
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
             {{ item.name }}
        </ListingDataCell> 
        <ListingDataCell>
             {{ item.type }}
        </ListingDataCell> 
        <ListingDataCell>
             {{ item.content?.[currentLocale] }}
        </ListingDataCell> 
        <ListingDataCell>
          <div class="flex items-center justify-end gap-3">
            <IconButton
              :as="Link"
              :href="route('blocks.edit', item)"
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

              <template #title>Delete Block
              </template>
              <template #content>
                Confirm deletion? Data will be permanently removed and can't be undone.
              </template>

              <template #buttons="{ setIsOpen }">
                <Button
                  @click.prevent="
                    () => {
                      action('delete', route('blocks.destroy', item), {
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
} from "craftable-pro/Components";
import { PaginatedCollection } from "craftable-pro/types/pagination";
import type { Block } from "./types";
import type { PageProps } from "craftable-pro/types/page";
import dayjs from "dayjs";


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
 

interface Props {
  blocks: PaginatedCollection<Block>;
  typeOptions: Array<{value: string|number, label: string}>;
}
defineProps<Props>();

</script>
