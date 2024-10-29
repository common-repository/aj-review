<?php
add_action('add_meta_boxes_comment', 'ajrv_admin_comment_add_meta_box' );
function ajrv_admin_comment_add_meta_box()
{
	add_meta_box( 'ajrv-user-rating-comment-title', __( '사용자 리뷰' ), 'ajrv_admin_comment_meta_box_cb', 'comment', 'normal', 'high' );
}
function ajrv_admin_comment_meta_box_cb( $comment )
{
    $ajrv_opt_maxval = get_option('ajrv_opt_maxval', "10");
	$userrating = get_comment_meta( $comment->comment_ID, 'ajrv_userpoint', true );
	wp_nonce_field( 'ajrv_comment_update', 'ajrv_comment_update', false );
	if($userrating){
?>
	<div class='ajrv-comment-form-israting'>
		<input id='ajrv_is_rating' name='ajrv_is_rating' type='hidden' value='on' />
		<div id='ajrv_review_userbox' class='clearfix'>
			<div class='ajrv-rating' id='ajrv_userrate' data-rateyo-rating="<?php echo $userrating?>" data-rateyo-max-value="<?php echo $ajrv_opt_maxval?>" style='float:left;'></div>
			<div class='ajrv_userrate_text' class='clear:both' style='font-size: 18px; padding-top: 6px; font-weight: bold;'><?php echo $userrating?></div>
			<input id='ajrv_userrate_userpoint' name='ajrv_userrate_userpoint' type='hidden' />
			<div style='clear:both'></div>
		</div>
	</div>
<?php
	}
}
function ajrv_comment_user_rating_edit_comment( $comment_id )
{
    global $table_prefix, $wpdb;
	$ajrv_review_user = $table_prefix . 'ajrv_review_user';
	if( ! isset( $_POST['ajrv_comment_update'] ) || ! wp_verify_nonce( $_POST['ajrv_comment_update'], 'ajrv_comment_update' ) )
		return;
	if( isset( $_POST['ajrv_userrate_userpoint'] ) ){
		$user_rating = sanitize_text_field($_POST['ajrv_userrate_userpoint']);
		update_comment_meta( $comment_id, 'ajrv_userpoint', $user_rating );

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$mysqli->query("update $ajrv_review_user set overall = $user_rating where commentid = $comment_id;");
	}
}

add_action('deleted_comment', 'ajrv_comment_del');
function ajrv_comment_del( $comment_id ) {
    global $table_prefix, $wpdb;
	$ajrv_review_user = $table_prefix . 'ajrv_review_user';

	delete_comment_meta( $comment_id, 'ajrv_userpoint' );

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$mysqli->query("delete from $ajrv_review_user where commentid = $comment_id;");
}

add_action( 'comment_form_logged_in_after', 'ajrv_comment_box' );
add_action( 'comment_form_after_fields', 'ajrv_comment_box' );
function ajrv_comment_box( $default ) {
    global $table_prefix, $wpdb;
    $ajrv_review = $table_prefix . 'ajrv_review';
    $ajrv_opt_maxval = get_option('ajrv_opt_maxval', "10");
	$ajrv_review_user = $table_prefix . 'ajrv_review_user';

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$postid = get_the_ID();
	$isreviewcontent = false;

	$res = $mysqli->query("select * from $ajrv_review where postid = $postid;");
	$ritemdata = array();
	if(mysqli_num_rows($res)){
		$isreviewcontent = true;
		$row = mysqli_fetch_assoc($res);

		if(is_user_logged_in()){
			$current_user = wp_get_current_user();
			$ql = "select id from $ajrv_review_user where reviewid = ".$row["id"]." and useremail = '".$current_user->user_email."'";
			$res = $mysqli->query($ql);
			if(mysqli_num_rows($res)){
				$isreviewcontent = false;
			}else{
				$user_id = get_current_user_id();
				if($row["authorid"] == $user_id){
					$isreviewcontent = false;
				}
			}
		}
	}
	if($isreviewcontent){
		$commenter = wp_get_current_commenter();
		$ajrv_opt_userrating = get_option('ajrv_opt_userrating', "");
		$ajrv_opt_userrating_onlyloggeduser = get_option('ajrv_opt_userrating_onlyloggeduser', "N");
		if(!is_user_logged_in() && $ajrv_opt_userrating_onlyloggeduser == "Y"){
			return $default;
		}
		if($ajrv_opt_userrating){
			echo "
			<div class='ajrv-comment-form-israting'>
				<label for='ajrv_is_rating'>". __('리뷰인가요?', 'ajreview' ) . "</label>
				<input id='ajrv_is_rating' name='ajrv_is_rating' type='checkbox' />

		<table class='ajrv_user_r_box' style='display:none;width: initial;' id='ajrv_review_userbox'><tr><td style='padding: 0px 0px 2px 0px;vertical-align: middle;'>
			<div id='ajrv_userrate' data-rateyo-max-value=".$ajrv_opt_maxval." data-rateyo-star-width='24px' data-rateyo-rating=".round($ajrv_opt_maxval / 2, 1)." style='float:left;padding:0px 6px;'></div>
			</td><td class='ajrv_user_p_data'>
			<div><span id='ajrv_userrate_val' class='ajrv_userrate_text_ro' class='clear:both'>".round($ajrv_opt_maxval / 2, 1)."</span></div>
			<input id='ajrv_userrate_userpoint' name='ajrv_userrate_userpoint' type='hidden' value='".round($ajrv_opt_maxval / 2, 1)."' />
			<input name='ajrv_review_id' type='hidden' value='".$row["id"]."' />
		</td></tr></table>

			</div>";
		}
	}
	return $default;
}

