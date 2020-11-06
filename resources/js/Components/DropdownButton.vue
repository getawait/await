<template>
  <div class="relative inline-block text-left">
    <div>
      <span class="rounded-md shadow-sm">
        <button
          @click="open = !open"
          type="button"
          class="shadow-sm inline-flex justify-center w-full rounded-md border border-gray-300 font-semibold px-4 py-2 bg-white text-xs uppercase leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150"
          id="options-menu"
          aria-haspopup="true"
          aria-expanded="true"
        >
          <slot name="text" />
          <!-- Heroicon name: chevron-down -->
          <svg
            class="-mr-1 ml-2 h-5 w-5"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </span>
    </div>

    <transition
      enter-active-class="transition ease-out duration-200"
      enter-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div
        v-show="open"
        class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg"
      >
        <div class="rounded-md bg-white shadow-xs">
          <div
            class="py-1"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="options-menu"
          >
            <slot name="dropdownItems" />
            </form>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
  export default {
    name: "DropdownButton",
    data() {
      return {
        open: false,
      }
    },
    created() {
      const closeOnEscape = (e) => {
        if (this.open && e.keyCode === 27) {
          this.open = false
        }
      }

      this.$once('hook:destroyed', () => {
        document.removeEventListener('keydown', closeOnEscape)
      })

      document.addEventListener('keydown', closeOnEscape)
    }
  }
</script>

<style scoped>

</style>