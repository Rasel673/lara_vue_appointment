import { defineStore } from "pinia";
import axios from "axios";


export const useUserStore=defineStore('users',{

    state:()=>{
        return{
           tasks:[
            {id:1,name:'Task 1',done:true},
            {id:2,name:'Task 2',done:false},
            {id:3,name:'Task 3',done:true},
            {id:4,name:'Task 4',done:false},
            {id:5,name:'Task 5',done:false},
            {id:6,name:'Task 6',done:true},
            
           ],

           sortable:'all'

        }
    },

    getters: {

      filterTask(){

        return this.sortable=='all'? this.allTasks:this.sortable=='pending'?this.pendingTasks:this.sortable=='completed'?this.completedTasks:this.allTasks;

      },
        


      allTasks(){
        return this.tasks;
      },


      pendingTasks(){

        return this.tasks.filter((task)=>!task.done);
      },


      completedTasks(){

        return this.tasks.filter((task)=>task.done);
      },



      totalTask(){
        return this.tasks.length;
      },

      pendingTask(){

        return this.tasks.filter((task)=>!task.done).length;
      },


      completedTask(){

        return this.tasks.filter((task)=>task.done).length;
      },




      getTask(){
        axios.get(`api/task`)
        .then((response) => {
        console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
      },

      
getUsers (page = 1){
       axios.get(`/api/users?page=${page}`)
    .then((response) => {
    console.log(response.data);
    })
    .catch((error) => {
      console.log(error);
    });
}



      },


    

      actions: {
       
        addTask(task) {
          this.tasks.push(task);
        },
        deleteTask(id) {
         this.tasks=this.tasks.filter((task)=>task.id!=id);
        },

        handleTask(id){
          var task=this.tasks.find((task)=>task.id==id);
          task.done=!task.done;
        }

      },

})