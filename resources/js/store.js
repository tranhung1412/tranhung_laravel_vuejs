import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

let cart = window.localStorage.getItem('cart');
let cartCount = window.localStorage.getItem('cartCount');
let auth = window.localStorage.getItem('auth');
let totalNum = window.localStorage.getItem('totalNum');
export default new Vuex.Store({
    state: {
        cart: cart ? JSON.parse(cart) : [],
        cartCount: cartCount ? JSON.parse(cartCount) : 0,
        search: null,
        auth: auth ? JSON.parse(auth) : null,
        totalNum: totalNum ? JSON.parse(totalNum) : 0,
    },

    mutations: {
        addToCart(state, item){
            let found  = state.cart.find(product  => product.product.id == item.product.id )
            if (found){
                found.quantity += item.quantity;
                if(found.quantity > item.product.quantity){
                    found.quantity -= item.quantity;
                    Swal.fire({
                        icon: 'error',
                        title: 'Số lượng sản phẩm không đủ đáp ứng...',
                        text: 'Vui lòng mua không vượt quá ' + (parseInt(item.product.quantity)) + ' sản phẩm',
                    })
                }
            }else{
                state.cartCount += item.quantity;
                state.cart.push(item);
            }

            this.commit('saveData');
        },

        updateCart(state, item){
            state.cart = item.cart;
            state.totalNum = item.total;
            this.commit('saveData');
        },

        searchinit(state, item){
            state.search = item;
        },
        login(state, item){
            state.auth = item;
            this.commit('saveData');
        },

        logout(state){
            state.auth = null;
            this.commit('saveData');
        },

        removeAllCart(state){
            state.cart = [];
            totalNum = 0;
            cartCount = 0;
            this.commit('saveData');
        },

        saveData(state){
            window.localStorage.setItem('cart', JSON.stringify(state.cart));
            window.localStorage.setItem('cartCount', JSON.stringify(state.cartCount));
            window.localStorage.setItem('auth', JSON.stringify(state.auth));
            window.localStorage.setItem('totalNum', JSON.stringify(state.totalNum));
        },

        removeFromCart(state, item){
            let index = state.cart.indexOf(item);
            state.cartCount -= item.quantity;
            state.cart.splice(index, 1);
            this.commit('saveData');
        }
    }

})
