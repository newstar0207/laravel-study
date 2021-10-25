    <template>
    <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5" v-for="post in posts" :key="post.id">
        <post-item></post-item>
    </div>
</template>
<script>
import PostItem from './PostItem.vue'
export default {
    components : {
        PostItem,
    },
    data() {
        return {
            posts : [1,2,3,4,5]
        }
    }
}
</script>
<style>

</style>
