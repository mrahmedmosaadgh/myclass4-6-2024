<template>
<div class="p-0 flex flex-row  ">
  <a-popover   trigger="click">
    <template #content>
    <div class="  flex ">
<div class="  relative" @click="$emit('my_col',props.col)">
<table_sort_icon class="  hover:opacity-100 opacity-40" v-if="props.data.sort==1" :data="props.data.sort"  @click="props.data.sort=2"  >table_sort_icon err</table_sort_icon>
<table_sort_icon class="  hover:opacity-100 opacity-40" v-if="props.data.sort==2" :data="props.data.sort"  @click="props.data.sort=3"  >table_sort_icon err</table_sort_icon>
<table_sort_icon class="  hover:opacity-100 opacity-40" v-if="props.data.sort==3" :data="props.data.sort"  @click="props.data.sort=1"  >table_sort_icon err</table_sort_icon>


</div>
<!-- v-model:value="formState.user" -->
  <a-input class="ml-6"
  v-model:value="props.data.search_text"
    placeholder="filter"
@keyup.enter="$emit('text_filter',{text:props.data.search_text,col:props.col})"
  >
        <template #prefix><SearchOutlined style="props.color: rgba(0, 0, 0, 0.25)" /></template>
      </a-input>

    </div>



    </template>
    <a-button type="text" size="small" class="noprint hover:opacity-100 opacity-40 "  ><MoreOutlined /></a-button>
  </a-popover>



<div class="  text-center w-full  text-xs">
{{props.text}}

</div>

</div>
</template>
<script   setup>
import {SearchOutlined,MoreOutlined}  from '@ant-design/icons-vue';
import table_sort_icon from "./table_sort_icon.vue";
const props=defineProps(['data','text','col' ])
const emit=defineEmits(['my_col','text_filter'])
// function fun(){
//     // //console.log(props.col);
//  emit('my_col',props.col)
// }
</script>

