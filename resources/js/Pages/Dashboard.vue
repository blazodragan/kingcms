<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import BarChart from "@/Components/BarChart.vue";
import {ChevronRightIcon, DocumentTextIcon, PhotoIcon, RectangleGroupIcon, LinkIcon, Cog6ToothIcon, CreditCardIcon, UserCircleIcon, FingerPrintIcon, HomeIcon, TicketIcon, QuestionMarkCircleIcon, CheckIcon    } from '@heroicons/vue/24/outline';
import TicketList from "@/Components/TicketList.vue";

const props = defineProps({
	// tickets: Object,
	// total_tickets: Number,
	// locked_ticket: Number,
	// opened_ticket: Number,
	// resolved_ticket: Number,
	// unresolved_ticket: Number,
	// opened: Array,
	// closed: Array,
});

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
			<div class="flex items-center">
			<div class="flex mr-2 flex-shrink-0 items-center justify-center bg-zinc-200 h-12 w-12 rounded-xl">
					<HomeIcon
					class="w-6 h-6 text-zinc-700"
					/>
				</div>
				<div>
            <h2 class="font-semibold text-xl text-gray-500 leading-tight">
                Dashboard
            </h2>
			<span class="text-sm text-gray-500">Overview of information</span>
		</div>
		</div>
        </template>
        <div class="py-4 bg-dots-darker bg-center bg-gray-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
    <!-- Component Start -->
	<h3 class="mb-4 font-semibold text-xl">Overview</h3>
	<div class="grid lg:grid-cols-4 md:grid-cols-2 gap-6 w-full">
		<!-- Tile 1 -->
		<!-- <div class="drop-shadow-sm">
			<div class="flex items-center p-4 bg-white rounded-t-md">
				<div class="flex flex-shrink-0 items-center justify-center bg-green-200 h-12 w-12 rounded-xl">
					<TicketIcon
					class="w-6 h-6 text-green-700"
					/>
				</div>
				<div class="flex-grow flex flex-col ml-4">
					<div class="flex items-center text-xl justify-between">
						<span class="text-gray-500">Total Tickets</span>
						<span class="text-green-500 font-semibold ml-2">{{total_tickets}}</span>
					</div>
				</div>
			</div>
			<div class="flex bg-gray-50 w-full rounded-b-md">
				<span class="p-2 flex items-center">
					<a href="#" class="px-3 hover:underline">Check Total Tickets</a>
					<ChevronRightIcon
					class="w-5 h-5 text-gray-400"
					/>
				</span>
			</div>
		</div> -->
		<!-- Tile 2 -->
		<!-- <div class="drop-shadow-sm">
			<div class="flex items-center p-4 bg-white rounded-t-md">
				<div class="flex flex-shrink-0 items-center justify-center bg-blue-200 h-12 w-12 rounded-xl">
					<DocumentTextIcon
					class="w-6 h-6  text-blue-700"
					/>
				</div>
				<div class="flex-grow flex flex-col ml-4">
					<div class="flex items-center text-xl justify-between">
						<span class="text-gray-500">Open Tickets</span>
						<span class="text-blue-500 font-semibold ml-2">{{ opened_ticket }}</span>
					</div>
				</div>
			</div>
			<div class="flex bg-gray-50 w-full rounded-b-md">
				<span class="p-2 flex items-center">
					<a href="#" class="px-3 hover:underline">Check Open Tickets</a>
					<ChevronRightIcon
					class="w-5 h-5 text-gray-400"
					/>
				</span>
			</div>
		</div> -->
		<!-- Tile 3 -->
		<!-- <div class="drop-shadow-sm">
			<div class="flex items-center p-4 bg-white rounded-t-md">
				<div class="flex flex-shrink-0 items-center justify-center bg-red-200 h-12 w-12 rounded-xl">
					<QuestionMarkCircleIcon
					class="w-6 h-6  text-red-700"
					/>
				</div>
				<div class="flex-grow flex flex-col ml-4">
					<div class="flex items-center text-xl justify-between">
						<span class="text-gray-500">Unresolved</span>
						<span class="text-red-500 font-semibold ml-2">{{ unresolved_ticket }}</span>
					</div>
				</div>
			</div>
			<div class="flex bg-gray-50 w-full rounded-b-md">
				<span class="p-2 flex items-center">
					<a href="#" class="px-3 hover:underline">Check Unresolved Tickets</a>
					<ChevronRightIcon
					class="w-5 h-5 text-gray-400"
					/>
				</span>
			</div>
		</div> -->
		<!-- Tile 4 -->
		<!-- <div class="drop-shadow-sm">
			<div class="flex items-center p-4 bg-white rounded-t-md">
				<div class="flex flex-shrink-0 items-center justify-center bg-indigo-200 h-12 w-12 rounded-xl">
					<CheckIcon
					class="w-6 h-6  text-indigo-700"
					/>
				</div>
				<div class="flex-grow flex flex-col ml-4">
					<div class="flex items-center text-xl justify-between">
						<span class="text-gray-500">Resolved</span>
						<span class="text-indigo-500 font-semibold ml-2">{{resolved_ticket}}</span>
					</div>
				</div>
			</div>
			<div class="flex bg-gray-50 w-full rounded-b-md">
				<span class="p-2 flex items-center">
					<a href="#" class="px-3 hover:underline">Check Resolved Tickets</a>
					<ChevronRightIcon
					class="w-5 h-5 text-gray-400"
					/>
				</span>
			</div>
		</div> -->
	</div>
	<!-- Component End  -->
                    <!-- Commonent Acticites End-->
                    <h3 class="mb-4 mt-6 font-semibold text-xl">Ticekts Chart</h3>
                    <div class="grid lg:grid-cols-1 md:grid-cols-1 w-full">

                        <!-- <div class="bg-white p-4 shadow-md sm:rounded-lg">
                            <BarChart :opened="opened" :closed="closed"/>
                        </div> -->
                    </div>
	<!-- Commonent Acticites Start-->
	<h3 class="mb-4 mt-10 font-semibold text-xl">Latest Tickets</h3>
	<div class="grid lg:grid-cols-1 md:grid-cols-1 gap-6 w-full">

<div class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" v-if="props.tickets?.length">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6">
                    Title
                </th>
				<th scope="col" class="py-3 px-6">
                    Message
                </th>
                <th scope="col" class="py-3 px-6">
                    Created By
                </th>
                <th scope="col" class="py-3 px-6">
                    created_at
                </th>
                <th scope="col" class="py-3 px-6">
                    <span class="sr-only">View</span>
                </th>
            </tr>
        </thead>
        <tbody>
			<TicketList
          v-for="ticket in tickets"
          :key="ticket.id"
          :ticket="ticket"
        />
        </tbody>
    </table>
</div>
</div>
                </div>
            </div>

        </div>

    </AppLayout>
</template>

