<template>
    <div
        class="bg-white py-5 p-2"
        v-if="Ap.permissions.has('add_school_semester')"
    >
        <div class="flex">
            <!-- create_calendar_data okkkkk -->
            <div class="p-2">
                {{ Ap.school_name }}
                <!-- {{ Ap.school_id }} -->
            </div>
            <a-dropdown v-if="Ap?.user_schools?.length > 1">
                <div
                    class="p-1 gap-1 w-4 cursor-pointer flex flex-col text-2xl scale-50"
                >
                    <div class="rounded bg-blue-600 h-2 w-2"></div>
                    <div class="rounded bg-blue-600 h-2 w-2"></div>
                    <div class="rounded bg-blue-600 h-2 w-2"></div>
                </div>

                <template #overlay>
                    <a-menu>
                        <!-- <div class="p-0 text-center">title</div> -->
                        <a-menu-divider />
                        <a-menu-item
                            v-for="school in Ap.user_schools"
                            :key="school.id"
                            @click="
                                show_all_get(
                                    school.school_id,
                                    school.myschool.name_ar
                                )
                            "
                        >
                            <div>
                                {{ school.myschool.name_ar }}
                            </div>
                        </a-menu-item>
                    </a-menu>
                </template>
            </a-dropdown>
        </div>

        <a-modal
            :okButtonProps="{
                disabled: true,
                hidden: true,
            }"
            :cancelButtonProps="{
                disabled: true,
                hidden: true,
            }"
            :maskClosable="false"
            ref="modalRef"
            v-model:open="showModal.show"
            :wrap-style="{ overflow: 'auto' }"
        >
            <!-- @ok="handleOk" -->
            <template #title>
                {{ showModal.mood == "modal_update" ? "update" : "new" }}
            </template>
            <modal_new
                @open="
                    showModal.show = $event;
                    show_all();
                "
                v-if="showModal.mood == 'modal_create'"
                :data="showModal.data"
                >modal_new err</modal_new
            >
            <modal_update
                @open="
                    showModal.show = $event;
                    show_all();
                "
                v-if="showModal.mood == 'modal_update'"
                :data="showModal.data"
                >modal_update err</modal_update
            >
            <!-- <component  :is="showModal.mood"  :data="showModal.data" /> -->
            <!-- <p>Some contents...</p>
      <p>Some contents...</p>
      <p>Some contents...</p> -->
        </a-modal>

        <!-- 2 - main table ---------v-if="!Ap.showmodal_create1"@click="create()"  ------------------------------------------------------------ -->
        <section name="main_table" v-if="Ap.school_id != null">
            <a-button class="noprint" type="primary" @click="showModal_fun()">
                <div class="p-0 w-4 h-4 mybtn_plus_white"></div>
                <!-- {{tr['new'][Ap.lang]}} -->
            </a-button>

            <div class="flex w-full justify-center text-center">
                {{ tr["table_title"][Ap.lang] }}
            </div>
            <div class="overflow-auto">
                <!--mybtn_add--mybtn_add--------------------------------------------------------------------- -->
                <table
                    :class="Ap.mytabl_class"
                    :dir="Ap.lang == 'ar' ? 'rtl' : 'ltr'"
                >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th v-for="(item, i) in main_table_header" :key="i">
                                {{ item[lang] }}
                            </th>

                            <!--table head--end--------------------------------------------------------------------- -->
                        </tr>
                    </thead>
                    <!--table body----------------------e1------------------------------------------------- -->
                    <tbody>
                        <tr
                            v-for="(item, index) in main_table_data"
                            :key="index"
                        >
                            <td>{{ index + 1 }}</td>
                            <td
                                v-for="(head, ii) in main_table_header"
                                :key="ii"
                            >
                                {{
                                    item[head.col] == 1
                                        ? "نشط"
                                        : item[head.col] == 0
                                        ? ""
                                        : item[head.col]
                                }}
                            </td>

                            <td class="noprint">
                                <div class="flex">
                                    <a-button
                                        size="small"
                                        type="primary"
                                        class="ml-2"
                                        @click="update_modal_show(index, item)"
                                    >
                                        <div
                                            class="mybtn_edit_white w-4 h-4 m-1 p-2"
                                        ></div>
                                    </a-button>
                                    <!-- <n-button size="small"    class=" ml-2" type="info"  >
                                       <svg version="1.1"   xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="eye-open.svg" inkscape:version="0.48.4 r9939" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22px" height="22px" viewBox="0 0 1200 1200" enable-background="new 0 0 1200 1200" xml:space="preserve" fill="white" stroke="#efe6e6"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <sodipodi:namedview inkscape:cy="417.05123" inkscape:cx="455.50398" inkscape:zoom="0.37249375" showgrid="false" id="namedview30" guidetolerance="10" gridtolerance="10" objecttolerance="10" borderopacity="1" bordercolor="#666666" pagecolor="#ffffff" inkscape:current-layer="svg2" inkscape:window-maximized="1" inkscape:window-y="24" inkscape:window-height="876" inkscape:window-width="1535" inkscape:pageshadow="2" inkscape:pageopacity="0" inkscape:window-x="65"> </sodipodi:namedview> <path id="path6686" inkscape:connector-curvature="0" d="M779.843,599.925c0,95.331-80.664,172.612-180.169,172.612 c-99.504,0-180.168-77.281-180.168-172.612c0-95.332,80.664-172.612,180.168-172.612 C699.179,427.312,779.843,504.594,779.843,599.925z M600,240.521c-103.025,0.457-209.814,25.538-310.904,73.557 c-75.058,37.122-148.206,89.496-211.702,154.141C46.208,501.218,6.431,549,0,599.981c0.76,44.161,48.13,98.669,77.394,131.763 c59.543,62.106,130.786,113.018,211.702,154.179c94.271,45.751,198.616,72.092,310.904,73.557 c103.123-0.464,209.888-25.834,310.866-73.557c75.058-37.122,148.243-89.534,211.74-154.179 c31.185-32.999,70.962-80.782,77.394-131.763c-0.76-44.161-48.13-98.671-77.394-131.764 c-59.543-62.106-130.824-112.979-211.74-154.141C816.644,268.36,712.042,242.2,600,240.521z M599.924,329.769 c156.119,0,282.675,120.994,282.675,270.251c0,149.256-126.556,270.25-282.675,270.25S317.249,749.275,317.249,600.02 C317.249,450.763,443.805,329.769,599.924,329.769L599.924,329.769z"></path> </g></svg>
                                    </n-button> -->

                                    <!-- v-model:open="show_delete_confirm" -->
                                    <a-popover title="Title" trigger="click">
                                        <template #content>
                                            {{ tr["sure"][Ap.lang] }}
                                            delete {{ item.name }}
                                            <a-button
                                                type="primary"
                                                danger
                                                @click="
                                                    show_delete_confirm =
                                                        !show_delete_confirm;
                                                    fun_delete(item.id);
                                                "
                                            >
                                                delete</a-button
                                            >

                                            <!-- <a @click="show_delete_confirm=!show_delete_confirm;fun_delete(item.id)">Close</a> -->
                                        </template>
                                        <!-- <a-button type="primary">Click me</a-button> -->
                                        <div
                                            class="mybtn_delete cursor-pointer w-6 h-6 p-3"
                                        ></div>
                                    </a-popover>
                                </div>
                            </td>
                            <!--table body--end-- circle--circle-quaternary-----warning----------------------------------------------------------- -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 2 - main table --end------------------------------------------------------------------- -->
    </div>
    <no_permission v-else>no_permission err</no_permission>

