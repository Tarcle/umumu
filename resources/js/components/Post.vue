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
            <button class="like">좋아요</button>
            <button class="comment" @click="load_comment(post.id)">댓글 {{ laravel.comment_count[post.id] ? laravel.comment_count[post.id] : 0 }}개</button>
            <button class="share">공유</button>
        </div>
        <div is="comments" :post="post"></div>
        <form v-if="comment_on" :action="'/write/comment/'+post.id" class="comment-write">
            {{ laravel.csrf }}
            <textarea name="comment" placeholder="댓글을 달아보세요."></textarea>
            <button type="submit">댓글 달기</button>
        </form>
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
                comment_on: false,
            }
        },
        mounted() {
            //
        },
        methods: {
            load_comment: function (postid) {
                this.comment_on = true;
            },

            display_datetime: function (date) {
                var now = new Date();

                var writeDay = new Date(date);
                var minus;
                if(now.getFullYear() > writeDay.getFullYear()) {
                    minus = now.getFullYear()-writeDay.getFullYear();
                    return minus+"년 전";
                } else if(now.getMonth() > writeDay.getMonth()) {
                    //년도가 같을 경우 달을 비교해서 출력
                    minus = now.getMonth()-writeDay.getMonth();
                    return minus+"달 전";
                } else if(now.getDate() > writeDay.getDate()) {
                    //같은 달일 경우 일을 계산
                    minus = now.getDate()-writeDay.getDate();
                    return minus+"일 전";
                } else if(now.getDate() == writeDay.getDate()) {
                    //당일인 경우에는
                    var nowTime = now.getTime();
                    var writeTime = writeDay.getTime();
                    if(nowTime>writeTime) {
                        //시간을 비교
                        sec = parseInt(nowTime - writeTime) / 1000;
                        day = parseInt(sec/60/60/24);
                        sec = (sec - (day * 60 * 60 * 24));
                        hour = parseInt(sec/60/60);
                        sec = (sec - (hour*60*60));
                        min = parseInt(sec/60);
                        sec = parseInt(sec-(min*60));
                        if(hour>0) {
                            //몇시간전인지
                            return hour+"시간 전";
                        } else if(min>0) {
                            //몇분전인지
                            return min+"분 전";
                        }else if (sec>0) {
                            //몇초전인지 계산
                            return sec+"초 전";
                        }
                    }
                }
            }
        }
    }
</script>