<template>
  <div>
    {{ userName }}: 你好 vue3
  </div>
</template>

<script>
export default {
  name: "index",
  data() {
    return {
      userName: "张三32"
    }
  },
  created() {
  },
  methods: {}
}
</script>