<template>
    <div class="min-h-screen w-80 h-80 flex flex-col sm:justify-center items-center pt-6 sm:pt-0  z-10">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
