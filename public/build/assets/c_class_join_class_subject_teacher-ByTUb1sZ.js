import{y as U,o,e as d,a,t,u as _,F as p,h as y,b as i,w as B,p as v,A,f as C,a5 as N,g as u}from"./app-DuCM5fMY.js";import{u as D}from"./appstore-i93wDcAb.js";import{B as E}from"./index-lgGGxHJv.js";import"./LoadingOutlined-C7QN_DUS.js";import"./AntdIcon-9khPcjWE.js";import"./CloseOutlined-CxVmtEZu.js";import"./ExclamationCircleFilled-B0V7oa9j.js";import"./CloseCircleFilled-BQZlZZal.js";import"./useState-BLwVHUq_.js";const F={class:"rounded overflow-x-auto w-full m-auto"},M={cellspacing:"0",class:"tg w-full"},$={class:""},L=a("th",null,"#",-1),T={class:"w-24"},q={class:"w-12"},z={class:"w-12"},G={class:"w-8"},H={class:"p-0 text-xs flex whitespace-nowrap"},I={class:"p-0 text-xs"},J={class:"w-24"},K=["title"],O={key:0,class:"p-0 text-gray-400"},P=["onUpdate:modelValue"],Q=["value"],R={key:0,class:"p-0 text-gray-400"},W=["onUpdate:modelValue"],X=["value"],ls={__name:"c_class_join_class_subject_teacher",props:["data","subjects","my_teachers","classroom"],setup(n){const w=n,c=D();U(()=>{var r;(r=w.data)==null||r.my_subjects.forEach(l=>{l.deleted=0})});function S(){var l;var r={id:null,my_teacher:{name_ar:""},my_subject:{id:null},class_id:"",teacher_id:"",subject_id:"",deleted:0};(l=w.data)==null||l.my_subjects.push(r)}return(r,l)=>{var f;const b=E;return o(),d("div",F,[a("table",M,[a("thead",$,[a("tr",null,[L,a("th",T,t(_(c).lang=="en"?"Name":"الاسم"),1),a("th",q,t(_(c).lang=="en"?"grade":"الصف"),1),a("th",z,t(_(c).lang=="en"?"details":"التفاصيل"),1)])]),a("tbody",null,[(o(!0),d(p,null,y((f=n.data)==null?void 0:f.my_subjects,(s,g)=>{var j,x,k;return v((o(),d("tr",{key:g},[a("td",G,[a("div",H,[a("div",I,t(g+1)+":"+t((s==null?void 0:s.deleted)==1),1)])]),a("td",J,[a("div",{class:"p-0",title:_(c).lang=="en"?(s==null?void 0:s.ar)+" "+(s==null?void 0:s.detail):(s==null?void 0:s.en)+" "+(s==null?void 0:s.detail)},t(_(c).lang=="en"?s==null?void 0:s.en:s==null?void 0:s.ar),9,K)]),a("td",null,[s.subject_id!=s.my_subject.id?(o(),d("div",O," old: "+t((j=s==null?void 0:s.my_subject)==null?void 0:j.ar),1)):C("",!0),v(a("select",{class:"w-44","onUpdate:modelValue":e=>s.subject_id=e},[(o(!0),d(p,null,y(n.subjects,(e,h)=>(o(),d("option",{key:h,value:e.id},t(e.ar+" || "+e.en+" || "+e.detail),9,Q))),128))],8,P),[[N,s.subject_id]])]),a("td",null,[(s==null?void 0:s.teacher_id)!=((x=s==null?void 0:s.my_teacher)==null?void 0:x.user_id)?(o(),d("div",R," old: "+t((k=s==null?void 0:s.my_teacher)==null?void 0:k.name_ar),1)):C("",!0),v(a("select",{class:"w-44","onUpdate:modelValue":e=>s.teacher_id=e},[u(t(n.my_teachers)+" ",1),(o(!0),d(p,null,y(n.my_teachers,(e,h)=>{var V;return o(),d("option",{key:h,value:e.user_id},t((V=e.my_user)==null?void 0:V.name_ar),9,X)}),128))],8,W),[[N,s.teacher_id]])]),a("td",null,[u(t(s.deleted==1)+" ",1),i(b,{type:"primary",onClick:e=>s.deleted=1},{default:B(()=>[u("Submit")]),_:2},1032,["onClick"])])])),[[A,(s==null?void 0:s.deleted)==0]])}),128))])]),i(b,{type:"primary",onClick:l[0]||(l[0]=s=>S())},{default:B(()=>[u("add_record()")]),_:1})])}}};export{ls as default};
