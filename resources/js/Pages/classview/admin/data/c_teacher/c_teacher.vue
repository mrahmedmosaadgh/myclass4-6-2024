<template>
    <div>
        <div class="hidden h-0">{{ counter }}</div>

        <a-button
            type="primary"
            shape="circle"
            @click="insert_show = !insert_show"
            ><PlusOutlined
        /></a-button>

        <div class="rounded overflow-x-auto w-full m-auto">
            <table cellspacing="0" class="tg w-full">
                <thead class="">
                    <!-- <tr  >
                        <th colspan="32" class="no-border_background pt-4">

                            <div class="p-0 text-center w-full"></div>
                        </th>
                    </tr> -->
                    <tr>
                        <th>#</th>

                        <th class="w-12">
                            <a-button
                                type="primary"
                                shape="circle"
                                @click="sequence_edit = !sequence_edit"
                                ><EditOutlined
                            /></a-button>
                            {{ Ap.lang == "en" ? "id  " : " ترتيب" }}
                        </th>
                        <th class="w-80">
                            <div class="p-0 flex">
                                <div class="p-0">
                                    <a-form-item has-feedback name="ar">
                                        <div class="p-0 text-xs text-gray-300">
                                            filter Ar/En
                                        </div>

                                        <a-input-search
                                            @keyup.enter="show_fun()"
                                            v-model:value="filter_text"
                                            type="text"
                                            autocomplete="off"
                                            @search="show_fun()"
                                        />
                                    </a-form-item>
                                </div>
                            </div>
                            {{ Ap.lang == "en" ? "Name" : "الاسم" }}
                        </th>
                        <!-- <th class="w-24">
                            {{ Ap.lang == "en" ? "classroom" : "الفصل" }}
                        </th> -->
                        <th>
                            count:{{ Ap?.res?.my_teachers?.c_teachers?.length }}
                        </th>
                        <!-- <th class="w-12">
                            {{ Ap.lang == "en" ? "details" : "التفاصيل" }}
                        </th> -->
                    </tr>
                </thead>
                <!-- @click.ctrl="handleCtrlClick(index)" -->
                <tbody>
                    <tr
                        v-for="(item, index) in Ap?.res?.my_teachers
                            ?.c_teachers"
                        :key="index"
                        :class="{
                            even: (index + 1) % 2 === 0,
                            selected: item['select'] == 1,
                        }"
                    >
                        <td class="w-8">
                            <div class="p-0 text-xs flex whitespace-nowrap">
                                <div class="p-0 text-xs">
                                    {{ index + 1 }}
                                </div>
                            </div>
                        </td>
                        <td>


                            <a-input-number
                                v-if="sequence_edit"
                                v-model:value="item.sequence"
                                @blur="
                                    update_col_fun(
                                        item.id,
                                        'sequence',
                                        item.sequence
                                    )
                                "
                            />

                            <div class="p-0" v-if="!sequence_edit">
                                {{ item.sequence }}
                            </div>
                        </td>
                        <td class="w-24">
                            <!-- ------------------------------------------------------------------------------------ -->


                        <div class="p-0 flex m-auto">
                            <n-popover trigger="click" >
                                        <template #trigger>




                                       <a-button type="text" class="p-1 text-white">
                                    <MoreOutlined
                                        class="p-1 rounded-full bg-blue-300 hover:scale-150"
                                    />
                                </a-button>


                                        </template>


      <div class="p-4 flex gap-2  cursor-default">


<a-button
 v-clipboard:copy="item.my_user?.email"
@click="Ap.msg.info('username copied')"
 type="primary"
   >copy username </a-button>
<a-button
 v-clipboard:copy="item.my_user?.my_password"
