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
        <el-row :gutter="20">
          <el-col :span="6">


            <el-icon v-for="icon in icons"></el-icon>

          </el-col>
        </el-row>
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