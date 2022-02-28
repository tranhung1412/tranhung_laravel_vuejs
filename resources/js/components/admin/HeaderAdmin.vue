<template>
    <div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Trang Chủ</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Liên Hệ</a>
                </li>
            </ul>
            <!-- SEARCH FORM -->
            <div class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input v-model="textSearch" @keyup.enter="search"  class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit" @click.prevent="search">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right navbar links -->
            
        </nav>
        <!-- /.navbar -->
    </div>
</template>

<script>
    export default {
        name: "Header",
        data(){
            return{
                textSearch: ""
            }
        },
        methods:{
            search(){
                var current = this;
                if (current.textSearch === ""){
                    console.log("nullll");
                    current.textSearch = null;
                }
                this.$store.commit('searchinit', current.textSearch);
                Fire.$emit('search');
            }
        }
    }
</script>

<style scoped>
    @import "~admin-lte/dist/css/adminlte.min.css";
    @import "~admin-lte/plugins/fontawesome-free/css/all.css";
</style>
