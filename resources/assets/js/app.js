
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('../../../node_modules/owl.carousel/dist/owl.carousel.min.js');

$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        dots: false,
        loop: true,
        margin: 20,
        nav: true,
        navContainer: '.owl-carousel',
        navText: [
            '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
            '<i class="fa fa-chevron-right" aria-hidden="true"></i>'
        ],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3,
            }
        }
    });
});

window.Vue = require('vue');
window.Bus = new Vue();
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('checkout-form', require('./components/CheckoutForm.vue'));

const app = new Vue({
    data: {
        user: WWD.user
    },
    el: '#app',
});
