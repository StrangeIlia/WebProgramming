import Vue from 'vue'
import App from './App.vue'
import router from './router'
import { HTTP } from "./components/http";

Vue.config.productionTip = false

let MainVue = new Vue({
  router,
  render: h => h(App),

  created() {
    let data = new FormData();
    HTTP.post('/users/login', data).then(response => {
      if(response.data.status ==='success'){
        this.successAuth = true;
      }
      else {
        this.successAuth = false;
      }
    });
  },

  data(){
    return {
      successAuth: false
    }
  },
});

MainVue.$mount('#app')
