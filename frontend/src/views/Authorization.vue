<template>
    <div class="my-container">
        <div class="col-md-4">
            <form @submit="method_login">
                <div>{{errors.method}}</div>
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input id="login" type="text" class="form-control" placeholder="Введите ваш логин" v-model="login">
                    <div class="error">{{errors.login}}</div>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" class="form-control" placeholder="Введите пароль" v-model="password">
                    <div class="error">{{errors.login}}</div>
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="checkbox" v-model="rememberMe">Запомнить меня</label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success w-100">Войти</button>
                </div>
                <div class="form-group">
                    <router-link :to="{name:'home', params:{}}">
                        <button type="submit" class="btn btn-primary w-100">Вернуться на главную страницу</button>
                    </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { HTTP } from "../components/http";
    import {MainVue} from "../main";

    export default {
        name: 'Authorization',

        data(){
            return {
                login: "",
                password: "",
                rememberMe: false,
                errors: {
                    login: "",
                    password: "",
                    method: ""
                }
            }
        },

        methods: {
            method_login : function (e) {
                let okay = true;
                if(!this.login || this.login.trim().length === 0){
                    this.errors.username = 'Введите логин';
                    okay = false;
                }
                if(!this.password || this.password.trim().length === 0){
                    this.errors.password = 'Введите пароль';
                    okay = false;
                }

                if(okay){
                    let data = new FormData();
                    data.append('login', this.login);
                    data.append('password', this.password);

                    HTTP.post('/users/login', data)
                        .then(response => {
                            if(response.data.status === 'success'){
                                if(this.rememberMe)
                                {
                                    localStorage.authKey = response.data.authKey;
                                    localStorage.accessToken = response.data.accessToken;
                                }
                                MainVue.userInfo.login = this.login;
                                MainVue.userInfo.authKey = response.data.authKey;
                                MainVue.userInfo.accessToken = response.data.accessToken;
                                this.$router.push('/');
                            } else {
                                this.errors.method = 'Неверный логин или пароль';
                            }
                        });
                }

                e.preventDefault();
            }
        }
    }
</script>