<template>
    <div>
        <div class="min-h-screen bg-yellow-400 flex justify-center items-center py-10">
            <div class="container mx-auto p-12 bg-gray-100 rounded-xl mx-5">
                <div class="flex flex-row justify-between">
                    <h1 class="text-4xl uppercase font-bold  mb-8">all posts</h1>
                    <h1 class="text-2xl uppercase font-bold  mb-8 underline">post..</h1>
                </div>
                 <div class="sm:grid sm:grid-cols-2 lg:grid-cols-3 gap-4 space-y-4 sm:space-y-0 ">

                    <!-- Box -->
                    <div v-for="post in posts" :key="post.id">
                        <div class="bg-white">
                            <div>
                            <div class="shadow-lg hover:shadow-xl transform transition duration-500 hover:scale-105">
                                <div>
                                <img class="w-full h-96" :src="post.image_path" />
                                <div class="px-4 py-2 h-44">
                                    <h1 class="text-xl font-gray-700 font-bold">{{ post.title }}</h1>
                                    <p class="text-sm tracking-normal">{{ post.content  }}</p>
                                    <div class = "flex flex-row w-auto" >
                                        <button v-if="user != null" class="mt-12 w-1/2 text-center bg-yellow-400 py-2 mx-3 rounded-lg" @click="deletePost(post)">delete</button>
                                        <button v-if="user != null" class="mt-12 w-1/2 text-center bg-yellow-400 py-2 mx-3 rounded-lg" @click="updatePost(post)">update</button>
                                        <button class="mt-12 w-1/2 text-center bg-yellow-400 py-2 mx-3 rounded-lg" @click="showPost(post.id)">open</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal -->

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
                                <form @submit.prevent="submit(this.post_id)">
                                    <div class="mb-4">
                                        <label class="block text-sm font-bold mb-2">Title</label>
                                        <input v-model="form.title" required name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" type="text" placeholder="title..">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-bold mb-2">Content</label>
                                        <input v-model="form.content" required name="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" type="text" placeholder="content..">
                                    </div>
                                    <input type="file" @input="form.image = $event.target.files[0]"/>

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
                                <button class="mt-12 w-1/2 text-center bg-yellow-400 py-2 mx-3 rounded-lg" @click="deleteSubmit(this.post_id)">delete</button>
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
    props : [
        'posts',
        'user',
    ],
    data() {
        return {
            updateModal : false,
            deleteModal : false,
            form : this.$inertia.form({
                title : '',
                content : '',
                image : '',
            }),
            post_id : null,
        }
    },
    methods : {
        updatePost(post){
            console.log(post)
            this.form.title = post.title
            this.form.content = post.content
            this.form.image = post.image_path
            this.post_id = post.id
            this.updateModal = true
        },
        deletePost(post){
            this.form.title = post.title
            this.form.content = post.content
            this.form.image = post.image_path
            this.post_id = post.id
            this.deleteModal = true
        },
        submit(post_id) {
            this.$inertia.post(`/post/${post_id}`, {
                _method : 'put',
                image : this.form.image,
                title : this.form.title,
                content : this.form.content
            })
        },
        deleteSubmit(post_id) {
            this.$inertia.delete('/post/' + post_id)
            this.deleteModal = false
        },
        showPost(post_id) {
            this.$inertia.visit('post/' + post_id, {method : 'get'})

        }
    },
}
</script>
<style>
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
