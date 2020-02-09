<template>
    <div id="gnb">
        <div class="container">
            <div class="left">
                <a href="/"><img src="/img/logo.png" alt=""></a>
                <form id="search-box">
                    <input type="text" placeholder="친구 검색">
                    <button type="submit">검색</button>
                </form>
            </div>
            <div class="right">
                <div class="profile" v-if="laravel.auth_check">
                    <p class="name">{{ laravel.user.name }}님 환영합니다.</p>
                    <a href="/logout">로그아웃</a>
                </div>
                <div class="profile" v-else>
                    <a href="/login">로그인</a>
                    <a href="/register">회원가입</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                laravel: laravel,
            }
        },
        mounted() {
            //
        }
    }
</script>