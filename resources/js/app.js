/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

require('./common');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('post', require('./components/Post.vue').default);
Vue.component('comment', require('./components/Comment.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to   
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        laravel: laravel,
        loading: false,
        posts: [],
        comment_count: [],
        input_search: '',
    },
    mounted() {
        params = location.href.split('/').slice(3);
        if(params[0] == '') {
            this.load_posts();
            _this = this;
            $(window).scroll(function(){
                if(!this.loading && (this.scrollY+document.body.clientHeight) >= $("body").height()-200) {
                    this.loading = true;
                    _this.load_posts();
                }
            });
        }
    },
    methods: {
        search: function () {
            location.href = '/search/' + this.input_search;
        },
        load_posts: function () {
            axios.post('/load/posts/'+this.posts.length)
                .then(res => {
                    this.posts = this.posts.concat(res.data);
                    this.loading = false;
                })
                .catch(res => {
                    alert('게시물을 불러오는 중 오류가 발생했습니다.');
                });
        }
    }
});
