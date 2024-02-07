<template lang="">
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1 class="m-0">Update Settings</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Settings</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="col-md-8">
          <form @submit.prevent="updateSettings()">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="" class="form-label">App Name</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="settings.app_name"
                    placeholder="App Name"
                  />
                  <span class="text-danger" v-if="errors && errors.app_name">{{
                    errors.app_name[0]
                  }}</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="" class="form-label">Date Format</label>
                  <select
                    class="form-control"
                    v-model="settings.date_format"
                    name="role"
                  >
                    <option value="d-m-Y">d-m-Y</option>
                    <option value="d/m/Y">d/m/Y</option>
                    <option value="Y-m-d">Y-m-d</option>
                  </select>
                  <span
                    class="text-danger"
                    v-if="errors && errors.date_format"
                    >{{ errors.date_format[0] }}</span
                  >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="" class="form-label">Pagination Limit</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="settings.pagination_limit"
                    placeholder="Pagination Limit"
                  />
                  <span
                    class="text-danger"
                    v-if="errors && errors.pagination_limit"
                    >{{ errors.pagination_limit[0] }}</span
                  >
                </div>
              </div>
              <div class="col-md-12">
                <button type="submit" class="btn btn-primary text-center">
                  Submit
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useToastr } from "../../toastr";
const settings = ref([]);

const toastr = useToastr();
const errors = ref();

const getSetiingsData = () => {
  axios
    .get("/api/settings")
    .then((response) => {
      console.log(response.data);
      settings.value = response.data;
    })
    .catch((error) => {
      console.log(error.response.data);
    });
};

const updateSettings = () => {
  axios
    .post("/api/settings", settings.value)
    .then((response) => {
      toastr.success(response.data.success);
    })
    .catch((error) => {
      if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      }
    });
};

onMounted(() => {
  getSetiingsData();
});
</script>
<style lang=""></style>
