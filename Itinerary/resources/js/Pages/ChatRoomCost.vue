<template>
    <!-- <div class="bg-white rounded-lg drop-shadow-lg p-6 m-6">
        <label>food</label>
        <input required class="border-2 border-gray-300" v-model="form.food" />
        <label>room</label>
        <input required class="border-2 border-gray-300" v-model='form.room'>
        <label>tran</label>
        <input required class="border-2 border-gray-300" v-model='form.tran'>
        <label>other</label>
        <input required class="border-2 border-gray-300" v-model='form.other'>
        <button @click="submit()" class="bg-blue-500 hover:bg-blue-400">Submit</button>
        <button @click="update()" class="bg-blue-500 hover:bg-blue-400">update</button>
    </div> -->


    <div class="p-6">

        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="ml-4">
                Cost
            </div>
        </div>

        <div>
                room
            </div>
            <div>
                food
            </div>
            <div>
                tran
            </div>
            <div>
                other
            </div>
            <div class="text-green-400">
                더치패이
            </div>

    </div>

    <jet-dialog-modal :show="costBtn" @close="costBtn = false">
        <template #title>
            <div>Calculate Cost...</div>
        </template>
        <template #content>
        <div class="flex justify-evenly mt-10">
            <div class="border focus-within:border-blue-500 focus-within:text-blue-500 relative rounded p-1">
                <div class="-mt-4 absolute px-1 uppercase text-xs">
                    <label class="bg-white text-gray-600 px-1">Food</label>
                </div>
                <input v-model="form.food" autocomplete="false" type="text" class="py-1 px-1 outline-none block h-full w-full">
            </div>
            <div class="border focus-within:border-blue-500 focus-within:text-blue-500 relative rounded p-1">
                <div class="-mt-4 absolute px-1 uppercase text-xs">
                    <label class="bg-white text-gray-600 px-1">Room</label>
                </div>
                <input v-model="form.room" autocomplete="false" type="text" class="py-1 px-1 outline-none block h-full w-full">
            </div>
        </div>
        <div class="flex justify-evenly mt-4">
            <div class="border focus-within:border-blue-500 focus-within:text-blue-500 relative rounded p-1">
                <div class="-mt-4 absolute px-1 uppercase text-xs">
                    <label class="bg-white text-gray-600 px-1">Tran</label>
                </div>
                <input v-model="form.tran" autocomplete="false" type="text" class="py-1 px-1 outline-none block h-full w-full">
            </div>
            <div class="border focus-within:border-blue-500 focus-within:text-blue-500 relative rounded p-1">
                <div class="-mt-4 absolute px-1 uppercase text-xs">
                    <label class="bg-white text-gray-600 px-1">Other</label>
                </div>
                <input v-model="form.other" autocomplete="false" type="text" class="py-1 px-1 outline-none block h-full w-full">
            </div>
        </div>
        </template>
        <template #footer>
            <button @click="submit()" class="rounded text-gray-100 px-3 py-1 bg-blue-500 hover:shadow-inner hover:bg-blue-700">Save</button>
            <button @click="update()" class="rounded text-gray-100 px-3 py-1 bg-blue-500 hover:shadow-inner hover:bg-blue-700">Update</button>
        </template>
    </jet-dialog-modal>
</template>
<script>
import { reactive, ref } from '@vue/reactivity'
import JetDialogModal from '../Jetstream/DialogModal.vue'
export default {
    props : [
        'room'
    ],
    components: {
        JetDialogModal,
    },

    setup(props) {
        const form = reactive({
            food : '',
            room : '',
            tran : '',
            other : '',
        })

        const costBtn = ref(true)

        // 1. 리스트를 불러와야함 -> 브로드캐스팅으로 해야할듯 함
        // 2. 처음을 어캐할지 생각중...

        function submit() {
            axios.post(`/room/${props.room.id}/cost`, {
                food_cost : form.food,
                room_cost : form.room,
                tran_cost : form.tran,
                other_cost : form.other,
            }).then(response => {
                console.log(response.data)
            }).catch(error => {
                console.log(error);
            })
        }

        function update() {
            axios.put(`/room/${props.room.id}/cost`, {
                food_cost : form.food,
                room_cost : form.room,
                tran_cost : form.tran,
                other_cost : form.other,
            }).then(response => {
                console.log(response.data)
            }).catch(error => {
                console.log(error);
            })
        }

        return {
            form,
            submit,
            update,
            costBtn,
        }
    }

}
</script>
<style>

</style>