</template>

<script setup>
import { ref, onMounted, computed, watch } from "vue";
import { useAppStore } from "@/stores/appstore";
// import { useschoolAdminStore } from "@/stores/schoolAdminStore";
import modal_new from "./com/add_school_semester_new.vue";
import modal_update from "./com/add_school_semester_update.vue";

const Ap = useAppStore();
// const schoolAdminStore = useschoolAdminStore();
const path_fix = "/api/school_admin/add_school_semester/";
const lang = computed(() => Ap.lang); //

const main_table_data = ref(""); //
const show_delete_confirm = ref(false); //
const showModal = ref({ show: false, mood: "modal_update", data: {} }); //

const api = ref({
    create: path_fix + "create",
    update: path_fix + "update",
    delete: path_fix + "delete",
    show_all: path_fix + "show_all",
    show: path_fix + "show",
});
const main_table_header = [
    //  {col:    'id'        , en:'id'                    , ar   : 'id'        , show   : 0  },
    { col: "year", en: "year", ar: "year", show: 1 },
    { col: "en", en: "name", ar: "name", show: 1 },
    { col: "ar", en: "name_ar", ar: "name_ar", show: 1 },
    //  {col:    'name_en'   , en:'name_en'               , ar   : 'name_en'   , show   : 1  },
    { col: "active", en: "active", ar: "نشط", show: 1 },
    //  {col:    'school_id' , en:'school_id'             , ar   : 'school_id' , show   : 0  },
];

