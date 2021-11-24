<template>
  <el-container>
    <el-header>Header</el-header>
    <el-container>
      <el-aside width="280px"></el-aside>
      <el-container>
        <el-main>
          <router-view></router-view>
        </el-main>
        <el-footer>Footer</el-footer>
      </el-container>
    </el-container>
  </el-container>
</template>


<script>
export default {
  name: "layout",
  components: {},
  data() {
    return {}
  },
  created() {
  },
  methods: {}
}
</script>
