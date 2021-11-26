<template>
  <el-container>
    <el-header style="padding:0">
      <el-menu class="think-header"
               :default-active="1"
               mode="horizontal" text-color="#fff" style="border-bottom:0"
               background-color="rgba(54,25,88,0.9)" active-text-color="rgba(54,25,88,1.0)"
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
        <el-tabs tab-position="left" style="height:100%">
          <el-tab-pane v-for="menu in menus">
            <template #label>{{ menu.name }}</template>
            <h5 v-text="menu.title">Default colors</h5>
            <el-menu default-active="2">
              <el-sub-menu index="1">
                <template #title>
<!--                  <el-icon>-->
<!--                    <location></location>-->
<!--                  </el-icon>-->
                  <span>Navigator One</span>
                </template>

                <el-menu-item index="1-1">item one</el-menu-item>
                <el-menu-item index="1-2">item one</el-menu-item>
                <el-menu-item index="1-3">item three</el-menu-item>

              </el-sub-menu>
              <el-menu-item index="2">
<!--                <el-icon>-->
<!--                  <icon-menu></icon-menu>-->
<!--                </el-icon>-->
                <span>Navigator Two</span>
              </el-menu-item>
              <el-menu-item index="3">
<!--                <el-icon>-->
<!--                  <document></document>-->
<!--                </el-icon>-->
                <span>Navigator Three</span>
              </el-menu-item>
              <el-menu-item index="4">
<!--                <el-icon>-->
                <!--                  <setting></setting>-->
                <!--                </el-icon>-->
                <span>Navigator Four</span>
              </el-menu-item>
            </el-menu>
          </el-tab-pane>
        </el-tabs>
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
  margin: 0;
  height: 100%;
  display: block;
  padding: 0;
}

body > .el-container {
  height: 100%;

  > .el-header {
    color: #fff;
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

.think-header.el-menu {
  .el-menu-item:not(.is-disabled) {
    border-bottom: 0 !important;

    &:hover {
      color: #FFF !important;
      background: rgba(54, 25, 88, 0.9) !important;
    }

    &.is-active {
      color: #FFF !important;
      background: rgba(0, 0, 0, 0.4);
      border-bottom: 0 !important;
    }
  }

  .el-sub-menu {
    .el-sub-menu__title {
      color: #FFF !important;
      background: none !important;
    }

    &.is-opened {
      .el-sub-menu__title {
        background: rgba(0, 0, 0, 0.1) !important;
      }
    }
  }
}

.el-tabs {

  .el-tabs__header {
    width: 60px;
    margin: 0 !important;
    background: rgba(54, 25, 88, 0.8);

    .el-tabs__active-bar {
      display: none !important;
    }

    .el-tabs__nav-wrap {
      margin-right: 0 !important;

      &::after {
        display: none;
      }
    }

    .el-tabs__item {
      color: #FFF;
      width: 100% !important;
      height: 60px !important;
      padding: 0 !important;
      line-height: 60px !important;
      text-align: center !important;

      &.is-active {
        background: rgba(0, 0, 0, 0.4);
      }

      &:hover:not(.is-active) {
        background: rgba(0, 0, 0, 0.1);
      }
    }
  }

  .el-tabs__content {
    width: 220px !important;
    height: 100% !important;
    //background: red;
    text-align: center;
    background: #FFF;
  }
}
</style>

<script>
export default {
  name: "layout",
  components: {},
  data() {
    return {
      menus: [
        {name: 'ONE', title: 'SHOW-ONE-LIST', subs: []},
        {name: 'TWO', title: 'SHOW-TWO-LIST', subs: []},
        {name: 'THR', title: 'SHOW-THR-LIST', subs: []},
        {name: 'FOR', title: 'SHOW-FOR-LIST', subs: []},
      ]
    }
  }
}
</script>
