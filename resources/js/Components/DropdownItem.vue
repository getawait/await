<template>
  <a
    :href="href"
    class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
    role="menuitem"
  >
    <slot />
  </a>
</template>

<script>
  export default {
    name: "DropdownItem",
    props: {
      href: {
        type: String,
        required: false,
        default: () => {
          return '#';
        }
      }
    }
  }
</script>

<style scoped>

</style>