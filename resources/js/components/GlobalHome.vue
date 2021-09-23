<template>
<router-view></router-view>

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
            console.log("i'm a home component")
            this.getPosts();
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
            }
        },

    }
</script>
