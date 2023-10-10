<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TicketList from "@/Components/TicketListBig.vue";
import TicketListSuite from "@/Components/TicketListSuite.vue";
import AddTicket from "@/Components/AddTicket.vue";
import { useForm, Head, router } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";

import { ref, reactive, onMounted, onUnmounted, computed } from "vue";
import PaginationSuite from "@/Components/PaginationSuite.vue";
import { PlusIcon, PencilIcon, TicketIcon } from "@heroicons/vue/24/outline";
import { pickBy } from "lodash";

const props = defineProps({
    statusEnum : Array,
    priorityEnum : Array,
    tickets: Object,
    ticketsSuite: Object,
    ticketTags: Array,
    queryParams: Object,
});

const query = {
    term: props.queryParams.term || "",
    status: props.queryParams.status || "",
    priority: props.queryParams.priority || "",
    orderby: props.queryParams.orderby || "",
    per_page: props.queryParams.per_page || "",
    tags: "",
};

function filter() {
    router.get("tickets", pickBy(this.query), {
        preserveState: true,
    });
}
function reset() {
    router.get("tickets");
}
const TicketBeingDeleted = ref(null);
const allSelectedTickets = ref();
const selectAllState = ref("Select All");

const checkedTickets = ref([]);
const form = useForm({
    name: "",
});
const submitForm = () => {
    form.post("tickets.store", {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
const deleteSelectedTicketForm = useForm({});
const deleteSelectedTicket = (checkedTickets) => {
    deleteSelectedTicketForm.delete(("tickets.destroy", [TicketBeingDeleted.value]),
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => (
                (TicketBeingDeleted.value = null),
                    (checkedTickets.length = null),
                    (allSelectedTickets.value = false),
                    (selectAllState.value = "Select All")
            ),
        }
    );
};
const confirmTicketDeletion = (checkedTickets) => {
    TicketBeingDeleted.value = checkedTickets;
    let arr = TicketBeingDeleted.value;
    let array = [];
    for (var i = 0; i < arr.length; i++) {
        array.push(arr[i]);
    }
    TicketBeingDeleted.value = array;
    console.log(checkedTickets.value);
};

const addTags = computed(() => {
    return [...props.ticketTags];
});
function removeFromArra(id) {
    let arr = checkedTickets.value;
    for (var i = 0; i < arr.length; i++) {
        if (arr[i] === id) {
            checkedTickets.value.splice(i, 1);
        }
    }
}
function resetButton(i) {
    allSelectedTickets.value = false;
    selectAllState.value = "Select All";
}

function selectAll(checkedTickets) {
    if (!allSelectedTickets.value) {
        allSelectedTickets.value = true;
        selectAllState.value = "Diselect All";
    } else {
        allSelectedTickets.value = false;
        selectAllState.value = "Select All";
        checkedTickets.splice(0, checkedTickets.length);
    }
}
// For add Keywords
const addFormTicket = ref(null);
function openAddBoxTicket() {
    addFormTicket.value = true;
}

const openOnCtrlNew = (e) => {
    if (e.key === "o" && (e.altKey || e.metaKey)) {
        e.preventDefault();
        addFormTicket.value = true;
    }
};
const openOnImport = (e) => {
    if (e.key === "i" && (e.altKey || e.metaKey)) {
        e.preventDefault();
        addFormTicket.value = true;
    }
};

onMounted(
    () => document.addEventListener("keydown", openOnCtrlNew),
    document.addEventListener("keydown", openOnImport)
);

onUnmounted(() => {
    document.removeEventListener("keydown", openOnCtrlNew),
        document.removeEventListener("keydown", openOnImport);
});
</script>

<template>
  <AppLayout title="Tickets">
    <template #header>
        <div class="flex items-center">
            <div
                class="
            flex
            mr-2
            flex-shrink-0
            items-center
            justify-center
            bg-green-200
            h-12
            w-12
            rounded-xl
          "
            >
                <TicketIcon
                    class="w-6 h-6 text-green-700"
                />

            </div>
            <div>
                <h2 class="font-semibold text-xl text-black leading-tight">Tickets</h2>
                <span class="text-sm text-gray-500"
                >All tickets information</span
                >
            </div>
        </div>
        <div class="flex">
            <button
                type="button"
                @click="openAddBoxTicket()"
                class="
            bg-green-200
            text-green-900
            font-medium
            rounded-lg
            text-sm
            px-3
            py-2
            text-center
            inline-flex
            items-center
            hover:bg-green-100
            active:bg-green-200
            focus:outline-none
            focus:border-green-300
            focus:ring
            focus:ring-green-300
            disabled:opacity-25
            transition
          "
            >
                New
                <kbd
                    class="
              ml-2
              px-1
              py-0.5
              text-xs
              font-semibold
              text-black
              bg-green-100
              border border-green-200
              rounded-lg
            "
                >alt</kbd
                >
                +
                <kbd
                    class="
              px-1
              py-0.5
              text-xs
              font-semibold
              text-black
              bg-green-100
              border border-green-200
              rounded-lg
            "
                >o</kbd
                >
            </button>
        </div>
    </template>
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <section
              class="
          flex flex-col
          mb-4
          space-y-4
          sm:rounded
          lg:flex-row lg:items-center lg:justify-between lg:space-y-0
          border-b
          pb-4
        "
          >
              <div
                  class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-2"
              >
                  <select
                      v-model="query.tags"
                      v-on:change="filter()"
                      aria-label="Media date"
                      id="date"
                      class="
              pr-10
              pl-3
              w-full
              h-11
              rounded
              border-gray-300
              shadow-sm
              lg:h-9 lg:text-sm
              sm:w-44
              focus:outline-none focus:ring-blue-500 focus:border-blue-500
            "
                  >
                      <option disabled value="">Select a Type</option>
                      <option v-for="tag in addTags" :key="tag.index" :value="tag">
                          {{ tag }}
                      </option>
                  </select>
                  <select
                      v-model="query.priority"
                      v-on:change="filter()"
                      aria-label="Media date"
                      id="date"
                      class="
              pr-10
              pl-3
              w-full
              h-11
              rounded
              border-gray-300
              shadow-sm
              lg:h-9 lg:text-sm
              sm:w-44
              focus:outline-none focus:ring-blue-500 focus:border-blue-500
            "
                  >
                      <option disabled value="">Select a priority</option>
                      <option v-for="priority in priorityEnum" :key="priority" :value="priority">
                          {{ priority }}
                      </option>
                  </select>
                  <select
                      v-model="query.status"
                      v-on:change="filter()"
                      aria-label="Media date"
                      id="date"
                      class="
              pr-10
              pl-3
              w-full
              h-11
              rounded
              border-gray-300
              shadow-sm
              lg:h-9 lg:text-sm
              sm:w-44
              focus:outline-none focus:ring-blue-500 focus:border-blue-500
            "
                  >
                      <option disabled value="">Select a status</option>
                      <option v-for="status in statusEnum" :key="status" :value="status">
                          {{ status }}
                      </option>
                  </select>
                  <select
                      v-model="query.orderby"
                      v-on:change="filter()"
                      aria-label="Media date"
                      id="date"
                      class="
              pr-10
              pl-3
              w-full
              h-11
              rounded
              border-gray-300
              shadow-sm
              lg:h-9 lg:text-sm
              sm:w-44
              focus:outline-none focus:ring-blue-500 focus:border-blue-500
            "
                  >
                      <option disabled value="">Sort by</option>
                      <option value="title">Title</option>
                      <option value="created_at">Date Added</option>
                  </select>
              </div>

              <div
                  class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-2"
              >
                  <label for="search" class="text-sm font-medium text-gray-700 sr-only"
                  >Search</label
                  >
                  <input
                      v-model="query.term"
                      @keydown.enter="filter()"
                      type="search"
                      id="search"
                      class="
              w-full
              h-11
              rounded
              border-gray-300
              shadow-sm
              lg:h-9 lg:text-sm lg:w-64
              focus:ring-blue-500 focus:border-blue-500
            "
                      placeholder="Search by name..."
                      autocomplete="off"
                  />
                  <button
                      @click="filter()"
                      type="button"
                      class="
              inline-flex
              items-center
              px-4
              h-11
              font-medium
              text-gray-700
              bg-white
              rounded
              border border-gray-300
              shadow-sm
              lg:h-9 lg:text-sm
              hover:bg-gray-50
              focus:outline-none
              focus:ring-2
              focus:ring-offset-2
              focus:ring-blue-500
            "
                  >
                      Filter
                  </button>
                  <button
                      @click="reset()"
                      type="button"
                      class="
              inline-flex
              items-center
              px-4
              h-11
              font-medium
              text-red-700
              bg-white
              rounded
              border border-red-300
              shadow-sm
              lg:h-9 lg:text-sm
              hover:bg-red-50
              focus:outline-none
              focus:ring-2
              focus:ring-offset-2
              focus:ring-blue-500
            "
                  >
                      Reset
                  </button>
              </div>
          </section>
          <!-- <InputError :message="$attrs.errors?.status" class="mt-2" /> -->
          <section
              class="
          flex flex-col
          mb-6
          space-y-4
          lg:flex-row lg:items-center lg:justify-between lg:space-y-0
        "
          >
              <div
                  class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-2"
              >


              </div>
              <div class="flex flex-row" v-if="props.ticketsSuite.pagination.total_results > 0">
                  <PaginationSuite :pagination="props.ticketsSuite.pagination" />
                  <select
                      v-model="query.per_page"
                      v-on:change="filter()"
                      aria-label="Media date"
                      id="date"
                      class="
              ml-1
              pr-10
              pl-3
              w-full
              h-11
              rounded
              border-gray-300
              shadow-sm
              lg:h-9 lg:text-sm
              sm:w-20
              focus:outline-none focus:ring-blue-500 focus:border-blue-500
            "
                  >
                      <option value="">12</option>
                      <option value="24">24</option>
                      <option value="48">48</option>
                      <option value="96">96</option>
                  </select>
              </div>
          </section>

          <div
             
              class="
          container
          mx-auto
          grid
          lg:grid-cols-4
          md:grid-cols-2
          gap-6
          w-full
        "
        
          >
 
          <TicketListSuite
                  v-for="ticket in props.ticketsSuite?.data"
                  :key="ticket.id"
                  :ticket="ticket"
                  :allSelectedTickets="allSelectedTickets"
                  @add="(i) => checkedTickets.push(i)"
                  @remove="(i) => removeFromArra(i)"
                  @reset="(i) => resetButton(i)"
              />
          </div>
      </div>
  </AppLayout>
</template>
