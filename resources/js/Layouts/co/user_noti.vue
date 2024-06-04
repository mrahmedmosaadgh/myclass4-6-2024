<script setup>
import {BellOutlined } from '@ant-design/icons-vue';
 
</script>

<template>
<div>
    <div class="flex gap-2 p-2    text-xs  mx-4">

        <!-- <div class="px-1 rounded-full border-2">{{  data.role}}</div> -->

 
    </div>
  
    <a-dropdown>
 <div class="p-0">
    <a-badge count="3">
         <a-button type="text"   class="  hover:scale-110" >
        <template #icon><div class=" -mt-2  text-2xl">  <BellOutlined /></div>
        
        </template>
      </a-button>
  </a-badge>

 </div>





    <template #overlay>
      <a-menu>
        <!-- <a-menu-item></a-menu-item> -->
            <div class="px-1">
            <div class="px-1" > ( 0 ) رسالة غير مقروءة</div>
            <div class="px-1" >عرض الكل</div>
            <div class="px-1" >تعيين الكل كمقروء</div>
           


        
        </div>
        
 
      </a-menu>
    </template>
  </a-dropdown>

    
</div>
</template>
