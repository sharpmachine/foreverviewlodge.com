(function(d){function m(d){return"#"+d.css_dg_field_groups_num_columns_field_id+", "+("#"+d.css_sp_spec_field_id+" select.formberry-canvas-num-columns")}function n(b,a){if(a){var c=0;b.each(function(){var b=d(this),f=a[c];if(f){var g=b.closest("tr.template-download"),h=g.find("input.fi_delete"),j=g.find("input.fi_already_uploaded"),i=g.find("input.fi_size"),k=g.find("input.fi_type"),o=g.find("input.fi_upload_name"),p=g.find("input.fi_moved_to_final_dir"),g=g.find("a");h.attr("data-type",f.delete_type);
h.attr("data-url",f.delete_url);b.val(f.name);j.val(f.already_uploaded?"true":"false");i.val(f.size);k.val(f.type);o.val(f.upload_name);p.val(f.moved_to_final_dir?"true":"false");g.attr("href",f.url)}c++})}}var l={init:function(b){return this.each(function(){var a=d(this);a.data("formberry")||a.data("formberry",b);a.formberry_form_editor("init_all_group_caches",b);a.formberry_form_editor("init_all_field_caches",b);a.formberry_form_editor("init_groups_sortable",b);a.formberry_form_editor("init_field_sortables_for_all_groups",
b);a.formberry_form_editor("init_widgets",b);a.formberry_form_editor("init_canvas_events",b);a.formberry_form_editor("autosave",!0)})},get_default_num_columns:function(){return d(this).find("select.formberry-canvas-num-columns").val()},set_default_num_columns:function(b){return this.each(function(){var a=d(this),c=a.data("formberry");d(m(c)).val(b);a.formberry_form_editor("check_all_columns")})},autosave:function(b){return this.each(function(){var a=d(this),c=a.closest(".form-berry-wrap"),e=c.find(".formberry-autosave-timer"),
f=a.find(".formberry-autosave-timeout-min-field").val(),g=a.find(".formberry-autosave-timeout-enabled-field"),g=parseInt(g.val(),10),h="+"+f+"m";b?e.hasClass("hasCountdown")?g&&f&&(e.countdown("change","until",h),e.countdown("resume")):(f&&e.countdown({until:h,format:"MS",layout:"{mnn}{sep}{snn}",onExpiry:function(){c.find(".dtq-fby-form-wrapper form").formberry_form_editor("autosave",!1)}}),g||e.countdown("pause"),c.find(".formberry-autosave-disable").click(function(){c.find(".formberry-autosave-enabled-text").hide();
c.find(".formberry-autosave-disabled-text").show();c.find(".formberry-autosave-timeout-enabled-field").val("0");e.countdown("pause")}),c.find(".formberry-autosave-enable").click(function(){c.find(".formberry-autosave-disabled-text").hide();c.find(".formberry-autosave-enabled-text").show();c.find(".formberry-autosave-timeout-enabled-field").val("1");e.countdown("resume")}),a.submit(function(){e.countdown("pause")})):a.ajaxSubmit({beforeSubmit:function(a){d("div.dtq-fby-form-header-message").hide();
c.find(".formberry-autosave-done-text").hide();c.find(".formberry-autosave-in-progress-text").show();d.each(a,function(d,a){if(a.hasOwnProperty("name")&&"action"==a.name)return a.value="formberry_form_autosave",!1})},success:function(a){var b=jQuery.parseJSON(a);if(b){var e=c.find(".dtq-fby-form-wrapper form"),a=parseInt(b.form_id,10);e.find(".formberry-form-id-field").val(a);a=parseInt(b.autosave_timeout_min,10);e.find(".formberry-autosave-timeout-min-field").val(a);c.find(".formberry-autosave-done-text").show();
c.find(".formberry-autosave-in-progress-text").hide();a=parseInt(b.autosave_enabled,10);e.find(".formberry-autosave-timeout-enabled-field").val(a);a=b.code;e.find(".formberry-code-field").val(a);d.each(b.bgimages.design,function(a,d){if(a){var b=e.find("input.fi_name[name="+a+"\\[file_name\\]\\[\\]]");n(b,d)}});var f=1;e.find(".formberry-form-canvas-drop-area").children(".formberry-canvas-group").each(function(){var a=d(this).find("td.name input.fi_name");n(a,b.bgimages.groups[f]);f++});e.formberry_form_editor("autosave",
!0)}}})})},init_groups_sortable:function(b){return this.each(function(){var a=d(this),c=d("#"+b.css_sp_spec_field_id+" .formberry-form-canvas-drop-area");c.sortable({items:".formberry-canvas-group",placeholder:"formberry-canvas-group-placeholder",cursor:"move",distance:5,handle:".formberry-canvas-group-inner",stop:function(){a.formberry_form_editor("check_all_columns");a.formberry_form_editor("check_field_lists")},receive:function(){var e=d(this),f=d("#"+b.css_sp_spec_field_id+" .formberry-group-editor-template");
e.find(".formberry-fields-group-widget").each(function(){var b=d(this),e=f.find(".formberry-canvas-group").clone(!0,!0),j=c.closest(".formberry-form-canvas-wrapper").find("input.formberry-canvas-num-groups"),i=parseInt(j.val(),10)+1;j.val(i);e.find("[name]").each(function(){var a=d(this).attr("name");a&&d(this).attr("name",a.replace(/GROUP_TEMPLATE/g,i))});e.find("[id]").each(function(){var a=d(this).attr("id");a&&d(this).attr("id",a.replace(/GROUP_TEMPLATE/g,i))});e.find("label").each(function(){var a=
d(this).attr("for");a&&d(this).attr("for",a.replace(/GROUP_TEMPLATE/g,i))});var j=e.find("tbody.files"),k=e.find(".dtq-fby-form-field-fileupload").data("fileupload");k&&(k._files=j);e.find(".dtq-fby-form-field-colorpicker input").each(function(){var a=d(this),b=a.data("colorpickerId"),b=d("#"+b).clone(true,true),c="collorpicker_"+parseInt(Math.random()*1E5,10);a.data("colorpickerId",c);b.attr("id",c);b.data("colorpicker").el=a;b.appendTo(document.body)});e.find(".formberry-canvas-group-order").val(i);
a.formberry_form_editor("init_group_cache",e);a.formberry_form_editor("init_fields_sortable",c,e);b.replaceWith(e)});a.formberry_form_editor("check_all_columns");a.formberry_form_editor("check_field_lists")}})})},init_field_sortables_for_all_groups:function(b){return this.each(function(){var a=d(this),c=d("#"+b.css_sp_spec_field_id+" .formberry-form-canvas-drop-area");c.find(".formberry-canvas-group").each(function(){a.formberry_form_editor("init_fields_sortable",c,d(this))})})},init_fields_sortable:function(b,
a){return this.each(function(){var c=d(this),e=c.data("formberry");a.find(".formberry-canvas-group-fields").sortable({items:".formberry-canvas-field",placeholder:"formberry-canvas-field-placeholder",cursor:"move",distance:5,connectWith:".formberry-canvas-group-fields",start:function(c,e){var h=a.data("formberry-canvas-column-width");h&&e.placeholder.width(h);b.find(".formberry-canvas-field").each(function(){var a=d(this);a.hasClass("formberry-newrow")&&a.removeClass("formberry-newrow")})},over:function(b,
d){var c=a.data("formberry-canvas-column-width");c&&d.placeholder.width(c)},stop:function(){c.formberry_form_editor("check_all_columns");c.formberry_form_editor("check_field_lists")},receive:function(a,g){var h=d(this);if(g.helper){var j=g.helper.find('input[name="type"]').val(),i=d("#"+e.css_sp_spec_field_id+" .formberry-field-editor-template");h.find(".formberry-form-widget-type").each(function(){var a=d(this),e=i.find(".formberry-canvas-field").clone(!0,!0),f=b.closest(".formberry-form-canvas-wrapper").find(".formberry-canvas-num-fields"),
g=parseInt(f.val(),10)+1;f.val(g);e.find("[name]").each(function(){var a=d(this).attr("name");a&&d(this).attr("name",a.replace(/FIELD_TEMPLATE/g,g))});e.find("[id]").each(function(){var a=d(this).attr("id");a&&d(this).attr("id",a.replace(/FIELD_TEMPLATE/g,g))});e.find("label").each(function(){var a=d(this).attr("for");a&&d(this).attr("for",a.replace(/FIELD_TEMPLATE/g,g))});c.formberry_form_editor("init_field_cache",e);f=e.data("formberry");f.field_type_field.val(j);var k=h.closest(".formberry-canvas-group").data("formberry").group_order_field.val();
f.field_group_field.val(k);c.formberry_form_editor("field_on_change_type",e);c.formberry_form_editor("generate_field_editor_type_title",e,!1);c.formberry_form_editor("generate_field_editor_title",e,!1);c.formberry_form_editor("generate_field_required_title",e);a.replaceWith(e)})}else{var k=h.closest(".formberry-canvas-group").find(".formberry-canvas-group-order").val();g.item.find(".formberry-field-group").val(k)}}})})},init_widgets:function(b){return this.each(function(){var a="#"+b.css_sp_spec_field_id+
" .formberry-form-canvas-drop-area",c=d("#"+b.css_sp_spec_field_id+" .formberry-form-widgets-list-wrapper");c.find(".formberry-form-widget-type").draggable({revert:"invalid",helper:"clone",connectToSortable:a+" .formberry-canvas-group .formberry-canvas-group-fields"});c.find(".formberry-fields-group-widget").draggable({revert:"invalid",helper:"clone",connectToSortable:a})})},init_all_group_caches:function(b){return this.each(function(){var a=d(this);d("#"+b.css_sp_spec_field_id+" .formberry-canvas-group").each(function(){a.formberry_form_editor("init_group_cache",
d(this))})})},init_all_field_caches:function(b){return this.each(function(){var a=d(this);d("#"+b.css_sp_spec_field_id+" .formberry-canvas-field").each(function(){a.formberry_form_editor("init_field_cache",d(this))})})},init_group_cache:function(b){return this.each(function(){var a=b.find(".formberry-canvas-group-editor"),c=b.find(".formberry-canvas-group-order"),e=b.find("select.formberry-canvas-group-num-columns"),f=b.find("input.formberry-group-title-textbox"),g=b.find("span.formberry-canvas-group-title-text");
a.each(function(){var a=d(this),b=a.find(".dtq-fby-form-field-colorpicker input");a.data("formberry",{color_pickers:b})});b.data("formberry",{editors:a,group_order_field:c,num_columns_field:e,group_title_field:f,group_title_text:g})})},init_field_cache:function(b){return this.each(function(){var a=b.find(".formberry-canvas-field-editor"),d=b.find("select.formberry-field-type-selector"),e=b.find("span.formberry-canvas-field-type-text"),f=b.find(".formberry-field-group"),g=b.find("input.formberry-field-label-textbox"),
h=b.find("span.formberry-canvas-field-title-text"),j=b.find("input.formberry-field-required"),i=b.find("span.formberry-canvas-field-required");b.data("formberry",{editors:a,field_type_field:d,field_type_text:e,field_group_field:f,field_label_field:g,field_title_text:h,required_field:j,required_text:i})})},init_canvas_events:function(b){return this.each(function(){var a=d(this),c=d("#"+b.css_sp_spec_field_id+" .formberry-form-canvas-drop-area");d(m(b)).change(function(){var b=d(this).val();a.formberry_form_editor("set_default_num_columns",
b)});a.find(".formberry-form-tabs").bind("tabsshow",function(){a.formberry_form_editor("check_all_columns")});d(window).resize(function(){d(this).find(".dtq-fby-form-wrapper form").formberry_form_editor("check_all_columns")});a.formberry_form_editor("check_all_columns");c.on("click",".formberry-canvas-group-edit",function(){var a=d(this),c=a.find("img");a.closest(".formberry-canvas-group").data("formberry").editors.each(function(){var a=d(this);a.is(":visible")?(a.hide(),c.each(function(){d(this).attr("src",
b.group_editor_open_button)})):(a.show(),c.each(function(){d(this).attr("src",b.group_editor_close_button)}),a.data("formberry").color_pickers.each(function(){d(this).trigger("change")}))})});c.on("click",".formberry-canvas-group-delete",function(){var c=d(this);confirm(b.group_delete_confirm_text)&&(c=c.closest(".formberry-canvas-group"),c.data("formberry").editors.each(function(){d(this).data("formberry").color_pickers.each(function(){var a=d(this).data("colorpickerId");d("#"+a).remove()})}),a.formberry_form_editor("delete_group_bgimages",
c),c.remove())});c.on("change","select.formberry-canvas-group-num-columns",function(){var b=d(this),c=b.closest(".formberry-canvas-group"),g=a.formberry_form_editor("get_default_num_columns");(b=b.val())||(b=g);a.formberry_form_editor("set_columns_width",c,b)});c.on("change","input.formberry-group-title-textbox",function(){var b=d(this).closest(".formberry-canvas-group-inner");a.formberry_form_editor("generate_group_editor_title",b)});c.on("click",".formberry-canvas-field-edit",function(){var c=d(this),
f=c.find("img");c.closest(".formberry-canvas-field").data("formberry").editors.each(function(){var a=d(this);a.is(":visible")?(a.hide(),f.each(function(){d(this).attr("src",b.field_editor_open_button)})):(a.show(),f.each(function(){d(this).attr("src",b.field_editor_close_button)}))});a.formberry_form_editor("check_all_columns")});c.on("click",".formberry-canvas-field-delete",function(){d(this).closest(".formberry-canvas-field").remove();a.formberry_form_editor("check_all_columns");a.formberry_form_editor("check_field_lists")});
c.on("change","input.formberry-field-label-textbox",function(){var b=d(this).closest(".formberry-canvas-field");a.formberry_form_editor("generate_field_editor_title",b,!0)});c.on("click","input.formberry-field-required",function(){var b=d(this).closest(".formberry-canvas-field");a.formberry_form_editor("generate_field_required_title",b)});c.on("change","select.formberry-field-type-selector",function(){var b=d(this).closest(".formberry-canvas-field");a.formberry_form_editor("field_on_change_type",
b);a.formberry_form_editor("generate_field_editor_type_title",b,!1)});c.on("click","a.formberry-form-conditional-add",function(){var b=d(this).closest(".formberry-canvas-field");a.formberry_form_editor("field_on_add_conditional",b)});c.on("click","a.formberry-form-conditional-delete",function(){var b=d(this).closest(".formberry-canvas-field");a.formberry_form_editor("field_on_delete_conditional",d(this),b)});c.find("select.formberry-field-type-selector").each(function(){var b=d(this).closest(".formberry-canvas-field");
a.formberry_form_editor("field_on_change_type",b);a.formberry_form_editor("generate_field_editor_type_title",b,!1)});a.formberry_form_editor("check_field_lists")})},check_all_columns:function(){return this.each(function(){var b=d(this),a=b.data("formberry"),c=b.formberry_form_editor("get_default_num_columns");d("#"+a.css_sp_spec_field_id+" .formberry-canvas-group").each(function(){var a=d(this),f=a.data("formberry").num_columns_field.val();f||(f=c);b.formberry_form_editor("set_columns_width",a,f)})})},
set_columns_width:function(b,a){return this.each(function(){var c=d(this).data("formberry");0==a&&(a=1);var e=d("#"+c.css_sp_spec_field_id+" .formberry-form-canvas-drop-area").width();e<c.min_column_width&&(e=c.min_column_width);var e=e-2,f=c.column_margin*a+2,g=Math.floor((e-f)/a);g<c.min_column_width&&(g=c.min_column_width);g>c.max_column_width&&(g=c.max_column_width);f=g*a+f;f>e-c.column_margin&&(f=e-c.column_margin);f-=c.column_margin;g-=c.column_margin+1;b.data("formberry-canvas-column-width",
g);b.width(f);b.find(".formberry-canvas-field").each(function(b){var c=d(this);c.width(g);b%a==0?c.addClass("formberry-newrow"):c.removeClass("formberry-newrow")})})},field_on_change_type:function(b){return this.each(function(){var a=b.data("formberry").field_type_field.val();if("empty"==a)b.find("tr.formberry-field-row:not(.formberry-ft-empty)").hide();else{var c="formberry-ft-"+a;b.find("tr.formberry-field-row").each(function(){var a=jQuery(this);!a.hasClass(c)&&!a.hasClass("formberry-ft-all")&&
a.hide()});b.find("tr."+c).css("display","table-row");b.find("tr.formberry-ft-all").css("display","table-row")}})},field_on_add_conditional:function(b){return this.each(function(){var a=b.find("td.formberry-field-conditionals-list"),c=a.find("span.formberry-form-no-conditionals-configured"),e=a.find("table.formberry-form-conditionals-list > tbody"),f=a.find("div.formberry-form-conditional tr.formberry-form-conditional-row").clone(!0),g=a.find("table.formberry-form-conditionals-list tr.formberry-form-conditional-row").length+
1;f.find("input,select,option,textarea").each(function(){var a=d(this),b=a.attr("id"),c=a.attr("name");b&&a.attr("id",b.replace(/CONDITIONAL_ID/g,g));c&&a.attr("name",c.replace(/CONDITIONAL_ID/g,g))});e.append(f);c.hide()})},field_on_delete_conditional:function(b,a){return this.each(function(){b.closest("tr.formberry-form-conditional-row").remove();var c=a.find("td.formberry-field-conditionals-list");0==c.find("table.formberry-form-conditionals-list tr.formberry-form-conditional-row").length&&c.find("span.formberry-form-no-conditionals-configured").show()})},
generate_group_editor_title:function(b){return this.each(function(){var a=b.data("formberry"),c=d("<div />").text(a.group_title_field.val()).html(),c=d.trim(c);""!=c&&(c+=" ");a.group_title_text.html(c)})},delete_group_bgimages:function(b){return this.each(function(){b.find(".dtq-fby-form-field-fileupload .cancel button").each(function(){d(this).trigger("click")});b.find(".dtq-fby-form-field-fileupload .delete input").each(function(){d(this).trigger("click")})})},generate_field_editor_title:function(b,
a){return this.each(function(){var c=d(this),e=b.data("formberry"),f="";"empty"!=e.field_type_field.val()&&(f=d("<div />").text(e.field_label_field.val()).html(),f=d.trim(f),""!=f&&(f+=" "));e.field_title_text.html(f);a&&c.formberry_form_editor("check_field_lists")})},generate_field_required_title:function(b){return this.each(function(){var a=b.data("formberry"),c=a.required_field.is(":checked")?"*":"";a.required_text.html(c)})},generate_field_editor_type_title:function(b,a){return this.each(function(){var c=
d(this),e=b.data("formberry"),f=e.field_type_field.find("option:selected").text();e.field_type_text.html(f);c.formberry_form_editor("generate_field_editor_title",b,!1);c.formberry_form_editor("generate_field_required_title",b);a&&c.formberry_form_editor("check_field_lists")})},check_field_lists:function(){return this.each(function(){var b=d(this),a=b.data("formberry"),c=d("#"+a.css_sp_spec_field_id+" .formberry-form-canvas-drop-area").find(".formberry-canvas-field").map(function(a){var b=null,c=d(this).data("formberry");
"empty"!=c.field_type_field.val()&&(b=d("<div />").text(c.field_label_field.val()).html(),b=d.trim(b),b={field_order:a+1,label:b});return b}),e=!0,f=b.data("formberry_form_fields");if(f&&f.length==c.length)for(var e=!1,g=0;g<f.length;g++){var h=f[g],j=c[g];if(h.field_order!=j.field_order||h.label!=j.label){e=!0;break}}if(e){b.data("formberry_form_fields",c);var i=d("<div>");i.append('<option value=""></option>');d.each(c,function(a,b){var c=d("<option>").attr("value",b.field_order).text(b.label);
i.append(c)});var k=a.fields_list_fields;d("select.formberry-form-conditional-form-field").each(function(a){var b=d(this).attr("id");b&&(b=b.replace(/([#;&,\.\+\*\~':"\!\^$\[\]\(\)=>\|])/g,"\\$1"),k["conditional_form_field_"+a]=b)});d.each(k,function(a,b){var c=d("#"+b),e=c.find("option:selected").text();c.html(i.html());c.find("option").each(function(){var a=!0,b=d(this);b.text()==e&&(b.attr("selected","true"),a=!1);return a})})}})},destroy:function(){return this.each(function(){d(this).removeData("formberry")})}};
d.fn.formberry_form_editor=function(b){if(l[b])return l[b].apply(this,Array.prototype.slice.call(arguments,1));if("object"===typeof b||!b)return l.init.apply(this,arguments);d.error("Method "+b+" does not exist on $.formberry_form_editor");return null}})(dtq_fby_jQuery);