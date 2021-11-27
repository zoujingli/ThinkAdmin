<template>
  <el-container>
    <el-header>
      <el-menu
          :default-active="1"
          mode="horizontal"
          text-color="#fff"
          background-color="rgba(54,25,88,0.9)"
          active-text-color="rgba(54,25,88,1.0)"
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
      <el-aside>
        <el-tabs tab-position="left">
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
        <el-footer>©版权所有 2014-2021 ThinkAdmin</el-footer>
      </el-container>
    </el-container>
  </el-container>
</template>

<style lang="less">

html, body {
  margin: 0;
  height: 100%;
  padding: 0;
  display: block;
}

body > .el-container {
  height: 100%;

  > .el-header {
    margin: 0;
    padding: 0;
    user-select: none;
    -ms-user-select: none;
    -moz-user-select: none;

    .el-menu {
      border-bottom: 0;

      .el-menu-item {
        border-bottom: 0;

        &:not(.is-disabled) {
          &:first-child {
            width: 280px;
            padding: 0;
            font-weight: bold;

            &:hover, &:active, &:focus, &.is-active {
              color: #FFFFFF !important;
              background: rgba(0, 0, 0, 0) !important;
            }
          }

          &:hover {
            color: #FFFFFF !important;
            background: rgba(54, 25, 88, 0.9) !important;
          }

          &.is-active {
            color: #FFF !important;
            background: rgba(0, 0, 0, 0.4);
          }
        }
      }

      .el-sub-menu {
        .el-sub-menu__title {
          color: #FFFFFF !important;
          background: none !important;
        }

        &.is-opened {
          .el-sub-menu__title {
            background: rgba(0, 0, 0, 0.1) !important;
          }
        }
      }
    }
  }

  > .el-container {
    > .el-aside {
      background: #53a8ff;
      --el-aside-width: 280px;
      box-shadow: 10px 10px 5px #888888;

      .el-tabs {
        height: 100%;
        user-select: none;
        -ms-user-select: none;
        -moz-user-select: none;

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
              color: #333333;
              background: #FFFFFF;
            }

            &:hover:not(.is-active) {
              background: rgba(0, 0, 0, 0.1);
            }
          }
        }

        .el-tabs__content {
          width: 220px !important;
          height: 100% !important;
          background: #FFF;

          h5 {
            margin: 0;
            padding: 0;
            text-align: center;
            line-height: 60px;
            display: none;
            border-bottom: 1px solid #CCC;
          }

          .el-menu {
            border: none !important;
          }
        }
      }
    }

    > .el-container {
      > .el-main {
        padding: 0;
        background: #EFEFEF;

        > .el-container {
          > .el-header {
            line-height: 60px;
            background: rgb(255, 255, 255);
          }

          > .el-main {

          }
        }
      }

      > .el-footer {
        color: #333333;
        background: #CCCCCC;
        line-height: 60px;
        text-align: center;
      }
    }
  }
}
</style>

<script>
export default {
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
