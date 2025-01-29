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
                                    <input type="text" id="p1" v-model="url" class="form-control addUrlInput"
                                    placeholder="Put your url here">
                                </div>
                                <br>
                                <div>
                                    <button class="btn btn-dark" 
                                    v-on:click.prevent='shortenUrl'>
                                        Shorten
                                    </button>
                                </div>
                            </form>
                            <br>
                            <p v-if="!urlNotFound" class="alert alert-danger">
                                Url is not Valid
                            </p>
                            <div class="copyLink mb-5">
                                <span id="output_url">
                                    
                                </span>
                                <span id="clipBoard" v-on:click.prevent="copyContent">
                                    {{copyTextString}}
                                </span>
                            </div>
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
                urlNotFound:true,
                copyTextString: 'Copy text to clipboard',
                response:null,
            }
        },
        methods:{
            shortenUrl(){
                let self = this;
                let newUrl = self.url;
                let newArray = newUrl.split('//');
                let counter = 0;
                let resultNewUrl = Math.round((Math.pow(36,8) - Math.random()* Math.pow(36,8))).toString(36).slice(1);

                for(let i=0; i < newArray.length; i++)
                {
                    if(newArray[i] == 'http:' || newArray[i] == 'https:')
                    {
                        counter++;
                    }

                    if(counter == 0)
                    {
                        let newArrayOne = newUrl.split('.');
                        if(newArrayOne[i] == 'www')
                        {
                            counter++;
                        }

                        let newArrayTwo = newUrl.indexOf('.com');
                        if(newArrayTwo >= 0){
                            counter++;
                        }
                    }

                    if(counter==0){
                        self.urlNotFound = false;
                    } else {
                        let currentUrl = window.location.href+'u/'+resultNewUrl;
                        
                        axios.post('/url/shorten',{
                            url: newUrl,
                            shortlink: currentUrl,
                        }).then(function(response){
                            self.response = response.data;
                            $('.copyLink').fadeIn(500);
                            $('.copyLink').siblings('.form').find("#p1").val(self.response);
                            console.log(self.response);
                        });
                    }
                }
            },
            copyContent(){
                $("#p1").select();
                this.copyTextString = 'Url Coppied successfully';
                document.execCommand("copy");
                this.url = this.response;
            }
        }
    }
</script>
<style scoped>
    .copyLink{
        display:none;
    }

    #clipBoard{
        display:block;
        margin-top: 28px;
        background-color: #03cbf8;
        color: #fff;
        font-weight: 900;
        font-size: 17px;
    }

    #clipBoard:hover{
        background-color: #333;
        cursor: pointer;
    }

    #clipBoard:hover, clipBoard:active, clipBoard:focus{
        background-color: green;
        color: #333;
    }
</style>