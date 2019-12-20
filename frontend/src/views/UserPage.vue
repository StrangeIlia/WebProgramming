<template>
    <div class="album py-5 my-container">
        <h1>Это страница пользователя {{this.$route.params.selected_user}}</h1>
        <router-link to="/favorite_videos">Понравившееся</router-link> |
        <router-link to="/loaded_videos">Загруженные</router-link> |
        <router-link to="/user_playlists">Плейлисты</router-link> |
        <router-link v-if="this.successAuth" to="/add_video">Добавить новое видео</router-link>
    </div>
</template>

<script>
    export default {
        name: "UserPage",
    }
</script>