<script lang="ts" setup>
import { ref } from 'vue';

const query = ref('');
const results = ref([]);

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
</script>

<template>

    {{ router }}
    <div>

                                <div class="relative flex items-center text-gray-400 focus-within:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 absolute ml-2 mr-2 " pointer-events-none>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                    <input v-model="query" @input="search" placeholder="Search..." class="w-full pr-3 pl-10 py-2 font-semibold placeholder-gray-500 text-black rounded-md border-none ring-2 ring-gray-300 focus:ring-gray-500 focus:ring-2">
                                </div>


{{ results }}
        <div v-for="result in results" :key="result.title">
            <h3>{{ result.title }}</h3>
            <a :href="result.edit_link">Edit</a>
        </div>
    </div>
</template>
