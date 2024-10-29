<?php
wp_enqueue_script('ajrvjs', AJRV_PLUGIN_JS);
echo "<script>";
echo "var rinfo = { needgroupname : '".__('그룹 이름을 입력해주세요.', 'ajreview' )."', needcontent : '".__('글을 1개 선택해주세요.', 'ajreview' )."'};";
echo "</script>";
$tb_ajrv_group = $wpdb->prefix . "ajrv_group";

$isnew = true;
$ajrv_gid = "";
if(isset($_GET["ajrv_gid"])){
	$isnew = false;
	$ajrv_gid = sanitize_text_field($_GET["ajrv_gid"]);
	$gdata = $wpdb->get_results("select * from $tb_ajrv_group where id = $ajrv_gid;");
	$groupinfo = $gdata[0];
}
if(isset($_POST["ajrv_tp"])){
	$ajrv_tp = sanitize_text_field($_POST['ajrv_tp']);
	$ajrv_vl = sanitize_text_field($_POST['ajrv_vl']);
	if($ajrv_tp == "updategroup"){
		$sql = "update $tb_ajrv_group set title = '".sanitize_text_field($_POST['ajrv_group_title'])."', ";
		$sql .= "comment = '".sanitize_textarea_field($_POST['ajrv_group_comment'])."' where id = $ajrv_vl;";
		$wpdb->get_results($sql);
	}else if($ajrv_tp == "new"){
		$sql = "insert into $tb_ajrv_group (title, comment) values('".sanitize_text_field($_POST['ajrv_group_title'])."', '".sanitize_textarea_field($_POST['ajrv_group_comment'])."');";
		$wpdb->get_results($sql);
	}
	echo "<script>";
	echo "window.location = '/wp-admin/admin.php?page=ajrv_rlist_group';";
	echo "</script>";
	exit;
}
?>
<div class='wrap'>
	<h2>
		<?php echo __("그룹 만들기", "ajreview")?> 
	</h2>
	<form id="ajrv_admin_review_group_new" method="post">
		<div class="options">
			<p>
				<label><?php echo __('그룹 이름', 'ajreview' )?></label>
				<br />
				<input type id="ajrv_group_title" name="ajrv_group_title" style="width:150px" value="<?php echo (!$isnew ? $groupinfo->title : "")?>"/>
			</p>
        </div>
		<div class="options">
			<p>
				<label><?php echo __('그룹 설명', 'ajreview' )?>(<?php echo __('사용자 화면에 나타나지는 않습니다.', 'ajreview' )?>)</label>
				<br />
				<textarea type id="ajrv_group_comment" name="ajrv_group_comment" style='width:600px;height:100px'><?php echo (!$isnew ? $groupinfo->comment : "")?></textarea>
			</p>
        </div>
		<p>
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('변경 사항 저장', 'ajreview' )?>">
			<a href="/wp-admin/admin.php?page=ajrv_rlist_group" class="button"><?php echo __('그룹 목록', 'ajreview' )?></a>
		</p>
		<input type="hidden" id="ajrv_tp" name="ajrv_tp" value="<?php echo (!$isnew ? "updategroup" : "new")?>">
		<input type="hidden" id="ajrv_vl" name="ajrv_vl" value="<?php echo $ajrv_gid?>">
	</form>
</div>
