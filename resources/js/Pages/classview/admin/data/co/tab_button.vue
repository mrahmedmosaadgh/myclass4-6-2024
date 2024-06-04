<template>
    <div>
                <button
                    @click="$emit('my_comp')"
                    :class="
                       data?.active == 1
                            ? 'bg-green-800 p-2 text-white  rounded-tl-md rounded-tr-md'
                            : 'p-2  text-gray-400 '
                    "
                >
                    {{ data?.lang == "en" ? data?.title?.en : data?.title?.ar }}
                </button>
    </div>
</template>
<script setup>
// import { ref } from "vue";
// import { useAppStore } from "@/stores/appstore";
// const Ap = useAppStore();
defineProps(['data'])
// const db_msg = ref(null);

</script>
