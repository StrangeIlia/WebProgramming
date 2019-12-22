<template>
    <div>
        <h1 class="m-auto text-center">Это страница пользователя {{$root.username}}</h1>
        <div class="album py-5 my-container">
            <router-link to="/favorite_videos">Понравившееся</router-link> |
            <router-link to="/loaded_videos">Загруженные</router-link> |
            <router-link to="/user_playlists">Плейлисты</router-link> |
            <router-link v-if="this.$root.successAuth" to="/add_video">Добавить новое видео</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserPage"
    }
</script>