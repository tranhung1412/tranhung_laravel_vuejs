<template>
    <div id="public">
        <!-- Page Preloder -->
        <!--<div id="preloder">-->
            <!--<div class="loader"></div>-->
        <!--</div>-->
        <Header></Header>
        <ProductDetail></ProductDetail>
        <Footer></Footer>
    </div>
</template>

<script>
    import Header from "../customer/Header";
    import Footer from "../customer/Footer";
    import ProductDetail from "../customer/productDetail/ProductDetail";


    export default {
        name: "ProductDetailView",
        components: {Footer, Header, ProductDetail}
    }
</script>

<style scoped>

</style>
