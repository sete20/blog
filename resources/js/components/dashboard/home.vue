<template>
  <div id="cont">
    <div class="">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
						<h2>Manage <b>Posts</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="#addPostModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Post</span></a>

						<a href="#deletePostModal" v-if="selectedPosts.length"
						class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
						<a href="#deletePostModalnopost"  v-if="!selectedPosts.length"
						class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
					</div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
						<th>
							<span class="custom-checkbox">
								<input type="checkbox"
                                 @click="selectAll"
								 id="selectAll">
								<label for="selectAll"></label>
							</span>
						</th>
                        <th>Title</th>
                        <th>Body</th>
						<th>Category</th>
                        <th>Image</th>
                        <th>User</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody v-if="posts.data">
                    <tr v-for="(post,index) in posts.data" :key="index">
						<td>
											<span class="custom-checkbox">
								<input type="checkbox" :id="'checkbox1'+index" @click.stop="selectPost(post,$event)"
								name="options[]" value="1">
								<label :for="'checkbox1'+index"></label>
							</span>
						</td>
                        <td>{{ post.title }}</td>
                        <td>{{ post.body.substr(0,150) }}</td>
						<td>
                            <span class="p-1 mb-1 badge badge-info" v-for="category in post.categories" :key="category.id">
                            <span>{{ category.name }}</span>
                            </span>
                        </td>
                        <td>
                            <img  v-if="post.poster" :src="'img/posts/'+post.poster" style="width:100px;height:60px;border:1px solid #e7e7e7" alt="">
                            <img class="mr-3" v-else src="img/posts/defulat.png" alt="Generic placeholder image">

                        </td>
                        <td>{{post.user.first_name +' '+ post.user.last_name}}</td>
                   <td>
                <a href="#editPostModal" class="edit" @click="editPost(post,$event)"
							 data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                            <a href="#deletePostModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                            <router-link  :to="'/post/'+post.slug" class="" target="_blank"><i class="material-icons" data-toggle="tooltip" title="Delete">&#128065;</i></router-link>
                        </td>
                    </tr>


                </tbody>
            </table>
			<div class="clearfix">
                         <div class="hint-text">Showing <b>10</b> out of <b>{{posts.total}}</b> entries</div>
                <pagination :data="posts" @pagination-change-page="getPosts"></pagination>
            </div>
        </div>
    </div>
	<!-- Edit Modal HTML -->
	<div id="addPostModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form enctype="multipart/form-data">
					<div class="modal-header">
						<h4 class="modal-title">Add Post</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">

                    				<label>slug</label>
							<input type="text" class="form-control" required v-model="slug">
						</div>
                                     <div class="text-danger" v-show="slugError">
              ... slug is required and must be more than 3 chars
              </div>
						<div class="form-group">

							<label>title</label>
							<input type="text" class="form-control" required v-model="title">
						</div>
                                     <div class="text-danger" v-show="titleError">
              ... title is required and must be more than 3 chars
              </div>
						<div class="form-group">
							<label>body</label>
							<textarea name="body"  cols="30" class="form-control" rows="10" v-model="body"></textarea>
						</div>
                                     <div class="text-danger" v-show="bodyError">
              ... body is required and must be more than 3 chars
              </div>
						<div class="form-group">
							<label>category</label>
							<select name="" class="form-control" ref="categories" multiple="multiple" v-model="categoriesPost" @change="pushCategories">
                                <option value="0" disabled selected>choose category</option>

                                <option v-for="category in categories" :key="category.id"  :value="category.id">
                                        {{ category.name }}
								</option>
                            </select>
						</div>
                                     <div class="text-danger" v-show="categoriesError">
              ... categories is required
              </div>
						<div class="form-group">
							<label>image</label>
							<input type="file" name="images[]" accept="image/*" class="form-control imageData" multiple required  @change="onImageChanged" >
						</div>
                                     <div class="text-danger" v-show="imageError">
              ... image is required or  invalid
              </div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-success" value="Add"
                        :disabled="!isValidForm"
                         @click.prevent="addPost">
					</div>
				</form>
			</div>
		</div>
	</div>
   <editPost></editPost>
	<!-- Delete Modal HTML -->
	<div id="deletePostModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Delete Post</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete these Records?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
						<p class="text-warning"><small>Selected Posts : <strong>{{selectedPosts.length}}</strong></small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" @click.prevent="deletePosts"
						value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Delete Modal HTML -->
	<div id="deletePostModalnopost" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Delete Post</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>No post selected !</p>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
