<template>

    <div class="p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="ml-2 font-semibold text-xl text-gray-400">
                    Cost
                </div>
            </div>
            <p @click="costBtn = true" class="text-green-500 underline">update Cost</p>
        </div>

        <div class="flex flex-col mt-5">
            <div class="w-full lg:w-6/12 px-4 flex justify-around space-x-6">
                <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                        Food
                    </label>
                    <div class="border-0 px-3 py-3  bg-white rounded text-sm w-full">{{ originData.roomFood }}</div>
                </div>
                <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                        Room
                    </label>
                    <div class="border-0 px-3 py-3  bg-white rounded text-sm w-full">{{ originData.roomRoom }}</div>
                </div>
            </div>
            <div class="w-full lg:w-6/12 px-4 flex justify-around space-x-6">
                <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                        Tran
                    </label>
                    <div class="border-0 px-3 py-3  bg-white rounded text-sm w-full">{{ originData.roomTran }}</div>
                </div>
                <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                        Other
                    </label>
                    <div class="border-0 px-3 py-3  bg-white rounded text-sm w-full">{{ originData.roomOther }}</div>
                </div>
            </div>
            <div class="w-full lg:w-6/12 px-4 flex justify-around space-x-6">
                <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                        Sum
                    </label>
                    <div class="border-0 px-3 py-3  bg-white rounded text-sm w-full">{{ sum }}</div>
                </div>
                <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                        Dutch Pay
                    </label>
                    <div class="border-0 px-3 py-3  bg-white rounded text-sm w-full text-red-500">{{ dutchPay }}</div>
                </div>
            </div>
        </div>

    </div>

    <jet-dialog-modal :show="costBtn" @close="costBtn = false, costBtnClose()">
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
        <div class="font-bold text-red-700">{{ errorMessage }}</div>
        </template>
        <template #footer>
            <!-- <button @click="submit()" class="rounded text-gray-100 px-3 py-1 bg-blue-500 hover:shadow-inner hover:bg-blue-700">Save</button> -->
            <button @click="update()" class="rounded text-gray-100 px-3 py-1 bg-blue-500 hover:shadow-inner hover:bg-blue-700">Update</button>
        </template>
    </jet-dialog-modal>
</template>
<script>
import { computed, reactive, ref } from '@vue/reactivity'
import JetDialogModal from '../Jetstream/DialogModal.vue'
import { onMounted } from '@vue/runtime-core'
export default {
    props : [
        'room',
        'userLength'
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

        const originData = reactive({
            roomFood : props.room.cost.food_cost,
            roomRoom : props.room.cost.room_cost,
            roomTran : props.room.cost.tran_cost,
            roomOther : props.room.cost.other_cost,
        })

        onMounted(() => {
            form.food = props.room.cost.food_cost
            form.room = props.room.cost.room_cost
            form.tran = props.room.cost.tran_cost
            form.other = props.room.cost.other_cost
        })

        const costBtn = ref(false)

        const errorMessage = ref('')

        const sum = computed(() => parseInt(originData.roomFood) + parseInt(originData.roomRoom) + parseInt(originData.roomTran) + parseInt(originData.roomOther))
        const dutchPay = computed(() => sum.value / props.userLength )

        function costBtnClose() {
            form.food = originData.roomFood
            form.room = originData.roomRoom
            form.tran = originData.roomTran
            form.other = originData.roomOther
            errorMessage.value = ''
        }

        function update() {
            axios.put(`/room/${props.room.id}/cost`, {
                food_cost : form.food,
                room_cost : form.room,
                tran_cost : form.tran,
                other_cost : form.other,
            }).then(response => {
                costBtn.value = false
            }).catch(error => {
                console.log(error);
                errorMessage.value = 'you are not owner'
            })
        }

        const broadcastingRoom = Echo.join(`chat-room.${props.room.id}`)
            .listen('UpdateCost', (e) => {
                console.log(e)
                form.food = e.cost.food_cost
                originData.roomFood = e.cost.food_cost
                form.room = e.cost.room_cost
                originData.roomRoom = e.cost.room_cost
                form.tran = e.cost.tran_cost
                originData.roomTran = e.cost.tran_cost
                form.other = e.cost.other_cost
                originData.roomOther = e.cost.other_cost
            })

        return {
            form,
            onMounted,
            update,
            costBtn,
            broadcastingRoom,
            originData,
            costBtnClose,
            errorMessage,
            sum,
            dutchPay,
        }
    }

}
</script>
<style>

</style>
