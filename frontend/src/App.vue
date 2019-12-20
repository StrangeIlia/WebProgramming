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
                <router-link :to="{name:'auth', params:{}}">
                  <button type="submit" class="btn btn-primary m-auto">Вход</button>
                </router-link>
                <router-link :to="{name:'reg', params:{}}">
                  <button type="submit" class="btn btn-primary m-auto">Регистрация</button>
                </router-link>
              </div>
            </div>
            <div v-if="this.successAuth">
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{this.username}}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">Добавить видео</a>
                  <a class="dropdown-item" href="#">Добавить плейлист</a>
                  <a @click="logout" class="dropdown-item" href="#">Выход</a>
                </div>
              </div>
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
  import {MainVue} from "./main";

  export default {
    name: 'App',

    data() {
      return {
        mainMenuOptions : [
        'Добавить видео',
         'Выход'
        ]
      }
    },

    computed:{
      isRegOrAuth : function () {
        let isReg = this.$route.name === 'reg';
        let isAuth = this.$route.name === 'auth';
        return isReg || isAuth || this.successAuth;
      },
      username : function(){
        return MainVue.username;
      },
      successAuth : function () {
        return this.username !== '';
      },
    },

    methods: {
      logout : function () {
        HTTP.post('/users/logout').then(response => {
          if(response.data.status === 'success'){
            MainVue.username = '';
            delete localStorage.token;
          }
        });
      }
    }


  }
</script>