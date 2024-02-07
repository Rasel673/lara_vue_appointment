<template lang="">
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1 class="m-0">Appoinmet</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Appointment</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="d-flex justify-content-between mb-2">
              <div>
                <router-link to="/admin/appoinment/create">
                  <button class="btn btn-primary">
                    <i class="fa fa-plus-circle mr-1"></i> Add New Appointment
                  </button>
                </router-link>
              </div>
              <div class="btn-group">
                <button
                  type="button"
                  @click="getAppointments()"
                  class="btn"
                  :class="[
                    typeof selectedStatus === 'undefined'
                      ? 'btn-secondary'
                      : 'btn-default',
                  ]"
                >
                  <span class="mr-1">All</span>
                  <span class="badge badge-pill badge-info">{{
                    totalAppointment
                  }}</span>
                </button>
                <button
                  type="button"
                  v-for="(status, index) in appointmentStatus"
                  @click="getAppointments(status.value)"
                  class="btn"
                  :class="[
                    selectedStatus == status.value
                      ? 'btn-secondary'
                      : 'btn-default',
                  ]"
                >
                  <span class="mr-1">{{ status.name }}</span>
                  <span
                    class="badge badge-pill"
                    :class="`badge-${status.color}`"
                    >{{ status.count }}</span
                  >
                </button>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Client Name</th>
                      <th scope="col">Mobile</th>
                      <th scope="col">Start time</th>
                      <th scope="col">End Time</th>
                      <th scope="col">Status</th>
                      <th scope="col">Options</th>
                    </tr>
                  </thead>
                  <tbody v-if="apoointments.data.length > 0">
                    <tr
                      v-for="(appointment, index) in apoointments.data"
                      :key="appointment.id"
                    >
                      <td>{{ index + 1 }}</td>
                      <td>{{ appointment.client.full_name }}</td>
                      <td>{{ appointment.client.mobile }}</td>
                      <td>{{ appointment.start_date }}</td>
                      <td>{{ appointment.end_date }}</td>
                      <td>
                        <span
                          class="badge"
                          :class="`badge-${appointment.status.color}`"
                          >{{ appointment.status.name }}</span
                        >
                      </td>
                      <td>
                        <router-link
                          :to="`/admin/appoinment/${appointment.id}/edit`"
                          ><i class="fa fa-edit mr-2"></i
                        ></router-link>
                        <a
                          href=""
                          @click.prevent="deleteAppointment(appointment.id)"
                        >
                          <i class="fa fa-trash text-danger"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td colspan="6" class="text-center">No data</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, reactive, watch, computed } from "vue";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import Swal from "sweetalert2";

const apoointments = ref({
  data: [],
});

const appointmentStatus = ref([]);

const selectedStatus = ref();
// get appointment status

const getAppointmentStatus = () => {
  axios.get("/api/appointments_status").then((response) => {
    appointmentStatus.value = response.data;
  });
};

// appointment list -------------
const getAppointments = (status) => {
  selectedStatus.value = status;
  const params = {};
  if (status) {
    params.status = status;
  }
  axios
    .get(`/api/appointments`, {
      params: params,
    })
    .then((response) => {
      apoointments.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
};

const deleteAppointment = (id) => {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      axios.delete(`/api/appointments/${id}/delete`).then((response) => {
        apoointments.value.data = apoointments.value.data.filter(
          (appoinment) => appoinment.id != id
        );
        Swal.fire({
          title: "Deleted!",
          text: response.data,
          icon: "success",
        });
      });
    }
  });
};

const totalAppointment = computed(() => {
  return appointmentStatus.value
    .map((status) => status.count)
    .reduce((acc, value) => {
      return acc + value;
    }, 0);
});

onMounted(() => {
  getAppointments(), getAppointmentStatus();
});
</script>
<style lang=""></style>
