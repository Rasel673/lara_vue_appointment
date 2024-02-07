<template lang="">
  <div>
    <tr class="d-flex justify-content-between">
      <td>
        <input
          type="checkbox"
          @click="handleTask(task.id)"
          :checked="task.done"
          class="mr-2"
        />
        <del v-if="task.done">{{ task.name }}</del>
        <span v-else>{{ task.name }}</span>
      </td>
      <td>
        <button @click="remove(task.id)" class="btn btn-danger">
          <i class="fa fa-trash"></i>
        </button>
      </td>
    </tr>
  </div>
</template>
<script setup>
import { useUserStore } from "../../store/UserStore.js";

defineProps({
  task: Object,
});

const store = useUserStore();

const remove = (id) => {
  store.deleteTask(id);
};

const handleTask = (id) => {
  store.handleTask(id);
};
</script>
<style lang=""></style>
