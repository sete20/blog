<template>
  <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">

        <!-- Title -->
        <h1 class="mt-4">{{ post.title }}</h1>

        <!-- Author -->
        <p class=" alert alert-info" v-for="category in post.categories" :key="category.id" style="width: fit-content;
        padding: 5px;
        color: #142d31;" >
           <router-link :to="'/category/posts/'+category.id">
                   {{ category.name}}
                </router-link>

        </p>

        <hr>

        <!-- Date/Time -->
        <p>Posted on <strong class="p-1 badge badge-primary">{{ post.added_at }}</strong> at <strong class="p-1 badge badge-danger"> 12:00 PM</strong>
            <span class="float-right"><strong class="p-1 badge badge-info">{{ comments.length }}</strong> comments</span></p>

        <hr>

        <!-- Preview Image -->
               <img class="mr-3" v-if="post.poster" :src="'img/posts/'+post.poster" alt="Generic placeholder image">
          <img class="m-10" v-else src="img/posts/defulat.png" alt="Generic placeholder image">

        <hr>

        {{ post.body }}

        <hr>

        <!-- Comments Form -->
        <div class="my-4 card" v-if="isLogged">
          <h5 class="card-header">Leave a Comment:</h5>
          <div class="card-body">
            <form>
              <div class="form-group">
                <textarea id="textComment" v-model="body" class="form-control" rows="2"></textarea>
              </div>
              <button type="submit" :disabled="!this.commentValidation"  @click.prevent="createComment"  class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>

        <!-- Single Comment -->
      <div class="mb-4 media" v-for="comment in comments" :key="comment.id">
                   <img class="m-10"  src="http://placehold.it/50x50" alt="Generic placeholder image">
          <div class="media-body">
            <h5 class="mt-0">
            {{ comment.user.name }}
            </h5>
            <strong>{{comment.body}}</strong>



        <!-- Comment with nested comments -->

            <div class="mt-4 media" v-for="replay in comment.replays" :key="replay.id">
              <img class="mr-3 d-flex rounded-circle" id="personal_image" src="http://placehold.it/50x50" alt="">
              <div class="media-body">
                <h5 class="mt-0">{{ replay.user.name }}</h5>
                {{ replay.body }}
              </div>
            </div>



          </div>
        </div>

      </div>

      <!-- Sidebar Widgets Column -->
      <!-- Sidebar Widgets Column -->
       <div class="col-md-4">

        <!-- Search Widget -->
        <div class="my-4 card">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
              </span>
            </div>
          </div>
        </div>

        <!-- Categories Widget -->

        <categories></categories>
      </div>

    </div>
    <!-- /.row -->

  </div>
</template>

<script>
import axios from "axios"
import Categories from './Categories.vue';

    export default {
  components: { Categories },

        mounted() {
            console.log('in details');
            this.getPost();
        },

    created() {
          this.updateToken();
        },
        data(){
          return{
                post:'',
                categories:[],
                body:"",
                post_id:null,
                comments:[],
                }
        },

        methods: {
            getPost(){
               axios.get('api/posts/'+this.$route.params.slug).
               then(res=>{
                   this.post=res.data.post;
                   this.categories=res.data.categories;
                    this.post_id= this.post.id;
                    this.comments = this.post.comments;
                    this.initializeListener();
                    })
                .then(err=>{
                console.log(err);
                });
           },
            createComment(){
                let{post_id,body}= this;
                axios.post('api/comment',{body,post_id})
                .then(res=>{
                    // console.log(res.data.comment);
        $('.textComment').val('')
                  this.comments.unshift(res.data);

                }).catch(err=>{

                });
        },
        updateToken(){
          let token = JSON.parse(localStorage.getItem('userToken'));
        //   لمنادات الميتوشن وعملها commit
          this.$store.commit('setUserToken',token);
        },
         initializeListener(){
       Echo.join(`private-newComment.${this.post_id}`)
      .listen('NewComment', (e) => {
          console.log(e);
          this.comments.unshift(e.comment);
                // console.log(e);
                console.log("new event recev");
            });
        },
        },
        computed:{
            isLogged(){
                return this.$store.getters.isLogged;
            },
                commentValidation(){
            return this.body.length >= 3
        }
        }

    }

</script>
<style scoped>
#personal_image{height:50px;width:50px;border-radius:50px}
</style>
