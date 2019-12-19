<template>
    <div class="ml-auto mr-auto justify-content-center" style="max-width: 80%;">
        <div class="mt-3" style="border: solid #FF0000 3px; min-height: 300px;">
            <p class="text-center" style="font-size: 60px;">{{video.path}}</p>
        </div>

        <div style="border-bottom: solid 1px black;">
            <div class="font-weight-bold display-4">{{video.name}}</div>
        </div>
        <div class="mw-100" style="border-bottom: solid 1px black;">
            <div class="row justify-content-between ml-auto mr-auto">
                <div>Добавил пользователь: <a href="#">{{video.author}}</a></div>
                <div>Количество просмотров: {{video.numberOfViews}}</div>
            </div>
            <div>Описание: {{video.description}}</div>
        </div>
    </div>
</template>

<script>
    import { HTTP } from "../components/http";
    export default {
        name: 'Video',
        data () {
            return{
                video: {
                    id: 0,
                    name: "",
                    path: "",
                    author: "",
                    description: "",
                    preview: "",
                    numberOfViews: 0,
                    message: ""
                }
            }
        },

        created() {
            var id = this.$route.params.id;
            this.video.message = id;
            HTTP.get('/videos/selected_video?id=' + id).then(response => (this.video = response.data))
        }
    }

</script>