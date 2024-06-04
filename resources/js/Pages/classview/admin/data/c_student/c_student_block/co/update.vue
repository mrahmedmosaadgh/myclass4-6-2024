<template>
    <div class="p-0">
        <a-form
            :dir="Ap.lang == 'en' ? 'ltr' : 'rtl'"
            ref="formRef"
            name="data"
            :model="data"
        >
            <a-form-item
                name="class_id"
                :label="Ap.lang == 'en' ? '  classroom' : ' الفصل  '"
                has-feedback
                :rules="[
                    {
                        required: true,
                        message: 'Please select a classroom!',
                    },
                ]"
            >
                <a-select
                    v-model:value="data.class_id"
                    placeholder="Please select a classroom"
                >
                    <a-select-option
                        v-for="classroom in classes"
                        :value="classroom.id"
                        >{{ classroom.ar }}</a-select-option
                    >
                </a-select>
            </a-form-item>

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

            <a-form-item
                :label="Ap.lang == 'en' ? ' show report  ' : ' اظهار التقرير'"
                name="paid"
                has-feedback
                :rules="[
                    {
                        required: true,
                        message: 'Please input   detail!',
                    },
                ]"
            >
                <a-checkbox v-model:checked="data.paid">
                    <!-- @change="onCheckAllChange" -->
                </a-checkbox>
            </a-form-item>
        </a-form>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { EyeOutlined } from "@ant-design/icons-vue";
import { useAppStore } from "@/stores/appstore";
const props = defineProps(["data", "classes"]);
const Ap = useAppStore();
const selected_school_id = ref(null);
props.data.paid = 1;
function fun_filter(event) {
    //console.log("fun_filter", event);
}
</script>
