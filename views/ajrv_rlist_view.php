<?php
wp_enqueue_script('ajrvjs', AJRV_PLUGIN_JS);
$tb_review = $wpdb->prefix . "ajrv_review";
$tb_review_category = $wpdb->prefix . "ajrv_category";
$tb_post = $wpdb->prefix . "posts";
$tb_review_item = $wpdb->prefix . "ajrv_review_item";

$skin = "";
if(isset($_POST["ajrv_view_skin"])){
  $skin = sanitize_text_field($_POST["ajrv_view_skin"]);
}
$ajrv_opt_reviewskin = $skin ? $skin : get_option('ajrv_opt_reviewskin', "basic_2");
$review = $wpdb->get_results("select * from $tb_review where id = $reviewid;");
?>
<div class='wrap aj_bs_iso'>
	<div style="margin-bottom:20px;">
	  <h4 style="margin-bottom:15px;"><?php echo $review[0]->title?> </h4>
	  <form id="ajrv_frm_view" method="post">
		<select id="ajrv_view_skin" name="ajrv_view_skin" class="form-control-sm">
		  <option value="basic_1" <?php if($ajrv_opt_reviewskin == "basic_1"){ echo "selected"; }?>><?php echo __('박스형', 'ajreview' )?></option>
		  <option value="basic_2" <?php if($ajrv_opt_reviewskin == "basic_2"){ echo "selected"; }?>><?php echo __('심플형', 'ajreview' )?></option>
		  <option value="basic_3" <?php if($ajrv_opt_reviewskin == "basic_3"){ echo "selected"; }?>><?php echo __('White', 'ajreview' )?></option>
		  <option value="basic_4" <?php if($ajrv_opt_reviewskin == "basic_4"){ echo "selected"; }?>><?php echo __('Dark', 'ajreview' )?></option>
		</select>
	  </form>
	</div>
<?php
wp_enqueue_style('ajrvcss_'.ajrv_getskinbyname($ajrv_opt_reviewskin), plugins_url("skins/".ajrv_getskinbyname($ajrv_opt_reviewskin)."/style.css", __FILE__));
echo ajrv_review_single("", $reviewid, ajrv_getskinbyname($ajrv_opt_reviewskin));
?>
</div>
<p>
	<a href="/wp-admin/admin.php?page=ajrv_rlist&ajrv_rid=<?php echo $reviewid?>&ajrv_view=edit" class="button button-primary"><?php echo __('수정', 'ajreview' )?></a>
	<a href="/wp-admin/admin.php?page=ajrv_rlist&ajrv_view=list" class="button"><?php echo __('리뷰 목록', 'ajreview' )?></a>
</p>
