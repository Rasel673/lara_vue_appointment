<template lang="">
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1 class="m-0">Users</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="d-flex justify-content-between">
              <div>
                <button
                  type="button"
                  class="btn btn-primary mb-2"
                  @click="addUser"
                >
                  + Add User
                </button>
                <button
                  type="button"
                  v-if="selectedUsers.length > 0"
                  class="btn btn-danger mb-2 ml-2"
                  @click="bulkDelete"
                >
                  Delete Selected ({{ selectedUsers.length }})
                </button>
              </div>
              <div>
                <input
                  type="text"
                  name="query"
                  v-model="searchQuery"
                  placeholder=" search ..."
                  class="form-contol"
                />
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div
                  id="example2_wrapper"
                  class="dataTables_wrapper dt-bootstrap4"
                >
                  <div class="row">
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-6"></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <table
                        id="example2"
                        class="table table-bordered table-hover dataTable dtr-inline"
                        aria-describedby="example2_info"
                      >
                        <thead>
                          <tr>
                            <th>
                              <input
                                type="checkbox"
                                v-model="selectAll"
                                @change="selectAllUsers"
                              />
                            </th>
                            <th style="width: 10px;">Serial</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Regitered Date</th>
                            <th>Role</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody v-if="users.data.length > 0">
                          <tr
                            class="odd"
                            v-for="(user, index) in users.data"
                            :key="user.id"
                          >
                            <td>
                              <input
                                type="checkbox"
                                :checked="selectAll"
                                @change="toggleSelction(user)"
                              />
                            </td>
                            <td>{{ index + 1 }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ formatedDate(user.created_at) }}</td>
                            <td>
                              <select
                                class="form-control"
                                name="role"
                                @change="changeRole(user, $event.target.value)"
                              >
                                <option
                                  v-for="role in roles"
                                  :value="role.value"
                                  :selected="(user.role===role.name)"
                                  >{{ role.name }}</option
                                >
                              </select>
                            </td>
                            <td>
                              <a
                                href=""
                                @click.prevent="editUser(user)"
                                class="btn btn-primary"
                                ><i class="fa fa-edit"></i
                              ></a>
                              <a
                                href=""
                                @click.prevent="deleteUser(user)"
                                class="btn btn-danger ml-2"
                                ><i class="fa fa-trash"></i
                              ></a>
                              <!-- <a href="" class="btn
  btn-danger">Delete</a> -->
                            </td>
                          </tr>
                        </tbody>
                        <tbody v-else>
                          <tr>
                            <td colspan="6" class="text-center">No data</td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Serial</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Regitered Date</th>
                            <th>Role</th>
                            <th>Action</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                  <Bootstrap4Pagination
                    :data="users"
                    @pagination-change-page="getUsers"
                  />
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!--
  /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      </div>
    </div>
  </div>
  <!-- add &
  edit Modal -->
  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            <span v-if="editing">Edit User</span>
            <span v-else>Create User</span>
          </h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <Form
          @submit="handleSubmit"
          ref="form"
          :validation-schema="editing ? edit_userSchema : create_userSchema"
          v-slot="{ errors }"
        >
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Name</label>
              <Field
                type="text"
                name="name"
                class="form-control"
                :class="{ 'is-invalid': errors.name }"
                id="name"
                v-model="formValues.name"
              />
              <span class="invalid-feedback">{{ errors.name }}</span>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <Field
                type="email"
                class="form-control"
                name="email"
                id="exampleInputEmail1"
                :class="{
                  'is-invalid': errors.email,
                }"
                aria-describedby="emailHelp"
                v-model="formValues.email"
              />
              <span class="invalid-feedback">{{ errors.email }}</span>
              <small id="emailHelp" class="form-text text-muted"
                >We'll never share your email with anyone else.</small
              >
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <Field
                type="password"
                name="password"
                class="form-control"
                :class="{ 'is-invalid': errors.password }"
                id="exampleInputPassword1"
                v-model="formValues.password"
              />
              <span class="invalid-feedback">{{ errors.password }}</span>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </Form>
      </div>
    </div>
  </div>
  <!-- delete Modal -->
  <div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-labelledby="deleteModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Are You Sure?</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h5 class="text-center py-2 text-danger">
            You want to delete this user.
          </h5>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary close"
            data-dismiss="modal"
            aria-label="Close"
          >
            Close
          </button>
          <button
            type="button"
            @click.prevent="confirmDelte"
            class="btn btn-primary"
          >
            Yes
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, reactive, watch } from "vue";
import { Form, Field } from "vee-validate";
import * as yup from "yup";
import { useToastr } from "../../toastr";
import { formatedDate } from "../../helper";
import { useUserStore } from "../../store/UserStore";
import { Bootstrap4Pagination } from "laravel-vue-pagination";

