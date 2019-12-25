<template>
    <div class="ml-auto mr-auto justify-content-center" style="max-width: 80%;">
        <div class="my-container">
            <video controls>
                <source :src="video.path" type="video/mp4">
            </video>
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
        props: ['id'],
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
                }
            }
        },

        created() {
            HTTP.get('/videos/view?id=' + this.$props.id).then(response => (this.video = response.data))
        }
    }

</script>