<template>
    <div>
        h2h2
        <div v-for="roomList in room" :key="roomList.id">
            {{  room.title }}
        </div>

        <form action="/chatroom" method="post">
            <input type="text" label="title">
            <button>save</button>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return{
            roomList : null,
        }
    },
    created() {
        axios.get('/chatroom')
            .then(response => {
                this.roomList = response.data
                console.log(response)
            })
            .catch(error => {
                console.error(error)
            })
    }
}
</script>
<style>

</style>
