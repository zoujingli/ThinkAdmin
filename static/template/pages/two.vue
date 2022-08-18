<template>
  <el-container>
    <el-header>
      <el-row justify="space-between">
        <el-col :span="12">Element Plus Icons for {{ userName }} Template</el-col>
        <el-col :span="12" style="text-align:right">
          <el-button>功能按钮1</el-button>
          <el-button>功能按钮2</el-button>
        </el-col>
      </el-row>
    </el-header>
    <el-main>
      <el-scrollbar>

        <div v-for="icon in icons">
          <div style="line-height:3em">
            <component style="vertical-align:middle;color:#F66;width:1.5em;height:1.5em" :is="icon.name"></component>
            <b style="color:#333;margin-left:0.5em" v-text="icon.name"></b>：<span style="color:gray" v-text="icon"></span>
          </div>
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