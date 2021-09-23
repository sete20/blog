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
            <span class="float-right"><strong class="p-1 badge badge-info">22</strong> comments</span></p>

        <hr>

        <!-- Preview Image -->
        <div v-if="post.posters.length  !== 0">
               <img class="mr-3" v-for="poster in post.posters" :key="poster.id" :src="poster.path" alt="Generic placeholder image">
        </div>
          <img class="m-10" v-else src="img/posts/defulat.png" alt="Generic placeholder image">

          <img class="m-10" src="img/posts/defulat.png" alt="Generic placeholder image">

        <hr>

        {{ post.body }}

        <hr>

        <!-- Comments Form -->
        <div class="my-4 card">
          <h5 class="card-header">Leave a Comment:</h5>
          <div class="card-body">
            <form>
              <div class="form-group">
                <textarea class="form-control" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>

        <!-- Single Comment -->
      <div class="mb-4 media" v-for="(comment,i) in post.comments" :key="i">
          <img class="mr-3 d-flex rounded-circle" :src="'/img/'+comment.user.profile_img" style="height:50px;width:50px" alt="">
          <div class="media-body">
            <h5 class="mt-0"><strong>{{comment.user.name}}</strong></h5>
            {{comment.body}}


        <!-- Comment with nested comments -->

            <div class="mt-4 media">
              <img class="mr-3 d-flex rounded-circle" src="http://placehold.it/50x50" alt="">
              <div class="media-body">
                <h5 class="mt-0">Commenter Name</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
              </div>
            </div>

            <div class="mt-4 media">
              <img class="mr-3 d-flex rounded-circle" src="http://placehold.it/50x50" alt="">
              <div class="media-body">
                <h5 class="mt-0">Commenter Name</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
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
            console.log('in details')
            this.getPost();
            console.log(this.post);

        },
        data(){
          return{  post:'',categories:[]}
        },
        methods: {
           getPost(){
               axios.get('api/posts/'+this.$route.params.slug).then(res=>{
                   this.post=res.data.post;
                   this.categories=res.data.categories;
                   console.log(this.post);

                }).then(err=>{
                   console.log(err);
               });
           }
        },
    }
</script>
