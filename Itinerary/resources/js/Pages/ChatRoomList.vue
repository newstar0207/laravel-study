<template>
    <div class="bg-white rounded shadow-lg p-4 w-8/12">
        <div class="bg-white">
            <nav class="flex flex-col items-stretch sm:flex-row">

                <!-- <Link href="/"> -->
                <button @click="updatePage"  :class="updateBtn == false ? 'text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none' : ' py-4 px-6 block text-blue-500 border-b-2 font-medium border-blue-500'">
                    Room
                </button>
                <!-- </Link> -->
                <button @click='planPage'  :class="planBtn == false ? 'text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none' : ' py-4 px-6 block text-blue-500 border-b-2 font-medium border-blue-500'">
                    Plan
                </button>
                <button @click="costPage"  :class="costBtn == false ? 'text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none' : ' py-4 px-6 block text-blue-500 border-b-2 font-medium border-blue-500'">
                    Cost
                </button>
                <!-- <button  :class=" == false ? 'text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none' : 'text-blue-500 border-b-2 font-medium border-blue-500'"> -->
                    <!-- Tab 4 -->
                <!-- </button> -->
            </nav>

        </div>
        <!-- <update-chat-room v-if="updateBtn" :room ='room' :roomUsers = 'roomUsers' ></update-chat-room> -->
        <chat-room-plan v-if="planBtn" :room='room' ></chat-room-plan>
        <chat-room-cost v-if="costBtn" :room='room'></chat-room-cost>
    </div>


</template>
<script>
import ChatRoomUpdate from './ChatRoomUpdate.vue'
import { ref } from 'vue'
import ChatRoomPlan from './ChatRoomPlan.vue'
import ChatRoomCost from './ChatRoomCost.vue'

export default {
    props : [
        'room',
        'roomUsers'
    ],
    components : {
        ChatRoomUpdate,
        ChatRoomPlan,
        ChatRoomCost,
    },
    setup(props){
        const updateBtn = ref(true)
        const planBtn = ref(false)
        const costBtn = ref(false)

        function updatePage() {
            updateBtn.value = true
            planBtn.value = false
            costBtn.value = false
        }

        function costPage() {
            updateBtn.value = false
            planBtn.value = false
            costBtn.value =true
        }

        function planPage() {
            updateBtn.value = false
            planBtn.value = true
            costBtn.value = false
        }

        return {
            updateBtn,
            planBtn,
            updatePage,
            planPage,
            costBtn,
            costPage,
        }
    }
}
</script>
<style>

</style>
