<template>
    <div>
        <div v-for="post in posts" :key="post.id">
            <div class='border-2'>
                {{  post }}
                <img :src="post.image_path" alt="" width="300" height="300">  <!-- src 속성에 :src 잊지말것!!! -->
                <button @click="updatePost(post)">update</button>
                <button @click="deletePost(post)">delete</button>
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
                            <div>
                                <form @submit.prevent="submit(this.post_id)">
                                    <label for="title">title</label>
                                    <input type="text" v-model="form.title" name="title"/>
                                    <br>
                                    <label for="content">content</label>
                                    <input type="text" v-model="form.content" name="content"/>
                                    <input type="file" @input="form.image = $event.target.files[0]"/>
                                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                    </progress>
                                    <!--  -->
                                    <button type="submit">Submit</button>
                                </form>
                            </div>
                            <button class="modal-default-button" @click="this.updateModal = false">
                                OK
                            </button>
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
                            <div>delete??</div>
                            <button @click="deleteSubmit(this.post_id)">OK</button>
                            <button  @click="this.deleteModal = false">CANCEL</button>
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
            // this.form.put('/post/' + post_id, {
            //     preserveScroll: true,
            //     onSuccess: () => this.form.reset('title','content','image'),
            // })
            // this.updateModal = false
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

    .modal-default-button {
        float: right;
    }
</style>
