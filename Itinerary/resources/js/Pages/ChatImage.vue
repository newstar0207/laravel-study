<template>

    <!-- room 의 메세지에 있는 사진만 모아서 볼 수 있는 공간 -->

    <dir class="inline-grid grid-cols-3 gap-x-4 gap-y-4 pl-10 pr-10 pt-6">
            <div v-for="image in chatImage" :key="image.id" class="w-full bg-white rounded-lg shadow-md">
                <div class="flex justify-between m-6 flex flex-col">
                    <div class="">
                        <img :src="image.image" :alt="chatImage.chat">
                    </div>
                    <div class="mt-3 flex justify-between">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <div class="font-semibold text-gray-400 text-base content-end">{{ image.room.title }}</div>
                    </div>
                </div>
            </div>
        </dir>
</template>
<script>
export default {
    props: [
        'chatImage'
    ]

}
</script>
<style >

</style>
