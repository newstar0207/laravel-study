<template>

    <!-- {{  chatImage }} -->
    <dir class="grid grid-cols-3 grid-flow-row pt-2 overflow-y-auto">
        <div v-for="image in chatImage" :key="image.id">
            <div class="flex m-2 flex-col">
                <img @click="openImage(image)" :src="image.image" :alt="chatImage.chat" class="hover:border-2 hover:border-gray-100">
                <div class="mt-3 flex justify-between">
                    <!-- <svg @click="updateLike(image)" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg> -->
                    <div class="font-semibold text-gray-400 text-xs">{{ image.room.title }}</div>
                </div>
            </div>
        </div>
    </dir>

    <jet-dialog-modal :show="openImageModal" @close="openImageModal = false" >
        <template #content>
            <img :src="updateImageDesc.image">
            <p class="italic text-xs text-gray-700 mt-4">Memo..</p>
            <input type='text' v-model="updateImageDesc.desc" class="w-full border border-2 rounded-md border-blue-100 border-dashed">
        </template>
        <template #footer>
            <div class="flex justify-between">
                <div class="text-xl font-semibold  text-red-500">{{ message }}</div>
                <button @click="saveImageDesc"  class="rounded text-gray-100 px-3 py-1 bg-blue-500 hover:shadow-inner hover:bg-blue-700">Save</button>
            </div>
        </template>
    </jet-dialog-modal>

</template>
<script>
import { reactive, ref } from '@vue/reactivity'
import JetDialogModal from '../Jetstream/DialogModal.vue'
import { Inertia } from '@inertiajs/inertia'
export default {
    props: [
        'chatImage'
    ],
    components : {
        JetDialogModal,
    },
    setup(props) {

        const openImageModal = ref(false)
        const message = ref('')
        const updateImageDesc = reactive({
            desc : '',
            image : '',
            room_id : '',
            chat_id : '',

        })

        function openImage(image) {
            message.value = ''
            console.log('click')
            openImageModal.value = true,
            updateImageDesc.desc = image.desc
            updateImageDesc.image = image.image
            updateImageDesc.room_id = image.room_id
            updateImageDesc.chat_id = image.id
        }

        function saveImageDesc(){
            Inertia.post('/room/chat/' + updateImageDesc.chat_id, {
                desc : updateImageDesc.desc
            })
            message.value = 'complete'
        }

        return {
            openImage,
            openImageModal,
            updateImageDesc,
            saveImageDesc,
            message,
        }
    }

}
</script>
<style >

</style>
