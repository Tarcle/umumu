<template>
    <div class="comments">
        <div v-for="(comment,i) in comments" class="comment" :key="i">
            <div class="top">
                <a href="/profile/tarcle1" class="profile" style="background-image: url(/img/2.jpg)"></a>
                <a class="name" href="/profile/tarcle1">{{ comment.name }}</a>
                <span class="timestamp"></span>
            </div>
            <div class="content">{{ comment.content }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'post'
        ],
        data() {
            return {
                laravel: laravel,
                comments: [],
            }
        },
        mounted() {
            //
        },
    }
</script>