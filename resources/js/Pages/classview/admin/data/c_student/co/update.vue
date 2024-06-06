<template> 
    <div class="p-0 flex justify-center gap-2"> 
        <!-- data:{{ data }} save_student_data()-->
        <div class="P-0">
            <a-form
                @finish="$emit('ok',felid_form)"
                @finishFailed="onFinishFailed"
                :model="felid_form"
                dir="rtl"
            > 
                <a-form-item
                    name="ar"
                    has-feedback
                    :rules="[{ required: true, message: ' name ' }]"
                >
                    <template #label>
                        <div class="p-0 w-32">
                            {{ felid_names?.ar[lang] }}
                        </div>
                    </template>
                    <a-input
                        v-model:value="felid_form.ar"
                        placeholder=" "
                    />
                </a-form-item>

                <a-form-item
                    name="en"
                    has-feedback
                    :rules="[
                        {
                            required: true,
                            message: 'بيان مطلوب - required!',
                        },
                    ]"
                >
                    <template #label>
                        <div class="p-0 w-32">
                            {{ felid_names?.en[lang] }}
                        </div>
                    </template>
                    <a-input
                        v-model:value="felid_form.en"
                        placeholder=" choice"
                    />
                </a-form-item>

                <a-form-item
                    name="nationality_ar"
                    has-feedback
                    :rules="[
                        {
                            required: true,
                            message: 'بيان مطلوب - required!',
                        },
                    ]"
                >
                    <template #label>
                        <div class="p-0 w-32">
                            {{ felid_names?.nationality_ar[lang] }}
                        </div>
                    </template>
                    <a-input
                        v-model:value="felid_form.nationality_ar"
                        placeholder=" choice"
                    />
                </a-form-item>

                <a-form-item
                    name="nationality_en"
                    has-feedback
                    :rules="[
                        {
                            required: true,
                            message: 'بيان مطلوب - required!',
                        },
                    ]"
                >
                    <template #label>
                        <div class="p-0 w-32">
                            {{ felid_names?.nationality_en[lang] }}
                        </div>
                    </template>
                    <a-input
                        v-model:value="felid_form.nationality_en"
                        placeholder=" choice"
                    />
                </a-form-item>

                <a-form-item
                    name="birth_date"
                    has-feedback
                    :rules="[
                        {
                            required: true,
                            message: 'بيان مطلوب - required!',
                        },
                    ]"
                >
                    <template #label>
                        <div class="p-0 w-32">
                            {{ felid_names?.birth_date[lang] }}
                        </div>
                    </template>

                    <a-date-picker
                        class="w-full"
                        v-model:value="felid_form.birth_date"
                        value-format="YYYY-MM-DD"
                    />
                </a-form-item>

                <a-form-item
                    name="national_id"
                    has-feedback
                    :rules="[
                        {
                            required: true,
                            message: 'بيان مطلوب - required!',
                        },
                    ]"
                >
                    <template #label>
                        <div class="p-0 w-32">
                            {{ felid_names?.national_id[lang] }}
                        </div>
                    </template>

                    <a-input-number
                        class="w-full"
                        v-model:value="felid_form.national_id"
                    />
                </a-form-item>

                <a-form-item
                    name="passport"
                    has-feedback
                    :rules="[
                        {
                            required: false,
                            message: 'بيان مطلوب - required!',
                        },
                    ]"
                >
                    <template #label>
                        <div class="p-0 w-32">
                            {{ felid_names?.passport[lang] }}
                        </div>
                    </template>

                    <a-input 
                        class="w-full"
                        v-model:value="felid_form.passport"
                    />
                
                 </a-form-item>


                <a-form-item
                    
                
                >
                    <template #label>
                        <div class="p-0 w-32">
                            {{ felid_names?.notes[lang] }}
                        </div>
                    </template>

                    <a-input 
                        class="w-full"
                        v-model:value="felid_form.notes"
                    />
             

 




                 </a-form-item>
                 <div class="p-4 rounded flex flex-col justify-center  bg-red-300">
 
      <a-select
    v-model:value="felid_form.class_id"
    style="width: 300px"
    :options="classes"
  
