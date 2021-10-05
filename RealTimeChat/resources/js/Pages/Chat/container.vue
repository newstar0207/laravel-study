<template>
    <app-layout>
        <h1>hihihihihii!!!! !~~!~!~!</h1>
        <message-container :messages='messages'></message-container>
        <input-message></input-message>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import MessageContainer from './MessageContainer.vue';
import InputMessage from './InputMessage.vue';

export default {

    components :{
        AppLayout,
        MessageContainer,
        InputMessage,
    },
    data() {
        return {
            chatRooms : [],
            currentRoom : '',
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
            axios.get('/chat/room/' + this.currentRoom.id + '/messages')
                .then(response => {
                    this.messages = response.data;
                })
                .catch(error => {
                    console.error(error, 'getMessage error');
                });
        },
        setRoom(room){
            this.currentRoom = room;
            this.getMessages();
        }
    },
    created() {
        this.getRooms();
    }

}
</script>
<style>

</style>

