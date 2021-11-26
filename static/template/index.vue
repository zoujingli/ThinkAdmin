<template>
  <div>
    <el-icon :size="16">
      <edit></edit>
    </el-icon>
    {{ userName }}: 你好 vue3
  </div>
</template>

<script>
export default {
  data() {
    return {
      userName: "张三"
    }
  },
  created() {
  },
  methods: {}
}
</script>