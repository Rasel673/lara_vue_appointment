<template lang="">
  <div>
    <div class="container h-100">
      <div class="row h-100 justify-content-center align-items-center">
        <div class="login-box">
          <div class="card my-5">
            <div class="card-header"><h6>Todo List</h6></div>
            <div class="card-body">
              <AddTodoItem />
              <div class="pt-2">
                <table class="table table-striped">
                  <tbody>
                    <TodoItem
                      v-for="task in store.filterTask"
                      :key="task.id"
                      :task="task"
                    />
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <div class="row"><FilterTodoItem /></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { onMounted } from "vue";
import { useUserStore } from "../../store/UserStore";
import TodoItem from "./todoItem.vue";
import AddTodoItem from "./addTodoItem.vue";
import FilterTodoItem from "./filterTodoItem.vue";

const store = useUserStore();

onMounted(() => {
  store.getTask;
});
</script>
<style lang=""></style>
