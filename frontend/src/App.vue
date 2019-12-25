<template>
  <div class="my-body">
    <div class = "my-content">
      <header class="bg-dark" >
        <div class = "navbar navbar-expand">
          <div class = "navbar-site-name my-header-site-name">Кто - то там интертеймент</div>
          <div><form id="search-form" class="style-score ytd"></form></div>
          <div class="navbar-nav ml-auto">
            <div v-if="!this.isRegOrAuth">
              <div class="content">
                <button @click="show_Authoriztion" class="btn btn-primary m-auto">Вход</button>
                <router-link :to="{name:'reg', params:{}}">
                  <button type="submit" class="btn btn-primary m-auto">Регистрация</button>
                </router-link>
              </div>
              <modal_authoriztion v-show="modal.authorization" @close="close_Authoriztion"/>
            </div>
            <div v-if="this.$root.successAuth">
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{$root.username}}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <button @click="show_AddNewVideo" class="dropdown-item">Добавить видео</button>
                  <a class="dropdown-item">Добавить плейлист</a>
                  <a @click="logout" class="dropdown-item" href="#">Выход</a>
                </div>
              </div>
              <modal_addNewVideo v-show="modal.addNewVideo" @close="close_AddNewVideo"/>
            </div>
          </div>
        </div>
      </header>
      <router-view/>
    </div>

    <footer class="text-mutex">
      <div class="container">
        <p class="float-right">Кто - то там интертеймент. Прав вообще нет</p>
      </div>
    </footer>





  </div>
</template>

<script>
  import {HTTP} from "./components/http";
  import modal_addNewVideo from './components/Modal_AddNewVideo.vue';
  import modal_authoriztion from './components/Modal_Authorization.vue';

  export default {
    name: 'App',

    components: {
      modal_addNewVideo,
      modal_authoriztion
    },

    data() {
      return {
        modal: {
          addNewVideo: false,
          authorization: false
        },
      }
    },

    computed:{
      isRegOrAuth : function () {
        let isReg = this.$route.name === 'reg';
        let isAuth = this.$route.name === 'auth';
        return isReg || isAuth || this.$root.successAuth;
      }
    },

    methods: {
      show_AddNewVideo : function() {
        this.modal.addNewVideo = true;
      },

      close_AddNewVideo : function() {
        this.modal.addNewVideo = false;
      },

      show_Authoriztion : function() {
        this.modal.authorization = true;
      },

      close_Authoriztion : function() {
        this.modal.authorization = false;
      },

      logout : function () {
        HTTP.post('/site/logout').then(response => {
          if(response.data.status === 'success'){
            this.$root.username = '';
            delete localStorage.token;
            delete HTTP.defaults.headers['Authorization'];
          }
        });
      }
    }


  }
</script>