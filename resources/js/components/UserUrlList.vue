<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Url list history</div>

                    <div class="card-body">
                        <div v-if="user_urls">
                            <ul>
                                <li v-for="user in user_urls">
                                <p>Original url: <a :href="user.old_url" target="_blank">{{ user.old_url }}</a></p>
                                <p>Short url: <a :href="user.new_url" target="_blank">{{ user.new_url }}</a></p>
                                <br>
                                </li>
                            </ul>
                            </div>
                            <div v-else>
                            <p>No users found.</p>
                            </div>
                    </div>
                    <button class="btn btn-dark" ><a class="nav-link" href="/">Go Back</a></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['user'],
        data() {
            return {
            user_urls: null,
            };
        },
        mounted() {
            this.fetchUserUrls();
        },
        methods: {
            async fetchUserUrls() {
            try {
                const userId = this.user;
                const response = await axios.get(`/url_list/${userId}`);
                this.user_urls = response.data;
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
            },
        },
    }
</script>