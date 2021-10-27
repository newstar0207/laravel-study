<template>
    <div >
        this is container
        {{  user }}

        <div>
            <navi></navi>
        </div>

        <div class="border-2">
            <post :user = 'user'></post>
        </div>

        <div>
            <post-list-2 :posts = 'posts' :user = 'user'></post-list-2>
        </div>

    </div>
</template>
<script>
import Post from './Post/Post.vue';
import PostList2 from './Post/PostList2.vue'
import Navi from './Post/Navi.vue'

export default {
    components : {
        Post,
        PostList2,
        Navi,
    },
    props : [
        'user',
        'posts',
    ],
}
</script>
<style>

</style>
