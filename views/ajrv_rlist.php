<?php
function ajrv_rlist(){
	global $wpdb;
	$page = (isset( $_GET["ajrv_pg"])) ? sanitize_text_field($_GET["ajrv_pg"]) : 1;
	$view = (isset( $_GET["ajrv_view"])) ? sanitize_text_field($_GET["ajrv_view"]) : "list";
	$reviewid = (isset( $_GET["ajrv_rid"])) ? sanitize_text_field($_GET["ajrv_rid"]) : "";

	$pinfo = ajrv_getLicense();
	$lic_match = false;
	if($pinfo){
		$lic_match = true;
	}
	$latestver = ajrv_getLatestVer();
	echo "<div class='wrap'>";
	switch($view){
		case "list" : 
			echo "<h2>". __('리뷰 목록', 'ajreview' ) . " <a href='/wp-admin/admin.php?page=ajrv_rlist_new' class='add-new-h2'>".__('리뷰 등록', 'ajreview' )."</a></h2>";
			require_once(AJRV_PLUGIN_PATH . "views/ajrv_rlist_list.php");
			break;
		case "edit" : 
			echo "<h2 style='margin-bottom: 15px;'>". __('리뷰 수정', 'ajreview' ) . "</h2>";
			echo "</div>";
			echo "<div class='wrap aj_bs_iso'>";
			require_once(AJRV_PLUGIN_PATH . "views/ajrv_rlist_edit.php");
			break;
		case "new" : 
			echo "<h2 style='margin-bottom: 15px;'>". __('리뷰 등록', 'ajreview' ) . "</h2>";
			echo "</div>";
			echo "<div class='wrap aj_bs_iso'>";
			require_once(AJRV_PLUGIN_PATH . "views/ajrv_rlist_edit.php");
			break;
		case "link" : 
			echo "<h2 style='margin-bottom: 15px;'>". __('리뷰 연결', 'ajreview' ) . "</h2>";
			echo "</div>";
			require_once(AJRV_PLUGIN_PATH . "views/ajrv_rlist_link.php");
			break;
		case "review_view" : 
			echo "<h2 style='margin-bottom: 15px;'>". __('리뷰 보기', 'ajreview' ) . "</h2>";
			echo "</div>";
			require_once(AJRV_PLUGIN_PATH . "views/ajrv_rlist_view.php");
			break;
	}
	echo "</div>";
}
?>
