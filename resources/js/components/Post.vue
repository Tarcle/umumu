<template>
    <div class="post">
        <div class="top">
            <a :href="'/profile/'+post.userid" class="profile" :style="{ 'background-image': 'url(/img/'+post.writer+'.jpg)' }"></a>
            <a class="name" :href="'/profile/' + post.userid">{{ post.name }}</a>
        </div>
        <div class="meta">
            <span class="timestamp">{{ display_datetime(post.created_at) }}</span>
            <!-- <span class="target"></span> -->
        </div>
        <div class="content">{{ post.body }}</div>
        <div class="btn">
            <button class="like" :class="{ on: 0 }">좋아요</button>
            <button class="comment" @click="load_comment(post.id)">댓글 {{ comment_count }}개</button>
            <button class="share">공유</button>
        </div>
        <div class="comments" v-if="loading==2">
            <div is="comment" v-for="(comment,i) in comments" :comment="comment" :key="i"></div>
        </div>
        <div class="comments" v-else-if="loading==1"><div style="text-align:center">불러오는 중</div></div>
        <div v-if="loading>0" :action="'/write/comment/'+post.id" method="POST" class="comment-write">
            <input type="hidden" name="_token" :value="laravel.csrfToken">
            <input type="hidden" name="reply" :value="reply">
            <textarea name="content" v-model="content" placeholder="댓글을 달아보세요." @keypress="(e)=>keypress_button(e,write_comment)"></textarea>
            <button @click="write_comment">댓글 달기</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'post',
        ],
        data() {
            return {
                laravel: laravel,
                comment_count: 0,
                comments: [],
                reply: 0,
                loading: 0, //0:not loading, 1:loading, 2:loaded
                content: '',
            }
        },
        mounted() {
            axios.post('/load/comment_count/'+this.post.id)
                .then(res => {
                    this.comment_count = res.data;
                });
        },
        methods: {
            load_comment: function () {
                this.loading = 1;
                axios.post('/load/comments/'+this.post.id)
                    .then(res => {
                        this.loading = 2;
                        this.comments = res.data;
                    })
                    .catch(res => {
                        alert('댓글을 불러오는 중 오류가 발생했습니다.');
                    });
            },
            write_comment: function () {
                var content = this.content;
                this.content = '';
                axios.post('write/comment/'+this.post.id, {
                        _token: this.laravel.csrfToken,
                        reply: this.reply,
                        content: content,
                    })
                    .then(res => {
                        this.load_comment();
                    })
                    .catch(res => {
                        alert('댓글 작성에 실패했습니다.');
                    });
            }
        }
    }
</script>