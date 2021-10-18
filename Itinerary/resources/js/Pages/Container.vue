<template>
    <div>
        container
        <div id="test">
            <room-list v-bind:user = user></room-list>
        </div>

       <!-- 방에 맞게 db에 저장이 잘 되긴 하지만, 브로드캐스팅이 안됨 leave 가 문제인거 같음! 체크할것 -->

    </div>
</template>
<script>

// import ChatRoom from './Room/ChatRoom.vue';
import RoomList from './Room/RoomList.vue';
export default {

    props : [
        'user'
    ],
    components : {
        // ChatRoom,
        RoomList,
    },


}
</script>
<style>
    #test {
        border: 1px solid red;
    }
</style>
