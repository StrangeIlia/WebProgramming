import Vue from 'vue'
import App from './App.vue'
import router from './router'
import { HTTP } from "./components/http";

Vue.config.productionTip = false;

export let MainVue = new Vue({
  name: 'Main',
  router,
  data: {
    userInfo : {
      login : "",
      authKey : "",
      accessToken : ""
    }
  },

  render: h => h(App),

  created() {
    let sendData = new FormData();
    sendData.authKey = localStorage.authKey;
    sendData.accessToken = localStorage.accessToken;
    HTTP.post('/users/login', sendData).then(response => {
      if(response.data.status === 'success'){
        this.userInfo.login = response.data.login;
        this.userInfo.authKey = localStorage.authKey = response.data.authKey;
        this.userInfo.accessToken = localStorage.accessToken = response.data.accessToken;
      }
    });
  }
});

MainVue.$mount('#app');