const tr = ref(
    {
        // 'page_title'   :{en:" Upload from xlsx file"    , ar   : '       رفع الدرجات من شيت اكسيل'  },

        //    result_count

        table_title: { en: "school classes", ar: "قائمة فصول المدرسة   " },
        new: { en: "new", ar: "جديد  " },
        show_all: { en: "show_all", ar: "  اظهار الكل  " },
        sure: { en: "Are you sure?", ar: "    هل انت متاكد ؟  " },
        search: { en: "search", ar: "بحث  " },
        result_count: { en: "result_count", ar: "عدد النواتج  " },
        semester: { en: "semester", ar: " الفصل الدراسي  " },

        add: { en: "Add", ar: " اضافة" },
        stage: { en: " Stage   ", ar: "      المرحلة الدراسية      " },
        grade: { en: "Grade", ar: " الصف" },
        classroom: { en: "classroom", ar: " الفصل" },
        notes: { en: "Notes", ar: " ملاحظات" },
        edit: { en: "Edit", ar: "  تعديل" },

        delete: { en: "delete", ar: " حذف" },
        agree: { en: "agree", ar: " موافق" },
        cancel: { en: "cancel", ar: " الغاء" },
        msg1: { en: "cancel", ar: " الغاء" },
        msg2: { en: "cancel", ar: " الغاء" },
        create: { en: "create", ar: " انشاء جديد" },
        update: { en: "update", ar: " تحديث" },
        yes: { en: "yes", ar: "  موافق " },
        no: { en: "no", ar: " الغاء" },

        msg_confirm: { en: "Are you sure ?", ar: " هل انت متاكد ؟" },
    }

    // {{ tr['delete'] ? tr['delete'][lang] :'delete' }}
);

function showModal_fun() {
    showModal.mood = "modal_create";
    showModal.show = true;
    showModal.value = {
        show: true,
        mood: "modal_create",
        data: {
            school_id: Ap.school_id,
            year: "2023-2024",
            en: "",
            ar: "",
            start: "",
            end: "",

            status: 1,
            active: 1,
            notes: null,

            week_end_days_off: [5, 6],
        },
    };
}
//  "id": 1, "admin_id": 1, "school_id": 4, "year_id": 3, "year": "2023-2024", "name": "First trimester forqan 2023", "name_ar": "الفصل الدراسي الاول forqan 2023", "start": "2022-09-22", "end": "2024-11-16", "saturday_off": 1, "semester_days_off": null, "status": 1, "active": 1, "notes": null, "created_at": null, "updated_at": "2024-01-16T07:20:38.000000Z", "week_end_days_off": [ 5, 6 ] }
//  }

async function fun_delete(id) {
    //  delete  ---------------------------------------
    //  var msg=tr.value['msg_confirm'] ? tr.value['msg_confirm'][lang.value] :'msg_confirm'

    //  if(!confirm(msg )){ return}
    // if(!confirm(msg+msg2+' ?')){ return}

    Ap.loading = true;

    try {
        await axios
            .post(api.value["delete"], {
                id: id,
            })

            .then((res) => {
                Ap.loading = false;

                //console.log(" delete res.data");
                //console.log(res.data);
                //    showModal_create.value==false
                //  formValue.value=formValue_reset.value

                show_all();

                Ap.db_success = true;
            });
    } catch (e) {
        // Ap.showmodal1=false
        Ap.loading = false;
        Ap.db_error = true;
        //console.log(e);
    }
} //delete end

onMounted(() => {
    show_all();
});

//   ---------------------------------------------------------------------

async function show_all() {
    //  show_all  ---------------------------------------
    Ap.loading = true;

    try {
        await axios
            .post(api.value["show_all"], {
                school_id: Ap.school_id,
                //  'school_id':school_id.value,
                //  'colsdb':colsdb.value,
            })
            .then((res) => {
                Ap.loading = false;
                //console.log("show_all------>");
                //console.log(res.data);
                main_table_data.value = res.data.data;
                // main_table_data_reset.value = res.data.data;
                ap.user_schools = res.data.user_schools;
                Ap.school_id = res.data.school_id;

                Ap.school_name =
                    res.data.user_schools?.[0]?.myschool?.name_ar;
            });
    } catch (e) {
        Ap.loading = false;
        //console.log(e);
    }
} //show_all   show_all  show_all end
//   ---------------------------------------------------------------------

function update_modal_show(index, item) {
    showModal.value = { show: true, mood: "modal_update", data: item };
}
</script>
