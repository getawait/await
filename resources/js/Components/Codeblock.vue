<template>
  <div class="codeblock rounded-md">
    <div class="border-b font-semibold border-gray-600 text-white text-left px-4 py-2">
      <span class="mr-3 cursor-pointer">JavaScript</span>
      <span class="mr-3 cursor-pointer">PHP</span>
    </div>
    <pre v-highlightjs><code class="javascript rounded-br-md rounded-bl-md">{{ code }}</code></pre>
  </div>
</template>

<script>
  export default {
    name: "Codeblock",
    data() {
      return {
        code: 'var myHeaders = new Headers();\n' +
          'myHeaders.append("X-Requested-With", "XMLHttpRequest");\n' +
          'myHeaders.append("Content-Type", "application/x-www-form-urlencoded");\n' +
          '\n' +
          'var urlencoded = new URLSearchParams();\n' +
          'urlencoded.append("email", "email@email.com");\n' +
          'urlencoded.append("waitlist", "4678ee83-426f-40d4-8baf-53082fce3cb4");\n' +
          '\n' +
          'var requestOptions = {\n' +
          '  method: \'POST\',\n' +
          '  headers: myHeaders,\n' +
          '  body: urlencoded,\n' +
          '  redirect: \'follow\'\n' +
          '};\n' +
          '\n' +
          'fetch("http://127.0.0.1:8000/api/v1/subscribers", requestOptions)\n' +
          '  .then(response => response.text())\n' +
          '  .then(result => console.log(result))\n' +
          '  .catch(error => console.log(\'error\', error));',
      }
    }
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
</style>