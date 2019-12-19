import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import ContextPage from "../views/ContextPage";
import Auth from "../views/Authorization"
import Reg from  "../views/Registration"
import AddVideo from  "../views/AddVideo"
import LikedVideos from "../views/LikedVideos";
import LoadedVideos from "../views/LoadedVideos";
import Playlists from "../views/Playlists";

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/video',
    name: 'video',
    component: ContextPage
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
    path: "/add_video",
    name: 'add_video',
    component: AddVideo
  },
  {
    path: "/licked_videos",
    name: 'licked_videos',
    component: LikedVideos
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
  }
]

const router = new VueRouter({
  routes
})

export default router
