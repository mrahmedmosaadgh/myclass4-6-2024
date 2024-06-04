<script setup>
import { ref } from 'vue';
import tree from './tree.vue';

import {MenuOutlined } from '@ant-design/icons-vue';
 const open=ref(false)
  const menu_txt=[
{category:1,	en:"	Home	",ar:"	الصفحة الرئيسية	"},
{category:1,	en:"	Learning Tools	",ar:"	أدوات التعلم	"},
{category:1,	en:"	Courses Management	",ar:"	إدارة المواد	"},
{category:1,	en:"		",ar:"		"},
{category:1,	en:"	Courses Management	",ar:"	إدارة المواد	"},
{category:1,	en:"	Courses	",ar:"	المواد	"},
{category:1,	en:"	Questions Bank	",ar:"	أسئلة بنك	"},
{category:1,	en:"	Exams Schedule	",ar:"	جدول الامتحانات	"},
{category:1,	en:"	Session	",ar:"	حصة	"},
{category:1,	en:"	Books	",ar:"	كتب	"},
{category:1,	en:"	Weekly Plan	",ar:"	خطة أسبوعية	"},
{category:1,	en:"	Score Management	",ar:"	ادارة الدرجات	"},
{category:1,	en:"	Full Scheduale	",ar:"	الجدول المدرسي	"},
{category:1,	en:"	Libraries	",ar:"	المكتبات	"},
{category:1,	en:"		",ar:"		"},
{category:1,	en:"	Libraries	",ar:"	المكتبات	"},
{category:1,	en:"	Public Library	",ar:"	مكتبة عامة	"},
{category:1,	en:"	Custom Libraries	",ar:"	مكتبات مخصصة	"},
{category:1,	en:"	Virtual Factory	",ar:"	مصنع افتراضي	"},
{category:1,	en:"	Student Counseling	",ar:"	تقديم المشورة للطلاب	"},
{category:1,	en:"	Reports	",ar:"	التقارير	"},
{category:1,	en:"		",ar:"		"},
{category:1,	en:"	Management Reports	",ar:"	تقارير الإدارة	"},
{category:1,	en:"	User Reports	",ar:"	تقارير المستخدم	"},
{category:1,	en:"	Forms And Assessments	",ar:"	النماذج والتقييمات	"},
{category:1,	en:"	Evaluations | Surveys	",ar:"	التقييمات | الدراسات الاستقصائية	"},
{category:1,	en:"	Visits	",ar:"	زيارات	"},
{category:1,	en:"	Attendance And Absence	",ar:"	الحضور والغياب	"},
{category:1,	en:"		",ar:"		"},
{category:1,	en:"	Students	",ar:"	طلاب	"},
{category:1,	en:"	Teachers	",ar:"	معلمون	"},
{category:1,	en:"	Certificates	",ar:"	الشهادات	"},
{category:1,	en:"	Communication Tools	",ar:"	أدوات الاتصال	"},
{category:1,	en:"	Announcement	",ar:"	إعلان	"},
{category:1,	en:"	Calender	",ar:"	التقويم	"},
{category:1,	en:"	Virtual Classrooms	",ar:"	الفصول الافتراضية	"},
{category:1,	en:"	Discussion Rooms	",ar:"	غرف المناقشة	"},
{category:1,	en:"	Mailbox	",ar:"	صندوق بريد	"},
{category:1,	en:"		",ar:"		"},
{category:1,	en:"	Inbox	",ar:"	صندوق الوارد	"},
{category:1,	en:"	Compose	",ar:"	مؤلف موسيقى	"},
{category:1,	en:"	Inbox	",ar:"	صندوق الوارد	"},
{category:1,	en:"	Sent Messages	",ar:"	الرسائل المرسلة	"},
{category:1,	en:"	Drafts	",ar:"	المسودات	"},
{category:1,	en:"	Archive	",ar:"	أرشيف	"},
{category:1,	en:"	Trash	",ar:"	نفاية	"},
{category:1,	en:"	SMS	",ar:"	رسالة قصيرة	"},
{category:1,	en:"		",ar:"		"},
{category:1,	en:"	SMS	",ar:"	رسالة قصيرة	"},
{category:1,	en:"	Send A Short Message	",ar:"	أرسل رسالة قصيرة	"},
{category:1,	en:"	Whatsapp	",ar:"	Whatsapp	"},
{category:1,	en:"	Send Short Message From Excel	",ar:"	أرسل رسالة قصيرة من Excel	"},
{category:1,	en:"	Message Reports	",ar:"	تقارير الرسائل	"},
{category:1,	en:"	SMS Templates	",ar:"	قوالب الرسائل القصيرة	"},
{category:1,	en:"	Sms Template	",ar:"	قالب الرسائل القصيرة	"},
{category:1,	en:"	SMS Settings | Students | Fingerprint	",ar:"	إعدادات الرسائل القصيرة | الطلاب | بصمة	"},
{category:1,	en:"	Additional Services	",ar:"	خدمات إضافية	"},
{category:1,	en:"	CRM	",ar:"	CRM	"},
{category:1,	en:"		",ar:"		"},
{category:1,	en:"	Communication With Guardians	",ar:"	التواصل مع الأوصياء	"},
{category:1,	en:"	Communication With Guardians	",ar:"	التواصل مع الأوصياء	"},
{category:1,	en:"	Automated Call	",ar:"	مكالمة آلية	"},
{category:1,	en:"		",ar:"		"},
{category:1,	en:"	Automated Call	",ar:"	مكالمة آلية	"},
{category:1,	en:"	البوابات الذكية	",ar:"	البينبا	"},
{category:1,	en:"	Control Panel	",ar:"	لوحة التحكم	"},
{category:1,	en:"	Schools	",ar:"	المدارس	"},
{category:1,	en:"	Users	",ar:"	المستخدمون	"},
{category:1,	en:"		",ar:"		"},
{category:1,	en:"	Users	",ar:"	المستخدمون	"},
{category:1,	en:"	Administration	",ar:"	إدارة	"},
{category:1,	en:"	Teachers	",ar:"	معلمون	"},
{category:1,	en:"	Parents	",ar:"	آباء	"},
{category:1,	en:"	Students	",ar:"	طلاب	"},
{category:1,	en:"	Import Noor System	",ar:"	استيراد نظام noor	"},
{category:1,	en:"	Users Cards	",ar:"	بطاقات المستخدمين	"},
{category:1,	en:"	Search All Schools	",ar:"	ابحث في جميع المدارس	"},
{category:1,	en:"	Academic Years	",ar:"	السنوات الأكاديمية	"},
{category:1,	en:"	Canteens	",ar:"	المقاصف	"},
{category:1,	en:"	Clinics	",ar:"	العيادات	"},
{category:1,	en:"		",ar:"		"},
{category:1,	en:"	Diseases	",ar:"	الأمراض	"},
{category:1,	en:"	Clinics	",ar:"	العيادات	"},
{category:1,	en:"	Diseases	",ar:"	الأمراض	"},
{category:1,	en:"	Medicines	",ar:"	الأدوية	"},
{category:1,	en:"	Vaccinations	",ar:"	اللقاحات	"},
{category:1,	en:"	Medical Records	",ar:"	سجلات طبية	"},
{category:1,	en:"	Clinic Referral Requests	",ar:"	طلبات إحالة العيادة	"},
{category:1,	en:"	Diagnostics	",ar:"	التشخيص	"},
{category:1,	en:"	Behaviors	",ar:"	السلوكيات	"},
{category:1,	en:"		",ar:"		"},
{category:1,	en:"	Behaviors	",ar:"	السلوكيات	"},
{category:1,	en:"	Group	",ar:"	مجموعة	"},
{category:1,	en:"	Score Of Behavior	",ar:"	درجة السلوك	"},
{category:1,	en:"	Actions	",ar:"	أجراءات	"},
{category:1,	en:"	Support	",ar:"	يدعم	"},
{category:1,	en:"	The Accept And Register	",ar:"	القبول والتسجيل	"},

  ]
</script>

<template>
<div class="p-0   ">
  <a-button type="primary" @click="open=!open" shape="circle" class="hover:scale-110 "><MenuOutlined class="text-xl -mt-4" /></a-button>
  
  <a-drawer
    v-model:open="open"
    class="custom-class"
    root-class-name="root-class-name"
    :root-style="{ color: 'blue' }"
    style="color: red"
   
    placement="right"
    >
    <template #title>
      <div class="p-4 f3 text-blue-600 rounded-full  text-6xl"><div class="p-0 f11">my</div> CLASS</div>

    </template>
    <!-- @after-open-change="afterOpenChange" -->
    <a-collapse v-model:activeKey="activeKey" accordion>
    <a-collapse-panel key="1" header="This is panel header 1">
      <p>{{ menu_txt[0].ar }}</p>
    </a-collapse-panel>
    <a-collapse-panel key="2" header="This is panel header 2">
      <p>{{ menu_txt[1].ar }}</p>
    </a-collapse-panel>
    <a-collapse-panel key="3" header="This is panel header 3">
      <p>{{ menu_txt[2].ar }}</p>
    </a-collapse-panel>
  </a-collapse>
  </a-drawer>
    
</div>
</template>
