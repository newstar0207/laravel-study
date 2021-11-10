<template>
    <app-layout>
        <template #header>
            <div class="flex flex-row items-start">

            </div>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex flex-col verflow-hidden text-center bg-white shadow-xl sm:rounded-lg">
                    <div class="mb-4">
                        <span class="text-3xl font-black">sorry ㅋ</span>
                    </div>
                    <div>
                        <span>클릭하신 링크가 잘못되었거나 페이지가 삭제되었습니다ㅋ. </span>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from '../Layouts/AppLayout.vue'
export default {
    components : {
        AppLayout,
    }
}
</script>
<style>

</style>
