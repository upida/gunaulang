import{m as c,o as l,f as o,a,u as p,w as r,F as d,Z as m,b as t,p as f,t as s,d as g}from"./app-DN-RUE--.js";import{_ as h}from"./BasicLayout-CC9BFqav.js";import"./ApplicationLogo-CICgJVQf.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const x={class:"py-12"},b={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},v={class:"p-4 sm:p-8 bg-white shadow sm:rounded-lg"},y=t("thead",null,[t("tr",null,[t("th",{class:"text-left"}," Tanggal "),t("th",{class:"text-left"}," Username "),t("th",{class:"text-left"}," Total "),t("th",{class:"text-left"}," Status "),t("th",{class:"text-left"})])],-1),N={__name:"Index",props:{canLogin:{type:Boolean},canRegister:{type:Boolean},data:{type:Object}},setup(n){return(i,B)=>{const u=c("v-btn"),_=c("v-table");return l(),o(d,null,[a(p(m),{title:"Setiap Bagian Berharga"}),a(h,{canLogin:n.canLogin,canRegister:n.canRegister},{default:r(()=>[t("div",x,[t("div",b,[t("div",v,[a(_,null,{default:r(()=>[y,t("tbody",null,[(l(!0),o(d,null,f(n.data.order,e=>(l(),o("tr",{key:e.id},[t("td",null,s(e.created),1),t("td",null,s(e.username),1),t("td",null,s(e.total),1),t("td",null,s(e.status),1),t("td",null,[a(u,{href:i.route("mystore.order.edit",{id:e.id})},{default:r(()=>[g("Detail")]),_:2},1032,["href"])])]))),128))])]),_:1})])])])]),_:1},8,["canLogin","canRegister"])],64)}}};export{N as default};
