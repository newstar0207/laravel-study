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
    props : ['chatInfo'],
    data(){
        return {
            chats : [],
            chat : '',
        }
    },

    mounted() {
        axios.get('/chatroom/' + this.chatInfo.id + '/chat')
            .then(response => {
                console.log(response.data.data)
                this.chats = response.data.data
            })
            .catch(error => {
                console.error(error)
            })
    },
    methods :{
        createNewChat() {
            axios.post('/chatroom/' + this.chatInfo.id + '/chat', {
                chat : this.chat,
            }).then(response => {
                console.log(response);
            }).catch(error => {
                console.error(error);
            })
            this.chat = '';
        }
    }
}
</script>
<style>

</style>
