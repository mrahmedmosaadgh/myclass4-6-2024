<script setup>
 const data={
    role:'Admin',
    school:'AMS',
    semester:'Third semester 1445',
    time:'Saturday, June 1st, 2024 at 5:27 PM (GMT+03:00)',
 }
</script>

<template>
<div class="p-0   ">
    <div class="flex gap-2 p-2 opacity-50 fixed  top-0 text-xs  mx-4">

        <div class="px-1 rounded-full border-2">{{  data.role}}</div>
        <div class="px-1">{{  data.school}}</div>
        <div class="px-1">{{  data.semester}}</div>
        <div class="px-1">{{  data.time}}</div>
    </div>
  
</div>
</template>
