<template>
    <div class="flex flex-row  ">
        <a-popover trigger="click" v-model:open="open">
            <template #content>
                <div class="text-left w-40 flex whitespace-nowrap">
                    <a-button
                        type="primary"
                        size="small"
                        @click="
                            $emit('row_view');
                            open = !open;
                        "
                        class="w-full m-1 rounded px-1"
                        ><EyeOutlined
                    /></a-button>
                    <a-button
                        type="primary"
                        size="small"
                        @click="
                            $emit('row_update');
                            open = !open;
                        "
                        class="w-full m-1 rounded px-1"
                        ><EditOutlined
                    /></a-button>
                    <a-button
                        type="primary"
                        danger
                        size="small"
                        @click="
                            $emit('row_delete');
                            open = !open;
                        "
                        class="w-full m-1 rounded px-1"
                        ><DeleteOutlined
                    /></a-button>


                </div>

            </template>
            <a-button
                type="text"
                size="small"
                style="padding: 0px"
                class="noprint  "
                ><MoreOutlined style="padding: 0px; margin: 0px; width: 12px"
            /></a-button>
        </a-popover>
    </div>
</template>
<script setup>
import { ref } from "vue";
import {
    // SearchOutlined,
    MoreOutlined,
    EditOutlined,
    DeleteOutlined,
    EyeOutlined,
    //     SmileOutlined,
    //   SyncOutlined,
    //   LoadingOutlined,
    // CloseOutlined,CheckOutlined
} from "@ant-design/icons-vue";
// import table_sort_icon from "./table_sort_icon.vue";
// const props=defineProps(['data','text','col' ])
const emit = defineEmits(["row_update", "row_delete", "row_view"]);
// function fun(){
//     //console.log(props.col);
//  emit('my_col',props.col)
// }open
const open = ref(false  );
</script>
