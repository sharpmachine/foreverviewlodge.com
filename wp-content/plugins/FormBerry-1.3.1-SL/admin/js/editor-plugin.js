var form_params={type:"POST",data:{action:"formberry_get_add_form_info"},async:!1,success:function(a){fby_form_forms_info=JSON.parse(a)}};jQuery.ajax(ajaxurl,form_params);var button_params={type:"POST",data:{action:"formberry_get_add_form_button_info"},async:!1,success:function(a){fby_button_forms_info=JSON.parse(a)}};jQuery.ajax(ajaxurl,button_params);
(function(){tinymce.create("tinymce.plugins.FormBerry",{createControl:function(a,e){switch(a){case "fby_add_form":var b=e.createSplitButton("fby_add_form",{title:fby_form_forms_info.title,image:fby_form_forms_info.image_url,onclick:function(){}});b.onRenderMenu.add(function(a,b){b.add({title:fby_form_forms_info.header,"class":"mceMenuItemTitle"}).setDisabled(1);for(var d=fby_form_forms_info.forms,c=0;c<d.length;c++)b.add({title:d[c].title,code:d[c].code,onclick:function(){tinymce.activeEditor.execCommand("mceInsertContent",
0,this.code)}})});return b;case "fby_add_form_button":return b=e.createSplitButton("fby_add_form_button",{title:fby_button_forms_info.title,image:fby_button_forms_info.image_url,onclick:function(){}}),b.onRenderMenu.add(function(b,a){a.add({title:fby_button_forms_info.header,"class":"mceMenuItemTitle"}).setDisabled(1);for(var d=fby_button_forms_info.forms,c=0;c<d.length;c++)a.add({title:d[c].title,code:d[c].code,onclick:function(){tinymce.activeEditor.execCommand("mceInsertContent",0,this.code)}})}),
b}return null},getInfo:function(){return{longname:"FormBerry Plugin",author:"FormBerry",authorurl:"http://www.trigy.com",infourl:"http://www.trigy.com",version:"2.0"}}});tinymce.PluginManager.add("formberry",tinymce.plugins.FormBerry)})();