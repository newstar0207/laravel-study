<template>
    <div class="border-2 border-gray-500">
        show room
        {{ room.password }}
        <update-chat-room :room = 'room'></update-chat-room>

        <!-- 채팅방 -->
        <div class="border-2 border-gray-500">

            <!-- 채팅입력 -->
            this is chat room
            <form @submit.prevent="submit">
                <label>name</label>
                <input type="text" v-model="form.chat"/>
                <input type="file" ref="inputFile" @input="form.image = $event.target.files[0]"/>
                <br>
                <button type="submit" class="bg-blue-500 hover:bg-blue-400">Submit</button>
            </form>

            <!-- 채팅리스트 -->
            <!-- 채팅 내가 쓴 글만 내가 삭제할 수 있게 할것!!! -->
            <div v-for="chat in chats" :key="chat.id">
                {{ chat.chat }}
                {{ chat.user_id }}
                <img v-if="chat.image" :src="chat.image" alt="" width="300" height="300">
                <button @click="deleteChat(chat)" class="bg-blue-500 hover:bg-blue-400 ml-3">delete</button>
            </div>
        </div>
    </div>
</template>
<script>
import { reactive, ref } from '@vue/reactivity'
import UpdateChatRoom from './UpdateChatRoom.vue'

export default {
    props : [
        'room',
        'chatList',
    ],
    components : {
        UpdateChatRoom,
    },
    setup(props){
        const form = reactive({
            chat: null,
            image: null,
        })

        const chats = ref(props.chatList);


        function submit() {
            const formData = new FormData()
            if (form.image != null) {
                console.log(form.image)
                formData.append('image',form.image)
                // for (var pair of formData.entries()) {
                //     console.log(pair[0]+ ', ' + pair[1]);
                // }
                // return
            }
            formData.append('chat', form.chat)
            axios.post(`/room/${props.room.id}/chat`, formData,{
                headers: { 'Content-Type': 'multipart/form-data' }
            }).then((response) => {
                chats.value.push(response.data);
                form.chat = ''
                form.image = null
            }).catch((error) => {
                console.error(error);
            })
        }

        const deleteChatInchats = (chat) => {
            let i;
            for(i = 0 ;  i < chats.value.length ; i++){
                if (chats.value[i].id == chat.id) {
                    if (i > -1) chats.value.splice(i, 1)
                    break
                }
            }
        }

        const deleteChat = (chat) => {
            // Inertia.delete(`/chat/${chat.id}`)
            let localChat = chat
            axios.delete(`/chat/${localChat.id}`, {
                chat : localChat.chat,
                image : localChat.image,
            }).then((response) => {
                console.log(response)
                deleteChatInchats(localChat)
            }).catch((error) => {
                console.error(error)
            })
            // 해당 댓글 찾아서 삭제시키기
        }

        var broadcastingRoom = Echo.join(`chat-room.${props.room.id}`)
            .here((users) => {
                console.log(users, 'here!!!');
            })
            .joining((user) => {
                console.log(user, 'joining!!!'); // 토스트 띄울것
            })
            .leaving((user) => {
                console.log(user.name, 'leaving!!!');
            })
            .listen('NewChat', (e) => {
                // console.log(e, 'listen!!!');
                chats.value.push(e.chat)
                form.chat = ''
            })
            .listen('DeleteChat', (e) => {
                deleteChatInchats(e.chat);
            });





        return { submit, form, deleteChat, broadcastingRoom, chats, deleteChatInchats}
    }

}
</script>
<style>

</style>
