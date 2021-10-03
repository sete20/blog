<template>
<div>
<navbar></navbar>
<router-view></router-view>
</div>
</template>

<script>
import axios from "axios";

    export default {
        data(){
            return{
                posts:[],
                categories:[]
            }
        },
        mounted() {
            this.getPosts();
        },created() {
            this.updateToken();
        },
        methods: {
            getPosts(){
                axios.get('api/posts')
                .then(res=>{
                    this.posts =res.data.posts;
                    this.categories= res.data.categories;
                    }
                    ).
                then(err=>console.log(err))
            },
                   updateToken(){
            let token = JSON.parse(localStorage.getItem('userToken'));
            this.$store.commit('setUserToken',token);
        },
        },computed:{
            isLogged(){
                return this.$store.getters.isLogged;
            }
        }
 

    }
</script>
