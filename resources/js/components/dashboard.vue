<template lang="">
  <div> <div class="content-header"> <div class="container-fluid"> <div class="row mb-2">
  <div class="col-sm-6"> <h1 class="m-0">Dashboard</h1> </div> <div class="col-sm-6"> <ol
  class="breadcrumb float-sm-right"> <li class="breadcrumb-item"><a href="#">Home</a></li>
  </ol> </div> </div> </div> </div> <div class="content"> <div class="container-fluid">
  <div class="row"> <div class="col-lg-3 col-6"> <!-- small box --> <div class="small-box
  bg-info"> <div class="inner"> <div class="d-flex justify-content-between"> <h3>{{
    totalAppoinmentCount
  }}</h3> <div > <select v-model="selectedStatus" @change="getAppointmentCount()"
  class="form-control" name="role" > <option value="all">All</option> <option
  value="scheduled">Scheduled</option> <option value="confirmed">Confirmed</option>
  <option value="cencelled">Cencelled</option> </select> </div> </div> <p>Appointments</p>
  </div> <router-link to="/admin/appoinment" class="small-box-footer">More info <i
  class="fas fa-arrow-circle-right"></i></router-link> </div> </div> <!-- ./col --> <div
  class="col-lg-3 col-6"> <!-- small box --> <div class="small-box bg-success"> <div
  class="inner"> <div class="d-flex justify-content-between"> <h3>150</h3> <div > <select
  class="form-control" name="role" > <option value="scheduled">User</option> <option
  value="confirmed">SCHEDULED</option> <option value="cencelled">SCHEDULED</option>
  </select> </div> </div> <p>Users</p> </div> <div class="icon"> <i class="ion
  ion-stats-bars"></i> </div> <router-link to="/admin/users" class="small-box-footer">More
  info <i class="fas fa-arrow-circle-right"></i></router-link> </div> </div> </div> <!--
  /.row --> </div> </div> </div>
</template>
<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

const selectedStatus = ref("all");
const totalAppoinmentCount = ref(0);

const getAppointmentCount = () => {
  axios
    .get("/api/appointments_stat/count", {
      params: {
        status: selectedStatus.value,
      },
    })
    .then((response) => {
      totalAppoinmentCount.value = response.data;
    });
};

onMounted(() => {
  getAppointmentCount();
});
</script>
<style lang=""></style>