const toastr = useToastr();
const store = useUserStore();
const users = ref({
  data: [],
});

const roles = ref([
  {
    name: "ADMIN",
    value: 1,
  },

  {
    name: "USER",
    value: 2,
  },
]);

const editing = ref(false);

const formValues = ref({
  id: "",
  name: "",
  email: "",
  password: "",
});
const form = ref(null);
const userBeingDeleted = ref();

const create_userSchema = yup.object({
  name: yup.string().required(),
  email: yup.string().email().required(),
  password: yup.string().required().min(6),
});

const edit_userSchema = yup.object({
  name: yup.string().required(),
  email: yup.string().email().required(),
  password: yup.string().when((password, schema) => {
    return password ? schema.min(6) : schema;
  }),
});

// user list -------------

const getUsers = (page = 1) => {
  axios
    .get(`/api/users?page=${page}`)
    .then((response) => {
      users.value = response.data;
      selectedUsers.value = [];
      selectAll.value = false;
    })
    .catch((error) => {
      console.log(error);
    });
};

// add user--------

const addUser = () => {
  editing.value = false;
  form.value.resetForm();
  $("#exampleModal").modal("show");
};

const createUser = (values, { resetForm, setErrors }) => {
  axios
    .post("/api/create_user", values)
    .then((response) => {
      users.value.data.unshift(response.data);
      $("#exampleModal").modal("hide");
      resetForm();
      toastr.success("New User Created");
    })
    .catch((error) => {
      if (error.response.data.errors) {
        setErrors(error.response.data.errors);
      }
    });
};

// user edit-----------
const editUser = (user) => {
  editing.value = true;
  // form.value.resetForm();
  $("#exampleModal").modal("show");
  formValues.value = {
    id: user.id,
    name: user.name,
    email: user.email,
    // password:user.password
  };
};

const updateUser = (values, { resetForm, setErrors }) => {
  axios
    .post("/api/update_user/" + formValues.value.id, values)
    .then((response) => {
      const index = users.value.data.findIndex(
        (user) => user.id === response.data.id
      );
      users.value.data[index] = response.data;
      $("#exampleModal").modal("hide");
      toastr.success("Updated Successfully");
    })
    .catch((error) => {
      if (error.response.data.errors) {
        setErrors(error.response.data.errors);
      }
    });
};

// delete user---------------
const deleteUser = (user) => {
  $("#deleteModal").modal("show");
  userBeingDeleted.value = user.id;
};

const confirmDelte = () => {
  axios
    .get("/api/delete_user/" + userBeingDeleted.value)
    .then((response) => {
      $("#deleteModal").modal("hide");
      users.value.data = users.value.data.filter(
        (user) => user.id !== userBeingDeleted.value
      );
      toastr.success("User Delted Successfully");
    })
    .catch((error) => {
      toastr.error("something went wrong");
    });
};

const handleSubmit = (values, actions) => {
  if (editing.value) {
    updateUser(values, actions);
  } else {
    createUser(values, actions);
  }
};

const changeRole = (user, role) => {
  axios
    .post(`/api/change_role`, {
      user_id: user.id,
      role: role,
    })
    .then((response) => {
      toastr.success("Role Updated Successfully");
    })
    .catch((error) => {
      console.log(error.data);
    });
};

// bulk delete----------------
const selectedUsers = ref([]);

const toggleSelction = (user) => {
  const index = selectedUsers.value.indexOf(user.id);
  if (index === -1) {
    selectedUsers.value.push(user.id);
  } else {
    selectedUsers.value.splice(index, 1);
  }
};

const selectAll = ref(false);

const selectAllUsers = () => {
  if (selectAll.value) {
    selectedUsers.value = users.value.data.map((user) => user.id);
  } else {
    selectedUsers.value = [];
  }
};

const bulkDelete = () => {
  axios
    .delete(`/api/delete_bulk_user`, {
      data: {
        ids: selectedUsers.value,
      },
    })
    .then((response) => {
      users.value.data = users.value.data.filter(
        (user) => !selectedUsers.value.includes(user.id)
      );
      selectedUsers.value = [];
      toastr.success(response.data.message);
    });
};

const searchQuery = ref(null);

const search = () => {
  axios
    .get("/api/user/search/", {
      params: {
        query: searchQuery.value,
      },
    })
    .then((response) => {
      users.value = response.data;
    })
    .catch((error) => {});
};

watch(searchQuery, () => {
  search();
});

onMounted(() => {
  getUsers();
});
</script>
<style lang=""></style>
