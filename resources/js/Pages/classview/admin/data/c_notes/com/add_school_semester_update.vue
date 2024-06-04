<template>
    <div>

<div class="p-1">name</div>
<a-input v-model:value.lazy="props.data.name"  placeholder="name  " />
<div class="p-1">name_ar</div>
<a-input v-model:value.lazy="props.data.name_ar"  placeholder="name_ar  " />

<div class="flex flex-row gap-2">

<div class="p-0">
<div class="p-1">start</div>
<input class="ant-input  " type="date" v-model="props.data.start" />

</div>
<div class="p-0">
<div class="p-1">end</div>
<input class="ant-input  " type="date" :min="props.data.start" v-model="props.data.end" />

</div>





<div class="p-0">
<div class="p-1">week_end_days_off</div>
  <a-select
    v-model:value="props.data.week_end_days_off"
    mode="multiple"
    placeholder="Inserted are removed"
    style="width: 100%"
    :options="daysOfWeek_ar"
  ></a-select>
</div>
</div>
{{ props.data.week_end_days_off }}

<div class="flex">

<div class="p-0">
<div class="p-1">work_start</div>
<input class="ant-input  " type="time"   v-model="props.data.work_start" />

</div>

<div class="p-0">
<div class="p-1">work_end</div>
<input class="ant-input  " type="time"  v-model="props.data.work_end" />

</div>

</div>


    <a-checkbox v-model:checked="create_calendar_data"  >
     create_calendar_data
    </a-checkbox>

    <a-checkbox v-model:checked="props.data.active"  >
     active
    </a-checkbox>


    <!-- :options="filteredOptions.map(item => ({ value: item }))" -->
<div class="p-2">
         <a-button type="primary"   :loading="loading"
@click="fetch_first({fun:'admin_control_add_semester_calendar',
        route:'/api/school_admin/add_school_semester/update',
        data:props.data,
        create_calendar_data:create_calendar_data
            })"
         >submit</a-button>

         <a-button type="primary"   :loading="loading"
@click="fetch_first({fun:'admin_control_delete_extra_dates_from_attendance',
        route:'/api/school_admin/add_school_semester/create',
        data:props.data,
        create_calendar_data:create_calendar_data
            });"
         >clear extra data in attendance table</a-button>

      <a-button type="text" @click="$emit('open',false)"  >cancel</a-button>
</div>

<!-- loading size="small"-->
    </div>
</template>

<script  setup>
// import { DatePicker } from 'ant-design-vue';
// import dayjs from 'dayjs';
   import { ref
    // ,onMounted
    // ,computed
    //  ,watch
     } from 'vue';
   import {useAppStore} from '@/stores/appstore';const AppStore = useAppStore();
const props=defineProps(['data'])
const emits=defineEmits(['data','open'])
  props.data.week_end_days_off=props?.data?.week_end_days_off?.split(',')
  props.data.week_end_days_off=props?.data?.week_end_days_off?.map(element => parseInt(element));
// props.data.start='2023-11-26'
// props.data.end="2024-03-02"
props.data.work_start='07:30:00'
props.data.work_end="01:30:00"

// props.data.name="semester 2"
// props.data.name_ar="الفصل الدراسي الثاني"


           const loading = ref(false);//'2024-11-16'
           const create_calendar_data = ref(true);//
const daysOfWeek = [
  { en: 'Sunday', ar: 'الأحد', number: 0 },
  { en: 'Monday', ar: 'الاثنين', number: 1 },
  { en: 'Tuesday', ar: 'الثلاثاء', number: 2 },
  { en: 'Wednesday', ar: 'الأربعاء', number: 3 },
  { en: 'Thursday', ar: 'الخميس', number: 4 },
  { en: 'Friday', ar: 'الجمعة', number: 5 },
  { en: 'Saturday', ar: 'السبت', number: 6 }
];
const daysOfWeek_ar = [
  {label: 'الأحد'     , value: 0 },
  {label: 'الاثنين'   , value: 1 },
  {label: 'الثلاثاء'  , value: 2 },
  {label: 'الأربعاء'  , value: 3 },
  {label: 'الخميس'    , value: 4 },
  {label: 'الجمعة'    , value: 5 },
  {label: 'السبت'     , value: 6 }
];
const daysOfWeek_en = [
  { label: 'Sunday'       , value: 0 },
  { label: 'Monday'       , value: 1 },
  { label: 'Tuesday'      , value: 2 },
  { label: 'Wednesday'    , value: 3 },
  { label: 'Thursday'     , value: 4 },
  { label: 'Friday'       , value: 5 },
  { label: 'Saturday'     , value: 6 }
];
const fetch_first = (data_to_db) => {
    //console.log('fetch_first',data_to_db);


fetch_db(data_to_db)
};


const fetch_next = (res,data_first) => {
    if(data_first.fun=='admin_control_add_semester_calendar'){
   emits('open',false)

    }





    //console.log('fetch_next',res,data_first);
};







const fetch_db = (data_to_db) => {
    if(!data_to_db.route){alert('route null');return;}
    if(!data_to_db.fun){alert('fun null');return;}



    axios
        .post(data_to_db.route, data_to_db)
        .then((response) => {
            fetch_next(response.data,data_to_db);
        })
        .catch((error) => {
            console.error(error);
        });
};

</script>
<style  scoped>
/* input[type="date"] {
     -webkit-align-items: center;
     display: -webkit-inline-flex;
     font-family: monospace;
     overflow: hidden;
     padding: 0;
     -webkit-padding-start: 1px;
} */
.ant-input {
    box-sizing: border-box;
    margin: 0;
    padding: 4px 11px;
    color: rgba(0, 0, 0, 0.88);
    font-size: 14px;
    line-height: 1.5714285714285714;
    list-style: none;
    font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,'Noto Sans',sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol','Noto Color Emoji';
    position: relative;
    display: inline-block;
    width: 100%;
    min-width: 0;
    background-color: #ffffff;
    background-image: none;
    border-width: 1px;
    border-style: solid;
    border-color: #d9d9d9;
    border-radius: 6px;
    transition: all 0.2s;
}
</style>
