<template>
    <div>
        <div class="ps-section ps-home-blog  pb-80">
            <div class="ps-container">
                <div class="ps-section__header mb-50">
                    <h2 class="ps-section__title" data-mask="News">- Our Story</h2>
                    <div class="ps-section__action"><a class="ps-morelink text-uppercase" href="#">View
                        all post<i class="fa fa-long-arrow-right"></i></a></div>
                </div>
                <div class="ps-section__content">
                    <div class="row" >
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 " v-for="(blog, index) in blogs" :key="`${index}-${blogs.id}`">
                            <div class="ps-post">
                                <div class="ps-post__thumbnail"><router-link class="ps-post__overlay"
                                                                             :to="{ name: 'blog-detail', params: { slug: blog.slug} }"></router-link><img  style="width: 450px;height: 400px;"
                                    :src="blog.image"></div>
                                <div class="ps-post__content"><router-link class="ps-post__title"
                                                                           :to="{ name: 'blog-detail', params: { slug: blog.slug} }">{{blog.title}}</router-link>
                                    <p class="ps-post__meta"><span>By:<a class="mr-5"
                                                                         ></a></span>
                                        -<span class="ml-5">{{blog.created_at}}</span></p>
                                    <read-more more-str="" :text="blog.content" :max-chars=20>{{blog.content}}</read-more><router-link :to="{ name: 'blog-detail', params: { slug: blog.slug} }"
                                        class="ps-morelink">Read more<i
                                        class="fa fa-long-arrow-right"></i></router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ListPost",
        data() {
            return {
                blogs:[]
            }
        },
        methods: {
            getTreeBlog() {
                axios.get('/api/getTreeBlog')
                .then(response => {
                    console.log(response.data);
                    this.blogs = response.data.blog;
                })
            },
        
        },
        created() {
            this.getTreeBlog();
        }
    }
</script>

<style scoped>

</style>
