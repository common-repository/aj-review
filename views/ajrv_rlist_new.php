<?php
function ajrv_rlist_new(){
	global $wpdb;
	$pinfo = ajrv_getLicense();
	$lic_match = false;
	if($pinfo){
		$lic_match = true;
	}
	$latestver = ajrv_getLatestVer();
	?>
	<div class="wrap">
	<?php
	$newvermsg = "";
	echo "<h2>".__('리뷰 등록', 'ajreview' )."</h2>";
	require_once(AJRV_PLUGIN_PATH . "views/ajrv_rlist_edit.php");
?>
	</div>
<?php
}
?>
