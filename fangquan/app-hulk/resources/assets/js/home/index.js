(function ($, Vue) {
    var $form = $('form');
    Vue.component('example', require('../components/Example.vue'));
    const app = new Vue({
        el: '#app',
        data: {
            name: '小明',
            age: 10,
        }
    });

})(jQuery, Vue);