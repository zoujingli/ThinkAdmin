<template>
  <el-container>
    <el-header>
      <el-row justify="space-between">
        <el-col :span="12">Item-Three-Page</el-col>
        <el-col :span="12" style="text-align:right">
          <el-button>功能按钮1</el-button>
          <el-button>功能按钮2</el-button>
        </el-col>
      </el-row>
    </el-header>
    <el-main>
      <el-scrollbar>
        
        <el-form :inline="true" class="demo-form-inline">
          <el-form-item label="Approved by">
            <el-input placeholder="Approved by"></el-input>
          </el-form-item>
          <el-form-item label="Activity zone">
            <el-select placeholder="Activity zone">
              <el-option label="Zone one" value="shanghai"></el-option>
              <el-option label="Zone two" value="beijing"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button type="primary">Query</el-button>
          </el-form-item>
        </el-form>

        <el-table :data="tableData" border style="width:100%">
          <el-table-column prop="date" label="Date" width="180"/>
          <el-table-column prop="name" label="Name" width="180"/>
          <el-table-column prop="address" label="Address"/>
        </el-table>

      </el-scrollbar>
    </el-main>
  </el-container>
</template>

<script lang="ts">
export default {
  data() {
    return {
      tableData: [
        {
          date: '2016-05-03',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles',
        },
        {
          date: '2016-05-02',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles',
        },
        {
          date: '2016-05-04',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles',
        },
        {
          date: '2016-05-01',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles',
        },
      ],
    }
  },
}
</script>