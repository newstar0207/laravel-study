<template>
    <div>
        {{ post }}
        <div class="min-h-screen bg-yellow-400 items-center py-10">
            <div class=" p-12 bg-gray-100 rounded-xl mx-auto lg:mx-96 md:mx-52">
                <!-- <div class="sm:grid sm:grid-cols-2 lg:grid-cols-3 gap-4 space-y-4 sm:space-y-0 "> -->
                <!-- Box -->
                <div class="flex flex-row justify-between">
                    <h1 class="text-4xl uppercase font-bold  mb-8">Show post</h1>
                    <h1 class="text-2xl uppercase font-bold  mb-8 underline"><a href="/post">postList...</a></h1>
                </div>

                <div class="bg-white">
                    <div>
                        <img class="w-full h-96" :src="post.image_path" />
                        <div class="px-4 py-2 h-44">
                            <h1 class="text-xl font-gray-700 font-bold">{{ post.title }}</h1>
                            <p class="text-sm tracking-normal">{{ post.content  }}</p>
                            <div class = "flex flex-row w-auto" >
                                <!-- <button class="mt-12 w-1/2 text-center bg-yellow-400 py-2 mx-3 rounded-lg" @click="deletePost(post)">delete</button>
                                <button class="mt-12 w-1/2 text-center bg-yellow-400 py-2 mx-3 rounded-lg" @click="updatePost(post)">update</button>
                                <button class="mt-12 w-1/2 text-center bg-yellow-400 py-2 mx-3 rounded-lg" @click="showPost(post.id)">open</button> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <br>
                <form @submit.prevent="submit()">
                    <label for="form.message">new chat...</label>
                    <input id="last_name" required v-model="form.chat" />
                    <button type="submit">댓글입력</button>
                </form>

                <div v-for="chat in chats" :key="chat.id" class="flex flex-row">
                    <div>
                        {{ chat.chat }}
                    </div>
                    <button @click="deleteChat(chat)">--삭제</button>
                    <button @click="updateChat(chat)">수정</button>
                </div>
            </div>
        </div>

        <div>
        <!-- updated Modal -->

            <div v-if="updateModal" @close='updateModal = false'>
                <transition name="modal">
                    <div class="modal-mask">
                        <div class="modal-wrapper">
                            <div class="modal-container">
                            <div class="flex justify-end mb-6">
                                <button>
                                    <span class="mr-2" @click="this.updateModal = false">Close</span>
                                </button>
                            </div>
                            <h1 class="text-center text-2xl text-yellow-500">Update</h1>
                            <div>
                                <form @submit.prevent="updateSubmit(this.chat_id)">
                                    <div class="mb-4">
                                        <label class="block text-sm font-bold mb-2">Chat</label>
                                        <input v-model="form.chat" required name="chat" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" type="text" placeholder="chat..">
                                    </div>
                                    <div class="block md:flex items-center justify-between mt-3">
                                        <button class="text-green-500 font-bold py-2 px-4 rounded border-b-4 border-green-darkest" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>

            <!-- delete Modal -->

            <div v-if="deleteModal" @close='deleteModal = false'>
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-container">
                            <h1 class="text-center text-2xl text-yellow-500">Delete</h1>
                            <div class = "flex flex-row w-auto" >
                                <button class="mt-12 w-1/2 text-center bg-yellow-400 py-2 mx-3 rounded-lg" @click="deleteSubmit(this.chat_id)">delete</button>
                                <button class="mt-12 w-1/2 text-center bg-yellow-400 py-2 mx-3 rounded-lg" @click="this.deleteModal = false">cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    props :[
        'user',
        'post',
        'chats'
    ],
    data() {
        return {
            form : {
                chat: '',
                post_id : '',
            },
            updateModal : false,
            deleteModal : false,
            chat_id : null,
        }
    },
    methods :{
        submit(){
            this.post_id = this.post.id;
            this.$inertia.post('/post/' + this.post_id + '/chat', this.form);
            // this.$inertia.form.reset();
            this.form.chat = null;
        },
        updateChat(chat){
            console.log(chat)
            this.form.chat = chat.chat
            this.chat_id = chat.id
            this.updateModal = true
        },
        deleteChat(chat){
            this.chat_id = chat.id
            this.deleteModal = true
        },
        deleteSubmit(chat_id) {
            // console.log(chat_id)
            this.$inertia.delete('/chat/' + chat_id, this.form.post_id);
            this.deleteModal = false
        },
        updateSubmit(chat_id) {
            this.$inertia.put('/chat/' + chat_id, this.form);
        }
    }
}
</script>
<style >
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
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
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

</style>
