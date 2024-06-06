import{g as J,m as Q,_,r as U,F as Y,t as Z,u as oo,d as eo,k as no,y as to,e as k,P as v}from"./LoadingOutlined-C7QN_DUS.js";import{K as lo,L as w,m as io,b as r,p as ao,A as ro,B as so}from"./app-DuCM5fMY.js";import{C as co}from"./CloseOutlined-CxVmtEZu.js";import{I as uo,b as go,c as po,d as mo,E as fo}from"./appstore-i93wDcAb.js";import{C as vo,E as $o}from"./ExclamationCircleFilled-B0V7oa9j.js";import{C as yo}from"./CloseCircleFilled-BQZlZZal.js";import{c as Co}from"./motion-DAWOpLEP.js";const B=(o,e,n,i,a)=>({backgroundColor:o,border:`${i.lineWidth}px ${i.lineType} ${e}`,[`${a}-icon`]:{color:n}}),ho=o=>{const{componentCls:e,motionDurationSlow:n,marginXS:i,marginSM:a,fontSize:u,fontSizeLG:s,lineHeight:g,borderRadiusLG:$,motionEaseInOutCirc:c,alertIconSizeLG:d,colorText:m,paddingContentVerticalSM:f,alertPaddingHorizontal:y,paddingMD:h,paddingContentHorizontalLG:S}=o;return{[e]:_(_({},U(o)),{position:"relative",display:"flex",alignItems:"center",padding:`${f}px ${y}px`,wordWrap:"break-word",borderRadius:$,[`&${e}-rtl`]:{direction:"rtl"},[`${e}-content`]:{flex:1,minWidth:0},[`${e}-icon`]:{marginInlineEnd:i,lineHeight:0},"&-description":{display:"none",fontSize:u,lineHeight:g},"&-message":{color:m},[`&${e}-motion-leave`]:{overflow:"hidden",opacity:1,transition:`max-height ${n} ${c}, opacity ${n} ${c},
        padding-top ${n} ${c}, padding-bottom ${n} ${c},
        margin-bottom ${n} ${c}`},[`&${e}-motion-leave-active`]:{maxHeight:0,marginBottom:"0 !important",paddingTop:0,paddingBottom:0,opacity:0}}),[`${e}-with-description`]:{alignItems:"flex-start",paddingInline:S,paddingBlock:h,[`${e}-icon`]:{marginInlineEnd:a,fontSize:d,lineHeight:0},[`${e}-message`]:{display:"block",marginBottom:i,color:m,fontSize:s},[`${e}-description`]:{display:"block"}},[`${e}-banner`]:{marginBottom:0,border:"0 !important",borderRadius:0}}},So=o=>{const{componentCls:e,colorSuccess:n,colorSuccessBorder:i,colorSuccessBg:a,colorWarning:u,colorWarningBorder:s,colorWarningBg:g,colorError:$,colorErrorBorder:c,colorErrorBg:d,colorInfo:m,colorInfoBorder:f,colorInfoBg:y}=o;return{[e]:{"&-success":B(a,i,n,o,e),"&-info":B(y,f,m,o,e),"&-warning":B(g,s,u,o,e),"&-error":_(_({},B(d,c,$,o,e)),{[`${e}-description > pre`]:{margin:0,padding:0}})}}},xo=o=>{const{componentCls:e,iconCls:n,motionDurationMid:i,marginXS:a,fontSizeIcon:u,colorIcon:s,colorIconHover:g}=o;return{[e]:{"&-action":{marginInlineStart:a},[`${e}-close-icon`]:{marginInlineStart:a,padding:0,overflow:"hidden",fontSize:u,lineHeight:`${u}px`,backgroundColor:"transparent",border:"none",outline:"none",cursor:"pointer",[`${n}-close`]:{color:s,transition:`color ${i}`,"&:hover":{color:g}}},"&-close-text":{color:s,transition:`color ${i}`,"&:hover":{color:g}}}}},Io=o=>[ho(o),So(o),xo(o)],bo=J("Alert",o=>{const{fontSizeHeading3:e}=o,n=Q(o,{alertIconSizeLG:e,alertPaddingHorizontal:12});return[Io(n)]}),wo={success:vo,info:uo,error:yo,warning:$o},Bo={success:go,info:po,error:mo,warning:fo},_o=Z("success","info","warning","error"),Ho=()=>({type:v.oneOf(_o),closable:{type:Boolean,default:void 0},closeText:v.any,message:v.any,description:v.any,afterClose:Function,showIcon:{type:Boolean,default:void 0},prefixCls:String,banner:{type:Boolean,default:void 0},icon:v.any,closeIcon:v.any,onClose:Function}),To=lo({compatConfig:{MODE:3},name:"AAlert",inheritAttrs:!1,props:Ho(),setup(o,e){let{slots:n,emit:i,attrs:a,expose:u}=e;const{prefixCls:s,direction:g}=oo("alert",o),[$,c]=bo(s),d=w(!1),m=w(!1),f=w(),y=l=>{l.preventDefault();const p=f.value;p.style.height=`${p.offsetHeight}px`,p.style.height=`${p.offsetHeight}px`,d.value=!0,i("close",l)},h=()=>{var l;d.value=!1,m.value=!0,(l=o.afterClose)===null||l===void 0||l.call(o)},S=io(()=>{const{type:l}=o;return l!==void 0?l:o.banner?"warning":"info"});u({animationEnd:h});const N=w({});return()=>{var l,p,H,T,E,z,A,L,O,F;const{banner:D,closeIcon:W=(l=n.closeIcon)===null||l===void 0?void 0:l.call(n)}=o;let{closable:M,showIcon:C}=o;const P=(p=o.closeText)!==null&&p!==void 0?p:(H=n.closeText)===null||H===void 0?void 0:H.call(n),x=(T=o.description)!==null&&T!==void 0?T:(E=n.description)===null||E===void 0?void 0:E.call(n),G=(z=o.message)!==null&&z!==void 0?z:(A=n.message)===null||A===void 0?void 0:A.call(n),I=(L=o.icon)!==null&&L!==void 0?L:(O=n.icon)===null||O===void 0?void 0:O.call(n),R=(F=n.action)===null||F===void 0?void 0:F.call(n);C=D&&C===void 0?!0:C;const V=(x?Bo:wo)[S.value]||null;P&&(M=!0);const t=s.value,j=eo(t,{[`${t}-${S.value}`]:!0,[`${t}-closing`]:d.value,[`${t}-with-description`]:!!x,[`${t}-no-icon`]:!C,[`${t}-banner`]:!!D,[`${t}-closable`]:M,[`${t}-rtl`]:g.value==="rtl",[c.value]:!0}),X=M?r("button",{type:"button",onClick:y,class:`${t}-close-icon`,tabindex:0},[P?r("span",{class:`${t}-close-text`},[P]):W===void 0?r(co,null,null):W]):null,K=I&&(no(I)?Co(I,{class:`${t}-icon`}):r("span",{class:`${t}-icon`},[I]))||r(V,{class:`${t}-icon`},null),q=to(`${t}-motion`,{appear:!1,css:!0,onAfterLeave:h,onBeforeLeave:b=>{b.style.maxHeight=`${b.offsetHeight}px`},onLeave:b=>{b.style.maxHeight="0px"}});return $(m.value?null:r(so,q,{default:()=>[ao(r("div",k(k({role:"alert"},a),{},{style:[a.style,N.value],class:[a.class,j],"data-show":!d.value,ref:f}),[C?K:null,r("div",{class:`${t}-content`},[G?r("div",{class:`${t}-message`},[G]):null,x?r("div",{class:`${t}-description`},[x]):null]),R?r("div",{class:`${t}-action`},[R]):null,X]),[[ro,!d.value]])]}))}}}),Po=Y(To);export{Po as _};