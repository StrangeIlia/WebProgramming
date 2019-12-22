<template>
    <div class="my-container">
        <div class="col-md-4">
            <div>
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input id="login" type="text" class="form-control" placeholder="Введите ваш логин" v-model="username">
                    <div class="error" v-if="invalidUserName">Логин не может быть пустым!!!</div>
                </div>
                <div class="form-group">
                    <label for="email">Адрес электронной почты</label>
                    <input id="email" type="email" class="form-control" placeholder="Введите ваш адрес электронной почты" v-model="email">
                    <div class="error" v-if="invalidEmail">Email не может быть пустым!!!</div>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" class="form-control" placeholder="Введите пароль" v-model="password">
                    <div class="error" v-if="invalidPassword">Пароль не может быть пустым!!!</div>
                </div>
                <div class="form-group">
                    <label for="check_password">Подтвердите пароль</label>
                    <input id="check_password" type="password" class="form-control w-100" placeholder="Подтвердите пароль" v-model="repeatPassword">
                    <div class="error" v-if="invalidRepeatPassword">Пароль не может быть пустым!!!</div>
                </div>
                <div class="form-group">
                    <button class="btn btn-success w-100">Зарегистрироваться</button>
                </div>
                <div class="form-group">
                    <router-link :to="{name:'home', params:{}}">
                        <button type="submit" class="btn btn-primary w-100">Вернуться на главную страницу</button>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { HTTP } from "../components/http";
    import { MainVue } from "../main";
    const { required, maxLength, sameAs } = require('vuelidate/lib/validators');

    export default {
        name: 'Authorization',

        data(){
            return {
                username: "",
                email: "",
                password: "",
                repeatPassword: "",
                errors: {
                    username: "",
                    password: "",
                    method: ""
                }
            }
        },

        validations: {
            username: {
                required,
                maxLength: maxLength(30)
            },
            email: {
                required,
                maxLength: maxLength(30)
            },
            password: {
                required,
                maxLength: maxLength(30),
            },
            repeatPassword: {
                sameAsPassword: sameAs('password')
            }
        },

        computed: {
            invalidUserName : function(){
                return this.$v.username.$anyError && !this.$v.username.required;
            },

            invalidEmail : function(){
                return this.$v.email.$anyError && !this.$v.email.required;
            },

            invalidPassword : function(){
                return this.$v.password.$anyError && !this.$v.password.required;
            },

            invalidRepeatPassword : function () {
                return this.$v.repeatPassword.$anyError;
            }
        },

        methods: {
            login : function (e) {
                this.$v.$touch();
                if(this.$v.$invalid()) {
                      HTTP.post('/site/create', {
                          username: this.username,
                          password: this.password,
                          email: this.email
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