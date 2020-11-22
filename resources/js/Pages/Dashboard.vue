<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
          <h3 class="text-lg leading-6 font-medium text-gray-900">
            At a glance
          </h3>
          <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <dl>
                  <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                    Total Subscribers
                  </dt>
                  <dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
                    {{ stats.subscribersCount }}
                  </dd>
                </dl>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <dl>
                  <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                    Active Lists
                  </dt>
                  <dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
                    {{ stats.activeListCount }}
                  </dd>
                </dl>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <dl>
                  <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                    Referral rate
                  </dt>
                  <dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
                    {{ stats.referralRate }}%
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
          Resources
        </h3>

        <div class="flex flex-wrap">
          <div class="w-full sm:w-1/2 sm:pr-1">
            <div class="bg-white shadow sm:rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                  <FontAwesomeIcon icon="book" />
                  API Documentation
                </h3>
                <div class="mt-2 max-w-xl text-sm leading-5 text-gray-500">
                  <p>
                    Feel free to check out our API documentation, where you'll find all the information you might need.
                  </p>
                </div>
                <div class="mt-5">
                  <span class="inline-flex rounded-md shadow-sm">
                    <a
                      href="https://docs.getawait.com"
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

          <div class=" w-full sm:w-1/2 sm:pl-1">
            <div class="bg-white shadow sm:rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                  <FontAwesomeIcon :icon="['fab', 'discord']" />
                  Discord
                </h3>
                <div class="mt-2 max-w-xl text-sm leading-5 text-gray-500">
                  <p>
                    Become a part of the Await community by joining our Discord server and voice your opinion.
                  </p>
                </div>
                <div class="mt-5">
                  <span class="inline-flex rounded-md shadow-sm">
                    <a
                      href="https://discord.gg/PhtUHnx9nk"
                      type="button"
                      target="_blank"
                      class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150"
                    >
                      Join the community
                    </a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
  import AppLayout from './../Layouts/AppLayout'

  export default {
    components: {
      AppLayout,
    },
    props: {
      stats: {
        type: Object,
        required: true,
      },
    },
  }
</script>
