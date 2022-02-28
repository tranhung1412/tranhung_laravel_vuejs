<template>


    <!-- Header End -->

    <div>
        <div class="header--sidebar"></div>
        <header class="header">
            <div class="header__top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12 ">
                            <p><i class="fas fa-mobile"></i> Quang Trung - Gò Vấp - TP.HCM ---- Email: hungkaito123@gmail.com </p>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 ">
                            <div class="header__actions" style="width: 40%">
                                <div class="login" v-if="this.$store.state.auth != null" >
                                    <a href="#">{{this.$store.state.auth.name}}</a>
                                    <a href="#" @click="logout">Đăng Xuất</a>
                                </div>
                                <div class="login" v-else >
                                    <router-link :to="{name : 'login'}">Đăng Nhập & Đăng Ký</router-link>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <header class="header-section">

            <div class="container">
                <div class="inner-header">
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <div class="logo" >
                                <a href="./index.html">
                                    <img src="" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7">
                            <div class="advanced-search">
                                <div  class="input-group" style="max-width: 100%">
                                    <input v-model="textSearch" @keyup.enter="search" type="text" placeholder="Bạn muốn tìm gì" style="color: black">
                                    <button type="button"><i class="ti-search" @click="search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 text-right col-md-3" >
                            <ul class="nav-right" v-if="this.$store.state.auth">
                                <li class="cart-icon"><a href="#">
                                    <i class="icon_bag_alt"></i>
                                    <span>{{this.$store.state.cart.length}}</span>
                                </a>
                                    <div class="cart-hover">
                                        <div class="select-items">
                                            <table>
                                                <tbody>
                                                <tr v-for="(item, index) in this.$store.state.cart" :key="index">
                                                    <td class="si-pic"><img style="width: 70px; height: 70px"
                                                        :src="item.product.product_img[0].url" alt=""></td>
                                                    <td class="si-text">
                                                        <div class="product-selected">
                                                            <p>{{formatPrice(item.product.promotion)}} x {{item.quantity}}</p>
                                                            <h6>{{item.product.name}}</h6>
                                                        </div>
                                                    </td>
                                                    <td class="si-close">
                                                        <i class="ti-close" @click="removeItem(item)"></i>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="select-total" v-if="this.$store.state.cart.length > 0">
                                            <span>total:</span>
                                            <h5>{{formatSubTotalPrice()}}</h5>
                                        </div>
                                        <div class="select-total" v-else>
                                            <h5>Chưa có sản phẩm trong giỏ hàng</h5>
                                        </div>
                                        <div class="select-button" v-if="this.$store.state.cart.length > 0">
                                            <router-link class="primary-btn view-card" :to="{name : 'cart'}" >{{$t('viewcart')}}</router-link>
                                            <router-link class="primary-btn checkout-btn" :to="{name : 'checkout'}">{{$t('checkout')}}</router-link>
                                        </div>
                                    </div>
                                </li>
                                <li class="cart-price">{{formatSubTotalPrice()}}</li>
                            </ul>
                        </div>  <!-- end card -->
                    </div>
                </div>
            </div>
            <div class="nav-item">
                <div class="container">
                    <nav class="nav-menu mobile-menu d-flex justify-content-center">
                        <ul>
                            <li><router-link to="/home">{{$t('home')}}</router-link></li>
                            <li v-for="(category, index) in categories" :key="index"><router-link :to="{name:'product-category', params:{slugCategory: category.slug}}">{{category.name}}</router-link>
                                <ul class="dropdown">
                                    <li v-for="(productType, indexPro) in category.product_type"
                                        :key="indexPro"><router-link :to="{name:'product-productType', params:{slugCategory: category.slug, slugProductType : productType.slug}}" >{{productType.name}}</router-link></li>
                                    <!--<li><a href="#">Women's</a></li>-->
                                    <!--<li><a href="#">Kid's</a></li>-->
                                </ul>
                            </li>
                            <li><a href="#">{{$t('blog')}}</a></li>
                            <li><a href="#">{{$t('contact')}}</a></li>

                        </ul>
                    </nav>
                    <div id="mobile-menu-wrap"></div>
                </div>
            </div>
        </header>
    </div>
</template>

<script>
    import StringUtil from "../../utils/StringUtils"
    const stringUtil = new StringUtil();
    export default {
        name: "Header",
        data() {
            return {
                categories: [],
                auth:'',
                textSearch: ''
            }
        },
        methods: {
            getAllCategory() {
                axios.get('/api/getAllCategory')
                .then(response => {
                    console.log(response.data);
                    this.categories = response.data.category;
                })
            },
            callSetLangActions(lang) {
                i18n.locale = lang.value;
                i18n.fallbackLocale = lang.value;
            },
             User() {
                axios.get('/api/checklogin')
                .then(response => {
                    console.log(response.data.data);
                    this.auth = response.data.data;
                })
            },
            logout(){
                this.$store.commit('logout');
                this.$router.push({name: 'home'});

            },
            removeItem(item){
                this.$store.commit('removeFromCart',item);
                // axios.post('/api/removeItem/'+item.product.id  +'/' + item.quantity)
                // .then(response => {
                //     console.log(response.data);
                //     Fire.$emit('productDetail');
                // })

            },
            formatPrice(price) {
                let formatedNumber = price || 0;
                return stringUtil.formatNumber(formatedNumber);
            },
            formatTotalPrice(price, quantity) {
                let formatedNumber = price || 0;
                formatedNumber *= quantity;
                return stringUtil.formatNumber(formatedNumber);
            },
            formatSubTotalPrice() {
                // let formatedNumber = price || 0;
                // formatedNumber *= quantity;
                var total = 0;
                for(var i = 0; i < this.$store.state.cart.length; i++ ){
                    var item = this.$store.state.cart[i];
                    total += item.product.promotion * item.quantity;
                }
                return stringUtil.formatNumber(total);
            },
            search(){
                this.$router.push({name: 'search', params: {key: this.textSearch}});
            }
        },

        created() {
            this.User();
            this.getAllCategory();
        },


    }
</script>

<style scoped>

</style>
