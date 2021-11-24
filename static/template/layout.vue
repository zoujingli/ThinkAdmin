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

<style lang="less">
html, body, #app {
  height: 100%;
  display: block;
  margin: 0;
  padding: 0;
}

#app > .el-container {
  height: 100%;

  > .el-header {
    color: #fff;
    background: #0d84ff;
    line-height: 60px;
  }

  > .el-container {

    > .el-aside {
      background: #53a8ff;
    }

    > .el-container {

      > .el-main {
        background: gray;
      }

      > .el-footer {
        color: #fff;
        background: #333;
        line-height: 60px;
      }

    }
  }
}
</style>

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
