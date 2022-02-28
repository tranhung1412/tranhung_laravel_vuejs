<template>
    <div id="loading" v-if="isLoadingAnimation" class="fullscreenDiv">
        <div class="fixed-bottom">
            <div class="text-center float-right">
                <div class="spinner-border " style="width: 4rem; height: 4rem;" role="status">
                </div>
                <p>Loading...</p>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "LoadingAnimation",
        props:{
            isLoadingAnimation: Boolean,
        },
    }
</script>

<style scoped>
    .fullscreenDiv {
        background-color: rgba(232, 232, 232, 0.48);
        width: 100%;
        height: auto;
        bottom: 0px;
        top: 0px;
        left: 0;
        position: absolute;
        z-index: 2;
    }
</style>
