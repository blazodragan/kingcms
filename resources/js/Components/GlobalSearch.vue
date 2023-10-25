<script lang="ts" setup>
import { ref , computed, onMounted, onUnmounted} from 'vue';

const query = ref('');
const results = ref({
    news: [],
    page: [],
    category: [],
});
const boxRef = ref(null);


const search = async () => {
    if (query.value) {
        const response = await fetch('/api/global-search?q=' + query.value, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'include'
        });
        const data = await response.json();
        results.value = data.results;
    } else {
        results.value = [];
    }
};

// Computed property to get only non-empty groups
const nonEmptyGroups = computed(() => {
    return Object.entries(results.value)
        .filter(([key, value]) => value && value.length > 0)
        .reduce((acc, [key, value]) => {
            acc[key] = value;
            return acc;
        }, {});
});

const handleClickOutside = (event) => {
      if (boxRef.value && !boxRef.value.contains(event.target)) {
        // Clear out the groupedResults to close the box
        results.value = {};
      }
    }

    onMounted(() => {
      document.addEventListener('click', handleClickOutside);
    });

    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside);
    });
</script>

<template>

    
<div class="w-full max-w-md relative">

<div class="flex items-center text-gray-400 focus-within:text-gray-600">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 absolute ml-2 mr-2" pointer-events-none>
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
    </svg>
    <input v-model="query" @input="search" placeholder="Search..." class="w-full pr-3 pl-10 py-2 font-semibold placeholder-gray-500 text-black rounded-md border-none ring-2 ring-gray-300 focus:ring-gray-500 focus:ring-2">
</div>

<!-- Results Container -->
<div ref="boxRef" v-if="Object.keys(nonEmptyGroups).length > 0" class="custom-scrollbar absolute w-full mt-4 z-50 bg-white shadow border rounded-md overflow-y-scroll h-80">
    <div v-for="(resultsGroup, modelName) in nonEmptyGroups" :key="modelName" class="border-b last:border-0 p-4">
        <div class="text-md rounded p-2 bg-gray-200">{{ modelName }}</div>
        <ul>
            <li v-for="link in resultsGroup" :key="link.title" class="border-b last:border-0 p-2 text-sm truncate hover:bg-gray-100">
                <a :href="link.edit_link" class="text-blue-600 hover:text-blue-800"><h3 class="font-medium">{{ link.title }}</h3></a>
            </li>
        </ul>
    </div>
</div>

</div>

</template>
