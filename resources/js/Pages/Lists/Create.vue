<template>
  <AppLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Create a new list
        </h2>

        <InertiaLink
          href="/lists"
        >
          <SecondaryButton class="float-right">
            Back
          </SecondaryButton>
        </InertiaLink>
      </div>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <jet-form-section @submitted="createList">
          <template #title>
            List Details
          </template>

          <template #description>
            Create a new waitlist, and collect the details of potential users
          </template>

          <template #form>
            <div class="col-span-6">
              <jet-label value="List Owner (Team)" />
              <div class="mt-2">{{ $page.props.user.current_team.name }}</div>
            </div>

            <div class="col-span-6 sm:col-span-4">
              <jet-label
                for="name"
                value="Name"
              />
              <jet-input
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                autofocus
              />
              <jet-input-error
                :message="form.error('name')"
                class="mt-2"
              />
            </div>
          </template>

          <template #actions>
            <jet-action-message
              :on="form.recentlySuccessful"
              class="mr-3"
            >
              Created.
            </jet-action-message>

            <jet-button
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Create
            </jet-button>
          </template>
        </jet-form-section>
      </div>
    </div>
  </AppLayout>
</template>

<script>
  import AppLayout from '../../Layouts/AppLayout';
  import SecondaryButton from '../../Jetstream/SecondaryButton';
  import JetActionMessage from '../../Jetstream/ActionMessage';
  import JetButton from '../../Jetstream/Button';
  import JetFormSection from '../../Jetstream/FormSection';
  import JetInput from '../../Jetstream/Input';
  import JetInputError from '../../Jetstream/InputError';
  import JetLabel from '../../Jetstream/Label';

  export default {
    name: 'Create',
    components: {
      SecondaryButton,
      AppLayout,
      JetActionMessage,
      JetButton,
      JetFormSection,
      JetInput,
      JetInputError,
      JetLabel,
    },
    data() {
      return {
        form: this.$inertia.form({
          name: '',
        }, {
          bag: 'createList',
          resetOnSuccess: false,
        })
      }
    },

    methods: {
      createList() {
        this.form.post('/lists', {
          preserveScroll: true
        });
      },
    },
  }
</script>

<style scoped>

</style>
