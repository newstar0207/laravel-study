<template >
    <div >
        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
            <!-- 로고 -->

        <div class="flex items-center justify-center h-20 bg-white mb-2">
            <h1 class="text-3xl uppercase text-indigo-500">ITINERARY</h1>
        </div>

            <!-- 아이템 -->

        <ul class="flex flex-col bg-white h-screen">
            <li>
                <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-bell"></i></span>
                <span class="text-sm font-medium">Notifications</span>
                <span class="ml-auto mr-6 text-sm bg-red-100 rounded-full px-3 py-px text-red-500">5</span>
                </a>
            </li>
        </ul>
    </div>
</template>
<script>
export default {

}
</script>
<style>

</style>
