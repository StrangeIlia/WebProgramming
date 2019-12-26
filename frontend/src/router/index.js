import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import ContextPage from "../views/ContextPage";
import FavoriteVideos from "../views/FavoriteVideos";
import LoadedVideos from "../views/LoadedVideos";
import Playlists from "../views/Playlists";
import UserPage from "../views/UserPage";
import Test from "../views/Test";

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/test',
    name: 'test',
    component: Test
  },
  {
    path: '/video/:id',
    name: 'video',
    props: true,
    component: ContextPage,
  },
  {
    path: "/favorite_videos",
    name: 'favorite_videos',
    component: FavoriteVideos
  },
  {
    path: "/loaded_videos",
    name: 'loaded_videos',
    component: LoadedVideos
  },
  {
    path: "/user_playlists",
    name: 'user_playlists',
    component: Playlists
  },
  {
    path: '/user_page',
    name: 'user_page',
    component: UserPage
  }
];

const router = new VueRouter({
  routes
});

export default router
