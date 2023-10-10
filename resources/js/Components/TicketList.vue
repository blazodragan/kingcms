<script setup>
const props = defineProps({
  ticket: "",
});
</script>
 
<template>
              <tr class="bg-white border-b  hover:bg-gray-50">
                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{ ticket.title }}
                    
                </th>
                <td class="py-4 px-6">
                  {{ ticket.message.substr(0,60)+".." }}
                </td>
				<td class="py-4 px-6">
          {{ ticket.user.name }}
                </td>
                <td class="py-4 px-6">
                  {{ new Date(ticket.created_at).toLocaleString("en-GB",{ dateStyle: 'medium' }) }}
                </td>
                <td class="py-4 px-6 text-right">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                </td>
            </tr>
      <span class="truncate font-medium mt-2 text-xl text-center"></span>
      <span class="truncate font-medium mt-2 text-xl text-center"></span>
      <span class="truncate font-medium mt-2 text-xl text-center"></span>
</template>