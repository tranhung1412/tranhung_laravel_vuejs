<template>
    <div>
        <!-- Related Products Section End -->
        <div class="related-products spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>Sản phẩm liên quan</h2>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-6" v-for="(product, index) in products" :key="index">
                        <div class="product-item">
                            <div class="pi-pic">
                                <img :src="product.product_img[0].url" alt="">
                                <div class="sale pp-sale">Sale</div>
                                <div class="icon">
                                    <i class="icon_heart_alt"></i>
                                </div>
                                <ul>
                                    <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                    <li class="quick-view">
                                        <router-link
                                            :to="{ name: 'product-detail', params: {slugCategory: product.category.slug, slugProductType: product.product_type.slug, slug: product.slug} }">
                                            Xem Nhanh
                                        </router-link>
                                    </li>
                                    <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                                </ul>
                            </div>
                            <div class="pi-text">
                                <div class="catagory-name"></div>
                                <a href="#">
                                    <h5>{{product.name}}</h5>
                                </a>
                                <div class="product-price">
                                    {{formatPrice(product.price)}}
                                    <span>{{formatPrice(product.price)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Related Products Section End -->
    </div>
</template>

<script>
    import StringUtil from  "../../../utils/StringUtils"
    const stringUtil = new StringUtil();
    export default {
        name: "RelatedProduct",
        data(){
            return{
                products: []
            }
        },
        methods:{
            getRandomProduct(){
                axios.get('/api/getRandomProduct')
                .then(response => {
                    console.log(response.data.product);
                    this.products = response.data.product;
                })
            },
            formatPrice(price) {
                let formatedNumber = price || 0;
                return stringUtil.formatNumber(formatedNumber);
            },
        },
        created() {
            this.getRandomProduct();
        }
    }
</script>

<style scoped>

</style>
