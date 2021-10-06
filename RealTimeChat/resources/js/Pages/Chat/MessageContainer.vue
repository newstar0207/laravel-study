<template>
    <div class="h-96 w-full">
        <div class="p-2 flex flex-col-reverse overflow-scroll">
            <div v-for="msg in messages" :key="msg.id">
                <message-item :message= 'msg'></message-item>
            </div>
        </div>
    </div>
</template>
<script>
import MessageItem from './MessageItem.vue';
export default {
    props : ['messages'],
    components : {
        MessageItem,
    }
}
</script>

