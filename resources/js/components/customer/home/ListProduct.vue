<template>
    <div>

        <div class="ps-section--features-product ps-section masonry-root pt-40 pb-80">
            <div class="ps-container">
                <!--<div class="ps-section__header">-->
                    <!--<h3 class="ps-section__title" data-mask="features">- New Product</h3>-->
                    <!--<ul class="ps-masonry__filter">-->
                        <!--<li v-for="(val, key) in option.getFilterData" :key="key"-->
                            <!--:class="[key===filterOption? 'current' : '']" @click="filter(key)"><a-->
                            <!--style="cursor: pointer">{{key}} <sup>4</sup></a>-->
                        <!--</li>-->
                    <!--</ul>-->
                <!--</div>-->
                <div class="ps-section__content">
                    <section class="product-shop spad">
                        <div class="container">
                            <div class="product-list">
                                <!--<isotope ref="cpt" class="row" id="root_isotope1"-->
                                         <!--:item-selector="'filter-item'" :list="products"-->
                                         <!--:options='option' @filter="filterOption=arguments[0]">-->
                                    <!--<div class="col-lg-3 col-sm-6"-->
                                         <!--v-for="(element,index) in products"-->
                                         <!--:class='[element.product_type.name]' :key="index">-->

                                        <!--<div class="product-item">-->
                                            <!--<div class="pi-pic">-->
                                                <!--<img :src="element.product_img[0].url" alt="">-->
                                                <!--<div class="sale pp-sale">Sale</div>-->
                                                <!--<div class="icon">-->
                                                    <!--<i class="icon_heart_alt"></i>-->
                                                <!--</div>-->
                                                <!--<ul>-->
                                                    <!--<li class="w-icon active"><a href="#"><i-->
                                                        <!--class="icon_bag_alt"></i></a></li>-->
                                                    <!--<li class="quick-view">-->
                                                        <!--<router-link-->
                                                            <!--:to="{ name: 'product-detail', params: {slugCategory: element.category.slug, slugProductType: element.product_type.slug, slug: element.slug} }">-->
                                                            <!--+ Quick View-->
                                                        <!--</router-link>-->
                                                    <!--</li>-->
                                                    <!--<li class="w-icon"><a href="#"><i-->
                                                        <!--class="fa fa-random"></i></a></li>-->
                                                <!--</ul>-->
                                            <!--</div>-->
                                            <!--<div class="pi-text">-->
                                                <!--<div class="catagory-name">Towel</div>-->
                                                <!--<a href="#">-->
                                                    <!--<h5>{{element.name}}</h5>-->
                                                <!--</a>-->
                                                <!--<div class="product-price">-->
                                                    <!--{{formatPrice(element.price)}}-->
                                                    <!--<span>{{formatPrice(element.price)}}</span>-->
                                                <!--</div>-->
                                            <!--</div>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                <!--</isotope>-->
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6"
                                         v-for="(element,index) in products"
                                         :key="index">

                                        <div class="product-item">
                                            <div class="pi-pic">
                                                <img :src="element.product_img[0].url" alt="">
                                                <div class="sale pp-sale">Sale</div>
                                                <div class="icon">
                                                    <i class="icon_heart_alt"></i>
                                                </div>
                                                <ul>
                                                    <li class="w-icon active"><a href="#"><i
                                                        class="icon_bag_alt"></i></a></li>
                                                    <li class="quick-view">
                                                        <router-link
                                                            :to="{ name: 'product-detail', params: {slugCategory: element.category.slug, slugProductType: element.product_type.slug, slug: element.slug} }">
                                                            Xem Nhanh
                                                        </router-link>
                                                    </li>
                                                    <li class="w-icon"><a href="#"><i
                                                        class="fa fa-random"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="pi-text">
                                                <div class="catagory-name"></div>
                                                <a href="#">
                                                    <h5>{{element.name}}</h5>
                                                </a>
                                                <div class="product-price">
                                                    {{formatPrice(element.promotion)}}
                                                    <span>{{formatPrice(element.price)}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import StringUtil from "../../../utils/StringUtils"
    import isotope from "vueisotope"

    const stringUtil = new StringUtil();
    export default {
        name: "ListProduct",
        components: {
            isotope
        },
        data() {
            return {
                products: [],
                filterOption: "show all",
                option: {
                    itemSelector: ".filter-item",
                    getFilterData: {
                        "show all": function () {
                            return true;
                        },
                        "samsung": function (el) {
                            return el.product_type.name === "Samsung";
                        },
                        "iphone": function (el) {
                            return el.product_type.name === "Iphone";
                        },
                        "huawei": function (el) {
                            return el.product_type.name === "Huawei";
                        },
                        "oppo": function (el) {
                            return el.product_type.name === "Oppo";
                        },
                        "sony": function (el) {
                            return el.product_type.name === "Sony";
                        },
                    }
                }
            }
        },
        methods: {
            getAllProduct() {
                Fire.$emit('onLoading');
                axios.get('/api/getAllProduct')
                .then(response => {
                    console.log(response.data.product);
                    this.products = response.data.product;
                    Fire.$emit('offLoading');
                })
            },
            formatPrice(price) {
                let formatedNumber = price || 0;
                return stringUtil.formatNumber(formatedNumber);
            },
            filter: function (key) {
                this.$refs.cpt.filter(key);
            },
        },
        created() {
            this.getAllProduct();
        },

    }
</script>

<style scoped>
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    body {
        background: url(//subtlepatterns.com/patterns/scribble_light.png);
        font-family: Calluna, Arial, sans-serif;
        min-height: 1000px;
    }

    #wrap {
        width: 90%;
        max-width: 1100px;
        margin: 50px auto;
    }

    .columns_2 figure {
        width: 49%;
        margin-right: 1%;
    }

    .columns_2 figure:nth-child(2) {
        margin-right: 0;
    }

    .columns_3 figure {
        width: 32%;
        margin-right: 1%;
    }

    .columns_3 figure:nth-child(3) {
        margin-right: 0;
    }

    .columns_4 figure {
        width: 24%;
        margin-right: 1%;
    }

    .columns_4 figure:nth-child(4) {
        margin-right: 0;
    }

    .columns_5 figure {
        width: 19%;
        margin-right: 1%;
    }

    .columns_5 figure:nth-child(5) {
        margin-right: 0;
    }

    #columns figure:hover {
        -webkit-transform: scale(1.1);
        -moz-transform: scale(1.1);
        transform: scale(1.1);

    }

    #columns:hover figure:not(:hover) {
        opacity: 0.4;
    }

    div#columns figure {
        display: inline-block;
        background: #FEFEFE;
        border: 2px solid #FAFAFA;
        box-shadow: 0 1px 2px rgba(34, 25, 25, 0.4);
        margin: 0 0px 15px;
        -webkit-column-break-inside: avoid;
        -moz-column-break-inside: avoid;
        column-break-inside: avoid;
        padding: 15px;
        padding-bottom: 5px;
        background: -webkit-linear-gradient(45deg, #FFF, #F9F9F9);
        opacity: 1;
        -webkit-transition: all .3s ease;
        -moz-transition: all .3s ease;
        -o-transition: all .3s ease;
        transition: all .3s ease;
    }

    div#columns figure img {
        width: 100%;
        border-bottom: 1px solid #ccc;
        padding-bottom: 15px;
        margin-bottom: 5px;
    }

    div#columns figure figcaption {
        font-size: .9rem;
        color: #444;
        line-height: 1.5;
        height: 60px;
        font-weight: 600;
        text-overflow: ellipsis;
    }

    a.button {
        padding: 10px;
        background: salmon;
        margin: 10px;
        display: block;
        text-align: center;
        color: #fff;
        transition: all 1s linear;
        text-decoration: none;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        border-radius: 3px;
        border-bottom: 3px solid #ff6536;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
    }

    a.button:hover {
        background: #ff6536;
        border-bottom: 3px solid salmon;
        color: #f1f2f3;
    }

    @media screen and (max-width: 960px) {
        #columns figure {
            width: 24%;
        }
    }

    @media screen and (max-width: 767px) {
        #columns figure {
            width: 32%;
        }
    }

    @media screen and (max-width: 600px) {
        #columns figure {
            width: 49%;
        }
    }

    @media screen and (max-width: 500px) {
        #columns figure {
            width: 100%;
        }
    }

    abc{
        min-height: 900px;
    }
</style>
