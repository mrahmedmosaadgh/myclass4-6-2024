<template>
<div class="p-0">



</div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { EyeOutlined } from "@ant-design/icons-vue";
import { useAppStore } from "@/stores/appstore";
const props = defineProps(["data"]);
const Ap = useAppStore();
const selected_school_id = ref(null);

function fun_filter(event) {
    //console.log("fun_filter", event);
}

</script>