add_filter( 'comment_text', 'ajrv_show_comment_rating' );
function ajrv_show_comment_rating($comment_text) {
    $ajrv_opt_maxval = get_option('ajrv_opt_maxval', "10");
	$ajrv_userpoint = get_comment_meta(get_comment_ID(), "ajrv_userpoint", true);
	if($ajrv_userpoint) {
		$ajrv_rt = "<table class='ajrv_user_r_box' style='width: initial;'><tr><td style='padding: 0px 6px 2px 6px;vertical-align: middle;'>";
		$ajrv_rt .= "	<div class='ajrv-rating-ro' data-rateyo-max-value=".$ajrv_opt_maxval." data-rateyo-star-width='18px' data-rateyo-rating=".$ajrv_userpoint." data-rateyo-read-only='true' style='float:left;'></div>";
		$ajrv_rt .= "</td><td class='ajrv_user_p_data'>";
		$ajrv_rt .= "	<div><span class='ajrv_userrate_text_ro' class='clear:both'>".$ajrv_userpoint."</span></div>";
		$ajrv_rt .= "</td></tr></table>";
		return $ajrv_rt . $comment_text;
	}else{
		return $comment_text;
	}
}

add_filter( 'preprocess_comment', 'ajrv_verify_comment_meta_data' );
function ajrv_verify_comment_meta_data( $commentdata ) {
    global $table_prefix, $wpdb;
	$ajrv_review_user = $table_prefix . 'ajrv_review_user';

	$ajrv_review_id = isset($_POST["ajrv_review_id"]) ? sanitize_text_field($_POST["ajrv_review_id"]) : "";
	$ajrv_isreview = isset($_POST["ajrv_is_rating"]) ? sanitize_text_field($_POST["ajrv_is_rating"]) : "";
	$ajrv_reviewpoint = isset($_POST["ajrv_userrate_userpoint"]) ? sanitize_text_field($_POST["ajrv_userrate_userpoint"]) : "";

	if($ajrv_review_id && $ajrv_isreview && $ajrv_reviewpoint){

		$ajrv_comment_email = $commentdata["comment_author_email"];
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$ql = "select id from $ajrv_review_user where reviewid = $ajrv_review_id and useremail = '$ajrv_comment_email'";
		$res = $mysqli->query($ql);
		if(mysqli_num_rows($res)){
			wp_die( __( '이미 리뷰를 등록하였습니다.', 'ajreview' ) );
		}
	}
	return $commentdata;
}

add_action( 'comment_post', 'ajrv_save_comment_meta_data' );
function ajrv_save_comment_meta_data( $comment_id ){
    global $table_prefix, $wpdb;
	$ajrv_review_user = $table_prefix . 'ajrv_review_user';

	$ajrv_review_id = isset($_POST["ajrv_review_id"]) ? sanitize_text_field($_POST["ajrv_review_id"]) : "";
	$ajrv_isreview = isset($_POST["ajrv_is_rating"]) ? sanitize_text_field($_POST["ajrv_is_rating"]) : "";
	$ajrv_reviewpoint = isset($_POST["ajrv_userrate_userpoint"]) ? sanitize_text_field($_POST["ajrv_userrate_userpoint"]) : "";

	if($ajrv_review_id && $ajrv_isreview && $ajrv_reviewpoint){
		$comment_user_email = get_comment_author_email($comment_id);
		add_comment_meta( $comment_id, 'ajrv_userpoint', $ajrv_reviewpoint );

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$ql = "insert into $ajrv_review_user(reviewid, commentid, useremail, overall, regdate) values(";
		$ql .= "$ajrv_review_id, $comment_id, '$comment_user_email', $ajrv_reviewpoint, '" . date("Y-m-d H:i:s") . "');";
		$mysqli->query($ql);
	}
}
