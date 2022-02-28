<template>
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row" style="width: 100%">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <router-link to="/home" style="position: relative;"><i class="fa fa-home"></i> Home
                        </router-link>
                        <router-link  v-if="path.productType != null" style="position: relative;" :to="{name : 'product-category', params:{slugCategory: path.category.slug}}">{{path.category.name}}</router-link>
                        <router-link v-else :to="{name : 'product-category', params:{slugCategory: path.category.slug}}">{{path.category.name}}</router-link>
                        <router-link v-if="path.productType != null" :to="{name : 'product-productType', params:{slugCategory: path.category.slug , slugProductType: path.productType.slug}}">{{path.productType.name}}</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->
</template>

<script>
    export default {
        name: "Section",
        props: {
            path: Object
        },

    }
</script>

<style scoped>

</style>
