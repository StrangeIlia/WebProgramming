<template>
    <div class="my-container">
        <div class="col-md-4">
            <form @submit="login">
                <div class="form-group">
                    <label for="username">Логин</label>
                    <input id="username" type="text" class="form-control" placeholder="Введите ваш логин" v-model="username">
                    <div class="error" v-if="invalidUserName">Логин не может быть пустым!!!</div>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" class="form-control" placeholder="Введите пароль" v-model="password">
                    <div class="error" v-if="invalidPassword">Пароль не может быть пустым!!!</div>
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
    const { required, maxLength } = require('vuelidate/lib/validators');

    export default {
        name: 'Authorization',

        data(){
            return {
                username: "",
                password: "",
                rememberMe: false,
                errors: {
                    method: ""
                }
            }
        },

        computed: {
            invalidUserName : function(){
                return this.$v.username.$anyError && !this.$v.username.required;
            },

            invalidPassword : function(){
                return this.$v.password.$anyError && !this.$v.password.required;
            },
        },

        validations: {
            username: {
                required,
                maxLength: maxLength(30)
            },
            password: {
                required,
                maxLength: maxLength(30)
            }
        },

        methods: {
            login : function (e) {
                this.$v.$touch();
                if(!this.$v.$invalid) {
                    HTTP.post('/site/login', {
                        username: this.username,
                        password: this.password,
                        rememberMe: this.rememberMe
                    })
                        .then(response => {
                            if(response.data.status === 'success'){
                                localStorage.token = response.data.token;
                                MainVue.username = this.username;
                                HTTP.defaults.headers['Authorization'] = 'Bearer ' + localStorage.token;
                                this.$router.push('/');
                            } else {
                                MainVue.username = '';
                                delete localStorage.token;
                                this.errors.method = response.data;
                            }
                        }).catch(() => this.errors.method = 'Нет отклика от сервера');
                }
                e.preventDefault();
            },

            clearError : function (e) {
                this.errors.username = '';
                this.errors.method = '';
                this.errors.password = '';
                e.preventDefault();
            }
        }
    }
</script>