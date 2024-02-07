<template lang="">
    <div>
       

        <div class="content-header">
<div class="container">
<div class="row mb-2">
<div class="col-sm-6">
<h1 class="m-0"> 
<span v-if="editMode">Edit</span>
<span v-else>Add New</span>
Appointment</h1>
</div>
<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item">Appointment</li>
<li class="breadcrumb-item active">
<span v-if="editMode">Edit</span>
<span v-else>Create</span>


</li>
</ol>
</div>
</div>
</div>
</div>



<div class="content">
        <div class="container">
            <Form @submit="handleSubmit"  v-slot:default="{errors}">
            <div class="row">
           
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="form-label">Title</label>
                        <input type="text" class="form-control" v-model="form.title"  :class="{'is-invalid':errors.title}" placeholder="Title">
                        <span class="invalid-feedback">{{errors.title}}</span>
                    </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                <label for="client_id" class="form-label">Client</label>
                <select class="form-control" v-model="form.client_id"  :class="{'is-invalid':errors.client_id}" id="client_id">
                <option selected>Select Client</option>
                <option v-for="(client,index) in clients"  :value="client.id" :key="client.id">{{client.full_name}}</option>      
                
                </select>

                <span class="invalid-feedback">{{errors.client_id}}</span>
                    </div>
                </div>
               


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date" class="form-label">Appoinmet Start Time</label>
                        <input type="date" class="form-control flatpickr" v-model="form.start_date"  :class="{'is-invalid':errors.start_date}" placeholder="" id="start_date"  required>
                        <span class="invalid-feedback">{{errors.start_date}}</span>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_date" class="form-label">Appoinmet End Date</label>
                        <input type="date" class="form-control flatpickr" v-model="form.end_date" placeholder=""  :class="{'is-invalid':errors.end_date}"  id="end_date" required>
                        <span class="invalid-feedback">{{errors.end_date}}</span>
                    </div>
                </div>
              
             


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="form-label">Description</label>
                        <textarea v-model="form.description" class="form-control"  :class="{'is-invalid':errors.description}" id="" cols="5" rows="5"></textarea>
                        <span class="invalid-feedback">{{errors.description}}</span>
                    </div>
                </div>

                
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary text-center" >Submit</button>
                </div>

            
              
            </div>

        </Form>
        </div>
    </div>





    </div>
</template>
<script setup>

import {ref,onMounted,reactive} from 'vue';
import {Form} from 'vee-validate';
import { useToastr } from '../../toastr'; 
import { useRouter,useRoute } from 'vue-router';
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";


const form=reactive({
    'title':'',
    'client_id':'',
    'start_date':'',
    'end_date':'',
    'desciption':'',
});


const clients=ref();

const toastr=useToastr();

const router=useRouter();
const route=useRoute();

const editMode=ref(false);

const handleSubmit=(values,actions)=>{

    if(editMode.value){
        editAppointment(values,actions)
    }else{
        createAppointment(values,actions)
    }


}


const createAppointment=(values,actions)=>{
    axios.post('/api/appointments_add',form).then((response)=>{
    
    router.push('/admin/appoinment');
    toastr.success(response.data);
    
}).catch((error)=>{

    actions.setErrors(error.response.data.errors);

})
}

const getClients=()=>{
    axios.get('/api/clients').then((response)=>{
        clients.value=response.data;
    }).catch((error)=>{

    })
}


const editAppointment=(values,actions)=>{
    var id=route.params.id;
    axios.put(`/api/appointments/${id}/edit`,form).then((response)=>{
    router.push('/admin/appoinment');
    toastr.success(response.data);
    
}).catch((error)=>{

    actions.setErrors(error.response.data.errors);

})
}

const getSingleAppointment=()=>{
var id=route.params.id;
 axios.get(`/api/appointments/${id}/edit`).then(({data})=>{
     form.client_id=data.client_id;
     form.title=data.title;
     form.start_date=data.formatted_start_date;
     form.end_date=data.end_date;
     form.desciption=data.desciption;
    }).catch((error)=>{

    })

}

onMounted(()=>{
    getClients()
    getSingleAppointment()
    if(route.name==='appointment.edit'){
      editMode.value=true; 
     

    }

    flatpickr(".flatpickr",{
        enableTime:true,
        dateFormat:"d-m-Y h:i K",
        defaultHour:10
    })

})



</script>
<style lang="">
    
</style>