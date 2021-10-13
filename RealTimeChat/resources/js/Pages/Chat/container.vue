<template>
    <app-layout>
        <template #header>
            <chat-room-selection :rooms = 'chatRooms' :currentRoom = 'currentRoom' v-on:roomChanged='setRoom($event)'></chat-room-selection>
        </template>
        <h1>hihihihihii!!!! !~~!~!~!</h1>
        <styled-message-container :message='messages'></styled-message-container>
        <!-- <message-container :messages='messages'></message-container> -->
        <input-message :room = 'currentRoom' v-on:messagesent='getMessages'></input-message>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import MessageContainer from './MessageContainer.vue';
import InputMessage from './InputMessage.vue';
import ChatRoomSelection from './ChatRoomSelection.vue'
import StyledMessageContainer from './StyledMessageContainer.vue'

export default {

    components :{
        AppLayout,
        MessageContainer,
        InputMessage,
        ChatRoomSelection,
        StyledMessageContainer,

    },
    data() {
        return {
            chatRooms : [],
            currentRoom : {},
            messages: [],
        }
    },
    methods: {
        getRooms() {
            axios.get('/chat/rooms')
                .then(response => {
                    this.chatRooms = response.data;
                    if(this.chatRooms != null) {
                        this.setRoom(response.data[0]);
                    }
                })
                .catch(error => {
                    console.log('get Room error');
                });
        },
        getMessages() {
            axios.get('/chat/' + this.currentRoom.id + '/messages')
                .then(response => {
                    this.messages = response.data;
                })
                .catch(error => {
                    console.error(error, 'getMessage error');
                });
        },
        setRoom(room){
            this.currentRoom = room;
            // this.getMessages();
        },
        disconnect(room) {
            window.Echo.leave('chat.' + room.id);
        },
        connect() {
            this.getMessages();
            const vm = this;
            window.Echo.private('chat.' + this.currentRoom.id) // -> 채널연결
                .listen('.message.new', (e) => { // -> 메시지 받음
                    vm.getMessages();
                })
        }
    },
    created() {
        this.getRooms();
    },
    watch: {
        currentRoom(val, oldVal) {
            if(oldVal){
                this.disconnect(oldVal);
            }
            this.connect();
        }
    }

}
</script>
<style>

</style>

