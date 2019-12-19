<template>
    <div class="my-container">
        <div class="col-md-4">
            <form @submit="send">
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input id="login" type="text" class="form-control" placeholder="Введите ваш логин" v-model="login">
                    <div class="error">{{errors.login}}</div>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" class="form-control" placeholder="Введите пароль" v-model="password">
                    <div class="error">{{errors.password}}</div>
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
                }
            }
        },

        methods: {
            send : function (e) {
                let okey = true;
                if(!this.login || this.login.trim().length === 0){
                    this.errors.login = 'Введите логин';
                    okey = false;
                }
                if(!this.password || this.password.trim().length === 0){
                    this.errors.password = 'Введите пароль';
                    okey = false;
                }

                if(okey){

                    let data = new FormData();
                    data.append('username', this.login);
                    data.append('password', this.password);
                    data.append('rememberMe', this.rememberMe);

                    HTTP.post('/users/login', data)
                        .then(response => {
                            if(response.data.status === 'success'){
                                this.successAuth = true;
                                this.login = 'okey';
                                this.$router.push('/');
                            } else {
                                this.errors.login = this.errors.password = response.data;
                            }
                        });
                }

                e.preventDefault();
            }
        }
    }
</script>