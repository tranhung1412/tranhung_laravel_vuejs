<template>
    <div>
        <!-- Breadcrumb Section Begin -->
        <Section :path="path"></Section>
        <!-- Breadcrumb Section Begin -->

        <!-- Product Shop Section Begin -->
        <section class="product-shop spad">
            <div class="container">
                <!--<div class="row" style="border: 1px solid black">-->
                    <!--<div class="col-4">-->
                        <!--Tìm theo-->
                    <!--</div>-->
                    <!--<div class="col-2">-->
                        <!--<select class="sorting" >-->
                            <!--<option value="asc">Mức giá</option>-->
                            <!--<option value="desc">Giá từ cao đến thấp</option>-->
                        <!--</select>-->
                    <!--</div>-->
                    <!--<div class="col-sm-2">-->
                        <!--<select class="sorting" >-->
                            <!--<option value="asc">Hệ điều hành</option>-->
                            <!--<option value="desc">Giá từ cao đến thấp</option>-->
                        <!--</select>-->
                    <!--</div>-->
                    <!--<div class="col-2">-->
                        <!--<select class="sorting" >-->
                            <!--<option value="asc">Màn hình</option>-->
                            <!--<option value="desc">Giá từ cao đến thấp</option>-->
                        <!--</select>-->
                    <!--</div>-->
                    <!--<div class="col-sm-2">-->
                        <!--<select class="sorting" >-->
                            <!--<option value="asc">Tính năng</option>-->
                            <!--<option value="desc">Giá từ cao đến thấp</option>-->
                        <!--</select>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="row">
                    <div class="col-lg-12 order-1 order-lg-2" v-if="products.length > 0">
                        <div class="product-show-option">
                            <div class="row">
                                <div class="col-lg-7 col-md-7">
                                    <div class="select-option">
                                        <select class="sorting" v-model="sort" @change="getAllProductByCatgeoryId(path.category.id)">
                                            <option value="asc">Giá từ thấp đến cao</option>
                                            <option value="desc">Giá từ cao đến thấp</option>
                                        </select>
                                        <!--<select class="p-show">-->
                                            <!--<option value="">Show:</option>-->
                                        <!--</select>-->
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 text-right">
                                    <!--<p>Show 01- 09 Of 36 Product</p>-->
                                </div>
                            </div>
                        </div>
                        <div class="product-list">
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
                        <div class="loading-more" v-show="moreExists" >
                            <i class="icon_loading"></i>
                            <a style="cursor: pointer" @click="loadMore">
                                Xem thêm
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-12 order-1 order-lg-2" v-else>
                        <h3>Không tìm thấy sản phẩm nào</h3>
                    </div>
                </div>
            </div>
        </section>
        <!--&lt;!&ndash; Product Shop Section End &ndash;&gt;-->

        <!-- Partner Logo Section End -->
        <LoadingAnition :isLoading="isLoading"></LoadingAnition>
    </div>
</template>

<script>
    import StringUtil from  "../../../utils/StringUtils"
    import Section from "../Section";
    const stringUtil = new StringUtil();
    import LoadingAnition from "../../customer/LoadingAnimation";
    export default {
        name: "ShopProductList",
        components: {Section, LoadingAnition},
        data(){
            return{
                products: [],
                path:{
                    category: null,
                    productType: null
                },
                slugCategory: this.$route.params.slugCategory,
                itemPerPage: 2,
                numPerPageList: [
                    2,
                    3,
                    10
                ],
                test: [],
                nextPage: 0,
                isLoading: true,
                moreExists : false,
                sort: 'asc',
            }
        },
        methods:{
            // getProductBySort(){
            //     this.isLoading = true;
            //     axios.get('/api/getProductByCategoryId/'+ this.path.category.id+'/'+this.itemPerPage+"?sort="+this.sort)
            //     .then(response => {
            //         console.log(response.data.product.data);
            //         this.products = response.data.product.data;
            //         this.isLoading = false;
            //         if (response.data.product.current_page < response.data.product.last_page) {
            //             this.moreExists = true;
            //             this.nextPage = response.data.product.current_page + 1;
            //         }else{
            //             this.moreExists = false;
            //         }
            //     })
            //     .catch(function (error) {
            //         console.log(error);
            //     });
            //     console.log();
            //     console.log(this.sort);
            // },
            getSlug(){
                Fire.$emit('offLoading');
                this.path.category = null;
                this.slugCategory = this.$route.params.slugCategory;
                console.log("cate " + this.slugCategory);
                console.log("productType" + this.slugProductType);
                this.getCatgeoryBySlug(this.slugCategory);
            },
            getCatgeoryBySlug(slugCategory) {
                this.isLoading = true;
                axios.get('/api/getCategoryBySlug/'+ slugCategory)
                .then(response => {
                    this.isLoading = false;
                    console.log(response.data);
                    this.path.category = response.data[0];
                    this.getAllProductByCatgeoryId(response.data[0].id);
                    Fire.$emit('offLoading');
                }).catch(function (error) {
                    console.log(error);
                })
            },
            getAllProductByCatgeoryId(id) {
                this.isLoading = true;
                console.log("id " + id);
                axios.get('/api/getProductByCategoryId/'+ id+'/'+this.itemPerPage+"?sort="+this.sort)
                .then(response => {
                    console.log(response.data.product.data);
                    this.products = response.data.product.data;
                    this.isLoading = false;
                    if (response.data.product.current_page < response.data.product.last_page) {
                        this.moreExists = true;
                        this.nextPage = response.data.product.current_page + 1;
                    }else{
                        this.moreExists = false;
                    }
                    Fire.$emit('offLoading');
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            formatPrice(price) {
                let formatedNumber = price || 0;
                return stringUtil.formatNumber(formatedNumber);
            },
            loadMore : async function(){
            console.log("loadmore");
            console.log("nextpage", this.nextPage);
            var id = this.path.category.id;

            axios.get('/api/getProductByCategoryId/'+ id+'/'+this.itemPerPage+'?page=' + this.nextPage+"&sort="+this.sort)
            .then(response => {
                console.log(response.data.product);
                this.isLoading = false;
                if (response.data.product.current_page < response.data.product.last_page) {
                    this.moreExists = true;
                    this.nextPage = response.data.product.current_page + 1;
                }else{
                    this.moreExists = false;
                }
                var current = this;

                response.data.product.data.forEach(data => {
                    console.log(data);
                    current.products.push(data);
                    current.test.push(data);
                });
            })
            .catch(function (error) {
                console.log(error);
            })
        }
    },

        beforeRouteUpdate ( to, from , next ) {
            // console.log('Reusing this component.')
            // this.user = this.getUser(to.params.slugCategory);
            console.log('Entering User' +to.params.slugCategory);
            this.slugCategory = to.params.slugCategory;
            this.getCatgeoryBySlug(this.slugCategory);
            next()
        },

        created() {
            this.getSlug();
            //this.getAllProductByCatgeoryId();

        },
    }
</script>

<style scoped>
.loading-more a:hover{
    color: #e7ab3c;
}
</style>
