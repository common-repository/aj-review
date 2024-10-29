jQuery(document).ready(function($){
    function sliderset(){
        jQuery(".ajrv_itempoint").bootstrapSlider();
        jQuery(".ajrv_itempoint").on("change", function(slideEvt) {
            //console.log(jQuery(this).parent().find("span")[0]);
            jQuery(this).parent().find("span").text($(this).val());
            var allpoint = 0;
            var allcount = 0;
            jQuery.each(jQuery("#ajrv_post_metabox_itemlist .list-group-item input.ajrv_itempoint"), function(k, v){
                allpoint += parseInt(jQuery(this).val());
                allcount++;
            });
            var overall = allpoint / allcount;
            jQuery("#ajrv_pointbox").html(overall.toFixed(1));
        });
    }
    jQuery("#ajrv_btn_add_item").click(function(e){
        e.preventDefault();
        var maxval = rinfo.max;
        var halfval = parseInt(rinfo.max) / 2;
        console.log(rinfo);
        var newitem = "<div class='ajrv_item list-group-item form-inline'><input type='text' name='ajrv_item[]' class='ajrv_item_text form-control-sm' placeholder='"+rinfo.needitemname+"'>&nbsp;";
        newitem += "<input name='ajrv_itemvalue[]' type='text' class='ajrv_itempoint' data-slider-min='0' data-slider-max=" + maxval + " ";
        newitem += " data-slider-step='1' data-slider-value='" + halfval + "' />";
        newitem += "<span class='pointtext font-weight-bold'>" + halfval + "</span>";
        newitem += "<input type='button' class='btn btn-danger btn-sm ajrv_delete_item form-control-sm float-right' value='"+rinfo.del+"'></input>";
        newitem += "</div>";
        jQuery("#ajrv_post_metabox_itemlist").append(jQuery(newitem));
        sliderset();
    });
    jQuery('body').on('click','.ajrv_delete_item',function(e){
        console.log("del");
        console.log(jQuery(this));
        jQuery(this).parent().remove();
    });
    jQuery("#ajrv_new_category").click(function(e){
        e.preventDefault();
        jQuery("#ajrv_isnewcate").val("Y");
        jQuery("#ajrv_new_cate_name").val("");
        jQuery("#arjv_dv_select_category").hide();
        jQuery("#arjv_dv_new_category").show();
    });
    jQuery("#ajrv_cancel_category").click(function(e){
        e.preventDefault();
        jQuery("#ajrv_isnewcate").val("N");
        jQuery("#ajrv_new_cate_name").val("");
        jQuery("#arjv_dv_select_category").show();
        jQuery("#arjv_dv_new_category").hide();
    });
    jQuery("#ajrv_use_amount_1").click(function(){
        jQuery("#ajrv_use_amount_opt").show();
    });
    jQuery("#ajrv_use_amount_2").click(function(){
        jQuery("#ajrv_use_amount_opt").hide();
    });
    jQuery(".arjv_url").click(function(){
        var url = jQuery(this).attr("value");
        if(url != "[URL]"){
            window.location = jQuery(this).attr("value");
        }
    });
    jQuery(".ajrv_basic_2_wdget_item").mouseover(function(){
        jQuery(this).find(".ajrv_op").css("opacity", 1);
    });
    jQuery(".ajrv_basic_2_wdget_item").mouseout(function(){
        jQuery(this).find(".ajrv_op").css("opacity", 0.7);
    });
    sliderset();
    jQuery("#ajrv_proscons_1").click(function(){
        jQuery("#dv_proscons").show();
    });
    jQuery("#ajrv_proscons_2").click(function(){
        jQuery("#dv_proscons").hide();
    });
    jQuery("#ajrv_btn_addreview").click(function(){
		window.location = "/wp-admin/admin.php?page=ajrv_rlist_new";
    });
    jQuery(".ajrv_btn_del_review").click(function(){
		var rid = jQuery(this).attr("val");
		if(confirm(rinfo.delconfirm)){
			jQuery("#ajrv_tp").val("delreview");
			jQuery("#ajrv_vl").val(rid);
			jQuery("#ajrv_admin_review_list").submit();
		}
    });
    jQuery(".ajrv_btn_review_link").click(function(){
		var rid = jQuery(this).attr("val");
		window.location = "/wp-admin/admin.php?page=ajrv_rlist&ajrv_view=link&ajrv_rid="+rid;
    });
    jQuery("#ajrv_admin_btn_basic").click(function(){
		window.location = "/wp-admin/admin.php?page=ajrv-plugin-setting";
    });
    jQuery("#ajrv_btn_golist").click(function(){
		window.location = "/wp-admin/admin.php?page=ajrv_rlist";
    });
    jQuery("#ajrv_btn_shcodeinfo").click(function(){
		window.location = "/wp-admin/admin.php?page=ajrv_rlist_shcode";
    });
    jQuery("#ajrv_link_page").change(function(){
        if(jQuery(this).val() != ""){
            jQuery("#ajrv_link_post").prop('selectedIndex', 0);
            jQuery("#ajrv_link_hint_text").text(" -> Page : " + jQuery("#ajrv_link_page option:selected").text());
        }else if(jQuery("#ajrv_link_post").val() == ""){
            jQuery("#ajrv_link_hint_text").text("");
        }
    });
    jQuery("#ajrv_link_post").change(function(){
        if(jQuery(this).val() != ""){
            jQuery("#ajrv_link_page").prop('selectedIndex', 0);
            jQuery("#ajrv_link_hint_text").text(" -> Post : " + jQuery("#ajrv_link_post option:selected").text());
        }else if(jQuery("#ajrv_link_page").val() == ""){
            jQuery("#ajrv_link_hint_text").text("");
        }
    });
    jQuery("#ajrv_view_skin").change(function(){
        jQuery("#ajrv_frm_view").submit();
    });
    jQuery("#ajrv_link_cancel").click(function(){
		window.location = "/wp-admin/admin.php?page=ajrv_rlist";
    });
    jQuery("#ajrv_link_check").click(function(e){
        e.preventDefault();
        if(jQuery("#ajrv_link_page").val() == "" && jQuery("#ajrv_link_post").val() == ""){
            alert(rinfo.needcontent);
            return;
        }
        jQuery("#ajrv_admin_review_link").submit();
    });
    jQuery(".ajrv_btn_dellink_review").click(function(e){
        e.preventDefault();
		var rid = jQuery(this).attr("val");
		if(confirm(rinfo.linkconfirm)){
			jQuery("#ajrv_tp").val("dellink");
			jQuery("#ajrv_vl").val(rid);
			jQuery("#ajrv_admin_review_list").submit();
		}
    });
	
	//group
    jQuery("#ajrv_btn_addreviewgroup").click(function(e){
        e.preventDefault();
		window.location = "/wp-admin/admin.php?page=ajrv_rlist_group&ajrv_mode=new";
    });
    jQuery(".ajrv_btn_edit_group").click(function(e){
        e.preventDefault();
		var gid = jQuery(this).attr("val");
		window.location = "/wp-admin/admin.php?page=ajrv_rlist_group&ajrv_mode=new&ajrv_gid="+gid;
    });
    jQuery("#ajrv_group_edit_new").click(function(e){
        e.preventDefault();
		var title = jQuery("#ajrv_group_title").val();
		if(title == ""){
			alert(rinfo.needgroupname);
			return;
		}
		jQuery("#ajrv_admin_review_group_new").submit();
    });
    jQuery(".ajrv_btn_del_group").click(function(e){
        e.preventDefault();
		var gid = jQuery(this).attr("val");
		jQuery("#ajrv_tp").val("delgroup");
		jQuery("#ajrv_vl").val(gid);
		jQuery("#ajrv_admin_review_group_list").submit();
    });
    jQuery("#ajrv_sel_group").change(function(e){
		var gid = $(this).val();
		if(gid != ""){
			window.location = "/wp-admin/admin.php?page=ajrv_rlist&ajrv_group="+gid;
		}else{
			window.location = "/wp-admin/admin.php?page=ajrv_rlist";
		}
    });
    jQuery(".ajrv_btn_group_addreview").click(function(e){
        e.preventDefault();
		var gid = jQuery(this).attr("val");
		window.location = "/wp-admin/admin.php?page=ajrv_rlist_new&ajrv_gid="+gid;
    });
    jQuery("#ajrv_group_edit_cancel").click(function(e){
        e.preventDefault();
		window.location = "/wp-admin/admin.php?page=ajrv_rlist_group";
    });
	
    jQuery(".ajrv_btn_view_review").click(function(){
		var rid = jQuery(this).attr("val");
		window.location = "/wp-admin/admin.php?page=ajrv_rlist&ajrv_view=review_view&ajrv_rid="+rid;
    });
    jQuery("#ajrv_fbox_category").change(function(){
		fbox_show();
    });
    jQuery("#ajrv_fbox_criteria").change(function(){
		fbox_show();
    });
    jQuery("#ajrv_fbox_order").change(function(){
		fbox_show();
    });
    jQuery("#ajrv_fbox_itemcount").change(function(){
		fbox_show();
    });
    jQuery("#ajrv_fbox_detailshow").change(function(){
		fbox_show();
    });
    jQuery("#ajrv_fbox_title").keypress(function(e){ 
		if (e.keyCode == 13){
			fbox_show();
		}    
	});
    jQuery("#ajrv_is_rating").change(function(){
			if(jQuery(this).is(":checked")){
				jQuery("#ajrv_review_userbox").show();
			}else{
				jQuery("#ajrv_review_userbox").hide();
			}
    });
	$("#ajrv_userrate").rateYo({
		precision: 1,
		numStars: 5,
		starWidth: "24px",
		onChange: function (rating, rateYoInstance) {
			jQuery("#ajrv_userrate_userpoint").val(rating);
			jQuery("#ajrv_userrate_val").text(rating);
		}
	});
	$(".ajrv-rating-ro").rateYo({
		readOnly: true,
		precision: 1,
		numStars: 5,
	});
	function fbox_show(){
		var search = jQuery("#ajrv_fbox_title").val();
		var category = jQuery("#ajrv_fbox_category").val();
		var criteria = jQuery("#ajrv_fbox_criteria").val();
		var order = jQuery("#ajrv_fbox_order").val();
		var itemcount = jQuery("#ajrv_fbox_itemcount").val();
		var detailshow = jQuery("#ajrv_fbox_detailshow").val();
		window.location = "?search="+search+"&category="+category+"&criteria="+criteria+"&order="+order+"&itemcount="+itemcount+"&detailshow="+detailshow;
	}
});
function unlinkreview(rid){
	if(confirm(rinfo.linkconfirm)){
		document.getElementById("ajrv_tp").value = "dellink";
		document.getElementById("ajrv_vl").value = rid;
		document.getElementById("ajrv_admin_review_list").submit();
	}
}
function delreview(rid){
	if(confirm(rinfo.delconfirm)){
		document.getElementById("ajrv_tp").value = "delreview";
		document.getElementById("ajrv_vl").value = rid;
		document.getElementById("ajrv_admin_review_list").submit();
	}
}
function delgroup(gid){
	document.getElementById("ajrv_tp").value = "delgroup";
	document.getElementById("ajrv_vl").value = gid;
	document.getElementById("ajrv_admin_review_group_list").submit();
}
