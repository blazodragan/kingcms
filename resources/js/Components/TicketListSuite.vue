<script setup>
import { ref, computed, watch } from "vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { useForm, Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    role: "",
    allSelectedTickets: "",
});

const emit = defineEmits(["add", "remove", "reset"]);
const checked = ref(false);
const TicketBeingDeleted = ref(null);
const deleteTicketForm = useForm({});

const confirmTicketDeletion = (id) => {
    TicketBeingDeleted.value = id;
};

const deleteTicket = () => {
    deleteTicketForm.delete(("tickets.destroy", TicketBeingDeleted.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (TicketBeingDeleted.value = null),
    });
};
const handleChange = (id, checked) => {
    if (checked == true) {
        console.log(id);
        emit("add", id);
    } else {
        emit("remove", id);
    }
};

watch(
    () => props.allSelectedTickets,
    () => {
        if (props.allSelectedTickets == true) {
            checked.value = true;
            emit("add", props.ticket.id);
        } else {
            checked.value = false;
            emit("remove", props.ticket.id);
        }
    }
);
</script>




<template>

    <div
        class="col-span-1 flex flex-col bg-white drop-shadow-sm rounded-md"
        :class="{
      'border-indigo-300 ring ring-indigo-200 ring-opacity-100': checked,
    }"
    >
        <div class="flex flex-col px-4 pt-4 pb-2">
            <div class="flex flex-wrap">

                <!-- <div class="flex ml-2 mb-3">
                    <span v-if="ticket.attributes.state == 'Open'" class="bg-green-100  text-green-800 text-xs font-medium rounded px-3">{{ ticket.attributes.state }}</span>
                    <span v-else-if="ticket.attributes.state == 'Closed'" class="bg-red-100  text-red-800 text-xs font-medium rounded px-3">{{ ticket.attributes.state }}</span>
                    <span v-else class="bg-blue-100  text-blue-800 text-xs font-medium rounded px-3">{{ ticket.attributes.state }}</span>
                </div>
                <div class="flex ml-2 mb-3">
                    <span v-if="ticket.attributes.priority == 'P3'" class="bg-green-100  text-green-800 text-xs font-medium rounded px-3">{{ ticket.attributes.priority }}</span>
                    <span v-else-if="ticket.attributes.priority == 'P1'" class="bg-red-100  text-red-800 text-xs font-medium rounded px-3">{{ ticket.attributes.priority }}</span>
                    <span v-    else class="bg-blue-100  text-blue-800 text-xs font-medium rounded px-3">{{ ticket.attributes.priority }}</span>
                </div>

                <small class=" flex-1 text-right">{{ new Date(ticket.attributes.date_entered).toLocaleString("en-GB",{ dateStyle: 'medium' }) }}</small>
                <span v-if="ticket.attributes.ticketColor" class="absolute right-1 top-1 w-2 h-2 rounded-full ml-2" :class="[ticket?.ticketColor]"></span> -->
            </div>

            <span class="font-medium mt-2 text-xl text-center">{{ role.name }}</span>

        </div>
        <div
            class="
        flex
        justify-between
        bg-gray-50
        row-span-1
        w-full
        mt-auto
        text-xs
        rounded-b-md
        p-3
      "
        >
        <Link
            class="
            inline-flex
            items-center
            px-4
            py-2
            bg-white
            border border-gray-300
            rounded-md
            font-semibold
            text-xs text-gray-700
            uppercase
            tracking-widest
            shadow-sm
            hover:text-gray-500
            focus:outline-none
            focus:border-blue-300
            focus:ring
            focus:ring-blue-200
            active:text-gray-800 active:bg-gray-50
            disabled:opacity-25
            transition
          "
            tabindex="-1"
        >
           Contacts
        </Link>
        <Link
            class="
            inline-flex
            items-center
            px-4
            py-2
            bg-white
            border border-gray-300
            rounded-md
            font-semibold
            text-xs text-gray-700
            uppercase
            tracking-widest
            shadow-sm
            hover:text-gray-500
            focus:outline-none
            focus:border-blue-300
            focus:ring
            focus:ring-blue-200
            active:text-gray-800 active:bg-gray-50
            disabled:opacity-25
            transition
          "
            tabindex="-1"
        >
           Invoices
        </Link>
        </div>
    </div>
    <!-- Delete Token Confirmation Modal -->
    <ConfirmationModal
        :show="TicketBeingDeleted != null"
        @close="TicketBeingDeleted = null"
    >
        <template #title> Delete Ticket </template>

        <template #content>
            Are you sure you would like to delete this Ticket?
        </template>

        <template #footer>
            <SecondaryButton @click="TicketBeingDeleted = null">
                Cancel
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': deleteTicketForm.processing }"
                :disabled="deleteTicketForm.processing"
                @click="deleteTicket"
            >
                Delete
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
