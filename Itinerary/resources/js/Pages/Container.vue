<template>
    <container-layout>

        container!
        <!-- <div class="p-6 sm:px-20 bg-white border-b border-gray-200"> -->
        <div>
            error
            {{  error }}
        </div>

        <div>
            <create-room></create-room>
        </div>

        <!-- 모든 방 리스트 -->

        <div>
            <room-list :roomList = 'roomList'></room-list>
        </div>


        <!-- 룸 검색하기 -->
        <div class="border-2 border-gray-500">
            <form @submit.prevent="submit">
                <label for="first_name">Room Search</label>
                <br>
                <input id="first_name" v-model="form.searchRoomPassword" />
                <br>
                <button type="submit" class="bg-blue-500 hover:bg-blue-400">Submit</button>
            </form>
        </div>

    </container-layout>
</template>
<script>
import Navi from './Room/Navi.vue'
import ContainerLayout from '../Layouts/ContainerLayout.vue'
import CreateRoom from './CreateRoom.vue'
import { reactive } from '@vue/reactivity'
import { Inertia } from '@inertiajs/inertia'
import RoomList from './RoomList.vue'
export default {
    components : {
        ContainerLayout,
        Navi,
        CreateRoom,
        RoomList,
    },
    props : [
        'roomList',
        'exist',
        'error'
    ],
    setup() {
        const form = reactive({
            searchRoomPassword : null,
        })
        const submit = () => {
            Inertia.get('/room/find', form, {
                preserveScroll: true,
            });
        }

        return { form, submit}
    }

}
</script>
<style>
</style>

