<template>
  <AppLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Viewing "{{ list.data.name }}"
        </h2>

        <div class="float-right">
          <DropdownButton v-if="!showWelcomePage">
            <template #text>
              Export
            </template>
            <template #dropdownItems>
              <dropdown-item :href="`/lists/${list.data.id}/export`">
                CSV (.csv)
              </dropdown-item>
            </template>
          </DropdownButton>
          <InertiaLink
            href="/lists"
          >
            <SecondaryButton>
              Back
            </SecondaryButton>
          </InertiaLink>
        </div>
      </div>
    </template>

    <div
      v-if="showWelcomePage"
      class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-48"
    >
      <div class="flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-r from-teal-400 to-blue-500 text-white m-auto mb-2">
        <svg
          class="h-6 w-6"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
            clip-rule="evenodd"
          />
        </svg>
      </div>
      <div class="text-center">
        <h2 class="text-xl leading-9 tracking-tight font-extrabold text-gray-900 sm:text-2xl sm:leading-10">
          Quickstart guide
        </h2>
        <p class="max-w-2xl mx-auto text-xl leading-7 text-gray-500 mb-4">
          Welcome to your brand new waitlist, let's get the ball rolling
        </p>
      </div>

      <div class="px-6 pt-4">
        <span class="font-bold text-lg text-gray-900 mb-2">Join your waitlist</span>
        <p class="mb-4 text-gray-700">
          You don't have any eager digital adventurers on your waitlist yet – what are you waiting for?
        </p>

        <Codeblock :snippet="snippet"/>

        <div class="bg-white shadow sm:rounded-lg mt-8">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
              Stuck?
            </h3>
            <div class="mt-2 max-w-xl text-sm leading-5 text-gray-500">
              <p>
                Feel free to check out our API documentation, where you'll find all the information you might need.
              </p>
            </div>
            <div class="mt-5">
              <span class="inline-flex rounded-md shadow-sm">
                <a
                  href="https://await.readme.io/"
                  type="button"
                  target="_blank"
                  class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150"
                >
                  View documentation
                </a>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      v-else
      class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8"
    >
      <Alert
        v-for="(flash, key) in $page.flash"
        :key="key"
        class="mb-4"
        title="Yaay!"
        :message="flash"
      />

      <Table
        :column-names="[ 'Email address', 'Referred' , 'Actions' ]"
      >
        <tr
          v-for="row in rows"
          :key="row.id"
        >
          <TableData>{{ row.email }}</TableData>
          <TableData>
            <span v-if="row.referrer">
              {{ row.referrer }}
            </span>
            <span v-else-if="row.was_referred">
              Yes, but referrer was deleted
            </span>
            <danger-badge v-else>
              No referrer
            </danger-badge>
          </TableData>
          <TableData>
            <danger-button @click.native="deleteSubscriber(row.id, row.email)">
              Delete
            </danger-button>
          </TableData>
        </tr>
      </Table>
    </div>
  </AppLayout>
</template>

<script>
  import snippet from '../../Snippets/getting-started';
  import AppLayout from "../../Layouts/AppLayout";
  import SecondaryButton from "../../Jetstream/SecondaryButton";
  import Codeblock from "../../Components/Codeblock";
  import Table from "../../Components/Table";
  import TableData from "../../Components/TableData";
  import DangerButton from "../../Components/DangerButton";
  import DangerBadge from "../../Components/DangerBadge";
  import DropdownButton from "../../Components/DropdownButton";
  import DropdownItem from "../../Components/DropdownItem";
  import Alert from "../../Components/Alert";

  export default {
    name: "Show",
    components: {
      Alert,
      DropdownItem,
      DropdownButton,
      DangerBadge,
      DangerButton,
      TableData,
      Table,
      Codeblock,
      SecondaryButton,
      AppLayout
    },
    props: {
      list: {
        type: Object,
        required: true,
      },
      user: {
        type: Object,
        required: true,
      },
    },
    computed: {
      snippet() {
        return snippet({
          waitlistId: this.list.data.id,
          email: this.user.email,
        });
      },
      showWelcomePage() {
        return this.list.data.subscribers.length === 0;
      },
      rows() {
        return this.list.data.subscribers.map(subscriber => ({
          id: subscriber.id,
          email: subscriber.email,
          referrer: subscriber.referrer ? subscriber.referrer.email : false,
          was_referred: subscriber.was_referred,
        }));
      },
    },
    methods: {
      deleteSubscriber(id, email) {
        if (confirm(`Are you sure that you would like to delete the following subscriber: "${ email }"`)) {
          this.$inertia.delete(`/subscribers/${ id }`);
        }
      },
    },
  }
</script>

<style scoped>

</style>