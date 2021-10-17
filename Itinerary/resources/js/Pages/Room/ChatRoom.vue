<template>
    <div>
        {{ chatInfo }}
        <div v-if="chats[0]">
            <div v-for="chat in chats" :key="chat.id">
                {{ chat.chat }}
            </div>
        </div>

        <form onsubmit="event.preventDefault()" @keyup.enter="createNewChat()">
            <input type="text" v-model="chat">
            <button @click="createNewChat()">save</button>
        </form>

    </div>
</template>
<script>
export default {
    props : [
        'chatInfo',
        'user',
    ],
    data(){
        return {
            chats : [],
            chat : '',
            roomId : this.chatInfo.id,
            friend : [],
        }
    },

    created() {
        axios.get('/chatroom/' + this.chatInfo.id + '/chat')
            .then(response => {
                console.log(response.data.data)
                this.chats = response.data.data
            })
            .catch(error => {
                console.error(error)
            })

    },
    mounted() {
        Echo.join('chat-room.' + this.roomId) // 연결
            .joining((user) => { // 다른사람이 들어옴
                this.changeState(user,'Online', this.roomId);
            }).leaving((user) => {  // 나감
                this.changeState(user,'Offline', this.roomId);
            }).listen('UserOnline', (e) => { // 현재 있음
                this.friend = e.user;
            }).listen('UserOffline', (e) => { // 현재 없음
                this.friend = e.user;
            }).listen('NewChat', (e) => {
                this.chats.push(e.chat)
                console.log('dddddddd');
            });
    },
    methods :{
        createNewChat() {
            axios.post('/chatroom/' + this.roomId + '/chat', {
                chat : this.chat,
                }).then(response => {
                    console.log(response);
                }).catch(error => {
                    console.error(error);
                })
                this.chat = '';

        },
        changeState( user ,state, roomId){
            axios.put('/user/' + user + '/' + state + '/' + roomId)
                .then((response) => {
                    console.log(response.data)
                }).catch((error) => {
                    console.error(error);
                });

        }
    }

}
</script>
<style>

</style>
