<template>
    <div>
        <Banner></Banner>
        <Policy></Policy>
        <ListProduct></ListProduct>
        <ListPost></ListPost>
    </div>
</template>

<script>

    import Banner from "./Banner";
    import Policy from "./Policy";
    import ListProduct from "./ListProduct";
    import ListPost from "./ListPost";
    export default {
        name: "Home",
        components: {ListPost, ListProduct, Policy, Banner}
    }
</script>

<style scoped>

</style>