@click="Ap.msg.info('password copied')"
 type="primary"
   >copy password </a-button>





                                           </div>

                                    </n-popover>




                            <div
                                class="pt-2 flex"
                                :title="
                                    Ap.lang == 'en'
                                        ? item['ar'] + ' ' + item['detail']
                                        : item['en'] + ' ' + item['detail']
                                "
                            >

                                <div class="p-0">
                                    {{
                                        Ap.lang == "en"
                                            ? item["en"]
                                            : item["ar"]
                                    }}
                                </div>
                                <div class="p-0">
                                    <a-alert
                                        class="px-1 py-0 m-0 text-center text-xs red"
                                        message="Blocked"
                                        v-if="item?.paid == 0"
                                        :type="
                                            item?.paid == 0
                                                ? 'error'
                                                : 'success'
                                        "
                                    />
                                </div>
                            </div>
                        </div>








                            <!-- ------------------------------------------------------------------------------------ -->
                        </td>

                        <!-- <td>
                            {{
                                Ap.lang == "en"
                                    ? item?.my_class?.en
                                    : item?.my_class?.ar
                            }}
                        </td> -->

                        <td>
                            <a-dropdown>
                                <a-button type="text" class="p-0 text-white">
                                    <MoreOutlined
                                        class="p-1 rounded-full bg-blue-300 hover:scale-150"
                                    />
                                </a-button>
                                <template #overlay>
                                    <a-menu>
                                        <a-menu-item
                                            key="0"
                                            @click="update_show_fun(item)"
                                        >
                                            {{ Ap.tr("edit_data") }}
                                        </a-menu-item>

                                        <a-menu-divider />
                                        <a-menu-item
                                            key="3"
                                            @click="delete_fun(item.id)"
                                        >
                                            {{ Ap.tr("delete") }}
                                        </a-menu-item>
                                    </a-menu>
                                </template>
                            </a-dropdown>
                        </td>
                    </tr>
                </tbody>
            </table>

            <a-modal
                :maskClosable="false"
                v-model:open="update_show"
                title=""
                @ok="db_update_data_fun()"
            >
                <update :data="update_data">update err</update>
            </a-modal>

            <!-- <insert>insert err</insert> -->
            <!-- add new  _____________________ -->
            <a-modal
                :title="Ap.lang == 'en' ? 'New Teacher ' : 'معلم جديد'"
                v-model:open="insert_show"
                @ok="insert_fun()"
                class="p-2"
            >
                <!-- admin_id school_id class_id detail ar en -->
                <!-- :rules="rules"
                v-bind="layout"
                @finish="handleFinish"
                @validate="handleValidate"
                @finishFailed="handleFinishFailed" -->
                <update :data="insert_data">update err</update>
                <!--
                <a-form
                    :dir="Ap.lang == 'en' ? 'ltr' : 'rtl'"
                    ref="formRef"
                    name="custom-validation"
                    :model="insert_data"
                >
                    <a-form-item
                        name="class_id"
                        :label="Ap.lang == 'en' ? '  classroom' : ' الفصل  '"
                        has-feedback
                        :rules="[
                            {
                                required: true,
                                message: 'Please select your country!',
                            },
                        ]"
                    >
                        <a-select
                            v-model:value="insert_data.class_id"
                            placeholder="Please select a country"
                        >
                            <a-select-option
                                v-for="classroom in Ap.res?.my_teachers?.[
                                    'c_classes'
                                ]"
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
                        <a-input v-model:value="insert_data.ar" />
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
                        <a-input v-model:value="insert_data.en" />
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
                        <a-input v-model:value="insert_data.detail" />
                    </a-form-item>
                </a-form> -->

                <!-- <c_class_join_class_subject_teacher
                    :data="update_data"
                    :classroom="classroom"
                    :my_teachers="Ap.res?.my_teachers?.hrschooluser"
                    :subjects="Ap.res?.my_teachers?.c_subjects"
                    >c_class_join_class_subject_teacher
                    err</c_class_join_class_subject_teacher
                > -->
            </a-modal>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import insert from "./co/insert.vue";
import update from "./co/update.vue";
import {
    PlusOutlined,
    MoreOutlined,
    EditOutlined,
    SaveOutlined,
    ReloadOutlined,
} from "@ant-design/icons-vue";
import { useAppStore } from "@/stores/appstore";
const Ap = useAppStore();
const my_db_route = ref("/api/school_admin/c_teacher");

const data_to_get_class_marks = ref({});
const open_change_sequence = ref(false);
const current_sequence = ref(null);
const up_sequence = ref(null);
const school_id = ref(Ap.res?.my_teachers?.["c_teachers"][0]["school_id"]);
const classroom = ref(null);
const insert_data = ref({});
onMounted(() => {
    // show_fun();
});

const filter_text = ref(null);
const filter_col = ref("name");

// const my_teachers_filtered = computed(() => {
//     //console.log(1);
//     var my_data;
//     if (filter_text.value == "" || filter_text.value == null) {
//         my_data = Ap?.res?.my_teachers?.c_teachers;
//     }

//     if (
//         filter_col.value == "name" &&
//         !(filter_text.value == "" || filter_text.value == null)
//     ) {
//         my_data = Ap?.res?.my_teachers?.c_teachers.filter((el) => {
//             return (
//                 el.ar.includes(filter_text.value.trim()) ||
//                 el.my_class.en
//                     .toLowerCase()
//                     .includes(filter_text.value.trim()) ||
//                 el.my_class.detail.includes(filter_text.value.trim()) ||
//                 el.my_class.detail
//                     ?.toLowerCase()
//                     .includes(filter_text.value.trim()) ||
//                 el.en.toLowerCase().includes(filter_text.value.trim())
//             );
//         });
//     }

//     if (block_status.value == 1) {
//         return my_data.filter((el) => el.paid == 1);
//     }

//     if (block_status.value == 0) {
//         return my_data.filter((el) => el.paid == 0);
//     }

//     return my_data;
// });

const update_col_fun = (id, col, val) => {
    if (val == null || val == "") {
        return;
    }
    // Ap.res.my_teachers.c_teachers[index].sequence_edit=false
    // Ap?.res?.my_teachers?.c_teachers?.[index]?.sequence_edit=false
    //console.log("update_col_fun", id, col, val);
    Ap.d(
        {
            fun: "update_col",
            data: { id: id, col: col, val: val },
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: my_db_route.value,
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: false,
            res_ver: "delete",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "delete",
        }
    );
};

