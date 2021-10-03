<template>
  <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="login-form">
          <form action="/examples/actions/confirmation.php" method="post">
              <h2 class="text-center">Log in</h2>
              <div class="form-group">
                  <input type="text" class="form-control" v-model="email" placeholder="email" required="required">
              </div>
                        <div class="text-danger" v-show="emailError">
              ... email is not valid
              </div>
              <div class="form-group">
                  <input type="password" class="form-control" v-model="password" placeholder="Password" required="required">
              </div>
                  <div class="text-danger" v-show="paswwordError">
              ... password invalid
              </div>
              <div class="form-group">
                  <button type="submit"
                  @click.prevent="Login"
                  :disabled="!isValidForm"
                  class="btn btn-primary btn-block">Log in</button>
              </div>
              <div class="clearfix">
                  <a href="#" class="pull-right">Forgot Password?</a>
              </div>
          </form>
          <p class="text-center"><a class="switch-toregister-modal" href="#">Create an Account</a></p>
        </div>
      </div>
    </div>
  </div>
 </div>
</template>
<script>
export default({
    mounted(){

    },
    data() {
        return {
            email:'',
            password:'',
      }
    },
    computed:{
        paswwordError(){
             return this.password.length > 0 && this.password.length < 7

        },
        emailError(){
           return !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) && this.email.length > 0
        },
        isValidForm(){
             return this.password.length > 5 && (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email))
         }
        },methods: {

          Login(){
            let{email,password} = this;
            this.$store.dispatch('loginUser',{email,password});
          }
        },

})
</script>