</template>
<script>
import editPost from './editPost.vue'
export default{
    mounted() {
        this.getPosts();
    },
    	    components:{
        editPost
    },
    data() {
        return {
            slug:'',
            images:[],
            categories:'',
            title:'',
            body:'',
            posts:{},
            categoriesPost:'',
            selectedPosts:[],
        }
    },
    computed:{
        imageError(){
      return  this.images.length < 1;
        },
        categoriesError(){
      return  this.categoriesPost.length < 1;
        },
        titleError(){
       return     this.title.length < 3;
        },
        bodyError(){
      return  this.body.length < 3;
        },
            slugError(){
        return  this.slug.length < 3;
        },
        isValidForm(){
        return  this.body.length >= 3&& this.title.length >=3&&this.slug.length >=3 ;
        },
    },
    methods:
     {
        pushCategories(event){
            // console.log(this.$refs.categories.val);
            //     // this.categoriesPost.push(event.target.options.selectedIndex);
                    console.log(this.categoriesPost);
        },
        getPosts(page){
                       axios.get('api/dashboard/posts/?page='+page).then(res=>{
               this.posts = res.data.posts;
               this.categories = res.data.categories;
               console.log(this.categories);
               console.log(this.posts);
        }).then(err=>{
                   console.log(err);
        });
        },
        onImageChanged(event){
            this.images=[];
               console.log(this.images);
                    for (var i = 0; i < event.target.files.length; i++) {
                        // this.images[i]  = event.target.files[i];
                    // get item

                //    this.images[i]=event.target.files[i];
                   this.images =event.target.files[0];
                }
                             console.log(this.images);
		// },
        // this.images = [];
        //  for (let file of event.target.files) {
        //             try {
        //                 let reader = new FileReader();
        //                 reader.readAsDataURL(file); // Not sure if this will work in this context.

        //                 this.images.push(Object.entries(event.target.files[0]));
        //             } catch {}
        //         }
        //         console.log(this.images.__ob__.value);
            },
        addPost(){
            // document.querySelector('.imageData').val();
         let config ={
            headers :{"content-type" : 'multipart/form-data'}
        }
        let formdata = new FormData();
        formdata.append('title',this.title)
        formdata.append('body',this.body)
        formdata.append('slug',this.slug)
        formdata.append('images',this.images)
        formdata.append('categories',this.categoriesPost);
        axios.post('api/dashboard/posts',formdata,config).then(res=>{
            console.log(res);
            this.title=null;
            this.body=null;
            this.slug=null;
            this.images=null;
            this.categoriesPost=null;
            $('#addPostModal').modal('hide');
				$('.modal-backdrop').css('display','none');
        }).then(err=>{
            console.log(err);
        });

        },
        editPost(post){
            this.$store.commit('EditPost',post);
        },
        		selectPost(post,event){
			let index = this.selectedPosts.indexOf(post.id);
			if(index > -1){
				this.selectedPosts.splice(index,1)
				event.target.checked = false //uncheck
			}else{
				 this.selectedPosts.push(post.id);
				 event.target.checked = true;
			}
		},
        selectAll(event){
              if( event.target.checked ){
				  $('input[type="checkbox"]').prop('checked',true)
				  this.posts.data.forEach(p =>{
					  this.selectedPosts.push(p.id)
				  })
			  }else{
				   $('input[type="checkbox"]').prop('checked',false)
				   this.selectedPosts = []
			  }
		},
        	deletePosts(){
			 axios.post('/api/dashboard/posts/delete/',{posts_ids: this.selectedPosts})
			 .then(res => {
				 console.log(res.data)
                 this.selectedPosts=[];
				 $('#deletePostModal').modal('hide');
				$('.modal-backdrop').css('display','none');
				this.getPosts();
				$('input[type="checkbox"]').prop('checked',false)

			 })
			 .catch(err =>{
				 console.log(err)
			 });
		}
     },

}
    $(document).ready(function() {
            // Activate tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Select/Deselect checkboxes
            var checkbox = $('table tbody input[type="checkbox"]');
            $("#selectAll").click(function() {
                if (this.checked) {
                    checkbox.each(function() {
                        this.checked = true;
                    });
                } else {
                    checkbox.each(function() {
                        this.checked = false;
                    });
                }
            });
            checkbox.click(function() {
                if (!this.checked) {
                    $("#selectAll").prop("checked", false);
                }
            });
        });
