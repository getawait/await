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
  </AppLayout>
</template>

<script>
  import AppLayout from '../../Layouts/AppLayout';
  import Button from '../../Jetstream/Button';
  import SecondaryButton from '../../Jetstream/SecondaryButton';

  export default {
    name: 'Create',
    components: { SecondaryButton, Button, AppLayout },
  }
</script>

<style scoped>

</style>
