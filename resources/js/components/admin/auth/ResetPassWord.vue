<template>
    <div>
        <!-- Breadcrumb Section Begin -->
        <div class="breacrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-text">
                            <a href="#"><i class="fa fa-home"></i> Home</a>
                            <span>Reset Password</span>
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
                        <div class="login-form">    
                            <h2>Reset Password</h2>
                             <form @submit.prevent="restPassword">
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" v-model="form.password" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="re_password" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                    <div class="col-md-6">
                                        <input id="re_password" type="password" class="form-control" v-model="form.re_password" required>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label for="code" class="col-md-4 col-form-label text-md-right">Code</label>

                                    <div class="col-md-6">
                                        <input id="code" type="text" class="form-control" v-model="form.code" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Reset Password
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
</template>

<script>
    export default {
        name: "RestPassword",
        data() {
            return {
                form: new Form({
                    password:'',
                    re_password:'',
                    code:''
                }),
            }
        },
        methods: {
            restPassword(){
                var current=this;
                this.form.post('/api/password_reset', this.form)
                .then(function (response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                     current.$router.push({path: '/loginAdmin'});
                })
                .catch(function (error) {
                    console.log(error);
                })
            }
        },

        created() {
            //this.login();
        }
    }
</script>

<style scoped>

</style>