</script>
   <style>
        #cont {
            color: #566787;
            background: #f5f5f5;
            font-family: 'Varela Round', sans-serif;
            font-size: 13px;
        }

        .table-wrapper {
            background: #fff;
            padding: 20px 25px;
            margin: 30px 0;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            padding-bottom: 15px;
            background: #435d7d;
            color: #fff;
            padding: 16px 30px;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }

        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        .table-title .btn-group {
            float: right;
        }

        .table-title .btn {
            color: #fff;
            float: right;
            font-size: 13px;
            border: none;
            min-width: 50px;
            border-radius: 2px;
            border: none;
            outline: none !important;
            margin-left: 10px;
        }

        .table-title .btn i {
            float: left;
            font-size: 21px;
            margin-right: 5px;
        }

        .table-title .btn span {
            float: left;
            margin-top: 2px;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
            padding: 12px 15px;
            vertical-align: middle;
        }

        table.table tr th:first-child {
            width: 60px;
        }

        table.table tr th:last-child {
            width: 100px;
        }

        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }

        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }

        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table td:last-child i {
            opacity: 0.9;
            font-size: 22px;
            margin: 0 5px;
        }

        table.table td a {
            font-weight: bold;
            color: #566787;
            display: inline-block;
            text-decoration: none;
            outline: none !important;
        }

        table.table td a:hover {
            color: #2196F3;
        }

        table.table td a.edit {
            color: #FFC107;
        }

        table.table td a.delete {
            color: #F44336;
        }

        table.table td i {
            font-size: 19px;
        }

        table.table .avatar {
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
        }

        .pagination {
            float: right;
            margin: 0 0 5px;
        }

        .pagination li a {
            border: none;
            font-size: 13px;
            min-width: 30px;
            min-height: 30px;
            color: #999;
            margin: 0 2px;
            line-height: 30px;
            border-radius: 2px !important;
            text-align: center;
            padding: 0 6px;
        }

        .pagination li a:hover {
            color: #666;
        }

        .pagination li.active a,
        .pagination li.active a.page-link {
            background: #03A9F4;
        }

        .pagination li.active a:hover {
            background: #0397d6;
        }

        .pagination li.disabled i {
            color: #ccc;
        }

        .pagination li i {
            font-size: 16px;
            padding-top: 6px
        }

        .hint-text {
            float: left;
            margin-top: 10px;
            font-size: 13px;
        }
        /* Custom
    checkbox */

        .custom-checkbox {
            position: relative;
        }

        .custom-checkbox input[type="checkbox"] {
            opacity: 0;
            position: absolute;
            margin: 5px 0 0 3px;
            z-index: 9;
        }

        .custom-checkbox label:before {
            width: 18px;
            height: 18px;
        }

        .custom-checkbox label:before {
            content: '';
            margin-right: 10px;
            display: inline-block;
            vertical-align: text-top;
            background: white;
            border: 1px solid #bbb;
            border-radius: 2px;
            box-sizing: border-box;
            z-index: 2;
        }

        .custom-checkbox input[type="checkbox"]:checked+label:after {
            content: '';
            position: absolute;
            left: 6px;
            top: 3px;
            width: 6px;
            height: 11px;
            border: solid #000;
            border-width: 0 3px 3px 0;
            transform: inherit;
            z-index: 3;
            transform: rotateZ(45deg);
        }

        .custom-checkbox input[type="checkbox"]:checked+label:before {
            border-color: #03A9F4;
            background: #03A9F4;
        }

        .custom-checkbox input[type="checkbox"]:checked+label:after {
            border-color: #fff;
        }

        .custom-checkbox input[type="checkbox"]:disabled+label:before {
            color: #b8b8b8;
            cursor: auto;
            box-shadow: none;
            background: #ddd;
        }
        /* Modal styles */

        .modal .modal-dialog {
            max-width: 400px;
        }

        .modal .modal-header,
        .modal .modal-body,
        .modal .modal-footer {
            padding: 20px 30px;
        }

        .modal .modal-content {
            border-radius: 3px;
        }

        .modal .modal-footer {
            background: #ecf0f1;
            border-radius: 0 0 3px 3px;
        }

        .modal .modal-title {
            display: inline-block;
        }

        .modal .form-control {
            border-radius: 2px;
            box-shadow: none;
            border-color: #dddddd;
        }

        .modal textarea.form-control {
            resize: vertical;
        }

        .modal .btn {
            border-radius: 2px;
            min-width: 100px;
        }

        .modal form label {
            font-weight: normal;
        }
    </style>
