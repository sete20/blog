<template>
  <!-- Edit Modal HTML -->
	<div id="editPostModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form enctype="multipart/form-data" novalidate >
					<div class="modal-header">
						<h4 class="modal-title">Edit Post</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>

					<div class="modal-body">
                    			<div class="form-group">
							<label>slug</label>
							<input type="text" class="form-control" required v-model="PostToEdit.slug">
						</div>

						<div class="form-group">
							<label>title</label>
							<input type="text" class="form-control" required v-model="PostToEdit.title">
						</div>


						<div class="form-group">
							<label>body</label>
							<textarea  name=""  cols="30" class="form-control" v-model="PostToEdit.body"
                            rows="5"></textarea>
						</div>
						<div class="form-group">
							<label>category</label>
							<select name="" multiple="multiple" class="form-control" v-if="PostToEdit.categories" v-model="PostToEdit.categories">
                                <option value="0" disabled selected>choose category</option>

                                <option :value="category.id" v-for="category in categories" :key="category.id">
								 {{ category.name }}

								</option>
                            </select>
						</div>
						<div class="form-group">
							<label>image</label>
                            <img v-if="PostToEdit.poster" :src="'img/posts/'+PostToEdit.poster" style="height:60px;width:60px;border:1px solid #999" alt="">
                            <img v-else src="img/posts/defulat.png" style="height:60px;width:60px;border:1px solid #999" alt="">


                            <input type="file" class="form-control" required @change="onImageChanged" >
						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn " @click.prevent="updatePost"
                        value="Save">
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
export default {
    mounted() {
        this.postToEdit(),
        console.log(this.PostToEdit.id);
    },
data(){
		return {
			categories : [],
            post_id:this.postToEdit.id,
            poster:null,
		}
	},
	created(){
		this.getCategories();
	},
	methods:{
		getCategories(){
               axios.get('api/dashboard/posts')
                .then(res => {
                    console.log(res.data)
                    this.categories = res.data.categories;
                })
                .then(err => console.log(err))
		},
		onImageChanged(event){
			//console.log(event.target.files[0])
			this.poster = event.target.files[0];
            console.log(this.poster);
		},
		updatePost(){
			let config ={
				headers :{"content-type" : 'multipart/form-data'}
			}
            console.log(this.post_id)
			let formdata = new FormData();
            console.log(this.PostToEdit.id);
            // const url = ;
            formdata.append('slug',this.PostToEdit.slug)

            formdata.append('title',this.PostToEdit.title)
            formdata.append('body',this.PostToEdit.body)
            formdata.append('image',this.poster)
			formdata.append('categories',this.PostToEdit.categories)
	        axios.post('/api/dashboard/posts/update/'+this.PostToEdit.id,
            formdata

            ,config)

			.then(res => {
				console.log(res)
				// this.title = '';
				// this.body = '';
				// this.category = [];
                // this.image = '';
                // this.PostToEdit.image = res.data.image
				// $('#editPostModal').modal('hide');
				// $('.modal-backdrop').css('display','none')
			})

		}

    },
    computed:{
        PostToEdit(){

            return this.$store.getters.postToEdit;
        }
    }

}
</script>

<style>

</style>
