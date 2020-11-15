<template>
  <app-layout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Lists
        </h2>

        <InertiaLink
          href="/lists/create"
        >
          <Button class="float-right">
            Create new
          </Button>
        </InertiaLink>
      </div>
    </template>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
      <Alert
        v-if="$page.flash.successMessage"
        class="mb-4"
        title="Yaay!"
        :message="$page.flash.successMessage"
      />

      <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead>
                  <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                      Name
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                      Subscribers
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                      Status
                    </th>
                    <th class="px-6 py-3 bg-gray-50" />
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="list in lists.data">
                    <td class="px-6 py-4 whitespace-no-wrap">
                      <div class="flex items-center">
                        <div class="ml-4">
                          <div class="text-sm leading-5 font-medium text-gray-900">
                            {{ list.name }}
                          </div>
                          <div class="text-sm leading-5 text-gray-500">
                            Created on: {{ list.created_at }}
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                      {{ list.subscribers.length }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap">
                      <span
                        v-if="list.is_active"
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                      >
                        Active
                      </span>
                      <span
                        v-else
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800"
                      >
                        Inactive
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                      <a
                        :href="`/lists/${list.id}`"
                        class="text-indigo-600 hover:text-indigo-900"
                      >
                        View
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
  import AppLayout from './../../Layouts/AppLayout'
  import Button from '../../Jetstream/Button';
  import Alert from "../../Components/Alert";

  export default {
    components: {
      Alert,
      Button,
      AppLayout,
    },
    props: {
      lists: {
        type: Array,
        required: true,
      },
    },
  }
</script>
