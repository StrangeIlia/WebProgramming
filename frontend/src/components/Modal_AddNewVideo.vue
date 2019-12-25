<template>
    <transition name="modal_addNewVideo">
        <form @submit="send" enctype="multipart/form-data" method="post">
            <div class="modal-mask" v-if="result === ''">
                <div class="modal-wrapper">
                    <div class="modal-container">
                        <div class="modal-body">
                            <slot name="body">
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
                            </slot>
                        </div>

                        <div class="modal-footer">
                            <slot name="footer">
                                <button type="submit" class="modal-default-button">
                                    Добавление видео
                                </button>
                                <button class="modal-default-button" @click="close">
                                    Отмена
                                </button>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-mask" v-else>
                <div class="modal-wrapper">
                    <div class="modal-container">
                        <div class="modal-body">
                            {{result}}
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                                <button class="modal-default-button" @click="close">
                                    Выход
                                </button>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </transition>
</template>

<script>
    import {HTTP} from "./http";
    const { required, minLength, maxLength } = require('vuelidate/lib/validators');

    export default {
        name: 'modal_addNewVideo',

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
            close : function() {
                this.$emit('close');
            },

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
        },
    };
</script>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
        horiz-align: center;
    }

    .modal-container {
        width: 30%;
        min-width: 500px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .my-modal-header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>
