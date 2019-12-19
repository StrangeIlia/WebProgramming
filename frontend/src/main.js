import Vue from 'vue'
import App from './App.vue'
import router from './router'
import { HTTP } from "./components/http";

Vue.config.productionTip = false

let MainVue = new Vue({
  router,
  render: h => h(App),

  created() {
    let sendData = new FormData();
    sendData.authKey = localStorage.authKey;
    sendData.accessToken = localStorage.accessToken;
    HTTP.post('/users/login', sendData).then(response => {
      if(response.data.status ==='success'){
        this.$data.login = response.login;
        localStorage.authKey = response.authKey;
        localStorage.accessToken = response.accessToken;
      }
    });
  },

  data(){
    return {
      login: ''
    }
  },

  computed: {
    successAuth : function () {
      return this.$data.login !== '';
    }
  }
});

MainVue.$mount('#app')
