import Vue from 'vue'
import App from './App.vue'
import router from './router'
import {HTTP} from "./components/http";

Vue.config.productionTip = false;

export let MainVue = new Vue({
  name: 'Main',
  router,
  data: {
    username : ''
  },

  render: h => h(App),

  created() {
    HTTP.post('/users/get_username').then(response => {
      if(response.data.username !== null)
          this.username = response.data.username;
    });
  }
});

MainVue.$mount('#app');
