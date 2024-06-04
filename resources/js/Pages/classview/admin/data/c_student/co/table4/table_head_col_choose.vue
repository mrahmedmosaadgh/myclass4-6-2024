<template>
<div class=" flex flex-row  ">
  <a-popover   trigger="click">
    <template #content>
    <div class=" text-left flex whitespace-nowrap" v-for="(item, index) in props.data" :key="index">
   <button  @click="item.show=!item.show" class="w-full m-1 rounded px-1" :class="item.show?'green ':'bg-gray-200'">
   <div class="  text-left"  v-if="item.show"   >
{{props.lang=='en'? item['en']: item['ar']}}

   </div>

   <div class="  text-left"  v-if="!item.show">
{{props.lang=='en'? item['en']: item['ar']}}

   </div>


   </button>

    <!-- <a-switch v-model:checked="item.val">
      <template #checkedChildren><CheckOutlined />{{item.text}}</template>
      <template #unCheckedChildren><CloseOutlined />{{item.text}}</template>
    </a-switch> -->

<!-- {{item}} -->
    </div>
<!-- {{props.data}} -->


    </template>
    <a-button type="text" size="small"  class=" noprint hover:opacity-100 opacity-40 " @click="fun()"><MoreOutlined /></a-button>
  </a-popover>



<div class="p-0 flex  text-xs">
{{props.text}}

</div>

</div>
</template>
<script   setup>
import {
    // SearchOutlined,
    MoreOutlined,
    // CloseOutlined,CheckOutlined
    }  from '@ant-design/icons-vue';
// import table_sort_icon from "./table_sort_icon.vue";
const props=defineProps(['data','text','col','lang' ])
const emit=defineEmits(['my_col'])
function fun(){
    //console.log(props.col);
 emit('my_col',props.col)
}
</script>

