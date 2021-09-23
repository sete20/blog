<template>
  <div class="container intro-container">

    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">

        <h1 class="my-4">Page Heading
          <small>Secondary Text</small>
        </h1>

        <!-- Blog Post -->
                   <div class="media simple-post" v-for="post in posts" :key="post.id">
          <img class="mr-3" v-if="post.poster" :src="fdfd" alt="Generic placeholder image">
          <img class="mr-3" v-else src="img/posts/defulat.png" alt="Generic placeholder image">


          <div class="media-body">
     <h4 class="mt-0">
                <router-link :to="'/post/'+post.slug">{{post.title}}</router-link>
            </h4>

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
        <nav aria-label="...">
          <ul class="float-right pagination">
            <li class="page-item disabled">
              <span class="page-link">Previous</span>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active">
              <span class="page-link">
                2
                <span class="sr-only">(current)</span>
              </span>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav>

      </div>

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

export default ({
    mounted() {
        console.log('category posts');
        this.getCategoryPosts();
    },
    data() {
        return {
            posts:[],
        }
    },
    methods: {
        getCategoryPosts(){
            axios.get('api/category/posts/'+this.$route.params.category).then(res=>{
                this.posts = res.data.posts;
                console.log(this.posts);

            })
        }
    },


})
</script>
