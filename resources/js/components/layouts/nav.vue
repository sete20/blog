<template>
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">blog - vue</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="ml-auto navbar-nav">
          <li class="nav-item active">
            <router-link class="nav-link" to="/">Home
              <span class="sr-only">(current)</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="index.html">blog</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="contact.html">Contact</router-link>
          </li>
      <li class="nav-item">
            <router-link v-if="isLogged && isAdmin == 1" class="nav-link" to="dashbaord">dashboard</router-link>
          </li>
          <li v-if="!isLogged" class="nav-item register-btn reg-login-btn" data-toggle="modal" data-target="#register-modal">
            <router-link class="btn btn-info nav-link" to="" data-toggle="modal" data-target="#register-modal">Register</router-link>
          </li>
          <li v-if="!isLogged" class="nav-item reg-login-btn" data-toggle="modal" data-target="#login-modal">
            <router-link class="btn btn-primary text-weight nav-link" to="#">login</router-link>
          </li>
            <li v-if="isLogged" class="nav-item reg-login-btn">
            <button class="btn btn-primary text-weight nav-link" @click.prevent="logout" to="#">logout</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

</template>
<script>
export default {
    mounted() {
        this.updateToken();
        },created() {
        this.$store.commit('setAdmin');

        },

    methods:{
        logout(){
            this.$store.commit('removeUserToken');
        },
        updateToken(){
            let token = JSON.parse(localStorage.getItem('userToken'));
            this.$store.commit('setUserToken',token);
        },

        },computed:{
            isLogged(){
                return this.$store.getters.isLogged;
            },
        isAdmin(){
                return this.$store.getters.isAdmin;
            },
        }
}
    </script>
