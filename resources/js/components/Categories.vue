<template>

    <div class="my-4 card">
          <h5 class="card-header">Categories</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <ul class="mb-0 list-unstyled">

                                 <li  v-for="category in categories.data" :key="category.id" >

                <router-link :to="'/category/posts/'+category.id">
                   {{ category.name}}
                </router-link>


                  </li>



                </ul>
              </div>

            </div>
          </div>
        </div>
</template>
<script>
import axios from "axios"

    export default {
        mounted() {
            console.log('in ')
            this.getCategories();


        },
        data(){
          return{categories:{}}
        },
        methods: {
           getCategories(){
               axios.get('api/posts/').then(res=>{
                   this.categories=res.data.categories;

                }).then(err=>{
                   console.log(err);
               });
           }
        },
    }
</script>
