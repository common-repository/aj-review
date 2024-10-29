<?php
wp_enqueue_script('ajrvjs', AJRV_PLUGIN_JS);
$tb_review = $wpdb->prefix . "ajrv_review";
$tb_ajrv_group = $wpdb->prefix . "ajrv_group";
$gids = $wpdb->get_results("select groupid, count(*) as cnt from $tb_review group by groupid;");
foreach($gids as $g){
	if($g->groupid){
		$wpdb->get_results("update $tb_ajrv_group set reviewcount = $g->cnt where id = $g->groupid;");
	}
}

if(isset($_POST["ajrv_tp"])){
    $ajrv_tp = sanitize_text_field($_POST['ajrv_tp']);
    $ajrv_vl = sanitize_text_field($_POST['ajrv_vl']);
	if($ajrv_tp == "delgroup"){
		$wpdb->get_results("delete from $tb_ajrv_group where id = $ajrv_vl;");
	}
}
?>
<div class='wrap'>
	<h2>
		<?php echo __("그룹 목록", "ajreview")?> 
		<a href='/wp-admin/admin.php?page=ajrv_rlist_group&ajrv_mode=new' class='add-new-h2'><?php echo __("그룹 만들기", "ajreview")?></a>
	</h2>
	<form id="ajrv_admin_review_group_list" method="post">
		<input type="hidden" id="ajrv_tp" name="ajrv_tp" value="">
		<input type="hidden" id="ajrv_vl" name="ajrv_vl" value="">
	<?php
	require_once(AJRV_PLUGIN_PATH . "inc/ajrv.admin.group.list.php");
	$group_table = new AJRV_Group_Table();
	$group_table->prepare_items();
	$group_table->search_box( __( '검색', 'ajreview'), 'nds-group-find');
	$group_table->display();
	?>
	</form>
</div>
