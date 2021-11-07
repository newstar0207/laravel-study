<template>
    <container-layout>

        this is container
        <!-- <div class="p-6 sm:px-20 bg-white border-b border-gray-200"> -->
            {{  this.$page.props.user }}

            <!-- 방만들기 -->

            <div class="py-12">
                <div class="bg-white shadow-xl sm:rounded-lg h-300">
                        <form @submit.prevent="submit()">
                        <label>title</label>
                        <input id="title" required class="border-2 border-gray-300" v-model="form.title" />
                        <label>period</label>
                        <date-picker @period='periodPicker'></date-picker>
                        <!-- {{ period }} -->
                        <!-- <input id="period" required class="border-2 border-gray-300" v-model="form.period" /> -->
                        <button type="submit" class="bg-blue-500 hover:bg-blue-400">Submit</button>
                    </form>
                </div>
            </div>

        <!-- 모든 방 리스트 -->
            <!-- <div>{{ roomList }} : roomList</div> -->
            <div>
                <div v-for="room in roomList" :key="room.id" @click="openChatRoom(room)">
                    {{  room.title }}
                </div>
            </div>

    </container-layout>
</template>
<script>
import Navi from './Room/Navi.vue'
import ContainerLayout from '../Layouts/ContainerLayout.vue'
import DatePicker from './DatePicker.vue'
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
export default {
    components : {
        ContainerLayout,
        Navi,
        DatePicker,
    },
    props : [
        'dateValue',
        'roomList',
    ],
    setup (props) {
        console.log(props.roomList)
        const form = reactive({
            title: null,
            period : null,
        })
        const submit = () => {
            Inertia.post('/room', form, {
                preserveScroll: true,
                onSuccess: () => form.reset('title','period'),
            });
        }
        const periodPicker = (period) => {
            console.log(period, 'datavalue...')
            form.period = period
        }

        const openChatRoom = (room) => {
            Inertia.get('/room/' + room.id)
        }

        return { form, submit, periodPicker, openChatRoom }
    },

}
</script>
<style>
</style>

