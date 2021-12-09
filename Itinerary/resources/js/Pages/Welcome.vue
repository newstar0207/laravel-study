<template>

    <div class="bg-no-repeat bg-cover bg-center relative"  style="background-image: url(https://cdn.pixabay.com/photo/2020/05/30/10/08/video-conference-5238383_1280.jpg);"><div class="absolute bg-gradient-to-b from-green-500 to-blue-400 opacity-75 inset-0 z-0"></div>
        <div class="min-h-screen sm:flex sm:flex-row justify-center">
            <div class="flex items-center z-10 space-x-6">
                <div class="flex flex-col text-white">
                    <h1 class="mb-3 font-bold text-5xl flex flex-col">
                        Hi 💕 Welcome Itinerary
                    </h1>
                    <div class="flex">
                        <p class="pr-3">Create a plan in the comfort of chatting with your friends</p>
                        <div>
                            <button v-if="loginCom != false & registerCom != true" @click="registerCom = true, loginCom = false " class="ml-2 text-yellow-200 underline text-2xl">User Register</button>
                            <button v-if="loginCom == false & registerCom == true" @click="registerCom = false, loginCom = true " class="ml-2 text-yellow-200 underline text-2xl">User login</button>
                        </div>
                    </div>
                </div>
                <div>
                    <Link v-if="$page.props.user" :href="route('room.index')" class="ml-2 text-red-400 underline text-5xl">
                        Room
                    </Link>
                    <div v-else>
                        <login v-if="loginCom"></login>
                        <register v-if="registerCom"></register>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        <!-- <Link v-if="canRegister" :href="route('register')" class="ml-2 text-yellow-200 underline text-2xl">
                            User Register
                        </Link> -->

    <!-- <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </Link>
            </template>
        </div>
    </div> -->
</template>
<script>
    import { defineComponent, ref } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Login from '../Pages/Auth/Login.vue'
    import Register from '../Pages/Auth/Register.vue'

    export default defineComponent({
        components: {
            Head,
            Link,
            Login,
            Register,
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        },

        setup(props) {

            const registerCom = ref(false)
            const loginCom = ref(true)

            return {
                registerCom,
                loginCom,
            }
        }
    })
</script>
