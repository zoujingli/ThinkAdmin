<template>
  <div class="hello">Hello {{ who }}</div>
</template>

<script>
module.exports = {
  data: function () {
    return {
      who: 'xxx'
    }
  },
  created: function () {
    console.log(234123)
  }
}
</script>

<style>
.hello {
  background-color: #ffe;
}
</style>