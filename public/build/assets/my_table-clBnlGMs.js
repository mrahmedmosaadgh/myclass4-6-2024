import{y as ke,d as i,o as n,e as l,b as d,u as a,f as _,a as s,w as p,g as A,t as r,F as N,h as E,p as le,A as re,c as M,n as O,G as fe,H as ge}from"./app-DuCM5fMY.js";import{u as ye}from"./appstore-i93wDcAb.js";import{_ as xe}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{S as de}from"./SaveOutlined-C-xOJ6-3.js";import{R as we}from"./ReloadOutlined-CERf7MDg.js";import{E as be}from"./EditOutlined-CQNci86I.js";import{D as Ce}from"./DeleteOutlined-B394q2Md.js";import{M as $e}from"./MoreOutlined-Dn8n-63j.js";import{B as Se}from"./index-lgGGxHJv.js";import{B as Ae}from"./index-XB80zlEa.js";import{_ as Be}from"./index-CLPL0Y6L.js";import{_ as Ve}from"./index-C6upw1zv.js";import{_ as De}from"./index-D9SNFcq0.js";import{_ as Ne}from"./index-RfeOYOn2.js";import"./LoadingOutlined-C7QN_DUS.js";import"./AntdIcon-9khPcjWE.js";import"./CloseOutlined-CxVmtEZu.js";import"./ExclamationCircleFilled-B0V7oa9j.js";import"./CloseCircleFilled-BQZlZZal.js";import"./useState-BLwVHUq_.js";import"./motion-DAWOpLEP.js";import"./Ribbon-Tv3FPnrK.js";import"./DownOutlined-BUTiwnGH.js";import"./isMobile-BbN7I0i_.js";import"./KeyCode-B_gOgbN6.js";import"./FormItemContext-WqdLE0eK.js";import"./index-Nnij7LAV.js";const Ue=y=>(fe("data-v-2e16b3df"),y=y(),ge(),y),je={class:"pt-4 w-screen flex justify-center px-4 relative"},Ee={class:"rounded overflow-x-auto w-full m-auto"},Me={cellspacing:"0",class:"tg w-full"},Oe={class:""},Ie={key:0},ze={colspan:"32",class:"no-border_background pt-4"},He=["innerHTML"],Le=Ue(()=>s("div",{class:"p-0 text-center w-full"},null,-1)),Te={class:"max-w-min"},Fe={key:0,class:"p-0 w-full flex justify-center"},Re={class:"p-0 flex flex-col gap-2 w-24"},Ge={class:"p-0 flex flex-col"},qe={class:"p-0"},Je={class:"p-0 flex gap-4"},Ke={class:"p-0"},Pe={class:"p-0"},Qe={class:"p-0"},We=["onClick"],Xe={class:""},Ye={class:"w-12"},Ze={class:"w-8"},et={class:"p-0 text-xs flex whitespace-nowrap"},tt={class:"p-0 text-xs"},st={class:"w-52"},at=["title"],nt={class:"p-0 flex"},ot={class:"text-left w-40 flex flex-col gap-2 whitespace-nowrap"},lt={class:"p-0"},rt={class:"p-0"},dt={key:1,class:""},ct={key:1,class:"text-center"},_t=["onDblclick"],ut={key:2,class:"p-0 text-red-700 bg-red-100 text-center"},it={key:0,class:"p-0"},pt={key:1,class:"p-0"},mt={key:0,class:"p-0 relative"},ht={key:1,class:"p-0"},vt={key:0,class:"p-0"},kt={key:1,class:"p-0 text-2xs opacity-50"},ft={__name:"my_table",props:["data","settings","data_create"],emits:["save_update","save_create","save_delete","text_filter","view"],setup(y,{emit:ce}){const v=y,_e=ce,o=ye();ke(()=>{_e("view")});const U=i(0);i(!1);const B=i(!0),k=i(!1);i({open_me:!1}),i(!1),i({});const ue=i(1),ie=i("");i({sort:ue.value,col:"name",text:"name 122",search_text:ie.value});const pe=()=>{var u=o.lang=="en"?"Are you sure to  save all records        ?":"هل ترغب في حفظ كل السجلات    ";confirm(u)&&(o.d({fun:"save_all",data:v.data},{route:"/api/teacher_marks_edit",msg:o.lang=="en"?"Done with success":"تم بنجاح",loading:!0,res_ver:"save_all",msg_error:"save marks error",sys_error:!0,log:!0,d_fun:"save_all"}),k.value=!1)},V=i(null),me=u=>{V.value=u},he=u=>{v.data.forEach((c,j)=>{c.marks[u].mark=null}),k.value=!0},ve=u=>{k.value=!0,v.data.forEach((c,j)=>{c.marks[u].mark=V.value,c.marks[u].attend=1,c.marks[u].completed=1})};return(u,c)=>{var T,F,R,G;const j=Be,D=Se,I=Ve,z=Ae,H=De,L=Ne;return n(),l(N,null,[k.value?(n(),l("button",{key:0,onClick:c[0]||(c[0]=e=>pe()),class:"heart peep css animated-shadow-button fixed bottom-0 z-50"},[d(a(de))])):_("",!0),s("div",je,[s("div",Ee,[s("table",Me,[s("thead",Oe,[(T=v.settings)!=null&&T.title?(n(),l("tr",Ie,[s("th",ze,[s("div",{class:"p-0 text-center flex",innerHTML:(F=v.settings)==null?void 0:F.title},null,8,He),Le])])):_("",!0),s("tr",null,[s("th",null,[d(j,{color:"purple"},{title:p(()=>[A(r(a(o).lang=="en"?"reload data":"اعادة تحميل البيانات"),1)]),default:p(()=>[s("button",{class:"hover:scale-150",onClick:c[1]||(c[1]=e=>u.$emit("view"))},[d(a(we))])]),_:1}),A(" # ")]),s("th",Te,r(a(o).lang=="en"?"Name":"الاسم"),1),(n(!0),l(N,null,E((G=(R=v.data)==null?void 0:R[0])==null?void 0:G.my_subject_title,(e,m)=>{var x,w,b;return le((n(),l("th",{class:"w-32",key:m},[(b=(w=(x=a(o).res)==null?void 0:x.show)==null?void 0:w.semester)!=null&&b.teacher_close?_("",!0):(n(),M(D,{key:0,class:"mx-4 m-2",type:"text",onClick:f=>{U.value=m,B.value=!B.value},shape:"circle"},{default:p(()=>[d(a(be))]),_:2},1032,["onClick"])),d(H,{title:a(o).lang=="en"?"Auto fill column":"الاكمال التلقائي للدرجات",trigger:"click"},{content:p(()=>{var f,C,$;return[($=(C=(f=a(o).res)==null?void 0:f.show)==null?void 0:C.semester)!=null&&$.teacher_close?_("",!0):(n(),l("div",Fe,[s("div",Re,[s("div",Ge,[s("span",qe,r(a(o).lang=="en"?" mark:":"الدرجة"),1),d(I,{class:"w-full",value:V.value,"onUpdate:value":c[2]||(c[2]=g=>V.value=g),min:"0",max:e.highest_mark},null,8,["value","max"])]),s("div",Je,[s("div",Ke,[d(D,{type:"primary",shape:"circle",onClick:g=>ve(m),class:"noprint"},{default:p(()=>[d(a(de))]),_:2},1032,["onClick"])]),s("div",Pe,[d(D,{type:"primary",shape:"circle",onClick:g=>he(m),class:"noprint",danger:""},{default:p(()=>[d(a(Ce))]),_:2},1032,["onClick"])])])])]))]}),default:p(()=>[s("div",Qe,[s("button",{onClick:f=>me(e.highest_mark),class:"cursor-pointer hover:scale-125"},[d(z,{dir:"ltr",overflowCount:100,count:e.highest_mark,"number-style":{backgroundColor:"#fff",color:"#999",boxShadow:"0 0 0 1px #d9d9d9 inset"}},null,8,["count"])],8,We)])]),_:2},1032,["title"]),s("div",Xe,r(a(o).lang=="en"?e.en:e.ar),1)])),[[re,U.value==m||B.value]])}),128)),s("th",Ye,r(a(o).lang=="en"?"Sum":"المجموع"),1)])]),s("tbody",null,[(n(!0),l(N,null,E(v.data,(e,m)=>{var x,w,b,f,C,$,g;return n(),l("tr",{key:m,class:O({even:(m+1)%2===0,selected:e.select==1})},[s("td",Ze,[s("div",et,[s("div",tt,r(m+1),1)])]),s("td",st,[s("div",{class:"p-0",title:a(o).lang=="en"?e.ar:e.en},r(a(o).lang=="en"?e.en:e.ar),9,at)]),(n(!0),l(N,null,E(e.marks,(t,S)=>{var q,J,K,P,Q;return le((n(),l("td",{key:S},[s("div",nt,[(K=(J=(q=a(o).res)==null?void 0:q.show)==null?void 0:J.semester)!=null&&K.teacher_close?_("",!0):(n(),M(H,{key:0,trigger:"click"},{content:p(()=>[s("div",ot,[s("div",lt,[d(L,{checked:t.attend,"onUpdate:checked":h=>t.attend=h,checkedValue:1,unCheckedValue:0,onChange:h=>{k.value=!0,t.attend==0&&(t.mark=null)}},null,8,["checked","onUpdate:checked","onChange"]),A(" "+r(a(o).lang=="en"?"Attend  ":"حاضر"),1)]),s("div",rt,[d(L,{checked:t.completed,"onUpdate:checked":h=>t.completed=h,checkedValue:1,unCheckedValue:0,onChange:h=>{k.value=!0,t.completed==0&&(t.mark=null)}},null,8,["checked","onUpdate:checked","onChange"]),A(" "+r(a(o).lang=="en"?"Completed  ":" مكتمل"),1)])])]),default:p(()=>[d(D,{type:"text",size:"small",style:{padding:"0px"},class:"noprint"},{default:p(()=>[d(a($e),{style:{padding:"0px",margin:"0px",width:"12px"}})]),_:1})]),_:2},1024)),t.attend==1&&t.completed==1?(n(),l("div",dt,[d(z,{dot:((Q=(P=t==null?void 0:t.my_subject_title)==null?void 0:P[S])==null?void 0:Q.highest_mark)*.8>t.mark&&t.mark},{default:p(()=>{var h,W,X,Y,Z,ee,te,se,ae,ne;return[(X=(W=(h=a(o).res)==null?void 0:h.show)==null?void 0:W.semester)!=null&&X.teacher_close?_("",!0):(n(),M(I,{key:0,onChange:c[3]||(c[3]=oe=>k.value=!0),disabled:t.attend==0,class:O(t.mark==null?"border-gray-200 bg-gray-100":"border-green-500"),value:t.mark,"onUpdate:value":oe=>t.mark=oe,min:0,max:(Z=(Y=t==null?void 0:t.my_subject_title)==null?void 0:Y[S])==null?void 0:Z.highest_mark,status:((te=(ee=t==null?void 0:t.my_subject_title)==null?void 0:ee[S])==null?void 0:te.highest_mark)*.8>t.mark?"error":""},null,8,["disabled","class","value","onUpdate:value","max","status"])),(ne=(ae=(se=a(o).res)==null?void 0:se.show)==null?void 0:ae.semester)!=null&&ne.teacher_close?(n(),l("div",ct,r(t.mark),1)):_("",!0)]}),_:2},1032,["dot"]),t.edit==!1?(n(),l("div",{key:0,class:"px-2 w-12 h-6 red",onDblclick:h=>t.edit=!0},r(t.mark),41,_t)):_("",!0)])):(n(),l("div",ut,[t.attend==0?(n(),l("div",it,r(a(o).lang=="en"?"Absent  ":"غائب"),1)):_("",!0),t.completed==0?(n(),l("div",pt,r(a(o).lang=="en"?"Not completed  ":"غير مكتمل"),1)):_("",!0)]))])])),[[re,U.value==S||B.value]])}),128)),s("td",null,[(x=e==null?void 0:e.mark_sum)!=null&&x.mark?(n(),l("div",mt,[A(r((w=e==null?void 0:e.mark_sum)==null?void 0:w.mark)+" ",1),((b=e==null?void 0:e.mark_sum)==null?void 0:b.completed)==1?(n(),l("div",{key:0,class:O(["h2 w-6 mx-8 p-1 text-xs red rounded-full text-center",((f=e==null?void 0:e.mark_sum)==null?void 0:f.mark)>90?"green":"red"])},r((C=e==null?void 0:e.mark_sum)==null?void 0:C.letter),3)):(n(),l("div",ht,[(($=e==null?void 0:e.mark_sum)==null?void 0:$.attend)==0?(n(),l("div",vt,r(a(o).lang=="en"?"Absent  ":"غائب"),1)):_("",!0),((g=e==null?void 0:e.mark_sum)==null?void 0:g.completed)==0?(n(),l("div",kt,r(a(o).lang=="en"?"Not completed  ":"غير مكتمل"),1)):_("",!0)]))])):_("",!0)])],2)}),128))])])])])],64)}}},Jt=xe(ft,[["__scopeId","data-v-2e16b3df"]]);export{Jt as default};
