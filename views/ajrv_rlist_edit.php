<?php
global $table_prefix, $wpdb;
$ajrv_opt_maxval = get_option('ajrv_opt_maxval', "10");
$ajrv_opt_meta_show = get_option('ajrv_opt_meta_show', "postpage");
$reviewid = isset($reviewid) ? $reviewid : "";

wp_enqueue_script('ajrvjs', AJRV_PLUGIN_JS);
echo "<script>";
echo "var rinfo = { max : ".$ajrv_opt_maxval.", needitemname : '".__('항목을 입력해주세요.', 'ajreview' )."', del : '".__('삭제', 'ajreview' )."'};";
echo "</script>";
if(isset($_POST["ajrv_id"])){
    $reviewid      = sanitize_text_field($_POST['ajrv_id']);
    $post_id       = sanitize_text_field($_POST['ajrv_post_id']);
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $ajrv_category = $table_prefix . 'ajrv_category';
    $ajrv_review = $table_prefix . 'ajrv_review';
    $ajrv_review_item = $table_prefix . 'ajrv_review_item';

    $isnewcate      = sanitize_text_field( $_POST['ajrv_isnewcate'] );
    $title          = sanitize_text_field( $_POST['ajrv_title'] );
    $singleword     = sanitize_text_field( $_POST['ajrv_singleword'] );
    $groupid	    = sanitize_text_field( $_POST['ajrv_groupid'] );
    $categoryid     = sanitize_text_field( $_POST['ajrv_categoryid'] );
    $publisher  	= sanitize_text_field( $_POST['ajrv_publisher'] );
    $platform 	    = sanitize_text_field( $_POST['ajrv_platform'] );
    $reamount       = sanitize_text_field( $_POST['ajrv_reamount'] );
    $categoryname   = sanitize_text_field( $_POST['ajrv_categoryname'] );
    $onecomment     = sanitize_textarea_field( $_POST['ajrv_onelinecomment'] );
    $pros           = sanitize_textarea_field( $_POST['ajrv_pros'] );
    $cons           = sanitize_textarea_field( $_POST['ajrv_cons'] );
    $photo          = sanitize_text_field( $_POST['ajrv_photo'] );
    $photo  		= $photo ? $photo : "NULL";

    $pre_categoryid = 0;
    if($reviewid){
        $resPre = $mysqli->query("select * from $ajrv_review where id = $reviewid;");
        if(mysqli_num_rows($resPre)){
            $rowPre = mysqli_fetch_assoc($resPre);
            $pre_categoryid = $rowPre["categoryid"];
        }
    }
    //Category
    if($isnewcate == "Y"){
        //새로운 카테고리 등록
        $categoryname = $categoryname != "" ? $categoryname : "Uncategorized";
        $res = $mysqli->query("select id from $ajrv_category where title = '$categoryname' and groupid = $groupid;");
        if(mysqli_num_rows($res)){
            $row = mysqli_fetch_assoc($res);
            $categoryid = $row["id"];
        }else{
            $mysqli->query("insert into $ajrv_category(groupid, title, reviewcount, comment, regdate) values($groupid, '$categoryname', 0, '', '" . date("Y-m-d H:i:s") . "');");
            $categoryid = $mysqli->insert_id;
        }
    }
    error_log("update $ajrv_category set reviewcount = reviewcount + 1 where id = $categoryid;");
    $mysqli->query("update $ajrv_category set reviewcount = reviewcount + 1 where id = $categoryid;");
    error_log($isnewcate . " -- ".$categoryid . " --> " . $pre_categoryid);
    if($categoryid != $pre_categoryid && $pre_categoryid){
        $mysqli->query("update $ajrv_category set reviewcount = reviewcount - 1 where id = $pre_categoryid;");
    }

    $r_item = array();
    $sqlitem = "";
    $overall = 0;
    $realcount = 0;
    $totalvalue = 0;
    //Review Items

    if(is_array($_POST['ajrv_item'])){
        for($i = 0; $i < count($_POST['ajrv_item']); $i++){
            $itemname = sanitize_text_field($_POST['ajrv_item'][$i]);
            $itemvalue = sanitize_text_field($_POST['ajrv_itemvalue'][$i]);
            if($itemname){
                $realcount++;
                $totalvalue += (int)$itemvalue;
                $itemname = mysqli_real_escape_string($mysqli, $itemname);
                array_push($r_item, "insert into $ajrv_review_item(reviewid, groupid, title, overall) values(__RVID__, $groupid, '$itemname', $itemvalue);");
            }
        }
    }
    if($realcount > 0){
        $overall = round((float)$totalvalue / (float)$realcount, 3);
    }

    $savement = ($reviewid ? "수정" : "등록");
    //Review
    if($reviewid){
        $sql = "update $ajrv_review set";
        $sql .= " categoryid    = $categoryid ,";
        $sql .= " groupid    	= $groupid ,";
        if($post_id)
          $sql .= " postid        = $post_id ,";
        $sql .= " title         = '$title' ,";
        $sql .= " publisher		= '$publisher' ,";
        $sql .= " platform      = '$platform' ,";
        $sql .= " singleword    = '$singleword' ,";
        $sql .= " onelinereview = '$onecomment' ,";
        $sql .= " overall       = $overall ,";
        $sql .= " pros          = '$pros' ,";
        $sql .= " cons          = '$cons' ,";
        $sql .= " photo         = $photo ,";
        $sql .= " useramount    = $reamount ,";
        $sql .= " updated       = '".date("Y-m-d H:i:s")."' where id = $reviewid ;";
        error_log($sql);
        $mysqli->query($sql);
		$mysqli->query("delete from $ajrv_review_item where reviewid = $reviewid;");
    }else{
        $sql = "insert into $ajrv_review(groupid, categoryid, postid, authorid, title, publisher, platform, singleword, onelinereview, overall, pros, cons, photo, useramount, regdate) values(";
        $sql .= " $groupid, $categoryid, ".($post_id ? $post_id : "null").", ".get_current_user_id().", '$title', '$publisher', '$platform', '$singleword', '$onecomment', $overall, '$pros', '$cons', $photo, $reamount, '".date("Y-m-d H:i:s")."');";
		error_log($sql);
        $mysqli->query($sql);
        $reviewid = $mysqli->insert_id;
    }

	if(!$reviewid){
		add_action( 'admin_menu', 'register_newpage' );
		function register_newpage(){
			add_menu_page('custom_page', 'custom', 'administrator','custom', 'custompage');
			remove_menu_page('custom');
		}
	}

    foreach($r_item as $ritem){
        $ritem = str_replace("__RVID__", $reviewid, $ritem);
        $mysqli->query($ritem);
    }
    echo "<script>";
    echo "window.location = '/wp-admin/admin.php?page=ajrv_rlist&ajrv_view=list';";
    echo "</script>";
    exit;
}
?>
<div class="aj_bs_iso" style="margin-top:10px;">
	<form method="post">
	  <input type="hidden" name="ajrv_id" value="<?php echo $reviewid?>">
	<?php 
	$ajrv_group = $table_prefix . 'ajrv_group';
	if(count($wpdb->get_results("select * from $ajrv_group"))){
		post_metabox("", $reviewid, "standalone");
	?>
	<p>
		<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo ($reviewid ? __('변경 사항 저장', 'ajreview' ) : __('리뷰 등록', 'ajreview' ))?>">
		<a href="?page=ajrv_rlist&ajrv_view=list" class="button"><?php echo __('그룹 목록', 'ajreview' )?></a>
	</p>
	<?php
	}else{
	?>
		<div style="margin:20px 0px">
			<h4 style='margin-bottom:4px;'><?php echo __('리뷰 그룹 생성 필요', 'ajreview' )?></h4>
			<div class="text-info" style='margin-bottom:8px;'><?php echo __('리뷰 그룹을 먼저 만들어주세요.', 'ajreview' )?></div>
			<a class="button button-primary" href="/wp-admin/admin.php?page=ajrv_rlist_group&ajrv_mode=new" class="btn btn-primary btn-sm"><?php echo __('리뷰 그룹 만들기', 'ajreview' )?></a>
		</div>
	<?php 
	}
	?>
	</form>
</div>
