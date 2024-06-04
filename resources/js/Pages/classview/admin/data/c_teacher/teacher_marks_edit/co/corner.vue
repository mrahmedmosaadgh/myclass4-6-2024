<template>
        <div :style="`background-color: ${color};border-top-left-radius: 4px;border-top-right-radius: 4px; ;`"  class="-translate-x-6  w-full         relative   text-white text-center">
            <div class="p-0 whitespace-break-spaces "  dir="rtl" >

               {{ text }}
            </div>
<div class="corner  " dir="rtl" :style="`color: ${color};`"></div>
 </div>
</template>
<script   setup>
defineProps(['text','color' ]);
</script>
<style   scoped>
.corner {
    position: absolute;
    top: 100%;
    width: 10px;
    height: 10px;
    /* color: currentcolor; */
    border: 6px solid;
    transform: scaleY(0.75);
     
    transform-origin: top;
    filter: brightness(75%);
/* color:green  ; */
    inset-inline-end: 0;
    border-inline-end-color: transparent;
    border-block-end-color: transparent;
}
</style>