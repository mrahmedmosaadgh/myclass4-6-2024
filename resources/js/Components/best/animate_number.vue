<template>
  <div ref="numberDiv" @click="animate1()">0</div>
  <!-- {{props?.number}} / {{props?.duration}}

   <animate_number v-if="show_animate_number"
:duration="100"
:number="item"
>animate_number err</animate_number>

  -->
</template>

<script setup>
import { ref, onMounted } from 'vue';
const props=defineProps(['duration','number'])
const emit=defineEmits([ 'number'])

    const numberDiv = ref(0);

    onMounted(() => {
    //   const duration = 1000; // 1 second
    //   const number = 100  ;
    //   const increment = number / duration;
  animate1()
    });

function animate1(){
     var increment = props?.number / props?.duration;
    // const increment = ref(props.number / props.duration);
//
      let currentNumber = 0;

      const intervalId = setInterval(() => {
        currentNumber += increment;
        if (numberDiv.value){
        numberDiv.value.textContent = Math.floor(currentNumber);
// emit('number',numberDiv.value.textContent)
        }

        if (currentNumber >= props?.number) {
          clearInterval(intervalId);
        }
      }, 1);
}
</script>
