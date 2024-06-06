import{g as B,m as I,_ as s,r as y,K as f,u as P,e as H,P as D}from"./LoadingOutlined-C7QN_DUS.js";import{c as w,i as E}from"./index-CLPL0Y6L.js";import{K as T,m as x,b as v}from"./app-DuCM5fMY.js";const F=new f("antStatusProcessing",{"0%":{transform:"scale(0.8)",opacity:.5},"100%":{transform:"scale(2.4)",opacity:0}}),R=new f("antZoomBadgeIn",{"0%":{transform:"scale(0) translate(50%, -50%)",opacity:0},"100%":{transform:"scale(1) translate(50%, -50%)"}}),W=new f("antZoomBadgeOut",{"0%":{transform:"scale(1) translate(50%, -50%)"},"100%":{transform:"scale(0) translate(50%, -50%)",opacity:0}}),_=new f("antNoWrapperZoomBadgeIn",{"0%":{transform:"scale(0)",opacity:0},"100%":{transform:"scale(1)"}}),N=new f("antNoWrapperZoomBadgeOut",{"0%":{transform:"scale(1)"},"100%":{transform:"scale(0)",opacity:0}}),Z=new f("antBadgeLoadingCircle",{"0%":{transformOrigin:"50%"},"100%":{transform:"translate(50%, -50%) rotate(360deg)",transformOrigin:"50%"}}),A=o=>{const{componentCls:t,iconCls:l,antCls:a,badgeFontHeight:e,badgeShadowSize:b,badgeHeightSm:c,motionDurationSlow:m,badgeStatusSize:d,marginXS:p,badgeRibbonOffset:i}=o,n=`${a}-scroll-number`,r=`${a}-ribbon`,h=`${a}-ribbon-wrapper`,S=w(o,(g,C)=>{let{darkColor:u}=C;return{[`&${t} ${t}-color-${g}`]:{background:u,[`&:not(${t}-count)`]:{color:u}}}}),$=w(o,(g,C)=>{let{darkColor:u}=C;return{[`&${r}-color-${g}`]:{background:u,color:u}}});return{[t]:s(s(s(s({},y(o)),{position:"relative",display:"inline-block",width:"fit-content",lineHeight:1,[`${t}-count`]:{zIndex:o.badgeZIndex,minWidth:o.badgeHeight,height:o.badgeHeight,color:o.badgeTextColor,fontWeight:o.badgeFontWeight,fontSize:o.badgeFontSize,lineHeight:`${o.badgeHeight}px`,whiteSpace:"nowrap",textAlign:"center",background:o.badgeColor,borderRadius:o.badgeHeight/2,boxShadow:`0 0 0 ${b}px ${o.badgeShadowColor}`,transition:`background ${o.motionDurationMid}`,a:{color:o.badgeTextColor},"a:hover":{color:o.badgeTextColor},"a:hover &":{background:o.badgeColorHover}},[`${t}-count-sm`]:{minWidth:c,height:c,fontSize:o.badgeFontSizeSm,lineHeight:`${c}px`,borderRadius:c/2},[`${t}-multiple-words`]:{padding:`0 ${o.paddingXS}px`},[`${t}-dot`]:{zIndex:o.badgeZIndex,width:o.badgeDotSize,minWidth:o.badgeDotSize,height:o.badgeDotSize,background:o.badgeColor,borderRadius:"100%",boxShadow:`0 0 0 ${b}px ${o.badgeShadowColor}`},[`${t}-dot${n}`]:{transition:`background ${m}`},[`${t}-count, ${t}-dot, ${n}-custom-component`]:{position:"absolute",top:0,insetInlineEnd:0,transform:"translate(50%, -50%)",transformOrigin:"100% 0%",[`&${l}-spin`]:{animationName:Z,animationDuration:"1s",animationIterationCount:"infinite",animationTimingFunction:"linear"}},[`&${t}-status`]:{lineHeight:"inherit",verticalAlign:"baseline",[`${t}-status-dot`]:{position:"relative",top:-1,display:"inline-block",width:d,height:d,verticalAlign:"middle",borderRadius:"50%"},[`${t}-status-success`]:{backgroundColor:o.colorSuccess},[`${t}-status-processing`]:{overflow:"visible",color:o.colorPrimary,backgroundColor:o.colorPrimary,"&::after":{position:"absolute",top:0,insetInlineStart:0,width:"100%",height:"100%",borderWidth:b,borderStyle:"solid",borderColor:"inherit",borderRadius:"50%",animationName:F,animationDuration:o.badgeProcessingDuration,animationIterationCount:"infinite",animationTimingFunction:"ease-in-out",content:'""'}},[`${t}-status-default`]:{backgroundColor:o.colorTextPlaceholder},[`${t}-status-error`]:{backgroundColor:o.colorError},[`${t}-status-warning`]:{backgroundColor:o.colorWarning},[`${t}-status-text`]:{marginInlineStart:p,color:o.colorText,fontSize:o.fontSize}}}),S),{[`${t}-zoom-appear, ${t}-zoom-enter`]:{animationName:R,animationDuration:o.motionDurationSlow,animationTimingFunction:o.motionEaseOutBack,animationFillMode:"both"},[`${t}-zoom-leave`]:{animationName:W,animationDuration:o.motionDurationSlow,animationTimingFunction:o.motionEaseOutBack,animationFillMode:"both"},[`&${t}-not-a-wrapper`]:{[`${t}-zoom-appear, ${t}-zoom-enter`]:{animationName:_,animationDuration:o.motionDurationSlow,animationTimingFunction:o.motionEaseOutBack},[`${t}-zoom-leave`]:{animationName:N,animationDuration:o.motionDurationSlow,animationTimingFunction:o.motionEaseOutBack},[`&:not(${t}-status)`]:{verticalAlign:"middle"},[`${n}-custom-component, ${t}-count`]:{transform:"none"},[`${n}-custom-component, ${n}`]:{position:"relative",top:"auto",display:"block",transformOrigin:"50% 50%"}},[`${n}`]:{overflow:"hidden",[`${n}-only`]:{position:"relative",display:"inline-block",height:o.badgeHeight,transition:`all ${o.motionDurationSlow} ${o.motionEaseOutBack}`,WebkitTransformStyle:"preserve-3d",WebkitBackfaceVisibility:"hidden",[`> p${n}-only-unit`]:{height:o.badgeHeight,margin:0,WebkitTransformStyle:"preserve-3d",WebkitBackfaceVisibility:"hidden"}},[`${n}-symbol`]:{verticalAlign:"top"}},"&-rtl":{direction:"rtl",[`${t}-count, ${t}-dot, ${n}-custom-component`]:{transform:"translate(-50%, -50%)"}}}),[`${h}`]:{position:"relative"},[`${r}`]:s(s(s(s({},y(o)),{position:"absolute",top:p,padding:`0 ${o.paddingXS}px`,color:o.colorPrimary,lineHeight:`${e}px`,whiteSpace:"nowrap",backgroundColor:o.colorPrimary,borderRadius:o.borderRadiusSM,[`${r}-text`]:{color:o.colorTextLightSolid},[`${r}-corner`]:{position:"absolute",top:"100%",width:i,height:i,color:"currentcolor",border:`${i/2}px solid`,transform:o.badgeRibbonCornerTransform,transformOrigin:"top",filter:o.badgeRibbonCornerFilter}}),$),{[`&${r}-placement-end`]:{insetInlineEnd:-i,borderEndEndRadius:0,[`${r}-corner`]:{insetInlineEnd:0,borderInlineEndColor:"transparent",borderBlockEndColor:"transparent"}},[`&${r}-placement-start`]:{insetInlineStart:-i,borderEndStartRadius:0,[`${r}-corner`]:{insetInlineStart:0,borderBlockEndColor:"transparent",borderInlineStartColor:"transparent"}},"&-rtl":{direction:"rtl"}})}},j=B("Badge",o=>{const{fontSize:t,lineHeight:l,fontSizeSM:a,lineWidth:e,marginXS:b,colorBorderBg:c}=o,m=Math.round(t*l),d=e,p="auto",i=m-2*d,n=o.colorBgContainer,r="normal",h=a,S=o.colorError,$=o.colorErrorHover,g=t,C=a/2,u=a,O=a/2,z=I(o,{badgeFontHeight:m,badgeShadowSize:d,badgeZIndex:p,badgeHeight:i,badgeTextColor:n,badgeFontWeight:r,badgeFontSize:h,badgeColor:S,badgeColorHover:$,badgeShadowColor:c,badgeHeightSm:g,badgeDotSize:C,badgeFontSizeSm:u,badgeStatusSize:O,badgeProcessingDuration:"1.2s",badgeRibbonOffset:b,badgeRibbonCornerTransform:"scaleY(0.75)",badgeRibbonCornerFilter:"brightness(75%)"});return[A(z)]});var M=function(o,t){var l={};for(var a in o)Object.prototype.hasOwnProperty.call(o,a)&&t.indexOf(a)<0&&(l[a]=o[a]);if(o!=null&&typeof Object.getOwnPropertySymbols=="function")for(var e=0,a=Object.getOwnPropertySymbols(o);e<a.length;e++)t.indexOf(a[e])<0&&Object.prototype.propertyIsEnumerable.call(o,a[e])&&(l[a[e]]=o[a[e]]);return l};const X=()=>({prefix:String,color:{type:String},text:D.any,placement:{type:String,default:"end"}}),Y=T({compatConfig:{MODE:3},name:"ABadgeRibbon",inheritAttrs:!1,props:X(),slots:Object,setup(o,t){let{attrs:l,slots:a}=t;const{prefixCls:e,direction:b}=P("ribbon",o),[c,m]=j(e),d=x(()=>E(o.color,!1)),p=x(()=>[e.value,`${e.value}-placement-${o.placement}`,{[`${e.value}-rtl`]:b.value==="rtl",[`${e.value}-color-${o.color}`]:d.value}]);return()=>{var i,n;const{class:r,style:h}=l,S=M(l,["class","style"]),$={},g={};return o.color&&!d.value&&($.background=o.color,g.color=o.color),c(v("div",H({class:`${e.value}-wrapper ${m.value}`},S),[(i=a.default)===null||i===void 0?void 0:i.call(a),v("div",{class:[p.value,r,m.value],style:s(s({},$),h)},[v("span",{class:`${e.value}-text`},[o.text||((n=a.text)===null||n===void 0?void 0:n.call(a))]),v("div",{class:`${e.value}-corner`,style:g},null)])]))}}});export{Y as _,j as u};
