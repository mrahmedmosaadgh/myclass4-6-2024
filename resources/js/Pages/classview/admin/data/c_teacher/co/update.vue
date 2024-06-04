<template>
<div class="p-0">




                <a-form
                    :dir="Ap.lang == 'en' ? 'ltr' : 'rtl'"
                    ref="formRef"
                    name="data"
                    :model="data"
                >

                    <a-form-item
                        label="name ar"
                        name="ar"
                        has-feedback
                        :rules="[
                            {
                                required: true,
                                message: 'Please input   name ar!',
                            },
                        ]"
                    >
                        <a-input v-model:value="data.ar" />
                    </a-form-item>

                    <a-form-item
                        label="name en"
                        name="en"
                        has-feedback
                        :rules="[
                            {
                                required: true,
                                message: 'Please input   name en!',
                            },
                        ]"
                    >
                        <a-input v-model:value="data.en" />
                    </a-form-item>

                    <a-form-item
                        label="detail"
                        name="detail"
                        has-feedback
                        :rules="[
                            {
                                required: true,
                                message: 'Please input   detail!',
                            },
                        ]"
                    >
                        <a-input v-model:value="data.detail" />
                    </a-form-item>

 

                </a-form>










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
