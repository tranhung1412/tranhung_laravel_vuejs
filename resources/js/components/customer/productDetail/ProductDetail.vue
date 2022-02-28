<template>
    <div>
        <!--&lt;!&ndash; Page Preloder &ndash;&gt;-->
        <!-- Page Preloder -->

        <main class="ps-main">
            <Section :path="path"></Section>
            <!-- Product Shop Section Begin -->
            <section class="product-shop spad page-details">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <agile class="main" ref="main" :options="options1" :as-nav-for="asNavFor1">
                                        <div><img :src="mainImage"/></div>
                                    </agile>
                                    <agile class="thumbnails" ref="thumbnails" :options="options2" :as-nav-for="asNavFor2">
                                        <div class=" slide--thumbniail" v-for="(slide, index) in slides" :key="index"  @click="switchImage(index)" style="height: 150px"><img :src="slide.url" style="width: 130px"/></div>
                                    </agile>


                                </div>
                                <div class="col-lg-6">
                                    <div class="product-details">
                                        <div class="pd-title">
                                            <h3 class="font-weight-bold">{{productDetail.name}}</h3>
                                            <a href="#" class="heart-icon"><i
                                                class="icon_heart_alt"></i></a>
                                        </div>
                                        <div class="pd-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>(5)</span>
                                        </div>
                                        <div class="pd-desc">
                                            <h3 class="price">{{formatPrice(productDetail.promotion)}}
                                                <span>{{formatPrice(productDetail.price)}}</span>
                                            </h3>
                                        </div>
                                        <div class="pd-color">
                                            <h6>Color</h6>
                                            <div class="pd-color-choose">
                                                <div class="cc-item">
                                                    <input type="radio" id="cc-black">
                                                    <label for="cc-black"></label>
                                                </div>
                                                <div class="cc-item">
                                                    <input type="radio" id="cc-yellow">
                                                    <label for="cc-yellow"
                                                           class="cc-yellow"></label>
                                                </div>
                                                <div class="cc-item">
                                                    <input type="radio" id="cc-violet">
                                                    <label for="cc-violet"
                                                           class="cc-violet"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-bottom: 20px">
                                            <number-input style="top: 15px" v-model="quantity" :min="1" :max="productDetail.quantity" inline center controls></number-input>
                                            <button class="primary-btn pd-cart" style="margin-left: 10px"  @click="addToCart(productDetail)">Add To Cart</button>
                                        </div>

                                        <!--<div class="quantity">-->
                                            <!--<number-input v-model="quantity" :min="1" :max="10" inline controls></number-input>-->
                                            <!--&lt;!&ndash;<div class="pro-qty" >&ndash;&gt;-->

                                            <!--&lt;!&ndash;</div>&ndash;&gt;-->


                                        <!--</div>-->
                                        <div style="border-radius: 20px; border: 1px solid black">
                                            <div style="padding: 5px; margin-left: 5px; font-size: 16px; color: black; font-weight: bold" >Khuyến mãi</div>
                                            <ul class="a">
                                                <li>Tặng: <span style="color: red"> Balo - Chuột không dây</span> khi mua online</li>
                                                <li>Giảm: 200.000đ áp dụng cho 100 khách hàng nhanh nhất</li>
                                                <li>Mua: Bàn phím cơ <span style="color: red">chỉ 300.000đ</span></li>
                                                <li><span style="color: red">Giảm 200.000đ</span> khi thanh toán bằng Momo</li>
                                                <li>Ở đâu rẻ hơn: hoàn tiền lại <span style="color: red"></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-tab">
                                <div class="tab-item">
                                    <ul class="nav" role="tablist">
                                        <li>
                                            <a class="active" data-toggle="tab" href="#tab-1"
                                               role="tab">{{$t('product.description')}}</a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab-2" role="tab">{{$t('product.specifications')}}</a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab-3" role="tab">Customer
                                                Reviews ({{allComment.length}}) comment</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-item-content">
                                    <div class="tab-content">
                                        <div class="tab-pane fade-in active" id="tab-1"
                                             role="tabpanel">
                                            <div class="product-content">
                                                <div class="row">
                                                    <div class="col-lg-9">
                                                        <read-more style="font-size: 14px;" more-str="Đọc thêm" :text="productDetail.description" less-str="Thu gọn" :max-chars=500>
                                                            <div v-html="productDetail.description"></div>
                                                        </read-more>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                            <div class="specification-table">
                                                <div class="row">
                                                    <div class="col-lg-9">
                                                        <table>
                                                            <tr>
                                                                <td class="p-catagory">{{$t('product.screen')}}
                                                                </td>
                                                                <td>
                                                                    <div class="p-stock">{{productDetail.specification.screen}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-catagory">{{$t('product.operating_system')}}</td>
                                                                <td>
                                                                    <div class="p-stock">{{productDetail.specification.operating_system}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-catagory">{{$t('product.rear_camera')}}</td>
                                                                <td>
                                                                    <div class="p-stock">{{productDetail.specification.rear_camera}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-catagory">{{$t('product.front_camera')}}</td>
                                                                <td>
                                                                    <div class="p-stock">{{productDetail.specification.front_camera}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-catagory">cpu</td>
                                                                <td>
                                                                    <div class="p-stock">{{productDetail.specification.cpu}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-catagory">ram</td>
                                                                <td>
                                                                    <div class="p-stock">{{productDetail.specification.ram}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-catagory">{{$t('product.internal_memory')}}</td>
                                                                <td>
                                                                    <div class="p-stock">{{productDetail.specification.internal_memory}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-catagory">sim</td>
                                                                <td>
                                                                    <div class="p-stock">{{productDetail.specification.sim}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-catagory">{{$t('product.battery')}}</td>
                                                                <td>
                                                                    <div class="p-stock">{{productDetail.specification.battery}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-catagory">{{$t('product.design')}}</td>
                                                                <td>
                                                                    <div class="p-stock">{{productDetail.specification.design}}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                            <div class="customer-review-option">
                                                <h4>{{allComment.length}} Comment</h4>
                                                <div class="comment-option" v-for="(comment, index) in allComment" :key="`${index}-${comment.id}`" >
                                                    <div class="co-item">
                                                        <div class="avatar-pic">
                                                            <img
                                                                src="../../../../../public/assets/customer/fashi/img/product-single/avatar-1.png"
                                                                alt="">
                                                        </div>
                                                        <div class="avatar-text">
                                                            <h5>{{comment.user.name}}
                                                                <span>{{comment.created_at}}</span></h5>
                                                            <div class="at-reply">{{comment.noidung}}</div>
                                                                <div class="comment-option" style="margin-top:10px" v-for="(commentAdmin, indexAdmin) in comment.admincomment" :key="`${indexAdmin}-${commentAdmin.id}`" >
                                                                <div class="co-item commentchiren" >
                                                                    <div class="avatar-pic">
                                                                        <img
                                                                            src="../../../../../public/assets/customer/fashi/img/product-single/avatar-1.png"
                                                                            alt="">
                                                                    </div>
                                                                    <div class="avatar-text">
                                                                        <h5>{{commentAdmin.usercomment.name}}-Quản trị viên
                                                                            <span>{{commentAdmin.created_at}}</span></h5>
                                                                        <div class="at-reply" v-html="commentAdmin.content">{{commentAdmin.content}}</div>
                                                                    </div>
                                                                </div>        
                                                                </div>
                                                        </div>
                                                        
                                                    </div>        
                                                </div>
                                                 <div class="personal-rating">
                                                    <!--<h6>Your Ratind</h6>
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div> -->
                                                </div>
                                                <div class="leave-comment" v-if="this.$store.state.auth != null">
                                                    <h4>Leave A Comment</h4>
                                                    <form @submit.prevent="postCommment" class="comment-form">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <input type="text" disabled
                                                                       placeholder="Name" v-bind:value="this.$store.state.auth.name" readonly> 
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <input type="text" disabled
                                                                       placeholder="Email" v-bind:value="this.$store.state.auth.email" readonly> 
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <textarea
                                                                    placeholder="Messages" v-model="formMessage.noidung"></textarea>
                                                                <button type="submit"
                                                                        class="site-btn">Send
                                                                    message
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    
                                                </div>

                                                <div class="leave-comment" v-else>
                                                    <h4>Bạn cần đăng nhập để thực hiện chức năng này</h4>
                                                    <form @submit.prevent="login" class="comment-form">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <input type="email"
                                                                       placeholder="Email" v-model="form.email">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <input type="password"
                                                                       placeholder="Password" v-model="form.password">
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <button type="submit"
                                                                        class="site-btn">login
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Product Shop Section End -->
            <RelatedProduct></RelatedProduct>

        </main>
    </div>
</template>

<script>
    import StringUtil from "../../../utils/StringUtils"
    const stringUtil = new StringUtil();
    import LoadingAnition from "../../customer/LoadingAnimation";
    import Section from "../Section";
    import RelatedProduct from "./RelatedProduct";
    export default {
        name: "productDetail",
        components: {RelatedProduct, Section, LoadingAnition},
        data() {
            return {
                cartItem:{
                    productDetail: null,
                    quantity: 0,
                    productId: null,
                },
                mainImage: "https://images.unsplash.com/photo-1453831362806-3d5577f014a4?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ",
                productDetail: null,
                splitedStr: "",
                quantity: 1,
                path:{
                    category: null,
                    productType: null
                },
                isLoading: true,

                form: new Form({
                    email:'',
                    password:'',
                }),
                auth:'',
                formMessage: new Form({
                    noidung:'',
                }),
                comment:null,
                allComment:[],
                productId: null,

                asNavFor1: [],
                asNavFor2: [],
                options1: {
                    dots: false,
                    fade: true,
                    navButtons: false
                },

                options2: {
                    autoplay: false,
                    centerMode: true,
                    dots: false,
                    navButtons: false,
                    slidesToShow: 1,
                    responsive: [
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 4
                            }
                        },
                        {
                            breakpoint: 1000,
                            settings: {
                                navButtons: false
                            }
                        }
                    ]

                },
                slides: [
                    'https://images.unsplash.com/photo-1453831362806-3d5577f014a4?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
                    'https://images.unsplash.com/photo-1496412705862-e0088f16f791?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
                    'https://images.unsplash.com/photo-1506354666786-959d6d497f1a?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
                    'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
                    'https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
                    'https://images.unsplash.com/photo-1472926373053-51b220987527?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ',
                    'https://images.unsplash.com/photo-1497534547324-0ebb3f052e88?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&w=1600&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ'
                ],

            }
        },
        mounted () {
            this.asNavFor1.push(this.$refs.thumbnails)
            this.asNavFor2.push(this.$refs.main)
        },
        methods: {
            getProductDetail() {
                Fire.$emit('onLoading');
                this.isLoading = true;
                // var myCookie = document.cookie;
                // console.log("myCookie" + myCookie);
                var slug = this.$route.params.slug;
                axios.get('/api/getProductDetail/' + slug)
                .then(response => {
                    console.log(response.data.product[0]);
                    this.productDetail = response.data.product[0];
                    this.mainImage = response.data.product[0].product_img[0].url;
                    this.slides = response.data.product[0].product_img;
                    this.options2.responsive[0].settings.slidesToShow =  response.data.product[0].product_img.length;
                    this.path.category = response.data.product[0].category;
                    this.path.productType = response.data.product[0].product_type;
                    //this.isLoading = false;
                    Fire.$emit('offLoading');
                    console.log("idproduct " + response.data.product[0].id);
                    this.getComment( response.data.product[0].id);
                    this.productId = response.data.product[0].id;
                })
                
                
            },
            postCommment() {
                console.log("idComment " + this.productId);
                axios.post('/api/comment/' + this.productId, this.formMessage)
                .then(response => {
                    console.log(response.data.comment);
                    this.comment = response.data.comment;
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                     });
                     //current.$router.push({path: '/home'});
                    Fire.$emit('comment');
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
             User() {
                axios.get('/api/checklogin')
                .then(response => {
                    console.log(response.data.data);
                    this.auth = response.data.data;
                })
            },
            getComment(id) {
                console.log("idGetComment " + id);
                axios.get('/api/getAllCommentByIdProduct/'+id)
                .then(response => {
                    console.log(response.data.comment);
                    this.allComment = response.data.comment;
                })
            },
            login() {
                 axios.post('/api/login', this.form)
                .then(response => {
                    console.log(response.data.data);
                    let auth = response.data.data;
                    this.$store.commit('login', auth);
                    if (!auth || auth.length === 0) {
                            Toast.fire({
                            icon: 'error',
                            title: response.data.message
                        });
                    }else{
                        Toast.fire({
                        icon: 'success',
                        title: response.data.message
                     });
                     //current.$router.push({path: '/home'});
                    }
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            formatPrice(price) {
                let formatedNumber = price || 0;
                return stringUtil.formatNumber(formatedNumber);
            },
            addToCart(){
                var current = this;
                if (this.$store.state.auth == null){
                    current.$router.push({name: 'login'});
                } else {
                    console.log(parseInt(this.quantity));
                    console.log("product " + this.productDetail.quantity);
                    if (parseInt(this.quantity) > this.productDetail.quantity) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Số lượng sản phẩm không đủ đáp ứng...',
                            text: 'Vui lòng mua dưới ' + (parseInt(this.productDetail.quantity) + 1) + ' sản phẩm',
                        })
                    }else {
                        Toast.fire({
                            icon: 'success',
                            title: 'Thêm vào giỏ hàng thành công'
                        });
                        this.$store.commit('addToCart', {product: this.productDetail, quantity: parseInt(this.quantity), total: this.productDetail.price * this.quantity});

                    }


                }

            },
            switchImage(index){
                this.$refs.thumbnails.goTo(index);
                this.mainImage = this.slides[index].url;
            },

            spinner() {
                //  SPINNER
                $("#spinner").spinner();

                //  INPUT ONLY NUMBERS
                $('#spinner').keyup(function () {
                    this.value = this.value.replace(/[^0-9]/g,'');
                });
            },
            maxLengthCheck(object) {
                if (object.value.length > object.maxLength)
                    object.value = object.value.slice(0, object.maxLength)
            }

        },
        created() {
            this.getProductDetail();
            this.User();
            //this.getComment();
            Fire.$on('comment', ()=>{
               this.getComment(this.productId);
            });
            Fire.$on('productDetail', ()=>{
                this.getProductDetail();
            });
            this.spinner();
            window.onload = spinner;
        }
    }
</script>

<style scoped>
    /*input[type="number"] {*/
        /*outline: none;*/
        /*-moz-appearance: textfield;*/
    /*}*/
    /*input[type=number]::-webkit-inner-spin-button,*/
    /*input[type=number]::-webkit-outer-spin-button {*/
        /*-webkit-appearance: none;*/
        /*appearance: none;*/
    /*}*/

ul.a {
    list-style-type: circle;
    margin-left: 30px;
}


.main {
    margin-bottom: 30px;
}

.thumbnails {
    margin: 0 -5px;
    width: calc(100% + 10px);
}

.agile__nav-button {
    background: transparent;
    border: none;
    color: #ccc;
    cursor: pointer;
    font-size: 24px;
    -webkit-transition-duration: 0.3s;
    transition-duration: 0.3s;
}
.agile__nav-button .agile__nav-button {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
}
.agile__nav-button .agile__nav-button--prev {
    left: -45px;
}
.agile__nav-button .agile__nav-button--next {
    right: -45px;
}
.agile__nav-button:hover {
    color: #888;
}
.agile__dot {
    margin: 0 10px;
}
.agile__dot button {
    background-color: #eee;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: block;
    height: 10px;
    font-size: 0;
    line-height: 0;
    margin: 0;
    padding: 0;
    -webkit-transition-duration: 0.3s;
    transition-duration: 0.3s;
    width: 10px;
}
.agile__dot--current button, .agile__dot:hover button {
    background-color: #888;
}

.slide {
    -webkit-box-align: center;
    align-items: center;
    box-sizing: border-box;
    color: #fff;
    display: -webkit-box;
    display: flex;
    height: 450px;
    -webkit-box-pack: center;
    justify-content: center;
}
.slide--thumbniail {
    cursor: pointer;
    height: 100px;
    padding: 0 5px;
    -webkit-transition: opacity 0.3s;
    transition: opacity 0.3s;
}
.slide--thumbniail:hover {
    opacity: 0.75;
}
.slide img {
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
    -o-object-position: center;
    object-position: center;
    width: 100%;
}

</style>
