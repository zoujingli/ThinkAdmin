<template>
  <el-form class="loginForm" label-width="100px" :model="login" style="max-width:460px">
    <el-form-item label="登录账号">
      <el-input v-model="login.username" placeholder="请输入登录账号"></el-input>
    </el-form-item>
    <el-form-item label="登录密码">
      <el-input v-model="login.password" placeholder="请输入登录密码"></el-input>
    </el-form-item>
    <el-form-item label="图形验证">
      <el-input v-model="login.verify" placeholder="请输入图形验证"></el-input>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" data-route="/static/template/pages/one.vue">登录</el-button>
    </el-form-item>
  </el-form>
</template>

<style lang="less">
.loginForm {
  top: 50%;
  left: 50%;
  position: absolute;
  margin-top: -200px;
  margin-left: -230px;
}
</style>

<script lang="ts" setup>
import {reactive, ref} from 'vue'

const login = reactive({
  verify: '',
  username: '',
  password: '',
});
</script>
