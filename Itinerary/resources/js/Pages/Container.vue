<template>
    <div class="min-h-100% grid grid-cols-20 gab-4 bg-gray-100 p-2">
            <!-- sidebar -->
        <div class="flex flex-col col-span-3 rounded-r-3xl overflow-hidden">
            <sidebar-navi/>
        </div>

        <div class="flex flex-col col-start-4 col-span-4 h-100% pl-4 pr-4 py-4 rounded-xl">
            <styled-room-list v-bind:user = user></styled-room-list>
        </div>

        <!-- <div class="flex flex-row w-30 pl-2">
            <div id="test">
                <room-list v-bind:user = user></room-list>
            </div>
        </div> -->

        <div class="flex flex-col col-start-8 col-span-7 h-full w-100 bg-white px-4 py-6">
            <styled-chat-room></styled-chat-room>
        </div>
    </div>
</template>
<script>

import SidebarNavi from './Room/SidebarNavi.vue';
import RoomList from './Room/RoomList.vue';
import StyledRoomList from './Room/StyledRoomList.vue'
import StyledChatRoom from './Room/StyledChatRoom.vue'
export default {

    props : [
        'user'
    ],
    components : {
        RoomList,
        SidebarNavi,
        StyledRoomList,
        StyledChatRoom,
    },


}
</script>

