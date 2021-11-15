<template>
    <!-- show room -->
    <container-layout>
        <!-- <div class="flex flex-row grid grid-cols-20 h-screen  w-full"> -->
        <div class="flex flex-row grid grid-cols-20 min-h-[calc(100vh-72px)]">

            <!-- 리스트 -->
            <div class="border-2 border-gray-500 col-span-10 bg-white rounded shadow-lg p-4 my-4 ml-4 mr-4">
                room.password : {{ room.password }}
                <update-chat-room :room = 'room'></update-chat-room>
            </div>

            <!-- 메시지 -->
            <div class="flex-1 justify-between flex flex-col col-span-10 rounded p-2 mt-2 mr-4">
                <div class="flex justify-between py-1 border-b-2 border-gray-200">
                    <div class="flex items-center space-x-4">
                        <div class="flex flex-col leading-tight">
                            <div class="text-xl mt-1 flex items-center">
                            <span class="text-gray-700 mr-3">{{ room.title }}</span>

                            </div>
                            <span class="text-lg text-gray-600">{{ room.password }}</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                    </div>
                </div>

                <!-- 메시지 리스트 -->
                <div class="flex flex-col flex-grow space-y-4 p-3 overflow-y-scroll h-96">
                    <intersect @enter='inters(true)' @leave='inters(false)'>
                        <div>fsdf</div>
                    </intersect>
                    <div v-for="chat in chats" :key="chat.id">
                        <div class="flex items-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                <div class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600" @dblclick="clickChat(chat)">{{chat.chat}}
                                    <img v-if="chat.image" :src="chat.image" alt="" width="200" height="200">
                                </div>
                            </div>
                            <img src="https://images.unsplash.com/photo-1549078642-b2ba4bda0cdb?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=144&amp;h=144" alt="My profile" class="w-6 h-6 rounded-full order-1">
                        </div>

                        <div v-if="actionModal" @close='actionModal = false'>
                            <div class="modal-mask">
                                <div class="modal-wrapper">
                                    <div class="modal-container">
                                        <h1 class="text-center text-2xl text-red-500">Delete</h1>
                                        <div class = "flex flex-row w-auto" >
                                            <button class="mt-12 w-1/2 text-center bg-gray-400 py-2 mx-3 rounded-lg" @click="deleteChat(chat.id)">delete</button>
                                            <button class="mt-12 w-1/2 text-center bg-gray-400 py-2 mx-3 rounded-lg" @click="this.actionModal = false">cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- 메시지 입력 -->
                <div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0 flex-none">
                    <div class="relative flex">
                        <div class="px-2 mb-2 flex items-end inset-y-0 bottom-0 w-full">

                            <input type="file" ref="inputFile" style='display : none' @input="form.image = $event.target.files[0]"/>
                            <button @click=$refs.inputFile.click() class="outline-none focus:outline-none">
                                <svg class="text-gray-400 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                            <input placeholder="message..." v-model="form.chat" class="py-1 mx-3 pl-5 block w-full rounded-full bg-gray-100 outline-none focus:text-gray-700" type="text" name="message" required/>


                            <button @click="submit" class="outline-none focus:outline-none" >
                                <svg class="text-gray-400 h-7 w-7 origin-center transform rotate-90" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                            </button>

                            <!-- <input type="text" v-model="form.chat" class="w-full text-gray-600 placeholder-gray-600 bg-gray-200 rounded-full" placeholder="message..."/>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-400" @click="submit" ref='submitChat'>Submit</button> -->
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </container-layout>
</template>
<script>
import { onMounted, onUnmounted } from 'vue'
import { reactive, ref  } from '@vue/reactivity'
import UpdateChatRoom from './UpdateChatRoom.vue'
import ContainerLayout from '../Layouts/ContainerLayout.vue'
import Intersect from 'vue-intersect'
import JetConfirmationModal from '../Jetstream/ConfirmationModal.vue'

export default {
    props : [
        'room',
    ],
    components : {
        UpdateChatRoom,
        ContainerLayout,
        Intersect,
        JetConfirmationModal,

    },
    setup(props){
        const form = reactive({
            chat: null,
            image: null,
        })

        const chats = ref([]);
        const actionModal = ref(false)

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

                // scrollToEnd()
            }).catch((error) => {
                console.error(error);
            })
        }

        const deleteChatInchats = (chatId) => {
            let i;
            for(i = 0 ;  i < chats.value.length ; i++){
                if (chats.value[i].id == chatId) {
                    if (i > -1) chats.value.splice(i, 1)
                    break
                }
            }
            actionModal.value = false
        }

        const deleteChat = (chatId) => {
            // Inertia.delete(`/chat/${chat.id}`)
            // let localChat = chat
            axios.delete(`/chat/${chatId}`, {
                // chat : localChat.chat,
                // image : localChat.image,
            }).then((response) => {
                console.log(response)
                deleteChatInchats(chatId)
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

        let skip = 0
        function loadMoreChat() {
            axios.get(`/${props.room.id}/chat/${skip}`)
            .then((response) => {
                let reversedChats = response.data.reverse()
                console.log(reversedChats, 'moreChat!!!...')
                // chats.value
                chats.value = reversedChats.concat(chats.value)
                console.log(chats.value)
            })
            skip += 10;
            console.log('load...')
        }

            // function scrollToEnd() {

            // }


        function inters(enter) {
            if(enter) {
                console.log('entered!!!')
                loadMoreChat() // 앞으로 넣기
            }else {
                console.log('leaved...')
            }
        }

        function clickChat(chat){
            console.log(chat.id)
            actionModal.value = true
        }

        return {
            submit,
            form,
            deleteChat,
            broadcastingRoom,
            chats,
            deleteChatInchats,
            loadMoreChat,
            onMounted,
            onUnmounted ,
            inters,
            clickChat,
            actionModal,
        }
    }

}
</script>
<style>
    .max_pic {
        max-height: 550px;
    }

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0, 0.1);
        display: table;
        transition: opacity .3s ease;
    }
    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }
    .modal-container {
        width: 350px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }
</style>
