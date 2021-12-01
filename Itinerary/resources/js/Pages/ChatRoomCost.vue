<template>
    <div>
        {{ room }}
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
    </div>
</template>
<script>
import { reactive } from '@vue/reactivity'
export default {
    props : [
        'room'
    ],

    setup(props) {
        const form = reactive({
            food : '',
            room : '',
            tran : '',
            other : '',
        })

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
        }
    }

}
</script>
<style>

</style>
