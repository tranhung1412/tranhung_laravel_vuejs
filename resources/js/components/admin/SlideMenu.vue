<template>
    <div>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <!--<img src="{{asset('assets/admin/image/AdminLTELogo.png')}}"-->
                <img src="../../../../public/assets/admin/image/AdminLTELogo.png"
                    alt="AdminLTE Logo"
                     class="brand-image img-circle elevation-3"
                     style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../../../public/assets/admin/image/admin.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Tran Hung</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2"  v-for="(user, index) in users" :key="`${index}-${user.id}`">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" >
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->
                        <li class="nav-item" >
                            <router-link to="/admin/dashboard" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Dashboard
                                    
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item" v-for="(permission, index_permission) in user.permissions" :key="`${index_permission}-${permission.id}`">
                            <router-link :to="{ name: permission.slug}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    {{permission.name}}
                                    
                                </p>
                            </router-link>
                        </li>
                         <li class="nav-item" >
                            <router-link to="/admin/blog" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Blog
                                    
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/admin/order" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Order
                                    
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item" @click="logout">
                            <a href="/loginAdmin" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Logout
                                    
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
    </div>
</template>

<script>
    export default {
        name: "SildeMenu",
         data() {
            return {
                users:[],
            }
        },
        methods: {
             logout() {
                axios.get('/api/logout')
                .then(response => {
                    console.log(response.data);

                })
            },
            getPermissionUserLogin(){
                 axios.get('/api/getPermissionUserLogin')
                .then(response => {
                    console.log(response.data.user);
                    this.users = response.data.user;
                })
            }
        },
        created() {
            this.getPermissionUserLogin();
            
        }
    }
</script>

<style scoped>

</style>
