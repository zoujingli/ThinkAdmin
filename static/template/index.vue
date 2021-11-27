<template>
  <el-container>
    <el-header>
      <el-row justify="space-between">
        <el-col :span="12">页面标题 导航条</el-col>
        <el-col :span="12" style="text-align:right">
          <el-button>功能按钮区</el-button>
          <el-button>功能按钮区</el-button>
        </el-col>
      </el-row>
    </el-header>
    <el-main>
      {{ userName }}: 你好，这里是为下一代 ThinkAdmin 后台管理系统预设计的 UI 结构。
    </el-main>
  </el-container>
</template>

<script>
export default {
  data() {
    return {
      userName: "ThinkAdmin"
    }
  }
}
</script>