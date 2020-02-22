<template>
    <div class="comment">
        <div class="top">
            <a href="/profile/userid" class="profile" :style="'background-image: url(/img/'+comment.writer+'.jpg)'"></a>
            <a class="name" :href="'/profile/'+comment.userid">{{ comment.name }}</a>
            <span class="timestamp">{{ display_datetime(comment.created_at) }}</span>
        </div>
        <div class="content">{{ comment.comment }}</div>
    </div>
</template>

<script>
    export default {
        props: [
            'comment',
        ],
        data() {
            return {
                laravel: laravel,
            }
        },
        mounted() {
            //
        },
    }
</script>