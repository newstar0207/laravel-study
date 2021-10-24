<template>
    <app-layout>
        <template #header>
            <chat-room-selection :rooms = 'chatRooms' :currentRoom = 'currentRoom' v-on:roomChanged='setRoom($event)'></chat-room-selection>
        </template>
        <h1>hihihihihii!!!! !~~!~!~!</h1>
        <!-- <styled-message-container :messages='messages'></styled-message-container> -->
        <div class="py-12">
            <div class="flex flex-col ustify-between flex-1 h-screen p:2">
                <div class="p-2 flex flex-col-reverse overflow-scroll">
                    <div v-if="messages.data">
                        <div v-for="msg in messages.data" :key='msg.id'>
                            <styled-message-item :message='msg'></styled-message-item>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <message-container :messages='messages'></message-container> -->
        <input-message :room = 'currentRoom' v-on:messagesent='getMessages'></input-message>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputMessage from './InputMessage.vue';
import ChatRoomSelection from './ChatRoomSelection.vue'
import StyledMessageItem from './StyledMessageItem.vue'

export default {
    components :{
        AppLayout,
        InputMessage,
        ChatRoomSelection,
        StyledMessageItem,

    },
    data() {
        return {
            chatRooms : [],
            currentRoom : {},
            messages: [],
            next_page_url : '',
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
                    // vm.getMessages();
                    this.messages.data = [e.msg, ...this.messages.data];
                })
        },
        getMoreMessages() {
            if(this.messages.current_page === this.messages.last_page) {
                alert('last page...')
                return
            }

            axios.get(this.messages.next_page_url)
                .then((response) => {
                    // this.messages.data = [...this.messages.data, ...response.data.data]
                    // this.next_page_url = response.next_page_url;
                    // if(this.messages.next_page_url == null) {
                    //     return;
                    // }
                    this.messages= {...response.data, 'data':[...this.messages.next_page_url, ...response.data.data]}
                    // this.messages = [...this.messages, ...response.data]
                    // console.log(this.messages)

                })
                .catch((error) => {
                    console.error(error);
                })
        }
    },
    created() {
        this.getRooms();
    },
    mounted() {
        window.addEventListener('scroll',  debounce((e) => {
            // console.log(document.documentElement.scrollTop);
            // console.log(document.documentElement.offsetHeight);
            // console.log(window.innerHeight);
            if(document.documentElement.scrollTop < 10) {
                this.getMoreMessages();
            }
        }, 250));
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

