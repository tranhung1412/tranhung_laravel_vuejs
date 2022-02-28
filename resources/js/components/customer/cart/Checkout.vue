<template>
    <div>
        <!-- Shopping Cart Section Begin -->
        <div class="checkout-section spad">
            <div class="container">
                <div class="checkout-form">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Chi tiết đơn hàng</h4>
                            <div class="place-order">
                                <h4>Địa chỉ của bạn</h4>
                                <div class="order-total">
                                    <div class="order-table">
                                        <div class="checkout-address">
                                            <h5 style="color: rgba(231, 172, 60, 1);"><i
                                                class="fas fa-map-marker-alt"></i> Địa Chỉ Nhận Hàng
                                            </h5>
                                            <a v-if="checkChange" @click="showChange"
                                               style="float: right; font-size: 16px; color: #0a90eb;">Thay
                                                đổi</a>
                                            <div v-if="checkChange == false" style="float: right">
                                                <button  @click="showModal">Thêm địa chỉ mới
                                                </button>
                                                <button>Thiêt lập địa chỉ</button>
                                            </div>
                                            <div v-if="checkChange == false" class="row" style="clear: right"
                                                 v-for="(item, index) in customer" :key="index">
                                                <div class="col-form-label col-sm-1 pt-0">
                                                    <div class="form-check">
                                                        <input v-if="item.active == true" @click="changeAddress(item)"
                                                               class="form-check-input" type="radio"
                                                               name="publication_status" checked
                                                        >
                                                        <input v-else class="form-check-input"
                                                               type="radio" @click="changeAddress(item)"
                                                               name="publication_status"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-sm-11">
                                                    <label>{{item.name}} ({{item.phone}}) </label>
                                                    <p>{{item.address}}</p>
                                                </div>
                                            </div>
                                            <div>
                                                <div v-if="addressDefault != null & checkChange == true" class="row" style="clear: right">
                                                    <div class="col-form-label col-sm-1 pt-0">
                                                        <div class="form-check">
                                                            <input v-if="addressDefault.active" @click="changeAddress(item)"
                                                                   class="form-check-input" type="radio"
                                                                   name="publication_status" checked
                                                            >
                                                            <input v-else class="form-check-input"
                                                                   type="radio" @click="changeAddress(item)"
                                                                   name="publication_status"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-11">
                                                        <label>{{addressDefault.name}} ({{addressDefault.phone}}) </label>
                                                        <p>{{addressDefault.address}}</p>
                                                    </div>
                                                </div>
                                                <div v-if="addressDefault == null" class="row" style="clear: right">
                                                    <div class="col-sm-12">
                                                        Bạn chưa thêm địa chỉ nhận hàng
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="checkChange == false">
                                        <button class="site-btn place-btn" @click="updateAddress">
                                            Hoàn thành
                                        </button>
                                        <button @click="checkChange = true"
                                                style="float: right; background-color: #0b0b0b"
                                                class="site-btn place-btn">
                                            Trở lại
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">

                            <div class="place-order">
                                <h4>Đơn hàng của bạn</h4>
                                <div class="order-total">
                                    <ul class="order-table">
                                        <li>Sản phẩm <span>Thành tiền</span></li>
                                        <li class="fw-normal" v-for="(cart, index) in this.$store.state.cart" :key="index">{{cart.product.name}} x {{cart.quantity}} <span>{{cart.total}}</span>
                                        </li>
                                        <!--<li class="fw-normal">Subtotal <span>{{this.$store.state.totalNum}}</span></li>-->
                                        <li class="total-price">Tổng cộng <span>{{formatSubTotalPrice()}}</span></li>
                                    </ul>
                                    <div class="payment-check">
                                        <div class="pc-item">
                                            <label for="pc-check">
                                                Cheque Payment
                                                <input type="checkbox" id="pc-check">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="pc-item">
                                            <label for="pc-paypal">
                                                Paypal
                                                <input type="checkbox" id="pc-paypal">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="order-btn">
                                        <button @click="checkout" type="submit" class="site-btn place-btn">Đặt hàng
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Shopping Cart Section End -->

        <!-- Modal -->
        <div  class="modal fade" id="myModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div  class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-success">Thêm 1 địa chỉ mới</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="addAddress()">
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Họ & tên</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input v-model="form.phone" type="text" name="phone"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('phone') }">
                                <has-error :form="form" field="slug"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input v-model="form.address" type="text" name="address"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('address') }">
                                <has-error :form="form" field="slug"></has-error>
                            </div>
                            <div v-if="addressDefault" class="form-check">
                                <input v-model="form.active" type="checkbox"
                                       class="form-check-input">
                                <label class="form-check-label">Check me
                                    out</label>
                            </div>
                            <div v-else class="form-check">
                                <input v-model="form.active = 1" type="checkbox" checked disabled
                                       class="form-check-input">
                                <label class="form-check-label">Check me
                                    out</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-primary">Save
                                changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <LoadingAnition :isLoadingAnimation="isLoading"></LoadingAnition>
    </div>
