<template>
    <div>
        {{ currentRoom }}
        <div v-if="chats[0]">
            <div v-for="chat in chats" :key="chat.id">
                {{ chat.chat }}
            </div>
        </div>
<!-- @keyup.enter="createNewChat() -->
        <form onsubmit="event.preventDefault()">
            <input type="text" v-model="chat">
            <button @click="createNewChat()">save</button>
        </form>

    </div>
</template>
<script>
export default {
    props : [
        'currentRoom',
        'user',
    ],
    data(){
        return {
            chats : [],
            chat : '',
            friend : [],
        }
    },

    created() {
        this.getChatting();
    },
    mounted() {
        Echo.join('chat-room.' + this.currentRoom.id) // 연결
            .joining((user) => { // 다른사람이 들어옴
                this.changeState(user,'Online', this.currentRoom.id);
            }).listen('UserOnline', (e) => { // 현재 있음
                this.friend = (e.user.id);
            }).listen('UserOffline', (e) => { // 현재 없음
                this.friend = e.user.id;
            }).listen('NewChat', (e) => {
                this.chats.push(e.chat)
            });
    },
    methods :{
        createNewChat() {
            axios.post('/chatroom/' + this.currentRoom.id + '/chat', {
                chat : this.chat,
                }).then(response => {
                    console.log(response, 'response');
                    this.chats.push(response.data.data.chat);
                    this.chat = '';
                }).catch(error => {
                    console.error(error);
                })

        },
        changeState( user ,state, roomId){
            axios.put('/user/' + user.id + '/' + state + '/' + roomId)
                .then((response) => {
                    console.log(response.data, 'changeState');
                }).catch((error) => {
                    console.error(error);
                });

        },
        getChatting(){
            axios.get('/chatroom/' + this.currentRoom.id + '/chat')
            .then(response => {
                console.log(response.data.data)
                this.chats = response.data.data
            })
            .catch(error => {
                console.error(error)
            })
        },
        disconnect() {
            Echo.join('chat-room.' + this.currentRoom.id)
                .leaving((user) => {  // 나감
                    this.changeState(user,'Offline', this.currentRoom.id);
                });
        }
    },
    watch : {
        currentRoom(val, oldVal){
            if (oldVal.id != val.id) {
                this.disconnect();
                this.getChatting();
            }
        }
    }

}
</script>
<style>

</style>
