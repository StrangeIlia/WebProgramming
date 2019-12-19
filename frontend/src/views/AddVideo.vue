<template>
    <div class="my-container">
        <div class="col-md-4">
            <form @submit="send">
                <div class="form-group">
                    <label>
                        <label for="video_name">Введите название видео</label>
                        <input id="video_name" type="text" class="form-control w-100" placeholder="Название" v-model="video.name">
                        <div class="error">{{errors.name}}</div>
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <div>Выберите загружаемый файл: </div>
                        <input type="file" ref="video"  v-on:change="loadVideo()">
                        <div class="error">{{errors.path}}</div>
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <div>Выберите превью</div>
                        <input type="file" ref="preview" v-on:change="loadPreview()">
                        <div class="error">{{errors.preview}}</div>
                    </label>
                </div>
                <div class="form-group">
                    <button class = "btn-primary">Загрузить</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { HTTP } from "../components/http";

    export default {
        name: 'NewVideo',

        data(){
            return{
                video: {
                    name: "",
                    path: "",
                    preview: ""
                },
                errors: {
                    name: "",
                    path: "",
                    preview: ""
                }
            }
        },

        methods: {
            send : function (e) {
                let okey = true;

                if(!this.name || this.name.trim().length === 0){
                    this.errors.name = 'Введите название видео';
                    okey = false;
                }

                if(!this.path || this.path.trim().length === 0){
                    this.errors.path = 'Выберите загружаемое видео';
                    okey = false;
                }

                if(!this.preview || this.preview.trim().length === 0){
                    this.errors.preview = 'Выберите превью';
                    okey = false;
                }

                if(okey){
                    let data = new FormData();
                    data.append('name', this.name);
                    data.append('path', this.email);
                    data.append('preview', this.phone);
                    HTTP.post('/videos/add_video', data)
                        .then(response => (this.result = response.data.status));
                }

                e.preventDefault();
            },

            loadVideo : function(){
                this.video.path = this.$refs.video.files[0];
            },

            loadPreview : function(){
                this.video.preview = this.$refs.preview.files[0];
            }
        }
    }
</script>