<template>
    <div>
        <Header></Header>
        <SlideMenu></SlideMenu>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <router-view/>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.content -->
            <!-- /.content-wrapper -->
        </div>
    </div>
</template>

<script>
    import Header from "./admin/HeaderAdmin";
    import SlideMenu from "./admin/SlideMenu";
    
    
    export default {
        components: {
            Header,
            SlideMenu
        },
    }
</script>

<style scoped>
    @import "~admin-lte/dist/css/adminlte.min.css";
    @import "~admin-lte/plugins/fontawesome-free/css/all.css";
</style>
