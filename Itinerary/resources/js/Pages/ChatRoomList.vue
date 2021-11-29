<template>
    <div class="col-span-10 bg-white rounded shadow-lg p-4 my-4 ml-4 mr-4">

        <div class="bg-white">
            <nav class="flex flex-col sm:flex-row">

                <!-- <Link href="/"> -->
                <button @click="updatePage"  class="text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none text-blue-500 border-b-2 font-medium border-blue-500">
                    Room
                </button>
                <!-- </Link> -->
                <button @click='planPage'  class="text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none">
                    Plan
                </button>
                <button @click="costPage"  class="text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none">
                    Cost
                </button>
                <button  class="text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none">
                    Tab 4
                </button>
            </nav>

        </div>

        room.password : {{ room.password }}
        <update-chat-room v-if="updateBtn" :room ='room' :roomUsers = 'roomUsers'></update-chat-room>
        <chat-room-plan v-if="planBtn" :room='room' ></chat-room-plan>
        <chat-room-cost v-if="costBtn" :room='room'></chat-room-cost>
    </div>


</template>
<script>
import UpdateChatRoom from './UpdateChatRoom.vue'
import { ref } from 'vue'
import ChatRoomPlan from './ChatRoomPlan.vue'
import ChatRoomCost from './ChatRoomCost.vue'

export default {
    props : [
        'room',
        'roomUsers'
    ],
    components : {
        UpdateChatRoom,
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
