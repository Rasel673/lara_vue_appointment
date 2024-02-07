<template lang="">
    <div>
        <div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <div v-if="errorMsg" class="alert alert-danger" role="alert">
        {{errorMsg}}
    </div>



      <form @submit.prevent="handleSubmit">
        <div class="input-group mb-3">
          <input type="email" class="form-control" v-model="form.email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control"  v-model="form.password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" :disabled="loading">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="loading" ></span>
               
            Sign In
            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    

      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->


    </div>
</template>
<script setup>
import axios from 'axios';
import {reactive,ref} from 'vue';


const form=reactive({
email:'',
password:''
});

const loading=ref(false);
const errorMsg=ref();

const handleSubmit=()=>{
  loading.value=true;
  errorMsg.value='';
    axios.post('/login',form).then((response)=>{
        console.log(response.data);
        window.location.href='/admin/dasboard';
    }).catch((error)=>{
      errorMsg.value=error.response.data.message;
    }).finally(
      ()=>{
        loading.value=false
      }

    );
}


</script>
<style lang="">
    
</style>