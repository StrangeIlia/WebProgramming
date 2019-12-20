<template>
  <div class="my-body">
    <div class = "my-content">
      <header class="bg-dark" >
        <div class = "navbar navbar-expand">
          <div class = "navbar-site-name my-header-site-name">Кто - то там интертеймент</div>
          <div><form id="search-form" class="style-score ytd"></form></div>

          <div v-if="!this.isRegOrAuth" class="navbar-nav ml-auto">
            <div class="content">
              <router-link :to="{name:'auth', params:{}}">
                <button type="submit" class="btn btn-primary m-auto">Вход</button>
              </router-link>
              <router-link :to="{name:'reg', params:{}}">
                <button type="submit" class="btn btn-primary m-auto">Регистрация</button>
              </router-link>
            </div>
          </div>

          <div v-if="this.successAuth" class="navbar-nav ml-auto">
            <div class="content">
             <router-link :to="{name:'/', params:{}}">
                <button type="submit" class="btn btn-primary m-auto">{{login}}</button>
              </router-link>
              <button @click="logout" type="submit" class="btn btn-primary m-auto">Выход</button>
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

    computed:{
      isRegOrAuth : function () {
        let isReg = this.$route.name === 'reg';
        let isAuth = this.$route.name === 'auth';
        return isReg || isAuth || this.successAuth;
      },
      login : function(){
        return MainVue.userInfo.login;
      },
      successAuth : function () {
        return this.login !== '';
      },
    },

    methods: {
      logout : function () {
        let sendData = new FormData();
        sendData.authKey = this.$data.authKey;
        sendData.accessToken = this.$data.accessToken;
        HTTP.post('/users/logout', sendData).then(() => {
          MainVue.userInfo.login = '';
          MainVue.userInfo.authKey = '';
          MainVue.userInfo.accessToken = '';
          localStorage.authKey = '';
          localStorage.accessToken = '';
        });
      }
    }


  }
</script>