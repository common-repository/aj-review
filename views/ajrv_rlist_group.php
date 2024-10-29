<?php
function ajrv_rlist_group(){
	global $wpdb;
	$pinfo = ajrv_getLicense();
	$lic_match = false;
	if($pinfo){
		$lic_match = true;
	}
	$latestver = ajrv_getLatestVer();
	$newvermsg = "";
	if(isset($_GET["ajrv_mode"])){
		include(AJRV_PLUGIN_PATH . "views/ajrv_rlist_group_edit.php");
	}else{
		include(AJRV_PLUGIN_PATH . "views/ajrv_rlist_group_list.php");
	}
}
?>