:field-names="{ label: 'ar', value: 'id', options: 'classes' }"
    ></a-select>
                    <div>


      <a-select
    v-model:value="felid_form.task1"
    style="width: 300px"
    :options="[{label: 'التعديل علي البيانات', value: 0},{label: ' لا يمكنه التعديل  علي البيانات', value: 1}]"
    ></a-select>
    <!-- :field-names="{ label: 'name', value: 'id', options: 'children' }" -->


    </div>

                     <div class="pt-4">
      <!-- <a-radio-group v-model:value="felid_form.paid" button-style="solid">
        <a-radio-button :value="1">مشاهدة التقرير</a-radio-button>
        <a-radio-button :value="0">حجب التقرير </a-radio-button>
 
      </a-radio-group>  :filter-option="filterOption" -->
<!-- sdasdsad{{ classes }} -->
      <a-select
    v-model:value="felid_form.paid"
    style="width: 300px"
    :options="[{label: 'حجب التقرير', value: 0},{label: 'مشاهدة التقرير', value: 1}]"
  

    ></a-select>


    </div>   </div>             
                <!-- v-bind="tailLayout" -->
                <a-form-item>
                    <a-button html-type="submit" type="primary">{{
                        Ap.lang == "en" ? "Submit" : "تأكيد الحفظ"
                    }}</a-button>
                </a-form-item>
            </a-form>
        </div>
        <!-- </a-card> -->
    </div>
</template>
<script setup>
import { computed, ref ,onMounted } from "vue";
const props = defineProps(["data",'classes']);

// import type { FormInstance } from "ant-design-vue";
// import { SmileOutlined, UserOutlined } from "@ant-design/icons-vue";
import { useAppStore } from "@/stores/appstore";
const emits = defineEmits(["open_modal"]);
const Ap = useAppStore();

const lang = computed(() => Ap.lang);

const felid_form = ref({
    ar            : props?.data?.ar,
    en            : props?.data?.en,
    nationality_ar:  props?.data?.nationality_ar,
    nationality_en:  props?.data?.nationality_en,
    birth_date    :  props?.data?.birth_date,
    national_id   :  props?.data?.national_id,
    passport      :  props?.data?.passport,
    // gmail      : null,
    notes         : props?.data?.notes,
    task1         : props?.data?.task1,
    paid         : props?.data?.paid,
    student_id         : props?.data?.student_id,
    class_id         : props?.data?.class_id,

});
// onMounted(()=>{
//     felid_form.value.ar=props?.data?.ar
// })
const felid_names = {
    ar: { val: "", en: "Name Arabic", ar: "الاسم عربي" },
    en: { val: null, en: "Name English", ar: "اسم الانجليزية" },
    nationality_ar: {
        val: null,
        en: "Nationality Arabic",
        ar: "الجنسية عربية",
    },
    nationality_en: {
        val: null,
        en: "Nationality English",
        ar: "الجنسية الانجليزية",
    },
    birth_date: { val: null, en: "Birth Date", ar: "تاريخ الميلاد" },
    national_id: { val: null, en: "ID /Iqama NO", ar: "رقم الهوية/الإقامة" },
    passport: { val: null, en: "Passport NO", ar: "رقم جواز السفر" },
    notes: { val: null, en: "notes  ", ar: "ملاحظات" },
    task1: { val: null, en: "update his data  ", ar: " تحديث بياناته" },
    paid: { val: null, en: " See results  ", ar: "مشاهدة التقرير" },

    msg: {
        val: null,
        en: "Dear Parent: Please ensure that all data matches the student’s ID or passport data",
        ar: "مكرم ولي الأمر: برجاء التأكد من ان جميع البيانات مطابقة لبيانات هوية الطالب أو جواز السفر",
    },
};

function onFinishFailed() {
    // message.error("err");
    //console.log("felid_form.value");
    //console.log(felid_form.value);
}


const task1 = ref(null);
 
</script>
