<template>
  <div class="flex">
    <litepie-datepicker :formatter='formatter' as-single use-range v-model="dateValue"></litepie-datepicker>
  </div>
  <div>
      <!-- {{ date }} -->
  </div>
</template>

<script>
  import { ref, watch } from 'vue';
  import LitepieDatepicker from 'litepie-datepicker';
  import { onMounted } from 'vue'

  export default {
    components:{
        LitepieDatepicker
    },
    props : [
        'date',
    ],
    setup(props, context) {
        const dateValue = ref([]);
        const formatter = ref({
            date: 'YYYY-MM-DD',
            month: 'MMM'
        })

        // dateValue.value[0] = props.date.start_period
        // dateValue.value[1] = props.date.end_period
        // context.emit('period', dateValue)

        watch(dateValue ,() => {
            console.log('emit')
            context.emit('period', dateValue.value)
            // emit('period', dateValue)
        })



        onMounted(() => {
            if(props.date == null) {
                return
            }
            dateValue.value[0] = props.date.start_period
            dateValue.value[1] = props.date.end_period
            context.emit('period', dateValue.value)
        })

        return {
            dateValue,
            formatter,
            onMounted
        };
    },


  }
</script>
// https://chodragon9.github.io/blog/composition-api-rfc-migration/#state
