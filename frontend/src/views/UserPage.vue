<template>
    <div>
        <h1 class="m-auto text-center">Это страница пользователя {{this.username}}</h1>
        <div class="album py-5 my-container">
            <router-link to="/favorite_videos">Понравившееся</router-link> |
            <router-link to="/loaded_videos">Загруженные</router-link> |
            <router-link to="/user_playlists">Плейлисты</router-link> |
            <router-link v-if="this.successAuth" to="/add_video">Добавить новое видео</router-link>



        </div>
    </div>
</template>

<script>
    import {MainVue} from "../main";

    export default {
        name: "UserPage",
        computed: {
            username : function(){
                return MainVue.username;
            },
            successAuth : function () {
                return this.username !== '';
            },
        }
    }
</script>