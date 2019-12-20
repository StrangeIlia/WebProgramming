<template>
    <div class="my-container">
        <div class="col-md-4">
            <div>
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input id="login" type="text" class="form-control" placeholder="Введите ваш логин">
                </div>
                <div class="form-group">
                    <label for="email">Адрес электронной почты</label>
                    <input id="email" type="email" class="form-control" placeholder="Введите ваш адрес электронной почты">
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" class="form-control" placeholder="Введите пароль">
                </div>
                <div class="form-group">
                    <label for="check_password">Подтвердите пароль</label>
                    <input id="check_password" type="password" class="form-control w-100" placeholder="Подтвердите пароль">
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

</script>