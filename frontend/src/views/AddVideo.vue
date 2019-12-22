<template>
    <div class="my-container">
        <div class="col-md-4">
            <div v-if="this.result != ''">
                <h1>{{result}}</h1>
                <router-link :to="{name:'home', params:{}}">
                    <button class="btn btn-primary w-100">Вернуться на главную страницу</button>
                </router-link>
            </div>
            <div v-else>
                <form @submit="send" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <div>
                            <label for="video_name">Введите название видео</label>
                            <input id="video_name" type="text" class="form-control w-100" placeholder="Название" v-model="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label>Выберите загружаемый файл:</label>
                            <input  type="file" ref="video" @change="loadVideo">
                            <div class="error"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <lable>Выберите превью</lable>
                            <input type="file" ref="preview" @change="loadPreview">
                            <div class="error"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class = "btn-primary ">Загрузить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { HTTP } from "../components/http";
    const { required, minLength, maxLength } = require('vuelidate/lib/validators');

    export default {
        name: 'NewVideo',

        data(){
            return{
                name: "",
                video: null,
                preview: null,
                result: ""
            }
        },

        computed: {
            invalidVideoName : function(){
                return  this.$v.name.$anyError && !this.$v.name.required;
            }
        },

        validations: {
            name: {
                required,
                minLength: minLength(5),
                maxLength: maxLength(30)
            },
        },

        methods: {
            send : function (e) {
                let okey = true;

                if(!this.video){
                    this.error = 'Выберите загружаемое видео';
                    okey = false;
                }

                if(!this.preview){
                    this.error= 'Выберите превью';
                    okey = false;
                }

                if(okey){
                    let data = new FormData();
                    data.append('name', this.name);
                    data.append('video', this.video);
                    data.append('preview', this.preview);
                    HTTP.post('/videos/create', data, {
                        'Content-Type': 'multipart/form-data'
                        }
                    )
                        .then(response => {
                            if(response.data.status === 'success')
                                this.result = 'Видео успешно добавлено!!!';
                            else
                                this.result = 'Не удалось добавить видео!!!'
                        })

                    .catch(()=> this.result = 'Нет отклика от сервера');
                }

                e.preventDefault();
            },

            loadVideo : function(e){
                this.video= e.target.files[0];
            },

            loadPreview : function(e){
                this.preview = e.target.files[0];
            }
        }
    }
</script>