<template>
     <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Register</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="login-form" >
          <form action="/examples/actions/confirmation.php" method="post" nonvalidate>
              <h2 class="text-center">Create New Account</h2>
              <div class="form-group">
                  <input type="text" name="first_name" v-model="first_name" class="form-control" placeholder="firstname" >
              </div>
              <div class="text-danger" v-show="first_name_error">
              ... first name cannot be less than 4 character
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" v-model="last_name" name="last_name" placeholder="lastname" >
              </div>
              <div class="text-danger" v-show="last_name_error">
              ... last name cannot be less than 4 character

              </div>

              <div class="form-group">
                  <input type="email" class="form-control" v-model="email" name="email" placeholder="email">
              </div>

              <div class="text-danger" v-show="email_error">
              ... email is not valid
              </div>

              <div class="form-group">
                  <input type="password" class="form-control" v-model="password" name="password" placeholder="Password" >
              </div>
              <div class="text-danger" v-show="password_error">
              ... password invalid
              </div>

              <div class="form-group">
                  <button type="submit"     :disabled="!isValidForm"
                  @click.prevent="submitRegister" class="btn btn-primary btn-block" 
                  >Create Account</button>
              </div>
              <div class="clearfix">
                  <a href="#" class="pull-right">Forgot Password?</a>
              </div>
          </form>
          <p class="text-center">having account ?
             <strong class="switch-tologin-modal" ><a href="#">Login</a></strong>
          </p>
        </div>
      </div>
    </div>
  </div>
 </div>
</template>
<script>


export default ({
    mounted() {
        // this.submitRegister();
    },
    data(){
        return {
            first_name:'',
            last_name:'',
            email:'',
            password:'',
        }
    },
    computed:{
            first_name_error(){
            return this.first_name.length > 0 && this.first_name.length < 4
            },
            last_name_error(){
            return this.last_name.length > 0 && this.last_name.length < 4
            },
            email_error(){
           return !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) && this.email.length > 0

            },
            password_error(){
             return this.password.length > 0 && this.password.length < 7
            },
            isValidForm(){
                  return this.first_name.length > 4   &&this.last_name.length > 4 &&
             this.password.length > 5 && (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email))
            }

    },
    methods: {
        submitRegister(){
         let  {last_name,first_name,email,password} = this;
            this.$store.dispatch('registerUser',{first_name,last_name,email,password})
        
        }, 
    }, 
})
</script>
