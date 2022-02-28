<template>
    <div style="clear: both">
        <div class="slide"></div>

        <h2>Abc</h2>
        <div id="main">
            <h1>Vue isotope</h1>

            <h2>Filter</h2>
            <div class="button-group">
                <button v-for="(val, key) in option.getFilterData" class="button" :class="[key===filterOption? 'is-checked' : '']" @click="filter(key)">{{key}}
                </button>
            </div>

            <h2>Sort</h2>
            <div class="button-group">
                <button class="button" :class="[sortOption==='original-order'? 'is-checked' : '']" @click="sort('original-order')">original order</button>
                <button v-for="(val, key) in option.getSortData" class="button" :class="[key===sortOption? 'is-checked' : '']" @click="sort(key)">{{key}}</button>
            </div>

            <h2>Layout</h2>
            <div>
                <button v-for="layout in layouts" :class="[layout===currentLayout? 'is-checked' : '']" class="button" @click="changeLayout(layout)">
                    {{layout}}
                </button>
            </div>

            <isotope ref="cpt" id="root_isotope1" :item-selector="'element-item'" :list="list" :options='option' @filter="filterOption=arguments[0]" @sort="sortOption=arguments[0]" @layout="currentLayout=arguments[0]">
                <div v-for="element,index in list" :class='[element.category]'  :key="index">
                    <h3 class="name">{{element.name}}</h3>
                    <p class="symbol">{{element.symbol}}</p>
                    <p class="number">{{element.number}}</p>
                    <p class="weight">{{element.weight}}</p>
                </div>
            </isotope>
        </div>

    </div>
</template>

<script>
    import isotope from "vueisotope"
    export default {
        name: "Owl",
        components:{
            isotope
        },
        data(){
            return{
                firstName: "foo",
                products: [],
                layouts: [
                    "masonry",
                    "fitRows",
                    "cellsByRow",
                    "vertical",
                    "packery",
                    "masonryHorizontal",
                    "fitColumns",
                    "cellsByColumn",
                    "horiz"
                ],
                list: [{
                    name: "Mercury",
                    symbol: "Hg",
                    number: 80,
                    weight: 200.59,
                    category: "transition",
                    metal: true
                }, {
                    name: "Tellurium",
                    symbol: "Te",
                    number: 52,
                    weight: 127.6,
                    category: "metalloid"
                }, {
                    name: "Bismuth",
                    symbol: "Bi",
                    number: 83,
                    weight: 208.980,
                    category: "post-transition",
                    metal: true
                }, {
                    name: "Lead",
                    symbol: "Pb",
                    number: 82,
                    weight: 207.2,
                    category: "post-transition",
                    metal: true
                }, {
                    name: "Gold",
                    symbol: "Au",
                    number: 79,
                    weight: 196.967,
                    category: "transition",
                    metal: true
                }, {
                    name: "Potassium",
                    symbol: "K",
                    number: 19,
                    weight: 39.0983,
                    category: "alkali",
                    metal: true
                }, {
                    name: "Sodium",
                    symbol: "Na",
                    number: 11,
                    weight: 22.99,
                    category: "alkali",
                    metal: true
                }, {
                    name: "Cadmium",
                    symbol: "Cd",
                    number: 48,
                    weight: 112.411,
                    category: "transition",
                    metal: true
                }, {
                    name: "Calcium",
                    symbol: "Ca",
                    number: 20,
                    weight: 40.078,
                    category: "alkaline-earth",
                    metal: true
                }, {
                    name: "Rhenium",
                    symbol: "Re",
                    number: 75,
                    weight: 186.207,
                    category: "transition",
                    metal: true
                }, {
                    name: "Ytterbium",
                    symbol: "Yb",
                    number: 70,
                    weight: 173.054,
                    category: "lanthanoid"
                }, ],
                currentLayout: 'masonry',
                selected: null,
                sortOption: "original-order",
                filterOption: "show all",
                option: {
                    itemSelector: ".element-item",
                    getFilterData: {
                        "show all": function() {
                            return true;
                        },
                        metal: function(el) {
                            return !!el.metal;
                        },
                        transition: function(el) {
                            return el.category === "transition";
                        },
                        "alkali and alkaline-earth": function(el) {
                            return el.category === "alkali" || el.category === "alkaline-earth";
                        },
                        "not transition": function(el) {
                            return el.category !== "transition";
                        },

                        "metal but not transition": function(el) {
                            return !!el.metal && el.category !== "transition";
                        },
                        "number > 50": function(el) {
                            return el.number > 50;
                        },
                        "name ends with ium": function(el) {
                            return el.name.match(/ium$/);
                        }
                    },
                    getSortData: {
                        name: "name",
                        symbol: "symbol",
                        number: "number",
                        weight: "weight",
                        category: "category"
                    }
                }
            }
        },
        created() {
            this.getAllProduct();
        },
        methods: {
            // getAllProduct() {
            //     //Fire.$emit('onLoading');
            //     return new Promise((resolve, reject) => {
            //         axios.get('/api/getAllProduct')
            //         .then(response => {
            //             console.log(response.data.product);
            //             this.products = response.data.product;
            //             //Fire.$emit('offLoading');
            //         })
            //     })
            // },
            getAllProduct() {
                return new Promise((resolve, reject) => {
                    axios.get('/api/getAllProduct').then((data) => {
                        this.products = data.data.product;
                        resolve();
                    }).catch(error => reject(error));
                });
            },
            sort: function(key) {
                this.$refs.cpt.sort(key);
            },
            filter: function(key) {
                this.$refs.cpt.filter(key);
            },
            changeLayout: function(key) {
                this.$refs.cpt.layout(key);
            }
        },
        mounted() {
                // this.getAllProduct().then(() => {
                //     $('.owl-carousel').owlCarousel({
                //         loop:true,
                //         margin:10,
                //         nav:true,
                //         responsive:{
                //             0:{
                //                 items:1
                //             },
                //             600:{
                //                 items:3
                //             },
                //             1000:{
                //                 items:5
                //             }
                //         }
                //     });
                // })
        },
        // watch: {
        //     products: function (value) {
        //         if (value) {
        //             jQuery(document).ready(function () {
        //                 $('.owl-carousel').owlCarousel({
        //                     loop:true,
        //                     margin:10,
        //                     nav:true,
        //                     responsive:{
        //                         0:{
        //                             items:1
        //                         },
        //                         600:{
        //                             items:3
        //                         },
        //                         1000:{
        //                             items:5
        //                         }
        //                     }
        //                 })
        //             });
        //         }
        //     }
        // }
    }
</script>

<style scoped>
@import "../../../../../public/assets/customer/OwlCarousel2/dist/assets/owl.carousel.css";
@import "../../../../../public/assets/customer/OwlCarousel2/dist/assets/owl.theme.default.min.css";
</style>
