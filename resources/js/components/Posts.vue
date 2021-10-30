<template>
  <div class="container intro-container">

    <div class="row">
    <div class="col-md-8" v-if="isSearching">
     <h1 class="my-4">Page Heading
          <small>Secondary Text</small>
        </h1>

        <!-- Blog Post -->
                   <div class="media simple-post" v-for="post in posts.data" :key="post.id">
          <img class="mr-3" v-if="post.poster" :src="fdfd" alt="Generic placeholder image">
          <img class="mr-3" v-else src="img/posts/defulat.png" alt="Generic placeholder image">


          <div class="media-body">
     <h4 class="mt-0">
                <router-link :to="'/post/'+post.slug">{{post.title}}</router-link>
            </h4>
                    <p style=" white-space: wrap;
  overflow: hidden;
  text-overflow: ellipsis;">

                {{ post.body }}
              </p>
            <ul class="list-inline list-unstyled d-flex post-info">
                  <li><span><i class="fa fa-user"></i> <strong class="text-primary"></strong> </span></li>
                  <li>|</li>
                  <li><span><i class="fa fa-calendar"></i>{{ post.user.name  }}  </span></li>
                  <li>|</li>
                  <span><i class="fa fa-comment">{{ post.comments_count }}</i></span>

            </ul>
          </div>
        </div>



        <!-- Pagination -->
        <pagination :data="posts" @pagination-change-page="getPosts"></pagination>
    </div>
      <!-- Blog Entries Column -->
      <div class="col-md-8" v-else>

        <h1 class="my-4">Page Heading
          <small>Secondary Text</small>
        </h1>

        <!-- Blog Post -->
                   <div class="media simple-post" v-for="post in posts.data" :key="post.id">
          <img class="mr-3" v-if="post.poster" :src="'img/posts/'+post.poster" alt="Generic placeholder image">
          <img class="mr-3" v-else src="img/posts/defulat.png" alt="Generic placeholder image">


          <div class="media-body">
     <h4 class="mt-0">
                <router-link :to="'/post/'+post.slug">{{post.title}}</router-link>
            </h4>
              <p style="overflow: hidden;">

                {{ post.body }}
              </p>

            <ul class="list-inline list-unstyled d-flex post-info">
                  <li><span><i class="fa fa-user"></i> <strong class="text-primary"></strong> </span></li>
                  <li>|</li>
                  <li><span><i class="fa fa-calendar"></i>{{ post.user.name  }}  </span></li>
                  <li>|</li>
                  <span><i class="fa fa-comment">{{ post.comments_count }}</i></span>

            </ul>
          </div>
        </div>



        <!-- Pagination -->
               <pagination :data="posts" @pagination-change-page="getPosts"></pagination>


      </div>

       <div class="col-md-4">

        <!-- Search Widget -->
        <div class="my-4 card">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for..." v-model="searchPosts">
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
import axios from "axios";
import Categories from './Categories.vue';

    export default {
  components: { Categories },
        data(){
            return{
                posts:{},
                categories:[],
                isSearching:false,
                searchPosts:'',
            }
        },
        mounted() {
            console.log("i'm a home component")
            this.getPosts();
        },watch:{
            searchPosts:function(q){
                if (q.length > 0) {
                    this.isSearching = true;
               axios.get('api/search/posts/'+q).then(res=>{
                    this.posts = res.data.posts;
                    console.log(res.data.posts);
                    if(res.data.length > 0){
                this.isSearching = false;
                    let oldPosts =JSON.parse(localStorage.getItem('posts'));
                    this.posts = oldPosts;
                    }
               }).then(err=>{
                   console.log(err);
               });
                }
            }
        },
        methods: {
            getPosts(page){
               axios.get('/api/posts?page=' + page)
                .then(res=>{
                    this.posts =res.data.posts;
                    console.log(res.data);
                    this.categories= res.data.categories;
                    localStorage.setItem('posts',JSON.stringify(this.posts));
                    }
                    ).
                then(err=>console.log(err))
            }
        },

    }
</script>
