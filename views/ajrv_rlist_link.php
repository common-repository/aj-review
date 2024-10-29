<?php
wp_enqueue_script('ajrvjs', AJRV_PLUGIN_JS);
echo "<script>";
echo "var rinfo = { linkconfirm : '".__('정말 글과의 연결을 해제하겠습니까?', 'ajreview' )."', needcontent : '".__('글을 1개 선택해주세요.', 'ajreview' )."'};";
echo "</script>";
$tb_review = $wpdb->prefix . "ajrv_review";
$tb_review_category = $wpdb->prefix . "ajrv_category";
$tb_post = $wpdb->prefix . "posts";
$tb_review_item = $wpdb->prefix . "ajrv_review_item";

if(isset($_POST["ajrv_link_page"])){
    $page_id  = sanitize_text_field($_POST['ajrv_link_page']);
    $post_id  = sanitize_text_field($_POST['ajrv_link_post']);
    $p_id = $page_id ? $page_id : $post_id;
    $wpdb->get_results("update ".$tb_review. " set postid = ".$p_id." where id = $reviewid;");
    echo "<script>";
    echo "window.location = '/wp-admin/admin.php?page=ajrv_rlist&ajrv_view=list';";
    echo "</script>";
    exit;
}

$postids = $wpdb->get_results("select postid from ".$tb_review. " where postid is not null");

$review = $wpdb->get_results("select * from $tb_review where id = $reviewid;");
$ajrv_opt_showpos = get_option('ajrv_opt_showpos', "1");
$ajrv_pos = "";
if($ajrv_opt_showpos == "1"){
    $ajrv_pos = __("해당 글 뒤에 리뷰가 표시됩니다.", 'ajreview' );
}else if($ajrv_opt_showpos == "2"){
    $ajrv_pos = __("해당 글 앞에 리뷰가 표시됩니다.", 'ajreview' );
}else{
    $ajrv_pos = __("해당 글 앞과 뒤에 리뷰가 표시됩니다.", 'ajreview' );
}
?>
<div class='wrap aj_bs_iso'>
	<div class="alert alert-info">
		<?php echo __('포스트나 페이지 1개를 선택하여 연결할 수 있습니다.', 'ajreview' )?>
		<?php echo $ajrv_pos?>
	</div>
	<div style="margin-bottom:20px;">
	  <h4 style="margin-bottom:15px;"><?php echo __('연결할 리뷰', 'ajreview' )?> : <?php echo $review[0]->title?> </h4>
	  <div style="padding-left:40px;">
		<h5 id="ajrv_link_hint_text" style="margin-right:20px;"></h5>
	  </div>
	</div>
	<form id="ajrv_admin_review_link" method="post">
	  <div style="margin-top:10px;margin-bottom:20px;">
		<h4><?php echo __('포스트', 'ajreview' )?></h4>
		<select id="ajrv_link_post" name="ajrv_link_post" class="form-control-sm">
		  <option value=""><?php echo __('선택해주세요.', 'ajreview' )?></option>
	<?php
	$posts = $wpdb->get_results("select ID, post_title from ".$wpdb->prefix."posts where post_type = 'post' order by post_modified desc");
	foreach($posts as $post){
	  $isIn = false;
	  foreach($postids as $pstrv){
		if($pstrv->postid == $post->ID){
		  $isIn = true;
		  break;
		}
	  }
	  if(!$isIn)
		echo "<option value=".$post->ID.">".$post->post_title."</option>";
	}
	?>
		</select>
	  </div>
	  <div style="margin-top:10px;margin-bottom:10px;">
		<h4><?php echo __('페이지', 'ajreview' )?></h4>
		<select id="ajrv_link_page" name="ajrv_link_page" class="form-control-sm">
		  <option value=""><?php echo __('선택해주세요.', 'ajreview' )?></option>
	<?php
	$posts = $wpdb->get_results("select ID, post_title from ".$wpdb->prefix."posts where post_type = 'page' order by post_modified desc");
	foreach($posts as $post){
	  $isIn = false;
	  foreach($postids as $pstrv){
		if($pstrv->postid == $post->ID){
		  $isIn = true;
		  break;
		}
	  }
	  if(!$isIn)
		echo "<option value=".$post->ID.">".$post->post_title."</option>";
	}
	?>
		</select>
	  </div>
	</form>
</div>
<p>
	<input type="submit" name="submit" id="ajrv_link_check" class="button button-primary" value="<?php echo __('연결하기', 'ajreview' )?>">
	<a href="/wp-admin/admin.php?page=ajrv_rlist&ajrv_view=list" class="button"><?php echo __('리뷰 목록', 'ajreview' )?></a>
</p>
