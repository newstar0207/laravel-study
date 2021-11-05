<template>

    this is container
    <div class="border-2">
        {{  this.$page.props.user }}
    </div>
</template>
<script>
import Navi from './Room/Navi.vue'
export default {

    props : [
        'allChatRoom',
        'user'
    ],
    components : {
        // RoomList,
        // SidebarNavi,
        // StyledRoomList,
        // StyledChatRoom,
        // Navi,
    },
    mounted() {
        // this.$store.commit('setUser', this.user);
        // console.log(this.$store.state.index.user, 'user...');
        // console.log(this.$store.commit('getUser'), 'getUSer');
    }
}
</script>
<style>
    #img {
        width: 100%;
        height: 1000px;
        background-image: url('/storage/main-travel2.jpg');
        background-size: 100% 70%;
        background-repeat: no-repeat;
    }
</style>

