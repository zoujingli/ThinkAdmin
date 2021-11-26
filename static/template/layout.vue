<template>
  <el-container>
    <el-header style="padding:0">
      <el-menu
          mode="horizontal"
          text-color="#fff"
          :default-active="1"
          background-color="rgba(54,25,88,.9)"
          active-text-color="rgba(54,25,88,1)"
      >
        <el-menu-item route="/" index="1">ThinkAdmin For HTML</el-menu-item>
        <el-sub-menu index="2">
          <template #title>Workspace</template>
          <el-menu-item index="2-1">item one</el-menu-item>
          <el-menu-item index="2-2">item two</el-menu-item>
          <el-menu-item index="2-3">item three</el-menu-item>
        </el-sub-menu>
        <el-menu-item index="3">Info</el-menu-item>
        <el-menu-item index="4">Orders</el-menu-item>
      </el-menu>
    </el-header>
    <el-container>
      <el-aside width="280px">
        <el-container style="height:100%">
          <el-aside width="80px" style="background:rgba(54,25,88,.9);height:100%">

          </el-aside>
          <el-container style="background:#8c939d">
            <el-menu default-active="1" style="width:100%">
              <el-sub-menu index="1">
                <template #title>
                  <el-icon>
                    <location/>
                  </el-icon>
                  <span>Navigator One</span>
                </template>
                <el-menu-item-group title="Group One">
                  <el-menu-item index="1-1">item one</el-menu-item>
                  <el-menu-item index="1-2">item one</el-menu-item>
                </el-menu-item-group>
                <el-menu-item-group title="Group Two">
                  <el-menu-item index="1-3">item three</el-menu-item>
                </el-menu-item-group>
                <el-sub-menu index="1-4">
                  <template #title>item four</template>
                  <el-menu-item index="1-4-1">item one</el-menu-item>
                </el-sub-menu>
              </el-sub-menu>
              <el-menu-item index="2">
                <el-icon>
                  <icon-menu/>
                </el-icon>
                <span>Navigator Two</span>
              </el-menu-item>
              <el-menu-item index="3" disabled>
                <el-icon>
                  <document/>
                </el-icon>
                <span>Navigator Three</span>
              </el-menu-item>
              <el-menu-item index="4">
                <el-icon>
                  <setting/>
                </el-icon>
                <span>Navigator Four</span>
              </el-menu-item>
            </el-menu>
          </el-container>
        </el-container>
      </el-aside>
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
html, body {
  height: 100%;
  display: block;
  margin: 0;
  padding: 0;
}

body > .el-container {
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
        background: #efefef;
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
    return {
      menus: []
    }
  },
  created() {
  },
  methods: {}
}
</script>
