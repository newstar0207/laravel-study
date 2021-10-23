<template>


    <div v-for="chat in this.$store.state.chats" :key="chat.id">
        <div class="col-start-1 col-end-8 p-3 rounded-lg" v-if="chat.user_id == this.user.id">
            <div class="flex flex-row items-center">
                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">A</div>
                <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                    <div>
                        {{  chat.chat }}
                    </div>
                </div>
            </div>
        </div>


        <div class="col-start-6 col-end-13 p-3 rounded-lg" v-else>
            <div class="flex items-center justify-start flex-row-reverse">
            <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0" >A</div>
                <div class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                    <div>{{ chat.chat }}</div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            user : this.$store.state.user
        }
    },
}
</script>
<style>

</style>
