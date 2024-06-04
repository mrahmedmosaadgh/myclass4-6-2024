<template>



<div    class=" relative  ">
<!-- <div class="p-0 relative">
 <CaretUpOutlined    class="absolute top-0"   />
 <CaretDownOutlined  class="absolute top-2 opacity-40" />
</div> -->

 
 <button v-if="props.data==1" class=" absolute  rounded-full     -top-2  ">

 <CaretUpOutlined    class="absolute opacity-40"   />
 <CaretDownOutlined  class="   transform translate-y-1   opacity-40" />

</button>

<button v-if="props.data==2" class=" absolute       -top-2  ">
 <CaretUpOutlined    class="absolute  "   />
 <CaretDownOutlined  class="     transform translate-y-1  opacity-20" />
</button>
<button v-if="props.data==3" class=" absolute       -top-2  ">
 <CaretUpOutlined    class="absolute  opacity-20 "   />
 <CaretDownOutlined  class="     transform translate-y-1 " />
</button>

 </div>


</template>
<script   setup>
// import { SearchOutlined } from '@ant-design/icons-vue';
import { reactive, ref } from 'vue';
import {CaretDownOutlined,CaretUpOutlined,
// SortAscendingOutlined,SearchOutlined,FastBackwardOutlined, StarOutlined, StarFilled, StarTwoTone
 }  from '@ant-design/icons-vue';

// import { useAppStore } from "@/stores/appstore";
const props=defineProps({data:{
default:1
}} )
// const Ap = useAppStore();

</script>
<style scoped>
</style>
