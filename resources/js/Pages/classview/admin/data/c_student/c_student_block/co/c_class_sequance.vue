<template>
<div class="p-0">



</div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { EyeOutlined } from "@ant-design/icons-vue";
import { useAppStore } from "@/stores/appstore";
// import animate_number from "@/components/best/animate_number.vue";
const props = defineProps(["data"]);
const Ap = useAppStore();
const selected_school_id = ref(null);

function fun_delete(event) {
    //console.log("fun_delete", event);
}
function fun_filter(event) {
    //console.log("fun_filter", event);
}

function fun_before(fun) {}

function fun_next(res, fun) {}
function fun_db(data) {
    if (!data.route) {
        Ap.ms("error", "empty route", 1, 1);
    }
    fun_before(data.fun);
    try {
        axios.post(data.route, data).then((res) => {
            Ap.ms("success", "loading done", 1, 1);
            //console.log("db", res.data);
            fun_next(res.data, data.fun);
        });
    } catch (e) {
        //console.log(e);
        Ap.ms("error", "loading error", 1, 1);
    }
}
</script>
 