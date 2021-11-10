<template>
    <div class="rounded overflow-hidden shadow-lg">
      <img class="w-full" src="/mountain.jpg" alt="Mountain">
      <div class="px-6 py-4">
        <div class="font-bold text-xl mb-2">Mountain</div>
        <p class="text-gray-700 text-base">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
        </p>
      </div>
      <div class="px-6 pt-4 pb-2">
        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
      </div>
    </div>

    <jet-confirmation-modal :show="confirmingUserDeletion" @close="confirmingUserDeletion = false">
        <template #title>
            Delete Account
        </template>
        <template #content>
            want delete?
        </template>
        <template>
            <jet-secondary-button @click.native='confirmingUserDeletion = false'>
                Nevermind
            </jet-secondary-button>
        </template>
    </jet-confirmation-modal>
</template>
<script>
import jetConfirmationModal from '../../Jetstream/ConfirmationModal.vue'
import JetSecondaryButton from '../../Jetstream/SecondaryButton.vue'
import { ref } from 'vue'
export default {
    components : {
        jetConfirmationModal,
        JetSecondaryButton,
    },
    setup() {
        const confirmingUserDeletion = ref([false]);

        return { confirmingUserDeletion }
    }
}
</script>
<style>

</style>
