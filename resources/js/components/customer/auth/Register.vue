<template>
    <div>
        <!-- Breadcrumb Section Begin -->
        <div class="breacrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-text">
                            <a href="#"><i class="fa fa-home"></i> Trang Chủ</a>
                            <span>Đăng Ký</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Form Section Begin -->

        <!-- Register Section Begin -->
        <div class="register-login-section spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="register-form">
                            <h2>Đăng Ký</h2>
                            <form @submit.prevent="register">
                                <div class="group-input">
                                    <label for="username">Tên người dùng</label>
                                    <input type="text" id="username" v-model="form.name">
                                </div>
                                <div class="group-input">
                                    <label for="email"> Địa chỉ e-mail *</label>
                                    <input type="email" id="email" v-model="form.email" >
                                </div>
                                <div class="group-input">
                                    <label for="password">Mật khẩu *</label>
                                    <input type="password" id="password" v-model="form.password">
                                </div>
                                <div class="group-input">
                                    <label for="re_password">Nhập lại mật khẩu *</label>
                                    <input type="password" id="re_password" v-model="form.re_password" >
                                </div>
                                <button type="submit" class="site-btn register-btn">ĐĂNG KÝ</button>
                            </form>
                            <div class="switch-login">
                                <router-link :to="{name : 'login'}" class="or-login">ĐĂNG NHẬP</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register Form Section End -->

        <!-- Partner Logo Section Begin -->
        <div class="partner-logo">
            <div class="container">
                <div class="logo-carousel owl-carousel">
                    <div class="logo-item">
                        <div class="tablecell-inner">
                            <img src="img/logo-carousel/logo-1.png" alt="">
                        </div>
                    </div>
                    <div class="logo-item">
                        <div class="tablecell-inner">
                            <img src="img/logo-carousel/logo-2.png" alt="">
                        </div>
                    </div>
                    <div class="logo-item">
                        <div class="tablecell-inner">
                            <img src="img/logo-carousel/logo-3.png" alt="">
                        </div>
                    </div>
                    <div class="logo-item">
                        <div class="tablecell-inner">
                            <img src="img/logo-carousel/logo-4.png" alt="">
                        </div>
                    </div>
                    <div class="logo-item">
                        <div class="tablecell-inner">
                            <img src="img/logo-carousel/logo-5.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Partner Logo Section End -->
    </div>
</template>

<script>
    export default {
        name: "Register",
         data() {
            return {
                form: new Form({
                    name:'',
                    email:'',
                    password:'',
                    re_password:'',
                }),
            }
        },
        methods: {
            register() {
                var current = this;
                 axios.post('/api/registerClient', this.form)
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
                     current.$router.push({path: '/home'});
                    }
                    $('#exampleModal').modal('hide');
                    Fire.$emit('afterSaveChange');
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
        },

        created() {
            //this.login();
        }

    }
</script>

<style scoped>

</style>
