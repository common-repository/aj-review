<?php
wp_enqueue_script('ajrvjs', AJRV_PLUGIN_JS);
echo "<script>";
echo "var rinfo = { delconfirm : '".__('정말 해당 리뷰를 삭제하겠습니까?', 'ajreview' )."'};";
echo "</script>";
$tb_group = $wpdb->prefix . "ajrv_group";
$tb_review = $wpdb->prefix . "ajrv_review";
$tb_review_category = $wpdb->prefix . "ajrv_category";
$tb_post = $wpdb->prefix . "posts";
$tb_review_item = $wpdb->prefix . "ajrv_review_item";
$ajrv_opt_cur_mark = get_option('ajrv_opt_cur_mark', "");
if(isset($_POST["ajrv_tp"])){
    $ajrv_tp = sanitize_text_field($_POST['ajrv_tp']);
    $ajrv_vl = sanitize_text_field($_POST['ajrv_vl']);
	if($ajrv_tp == "delreview"){
		$wpdb->get_results("delete from $tb_review_item where reviewid = $ajrv_vl;");
		$wpdb->get_results("delete from $tb_review where id = $ajrv_vl;");
	}else if($ajrv_tp == "dellink"){
		$wpdb->get_results("update $tb_review set postid = null where id = $ajrv_vl;");
	}
}
$groupid = "";
if(isset( $_GET["ajrv_group"] )){
	$groupid = sanitize_text_field( $_GET["ajrv_group"] );
}
$tb_ajrv_group = $wpdb->prefix . "ajrv_group";
$gids = $wpdb->get_results("select groupid, count(*) as cnt from $tb_review group by groupid;");
foreach($gids as $g){
	if($g->groupid){
		$wpdb->get_results("update $tb_ajrv_group set reviewcount = $g->cnt where id = $g->groupid;");
	}
}
?>
<style>
#ajrv_admin_review_list a {
	color:#0073aa;
}
#ajrv_admin_review_list .column-title {
	min-width:300px;
}
#ajrv_admin_review_list .column-photo {
	width:30px;
	text-align:center;
}
#ajrv_admin_review_list .column-categorytitle {
	width:120px;
	text-align:center;
	vertical-align: middle;
}
#ajrv_admin_review_list .column-grouptitle {
	width:120px;
	vertical-align: middle;
}
#ajrv_admin_review_list .column-overall, 
#ajrv_admin_review_list .column-post_type {
	width:80px;
	text-align:center;
	vertical-align: middle;
}
#ajrv_admin_review_list .column-userrating {
	width:100px;
	text-align:center;
	vertical-align: middle;
}
#ajrv_admin_review_list .column-useramount {
	width:100px;
	text-align:center;
	vertical-align: middle;
}
#ajrv_admin_review_list .column-shortcode {
	width:150px;
	text-align:center;
	vertical-align: middle;
}
#ajrv_admin_review_list .column-regdate {
	width:150px;
	vertical-align: middle;
}
#ajrv_admin_review_list .column-control {
	width:240px;
	text-align:center;
}
#ajrv_admin_review_list .ac_match, .subsubsub a.current {
    color: #000 !important;
}
</style>
<form id="ajrv_admin_review_list" method="post">
	<input type="hidden" id="ajrv_tp" name="ajrv_tp" value="">
	<input type="hidden" id="ajrv_vl" name="ajrv_vl" value="">
<?php
require_once(AJRV_PLUGIN_PATH . "inc/ajrv.admin.review.list.php");
$review_table = new AJRV_Review_Table();
$review_table->prepare_items();
$review_table->search_box( __( '검색', 'ajreview'), 'nds-group-find');
$review_table->views();
$review_table->display();
?>
</form>