const sequence_edit = ref(false);
// const pagination_size = ref(100);
// const pagination_current = ref(1);
// const block_status = ref(3);
// const block_status_fun = () => {
//     if (block_status.value == 3) {
//         block_status.value = -1;
//     }

//     block_status.value = block_status.value + 1;
//     //console.log("ffff", block_status.value);
// };

const update_show = ref(false);
const update_data = ref({});
const update_show_fun = (item) => {
    update_data.value = item;
    // classroom.value = my_classroom;
    update_show.value = !update_show.value;
};

const delete_fun = (id) => {
    if (!confirm("Are you sure!")) {
        return;
    }
    Ap.d(
        {
            fun: "delete",
            data: id,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: my_db_route.value,
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "delete",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "delete",
        }
    );

    //console.log("item");
};

const update_block_fun = () => {
    if (!confirm("Are you sure!")) {
        return;
    }
    Ap.d(
        {
            fun: "update",
            data: update_data.value,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: my_db_route.value,
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "update",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "update",
        }
    );

    //console.log("item");
};
const db_update_data_fun = () => {
    if (!confirm("Are you sure!")) {
        return;
    }
    Ap.d(
        {
            fun: "update",
            data: update_data.value,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: my_db_route.value,
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "update",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "update",
        }
    );

    //console.log("item");
};

const insert_show = ref(false);
const insert_fun = () => {
    insert_data.value["school_id"] = school_id.value;

    //console.log("insert");
    if (!confirm("Are you sure!")) {
        return;
    }
    Ap.d(
        {
            fun: "insert",
            data: insert_data.value,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: my_db_route.value,
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "insert",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "insert",
        }
    );
};

const change_sequence_fun = () => {
    start_my_mood.value = !start_my_mood.value;
    var counter = 1;
    Ap.res?.my_teachers?.["c_teachers"].forEach((element, key) => {
        element["sequence"] = counter;
        counter++;
    });
};

const first_place1 = ref(null);
const to_place1 = ref(null);
const my_mood = ref(false);
const start_my_mood = ref(false);
const first_place = (index) => {
    my_mood.value = true;

    first_place1.value = index;
    open_change_sequence.value = !open_change_sequence.value;
};

const move_here = (index) => {
    // up_sequence.value=Ap.res?.my_teachers?.['c_teachers'][index]['sequence']

    var new_sequence =
        Ap.res?.my_teachers?.["c_teachers"]?.[index]?.["sequence"];
    //   var old_sequence=Ap.res?.my_teachers?.['c_teachers']?.[first_place1.value]?.['sequence']

    // Ap.res.my_teachers['c_teachers'][index]['sequence']=old_sequence
    Ap.res.my_teachers["c_teachers"][first_place1.value]["sequence"] =
        new_sequence - 1;
    //console.log(Ap.res.my_teachers["c_teachers"], index);

    Ap.res.my_teachers["c_teachers"].sort((a, b) => a.sequence - b.sequence);

    var counter = 1;
    Ap.res?.my_teachers?.["c_teachers"].forEach((element, key) => {
        if (index == key) {
        }
        element["sequence"] = counter;
        counter++;
    });

    // //   var items = Ap.res.my_teachers['c_teachers'];
    //   var item = Ap.res.my_teachers['c_teachers'].splice(first_place1.value, 1)[0];

    //   // Insert the item at index 3
    //   Ap.res.my_teachers['c_teachers'].splice(index, 0, item);
    // //   Ap.res.my_teachers['c_teachers']=items

    //console.log("done");
    my_mood.value = false;

    // open_change_sequence.value=!open_change_sequence.value
};

const show_fun = () => {
    Ap.d(
        {
            fun: "show",
            data: filter_text.value,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: my_db_route.value,
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "my_teachers",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "my_teachers",
        }
    );
};

// const  semester_id = ref(Ap.res?.class_marks[0]['semester_id']);
const mood = ref("view");
const mood2 = ref({ my_mood: "view" });
const data_create = ref({
    // teacher_start: "",
    // teacher_end: "",
    // student_start: "",
    // student_end: "",
    en: "",
    ar: "",
    // stage: null,
    // grades: "",
    notes: null,
});
// "id": 2, "admin_id": 1, "school_id": 4, "semester_id": 1,

const counter = computed(() => {
    if (Ap.d_fun == "update") {
        update_show.value = false;
        show_fun();
    }
    if (Ap.d_fun == "delete") {
        show_fun();
    }

    if (Ap.d_fun == "create") {
        mood.value = "view";
        mood2.value["my_mood"] = "view";
    }

    if (Ap.d_fun == "save_all") {
        show_fun();
        // get_class_marks(get_class_marks_data.value);
    }

    return Ap.d_counter;
});

const get_class_marks_data = ref([]);
const get_class_marks = (event) => {
    get_class_marks_data.value = event;
    data_to_get_class_marks.value["school_id"] = event.school_id;
    data_to_get_class_marks.value["subject_id"] = event.subject_id;
    data_to_get_class_marks.value["class_id"] = event.class_id;
    get_class_marks_db();
};

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