</template>

<script>
    import LoadingAnition from "../../customer/LoadingAnimation";
    import StringUtil from "../../../utils/StringUtils"
    const stringUtil = new StringUtil();
    export default {
        name: "Checkout",
        components:{LoadingAnition},
        data() {
            return {
                checkChange: true,
                form: new Form({
                    idUser: '',
                    name: '',
                    phone: '',
                    address: '',
                    active: 0
                }),
                customer: [],
                selectedItem: null,
                addressDefault: null,
                display: false,
                order:{
                    customer: [],
                    cart: [],
                    totalNum: '',
                    idUser: '',
                    email: ''
                },
                isLoading: false
            }
        },
        methods: {
            show() {
                checkChange: true;

            },
            showChange(){
              this.checkChange = false;
              this.getAddressCustomer();

            },
            showModal(){
                this.form.reset();
                this.form.idUser = this.$store.state.auth.id;
                $('#myModal').appendTo("body").modal('show');
            },
            addAddress() {
                // this.form.reset();
                var current = this;
                this.form.post('/api/admin/customer', this.form)
                .then(function (response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    $('#myModal').appendTo("body").modal('hide');
                    Fire.$emit('allCustomer');
                    if (current.selectedItem == null){
                        current.selectedItem = response.data.customer;
                    }
                    Fire.$emit('getCustomer');
                    //this.customer = response.data;

                })
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
            changeAddress(item){
               this.selectedItem = item ;
            },
            updateAddress() {
                axios.put('/api/admin/customer/'+ this.selectedItem.id, this.selectedItem)
                .then(response => {
                    console.log(response.data);
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    Fire.$emit('getCustomer');
                });

                this.checkChange = true;
            },
            checkout(){
                this.isLoading = true;
                this.order.customer = this.selectedItem;
                this.order.cart = this.$store.state.cart;
                this.order.totalNum = this.$store.state.totalNum;
                this.order.idUser = this.$store.state.auth.id;
                this.order.email = this.$store.state.auth.email;
                axios.post('/api/admin/cart', this.order)
                .then(response => {
                    console.log(response.data);
                    this.isLoading = false;
                    Toast.fire({
                        icon: 'success',
                        title: 'Đặt hàng thành công'
                    });
                    this.$router.push({name: 'home'});
                    this.$store.commit('removeAllCart');

                })
            },
            getAddressCustomer() {
                console.log("getAddressCustomer");
                axios.get('/api/admin/customer')
                .then(response => {
                    console.log(response.data);
                    this.customer = response.data;
                })
            },
            getAddressCustomerActive() {
                console.log("getAddressCustomerActive");
                axios.get('/api/getCustomerAddressActive')
                .then(response => {
                    console.log("bbbbbb");
                    console.log(response.data);
                    this.addressDefault = response.data[0];
                    this.selectedItem = response.data[0];
                })
            }
        },
        // watch:{
        //     selectedItem: function(newData) {
        //         this.selectedItem = newData;
        //         this.selectedItem.active = true;
        //     },
        //     addressDefault: function(newData) {
        //         this.addressDefault = newData;
        //         this.addressDefault.active = true;
        //     },
        //     customer: function(newData) {
        //         this.customer = newData;
        //     }
        // },
        created() {
            this.form.idUser = this.$store.state.auth.id;
            this.getAddressCustomerActive();
            this.getAddressCustomer();
            Fire.$on('allCustomer', ()=>{
               this.getAddressCustomer();
            });
            Fire.$on('getCustomer', ()=>{
                this.getAddressCustomerActive();
            });
        }
    }
</script>

<style scoped>
    /*.modal-backdrop {*/
        /*z-index: 1040 !important;*/
    /*}*/
    /*.modal-dialog {*/
        /*margin: 2px auto;*/
        /*z-index: 1100 !important;*/
    /*}*/
</style>
