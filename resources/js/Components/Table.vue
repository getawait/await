<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                <th
                  v-for="columnName in columnNames"
                  :key="columnName"
                  class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                >
                  {{ columnName }}
                </th>
              </tr>
            </thead>
            <tbody>
              <slot />
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "Table",
    props: {
      columnNames: {
        type: Array,
        required: true,
      },
      rows: {
        type: Array,
        required: true,
      },
    },
  }
</script>

<style scoped>
  tr:nth-child(odd) {
    @apply bg-white;
  }

  tr:nth-child(even) {
    @apply bg-gray-50;
  }
</style>