<template>
    <div class="border-2 border-gray-500">
        show room

        <update-chat-room :room = 'room'></update-chat-room>

    </div>
</template>
<script>
import UpdateChatRoom from './UpdateChatRoom.vue'

export default {
    props : [
        'room'
    ],
    components : {
        UpdateChatRoom,
    }
}
</script>
<style>

</style>
