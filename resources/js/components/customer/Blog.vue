<template>

    <div class="container">
        <div v-html="blogs.content">
            {{blogs.content}}
        </div>
    </div>
</template>

<script>
    export default {
        name: "Blog",
        data() {
            return {
                blogs: '',
            }
        },
        methods: {
            getBlogBySlug() {
                this.isLoading = true;
                var slug = this.$route.params.slug;
                axios.get('/api/getBlogBySlug/' + slug)
                .then(response => {
                    console.log(response.data.blog);
                    this.blogs = response.data.blog;
                })
            },

        },
        created() {
            this.getBlogBySlug();
        }
    }
</script>

<style scoped>

</style>
