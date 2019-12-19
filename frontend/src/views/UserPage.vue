<template>
    <div class="album py-5 my-container">
        <h1>Это страница пользователя {{this.$route.params.selected_user}}</h1>
        <router-link to="/liked_videos">Понравившееся</router-link> |
        <router-link to="/li">Загруженные</router-link> |
        <router-link to="/user_playlists">Плейлисты</router-link>
    </div>
</template>

<script>
    export default {
        name: "UserPage",
    }
</script>