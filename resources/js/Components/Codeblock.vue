<template>
  <div class="codeblock rounded-md">
    <div class="border-b font-semibold border-gray-600 text-white text-left px-4 py-2">
      <span
        :class="{ 'codeblock--selected': selectedType === 'js' }"
        class="mr-3 cursor-pointer"
        @click="selectType('js', 'javascript')"
      >
        JavaScript
      </span>
      <span
        :class="{ 'codeblock--selected': selectedType === 'php' }"
        class="mr-3 cursor-pointer"
        @click="selectType('php', 'php7')"
      >
        PHP
      </span>
    </div>
    <pre v-highlightjs="code"><code
      :class="`${selectedHighlightLanguage}`"
      class="rounded-br-md rounded-bl-md"
    /></pre>
  </div>
</template>

<script>
  export default {
    name: "Codeblock",
    props: {
      snippet: {
        type: Function,
        required: true,
      },
    },
    data() {
      return {
        selectedType: 'js',
        selectedHighlightLanguage: 'javascript',
      }
    },
    methods: {
      selectType(type, highlightLanguage) {
        this.selectedType = type;
        this.selectedHighlightLanguage = highlightLanguage;
      },
    },
    computed: {
      code() {
        return this.snippet(this.selectedType);
      },
    },
  }
</script>

<style scoped>
  .codeblock {
    background-color: #282a36;
  }

  .codeblock code {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
  }

  .codeblock--selected {
    color: #8be9fd;
  }
</style>