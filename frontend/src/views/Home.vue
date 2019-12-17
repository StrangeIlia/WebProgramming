<template>
  <main>
    <div class="album py-5">
      <div class="container">
        <div class="row">
          <div v-for="video in videos" :key="video.id" class="video-item">
            <div class="col-md-3">
                <div class="card mb-4 shadow-sm">
                  <img src="src/img.jpg" alt = "Невозможно">
                  <div class = "card-body">
                    <div class="card-text">
                      {{video.name}}
                    </div>
                  </div>
                </div>
            </div>
          </div>

          <div class="col-md-3">
              <div class="card mb-4 shadow-sm">

                <img src="src/img.jpg" alt = "Невозможно">
                <div class = "card-body">
                  <div class="card-text">
                    Очень интересный фильм (нет)
                  </div>
                </div>
              </div>
          </div>

        </div>
      </div>
    </div>
  </main>
</template>

<script>
  import { HTTP } from "../components/http";
  export default {
    name: 'Videos',
    data () {
      return{
        videos: []
      }
    },

    created() {
      HTTP.get('/videos').then(response => (this.videos = response.data))
    }
  }

</script>