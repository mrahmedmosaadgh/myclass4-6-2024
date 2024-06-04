<template>
    <div   v-if=" Ap.permissions.has('control_admin_data')">
        <div class="p-4 noprint">
            <span class="px-4 flex flex-row gap-4 noprint">
             <!-- ------------------------------------------------------------- -->
                                <tab_button
                                 v-for="(item, index) in comp_array" :key="index"
                    class="hover"
                    @my_comp="comp_fun(item)"
                    :data="{
                        active: comp == item.comp ? 1 : 0,
                        lang: Ap.lang,
                        title: { en: item.en, ar: item.ar },
                    }"
                >
                    err</tab_button
                >



                <!-- ------------------------------------------------------------- -->



            </span>
            <div class="h-1 noprint bg-green-800"></div>
        </div>
        <transition enter-active-class="fade-in" leave-active-class="fade-out">
            <c_subject v-if="comp == 'subject'">c_subject err</c_subject>
        </transition>

        <transition enter-active-class="fade-in" leave-active-class="fade-out">
            <c_class v-if="comp == 'class'">c_class err</c_class>
        </transition>

        <transition enter-active-class="fade-in" leave-active-class="fade-out">
            <c_teacher v-if="comp == 'teacher'">c_teacher err</c_teacher>
        </transition>
        <transition enter-active-class="fade-in" leave-active-class="fade-out">
            <c_student v-if="comp == 'student'">c_student err</c_student>
        </transition>

        <!-- <transition enter-active-class="fade-in" leave-active-class="fade-out">
            <c_semester v-if="comp == 'semester'">c_semester err</c_semester>
        </transition> -->
        <transition enter-active-class="fade-in" leave-active-class="fade-out">
            <!-- <c_notes v-if="comp == 'notes'">c_notes err</c_notes> -->
            <soon v-if="comp == 'notes'" :text="Ap.lang=='en'?null:'قريبا'" size="66" text_color="green">c_notes err</soon>
        </transition>


    </div>
       <!-- <no_permission v-else>no_permission err</no_permission> -->

</template>
<script setup>
import { ref } from "vue";
import { useAppStore } from "@/stores/appstore";
import tab_button from "./co/tab_button.vue";
import c_subject from "./c_subject/c_subject.vue";
import c_class from "./c_class/c_class.vue";
import c_teacher from "./c_teacher/c_teacher.vue";
import c_student from "./c_student/c_student.vue";
// import c_semester from "./c_semester/c_semester.vue";
import c_notes from "./c_notes/c_notes.vue";
const Ap = useAppStore();

const comp = ref(null);
const comp_array =  [
{comp:'subject'  ,en:'subject'  ,ar:'مادة'   },
{comp:'class'    ,en:'classroom',ar:'فصل'    },
{comp:'teacher'  ,en:'teacher'  ,ar:'معلم'   },
{comp:'student'  ,en:'student'  ,ar:'طالب'   },
// {comp:'semester' ,en:'semester' ,ar:'ترم'    },
// {comp:'notes' ,en:'notes' ,ar:'ملاحظات '    },


] ;
const comp_fun = ((item)=>
{
    if (!confirm("Are you sure! go to :"+item.en+" :"+item.ar )) {
        return;
    }
comp.value = item.comp
});
</script>
