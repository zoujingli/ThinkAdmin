<template>
  <el-container>
    <el-header>
      <el-row justify="space-between">
        <el-col :span="12">Item-Two-Page</el-col>
        <el-col :span="12" style="text-align:right">
          <el-button>功能按钮1</el-button>
          <el-button>功能按钮2</el-button>
        </el-col>
      </el-row>
    </el-header>
    <el-main>
      <el-scrollbar>

        <div v-for="icon in icons">
          <div><b>{{ icon.name }}：</b>{{ icon }}</div>
        </div>

      </el-scrollbar>
    </el-main>
  </el-container>
</template>

<script>
export default {
  data() {
    return {
      userName: "ThinkAdmin",
      icons: getApp().cache.icons
    }
  }
}
</script>