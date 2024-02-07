<template lang="">
  <div>
    <div class="d-flex">
      <input
        type="radio"
        name="sortable"
        v-model="sortable"
        value="all"
        class="m-1"
      />
      All({{ totalTask }})
      <input
        type="radio"
        name="sortable"
        v-model="sortable"
        value="completed"
        class="m-1"
      />
      Completed({{ completedTask }})
      <input
        type="radio"
        name="sortable"
        value="pending"
        v-model="sortable"
        class="m-1"
      />
      Pending({{ pendingTask }})
    </div>
  </div>
</template>
<script setup>
import { useUserStore } from "../../store/UserStore";
import { storeToRefs } from "pinia";
const store = useUserStore();
const { sortable, totalTask, completedTask, pendingTask } = storeToRefs(store);
</script>
<style lang=""></style>
