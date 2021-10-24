<template>
    <div class="h-96 w-full">
        <div class="p-2 flex flex-col-reverse overflow-scroll">
            <div v-for="msg in messages.data" :key="msg.id">
                <styled-message-item :message="msg"></styled-message-item>
            </div>
        </div>
    </div>
</template>
<script>
import StyledMessageItem from "./StyledMessageItem.vue";
export default {
    components: {
        StyledMessageItem,
    },
    data() {
        return {

        };
    },
    props: ["messages"],
};
</script>
<style>
.scrollbar-w-2::-webkit-scrollbar {
    width: 0.25rem;
    height: 0.25rem;
}

.scrollbar-track-blue-lighter::-webkit-scrollbar-track {
    --bg-opacity: 1;
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--bg-opacity));
}

.scrollbar-thumb-blue::-webkit-scrollbar-thumb {
    --bg-opacity: 1;
    background-color: #edf2f7;
    background-color: rgba(237, 242, 247, var(--bg-opacity));
}

.scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
    border-radius: 0.25rem;
}
</style>
