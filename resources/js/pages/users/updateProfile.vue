<template lang="">
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1 class="m-0">Update Profile</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Profile</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <input
                    @change="handleChange"
                    ref="fileInput"
                    type="file"
                    class="d-none"
                  />
                  <img
                    class="profile-user-img img-circle"
                    :src="form.avatar"
                    alt="User profile picture"
                    @click="openFile"
                  />
                </div>
                <h3 class="profile-username text-center">{{ form.name }}</h3>
                <p class="text-muted text-center">{{ form.role }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item">
                    <a class="nav-link active" href="#profile" data-toggle="tab"
                      ><i class="fa fa-user mr-1"></i> Edit Profile</a
                    >
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#changePassword" data-toggle="tab"
                      ><i class="fa fa-key mr-1"></i> Change Password</a
                    >
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="profile">
                    <form
                      class="form-horizontal"
                      @submit.prevent="updateProfile()"
                    >
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label"
                          >Name</label
                        >
                        <div class="col-sm-10">
                          <input
                            type="text"
                            class="form-control"
                            id="inputName"
                            placeholder="Name"
                            v-model="form.name"
                          />
                          <span
                            class="text-danger"
                            v-if="errors && errors.name"
                            >{{ errors.name[0] }}</span
                          >
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label"
                          >Email</label
                        >
                        <div class="col-sm-10">
                          <input
                            type="email"
                            class="form-control"
                            id="inputEmail"
                            placeholder="Email"
                            v-model="form.email"
                          />
                          <span
                            class="text-danger"
                            v-if="errors && errors.email"
                            >{{ errors.email[0] }}</span
                          >
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-success">
                            <i class="fa fa-save mr-1"></i> Save Changes
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane" id="changePassword">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label
                          for="currentPassword"
                          class="col-sm-3 col-form-label"
                          >Current Password</label
                        >
                        <div class="col-sm-9">
                          <input
                            type="password"
                            class="form-control"
                            id="currentPassword"
                            placeholder="Current Password"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="newPassword" class="col-sm-3 col-form-label"
                          >New Password</label
                        >
                        <div class="col-sm-9">
                          <input
                            type="password"
                            class="form-control"
                            id="newPassword"
                            placeholder="New Password"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <label
                          for="passwordConfirmation"
                          class="col-sm-3 col-form-label"
                          >Confirm New Password</label
                        >
                        <div class="col-sm-9">
                          <input
                            type="password"
                            class="form-control"
                            id="passwordConfirmation"
                            placeholder="Confirm New
  Password"
                          />
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-3 col-sm-9">
                          <button type="submit" class="btn btn-success">
                            <i class="fa fa-save mr-1"></i> Save Changes
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useToastr } from "../../toastr";

const toastr = useToastr();

const form = ref({
  name: "",
  email: "",
  role: "",
  avatar: "",
});

const fileInput = ref(null);

const openFile = () => {
  fileInput.value.click();
};

const profilePictureUrl = ref(null);

const handleChange = (event) => {
  const file = event.target.files[0];
  profilePictureUrl.value = URL.createObjectURL(file);

  const formData = new FormData();
  formData.append("profile_picture", file);

  axios
    .post("/upload_profile_picture", formData)
    .then((response) => {
      toastr.success(response.data.message);
      console.log(response.data);
    })
    .catch((error) => {});
};

const errors = ref();

const getUser = () => {
  axios
    .get("/profile")
    .then((response) => {
      form.value = response.data;
    })
    .catch((error) => {
      console.log(error.response.data.errors);
    });
};

const updateProfile = () => {
  axios
    .put("/profile", form.value)
    .then((response) => {
      toastr.success("Profile Updated Successfully");
    })
    .catch((error) => {
      if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      }
      console.log(error.response.data);
    });
};

onMounted(() => {
  getUser();
});
</script>
<style>
.profile-user-img:hover {
  background-color: purple;
  cursor: pointer;
}
</style>
