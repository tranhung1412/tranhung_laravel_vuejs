<template>
    <div>
        <div class="ps-section masonry-root pt-80">
            <div class="ps-container">
                <div class="ps-section__header mb-50">
                    <h3 class="ps-section__title" data-mask="--MỚI NHẤT--"></h3>
                </div>
                <div class="ps-section__content pb-50">
                    <div class="masonry-wrapper" data-col-md="3" data-col-sm="2" data-col-xs="1"
                         data-gap="30"
                         data-radio="100%">
                        <div class="ps-masonry">
                            <!--<div class="row">-->
                                <!--<div class="col-md-8"  >-->
                                    <!--<div class="row" style="margin-bottom: 30px;">-->
                                        <!--<div class="col-md-6">-->
                                            <!--<div class="grid-item__content-wrapper" ><a-->
                                                <!--class="ps-offer"-->
                                                <!--href="product-detail.html"><img -->
                                                <!--src="https://cdn.tgdd.vn/2020/04/banner/800-300-800x300-31.png"-->
                                                <!--alt=""></a>-->
                                            <!--</div>-->
                                        <!--</div>-->
                                        <!--<div class="col-md-6">-->
                                            <!--<div class="grid-item__content-wrapper"><a-->
                                                <!--class="ps-offer"-->
                                                <!--href="product-detail.html"><img-->
                                                <!--src="https://cdn.tgdd.vn/2020/04/banner/pk-304-800-300-800x300-1.png"-->
                                                <!--alt=""></a>-->
                                            <!--</div>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                    <!--<div class="row">-->
                                        <!--<div class="col-md-6">-->
                                            <!--<div class="grid-item__content-wrapper"><a-->
                                                <!--class="ps-offer"-->
                                                <!--href="product-detail.html"><img-->
                                                <!--src="https://cdn.tgdd.vn/2020/04/banner/a51-800-300-800x300.png"-->
                                                <!--alt=""></a>-->
                                            <!--</div>-->
                                        <!--</div>-->
                                        <!--<div class="col-md-6">-->
                                            <!--<div class="grid-item__content-wrapper"><a-->
                                                <!--class="ps-offer"-->
                                                <!--href="product-detail.html"><img-->
                                                <!--src="https://cdn.tgdd.vn/2020/04/banner/a9new2f-800-300-800x300.png"-->
                                                <!--alt=""></a>-->
                                            <!--</div>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                <!--</div>-->
                                <!--<div class="col-md-4">-->
                                    <!--<div class="grid-item__content-wrapper"><a class="ps-offer"-->
                                                                               <!--href="product-detail.html"><img-->
                                        <!--src="https://cdn.cellphones.com.vn/media/wysiwyg/mobile/realme/realme-6i-09.jpg"-->
                                        <!--alt=""></a>-->
                                    <!--</div>-->
                                <!--</div>-->
                            <!--</div>-->
                            <div class="row">
                                <div class="col-md-8">
                                    <vueper-slides :dragging-distance="50" autoplay >
                                        <vueper-slide
                                            v-for="(slide, i) in slides"
                                            :key="i"
                                            :image="slide.image"
                                            :title="slide.title"
                                            :content="slide.content"
                                            @click.native="getData()"
                                            :link="slide.link" />
                                    </vueper-slides>
                                </div>

                                <div class="col-md-4" style="height: 100px">
                                    <div class="grid-item__content-wrapper"><a
                                        class="ps-offer"
                                        href="#"><img
                                        src="https://fptshop.com.vn/Uploads/Originals/2014/5/3/201405031142404273_CKMT5_Banner_ver2.jpg"
                                        alt=""></a>
                                    </div>
                                    <div style="margin-top: 15px"><a
                                        class="ps-offer"
                                        href="#"><img style="height: 100px; width: 100%"
                                        src="https://cdn.tgdd.vn/Files/2015/12/03/751514/tgdd-online-friday-800-300-1.jpg"
                                        alt=""></a>
                                    </div>
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
    import { VueperSlides, VueperSlide } from 'vueperslides'
    import 'vueperslides/dist/vueperslides.css'
    export default {
        name: "Banner",
        components: { VueperSlides, VueperSlide },
        data() {
            return {
                banners:[],
                slides: [
                    {
                        // You can also provide a URL for the image.
                        image: 'https://techcare.vn/wp-content/uploads/2019/04/laptop-van-phong-Da-Nang-800x300.png',
                        link: ''
                    },
                    {
                        // You can also provide a URL for the image.
                        image: 'https://itcoms.vn/wp-content/images/thay-ban-phim-laptop-slide.jpg',
                    },
                    {
                        // You can also provide a URL for the image.
                        image: 'https://laptopcugiarehcm.net/wp-content/uploads/2019/04/khuyen-mai-khi-mua-laptop.jpg',
                    },
                    // Other slides.
                ]
            }
        },
        methods: {
            getAllBlog() {
                axios.get('/api/getAllBlog')
                .then(response => {
                    console.log(response.data.blog);
                    this.blogs = response.data.blog;

                })
            },

        },
        created() {
            this.getAllBlog();
        }
    }
</script>

<style scoped>


</style>
