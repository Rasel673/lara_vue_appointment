<template lang="">
  <div>
    <form @submit.prevent="addTask">
      <div class="d-flex justify-content-between">
        <input type="text" class="form-control" v-model="task" />
        <button class="btn btn-primary">Add</button>
      </div>
    </form>
  </div>
</template>
<script setup>
import { ref } from "vue";
import { useUserStore } from "../../store/UserStore";

const store = useUserStore();
const task = ref("");
const addTask = () => {
  let newtask = {
    id: Date.now,
    name: task.value,
    done: false,
  };
  store.addTask(newtask);
  task.value = "";
};
</script>
<style lang=""></style>
