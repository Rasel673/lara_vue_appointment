<script setup>
import { ref } from "vue";
import { useToastr } from "../toastr";
import { formatedDate } from "../helper";

defineProps({
  users: Object,
  index: Number,
});

const toastr = useToastr();

const emit = defineEmits(["userDeleted"]);

const userBeingDeleted = ref();
// delete user---------------

const deleteUser = (user) => {
  if (confirm("Do you really want to delete?")) {
    confirmDelte(user.id);
  }
};

const confirmDelte = (id) => {
  axios
    .get("/api/delete_user/" + id)
    .then((response) => {
      //   $('#deleteModal').modal('hide');
      toastr.success("User Delted Successfully");
      emit("userDeleted", id);
    })
    .catch((error) => {
      toastr.error("something went wrong");
    });
};
</script>

<template lang="">
  <tr v-for="(user,index) in users" :key="user.id"> <td><input type="checkbox"
  :checked="selectAll" @change="toggleSelction(user)" /></td> <td >{{ index + 1 }}</td>
  <td>{{ user.name }}</td> <td>{{ user.email }}</td> <td>{{
    formatedDate(user.created_at)
  }}</td> <td><select class="form-control" name="role"
  @change="changeRole(user,$event.target.value)"> <option v-for="role in roles"
  :value="role.value" :selected="(user.role===role.name)">{{ role.name }}</option>
  </select></td> <td> <a href="" @click.prevent="editUser(user)" class="btn
  btn-primary"><i class="fa fa-edit"></i></a> <a href="" @click.prevent="deleteUser(user)"
  class="btn btn-danger ml-2"><i class="fa fa-trash"></i></a> <a href="" class="btn
  btn-danger">Delete</a> </td> </tr> <!-- delete Modal --> <div class="modal fade"
  id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <h5
  class="modal-title" id="deleteModalLabel"> Are You Sure? </h5> <button type="button"
  class="close" data-dismiss="modal" aria-label="Close"> <span
  aria-hidden="true">&times;</span> </button> </div> <div class="modal-body"> <h5
  class="text-center py-2 text-danger"> You want to delete this user.</h5> </div> <div
  class="modal-footer"> <button type="button" class="btn btn-secondary close"
  data-dismiss="modal" aria-label="Close">Close</button> <button type="button"
  @click.prevent="confirmDelte" class="btn btn-primary">Yes</button> </div> </div> </div>
  </div>
</template>
