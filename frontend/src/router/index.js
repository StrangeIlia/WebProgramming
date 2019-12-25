import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import ContextPage from "../views/ContextPage";
import Auth from "../views/Authorization"
import Reg from  "../views/Registration"
import AddVideo from  "../views/AddVideo"
import FavoriteVideos from "../views/FavoriteVideos";
import LoadedVideos from "../views/LoadedVideos";
import Playlists from "../views/Playlists";
import UserPage from "../views/UserPage";

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/video/:id',
    name: 'video',
    props: true,
    component: ContextPage,
  },
  {
    path: '/auth',
    name: 'auth',
    component: Auth
  },
  {
    path: "/reg",
    name: 'reg',
    component: Reg
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
    path: "/add_video",
    name: 'add_video',
    component: AddVideo
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
