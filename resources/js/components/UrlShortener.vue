<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="shortener">
                    <div class="section-heading text-center">
                        <h1>URL Shortener</h1>
                        <br>
                        <div class="py-2" align="center">
                            <div class="pageIntroDescription border border-info p-3 mb-0">
                                Paste the URL below to be shortened
                            </div>
                        </div>
                        <br>
                        <div v-if="user">
                            <form action="" class="form">
                                <div class="input-group">
                                    <input type="text" id="p1" v-model="url" class="form-control addUrlInput">
                                </div>
                                <br>
                                <div>
                                    <button class="btn btn-dark" 
                                    v-on:click.prevent='shortenUrl'>
                                        Shorten
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div v-else>
                            <h5>You have to be logged in</h5>
                            <hr>
                            To shorten your urls
                            <a href="/register">
                                <small>
                                    Register Here
                                </small>
                            </a>
                            or
                            <a href="/login">
                                <small>
                                    Login Here
                                </small>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
        },
        props:['user'],
        data(){
            return {
                url:null,
            }
        },
        methods:{
            shortenUrl(){
                alert('works');
            }
        }
    }
</script>