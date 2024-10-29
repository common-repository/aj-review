<?php
function ajrv_post_metabox_html($post){

    $ajrv_opt_maxval = get_option('ajrv_opt_maxval', "10");
    $ajrv_opt_meta_show = get_option('ajrv_opt_meta_show', "postpage");
    
    wp_enqueue_script('ajrvjs', AJRV_PLUGIN_JS);
    wp_localize_script('ajrvjs', 'rinfo', array(
        'max' => $ajrv_opt_maxval,
    ));

    if(strstr($ajrv_opt_meta_show, "post")){
        add_meta_box( 'ajrv_meta_box', 'AJ 리뷰', 'post_metabox_insert', 'post');
    }
    if(strstr($ajrv_opt_meta_show, "post")){
        add_meta_box( 'ajrv_meta_box', 'AJ 리뷰', 'post_metabox_insert', 'page');
    }
}

function post_metabox_insert($post){
    post_metabox($post->ID);
}

function post_metabox($postid = "", $reviewid = "", $from = "include"){
    global $table_prefix, $wpdb;

    $ajrv_category = $table_prefix . 'ajrv_category';
    $ajrv_review = $table_prefix . 'ajrv_review';
    $ajrv_review_item = $table_prefix . 'ajrv_review_item';
	$ajrv_group = $table_prefix . 'ajrv_group';
	$list_group = $wpdb->get_results("select * from $ajrv_group");

    $ajrv_opt_cur = get_option('ajrv_opt_cur', "KRW");
    $ajrv_opt_cur_mark = get_option('ajrv_opt_cur_mark', "");
    $ajrv_opt_maxval = get_option('ajrv_opt_maxval', "10");

    wp_nonce_field('ajrv_nonce_action', 'ajrv_reviewbox_nonce');

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $isupdate = false;

    if($postid){
        $res = $mysqli->query("select a.*, b.title as categoryname from $ajrv_review as a, $ajrv_category as b where postid = $postid;");
        $ritemdata = array();
        if(mysqli_num_rows($res)){
            $isupdate = true;
            $row = mysqli_fetch_assoc($res);
        }
    }else if($reviewid){
        error_log("select a.*, b.title as categoryname from $ajrv_review as a, $ajrv_category as b where a.id = $reviewid;");
        $res = $mysqli->query("select a.*, b.title as categoryname from $ajrv_review as a, $ajrv_category as b where a.id = $reviewid;");
        $ritemdata = array();
        if(mysqli_num_rows($res)){
            $isupdate = true;
            $row = mysqli_fetch_assoc($res);
        }
    }
	
	$pre_group_id = "";
	if(isset($_GET["ajrv_gid"])){
		$pre_group_id = sanitize_text_field( $_GET["ajrv_gid"] );
	}
	if($isupdate){
		$pre_group_id = $row["groupid"];
	}
?>
<div class="ajrv_meta_box">
    <input type="hidden" id="ajrv_isnewcate" name="ajrv_isnewcate" value="N">
    <input type="hidden" name="ajrv_post_id" value="<?php if($isupdate) { echo $row["postid"]; }?>">
    <input type="hidden" id="ajrv_reviewid" name="ajrv_reviewid" value="<?php if($isupdate) { echo $row["id"]; }?>">
    <div class="">
        <div class="row">
            <div class="col-8">
                <div class="form-group">
                    <div class="font-weight-bold" style="margin-bottom:4px;"><?php echo __('리뷰 그룹', 'ajreview' )?></div>
					<select name="ajrv_groupid" id="ajrv_groupid" class="form-control form-control-sm" style="width:250px">
						<option value=""><?php echo __('리뷰 그룹을 선택해주세요.', 'ajreview' )?></option>
					<?php
						foreach($list_group as $group) {
							if($pre_group_id){
					?>
							<option value="<?php echo $group->id?>" <?php if($pre_group_id == $group->id){ echo "selected" ;}?>><?php echo $group->title?></option>
					<?php }else{ ?>
							<option value="<?php echo $group->id?>"><?php echo $group->title?></option>
					<?php
							}
						}
					?>
					</select>
                </div>
                <div class="form-group">
                    <div class="font-weight-bold" style="margin-bottom:4px;"><?php echo __('리뷰 제목', 'ajreview' )?></div>
                    <?php if($isupdate){ ?>
                    <input type="text" name="ajrv_title" class="ajrv_title form-control form-control-sm" value="<?php echo $row['title']?>">
                    <?php }else{ ?>
                    <input type="text" name="ajrv_title" class="ajrv_title form-control form-control-sm" value="">
                    <?php } ?>
                </div>
                <div class="form-group">
                    <div class="font-weight-bold" style="margin-bottom:4px;"><?php echo __('평가 요약', 'ajreview' )?></div>
                    <?php if($isupdate){ ?>
                    <textarea name="ajrv_onelinecomment" class="ajrv_onelinecomment form-control form-control-sm" style='height:100px !important;'><?php echo $row['onelinereview']?></textarea>
                    <?php }else{ ?>
                    <textarea name="ajrv_onelinecomment" class="ajrv_onelinecomment form-control form-control-sm" style='height:100px !important;'></textarea>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <div class="font-weight-bold" style="margin-bottom:4px;"><?php echo __('카테고리', 'ajreview' )?></div>
                    <div id="arjv_dv_select_category" class="form-inline input-group" style="width:400px">
                        <select name="ajrv_categoryid" id="ajrv_categoryid" class="form-control form-control-sm">
                        <?php
                        $rescat = $mysqli->query("select * from $ajrv_category;");
                        if(mysqli_num_rows($rescat)){
                            while ($cat = mysqli_fetch_assoc($rescat)) {
                                if($isupdate){
                        ?>
                                <option value="<?php echo $cat["id"]?>" <?php if($row["categoryid"] == $cat["id"]){ echo "selected" ;}?>><?php echo $cat["title"]?></option>
                        <?php }else{ ?>
                                <option value="<?php echo $cat["id"]?>"><?php echo $cat["title"]?></option>
                        <?php
                                }
                            }
                        }else{
                        ?>
                                <option value=""><?php echo __('카테고리를 추가해주세요.', 'ajreview' )?></option>
                        <?php } ?>
                        </select>
                        <div class="input-group-append">
                            <button type='button' class='btn btn-primary btn-sm' id="ajrv_new_category" style="vertical-align: baseline;"><?php echo __('카테고리 추가', 'ajreview' )?></button>
                        </div>
                    </div>
                    <div id="arjv_dv_new_category" class="form-inline input-group" style="display:none;width:400px;margin-top:4px;">
                        <input type="text" name="ajrv_categoryname" id="ajrv_new_cate_name" class="ajrv_category" value="<?php if($isupdate) { echo $row['categoryname']; }?>">
                        <div class="input-group-append">
                            <button type='button' class='btn btn-primary btn-sm' id="ajrv_cancel_category"><?php echo __('취소', 'ajreview' )?></button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="font-weight-bold" style="margin-bottom:4px;"><?php echo __('리뷰 항목', 'ajreview' )?></div>
                            <button type="button" id="ajrv_btn_add_item" class="ajrv_item_add btn btn-primary btn-sm"><?php echo __('항목 추가하기', 'ajreview' )?></button>
                        </div>
                        <div class="col-md-6">
                            <?php if($isupdate){?>
                            <div class="float-right ajrv_pointbox" id="ajrv_pointbox" style="width: 56px;text-align: center;"><?php echo round($row["overall"],1)?></div>
                            <?php }else{?>
                            <div class="float-right ajrv_pointbox" id="ajrv_pointbox" style="width: 56px;text-align: center;">5</div>
                            <?php }?>
                        </div>
                    </div>
                    <div class="ajrv_items list-group" id="ajrv_post_metabox_itemlist" style="margin-top:4px;">
                    <?php
                    if($isupdate){
                        $resitem = $mysqli->query("select * from $ajrv_review_item where reviewid = ". $row['id'] . ";");
                        if(mysqli_num_rows($resitem)){
                            while ($ritem = mysqli_fetch_assoc($resitem)) {
                    ?>
                        <div class="ajrv_item list-group-item form-inline">
                            <input type="text" name="ajrv_item[]" class="ajrv_item_text form-control-sm" value="<?php echo $ritem["title"]?>">
                            <input name="ajrv_itemvalue[]" type="text" class="ajrv_itempoint" data-slider-min="0" data-slider-max="<?php echo $ajrv_opt_maxval;?>"
                                data-slider-step="1" data-slider-value="<?php echo $ritem["overall"]?>"/>
                            <span class="pointtext font-weight-bold"><?php echo $ritem["overall"];?></span>
                            <input type='button' class='btn btn-danger btn-sm ajrv_delete_item form-control-sm float-right' value='<?php echo __('삭제', 'ajreview' )?>'>
                        </div>
                    <?php
                            array_push($ritemdata, $ritem["title"], $ritem["overall"]);
                            }
                        }
                    }else{
                    ?>
                        <div class="ajrv_item list-group-item form-inline">
                            <input type="text" name="ajrv_item[]" class="ajrv_item_text form-control-sm" value="" placeholder="<?php echo __('항목을 입력해주세요.', 'ajreview' )?>">
                            <input name="ajrv_itemvalue[]" type="text" class="ajrv_itempoint" data-slider-min="0" data-slider-max="<?php echo $ajrv_opt_maxval;?>"
                                data-slider-step="1" data-slider-value="<?php echo ($ajrv_opt_maxval / 2);?>"/>
                            <span class="pointtext font-weight-bold"><?php echo ($ajrv_opt_maxval / 2);?></span>
                            <input type='button' class='btn btn-danger btn-sm ajrv_delete_item form-control-sm float-right' value='<?php echo __('삭제', 'ajreview' )?>'>
                        </div>
                    <?php } ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="font-weight-bold" style="margin-bottom:4px;"><?php echo __('장점', 'ajreview' )?> / <?php echo __('단점', 'ajreview' )?></div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class='font-weight-bold'><?php echo __('장점', 'ajreview' )?> <small>(<?php echo __('한줄씩 입력해주세요.', 'ajreview' )?>)</small></h6>
                            <textarea name="ajrv_pros" class="ajrv_proscons form-control form-control-sm" style="height:150px !important;"><?php if($isupdate) { echo $row['pros']; }?></textarea>
                        </div>
                        <div class="col-md-6">
                            <h6 class='font-weight-bold'><?php echo __('단점', 'ajreview' )?> <small>(<?php echo __('한줄씩 입력해주세요.', 'ajreview' )?>)</small></h6>
                            <textarea name="ajrv_cons" class="ajrv_proscons form-control form-control-sm" style="height:150px !important;"><?php if($isupdate) { echo $row['cons']; }?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <?php if($from == "standalone"){
                    wp_enqueue_media();
                ?>
                <div class="form-group">
                    <div class="font-weight-bold" style="margin-bottom:4px;"><?php echo __('대표 이미지', 'ajreview' )?>(<?php echo __('글 연결시, 글의 대표 이미지가 사용됨', 'ajreview' )?></div>
                    <div>
                        <div class='image-preview-wrapper'>
                            <?php if($isupdate && $row["photo"]){?>
                            <img id='ajrv_image-preview' src='<?php echo wp_get_attachment_url($row["photo"]); ?>' height='100' style='max-height: 100px;'>
                            <?php }else{?>
                            <img id='ajrv_image-preview' src='' height='100' style='max-height: 100px;'>
                            <?php }?>
                        </div>
                        <input id="ajrv_upload_image_button" type="button" class="button" value="<?php echo __('사진 선택', 'ajreview' )?>" />
                        <?php if ($isupdate && $row["photo"]) {?>
                        <input id="ajrv_del_image_button" type="button" class="button" value="<?php echo __('선택 해제', 'ajreview' )?>" />
                        <?php }?>
                        <input type='hidden' name='ajrv_photo' id='ajrv_photo' value='<?php echo ($isupdate && $row["photo"]) ? $row["photo"] : "0"; ?>'>
                    </div>
                </div>
                <script type='text/javascript'>
                    jQuery( document ).ready( function( $ ) {
                        // Uploading files
                        var file_frame;
                        var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
                        var set_to_post_id = <?php echo ($isupdate && $row["photo"]) ? $row["photo"] : "0"; ?>; // Set this
                        jQuery('#ajrv_del_image_button').on('click', function( event ){
                            $( '#ajrv_image-preview' ).attr( 'src', '' ).css( 'width', 'auto' );
                            $( '#ajrv_photo' ).val('');
                        });
                        jQuery('#ajrv_upload_image_button').on('click', function( event ){
                            event.preventDefault();
                            // If the media frame already exists, reopen it.
                            if ( file_frame ) {
                                // Set the post ID to what we want
                                file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
                                // Open frame
                                file_frame.open();
                                return;
                            } else {
                                // Set the wp.media post id so the uploader grabs the ID we want when initialised
                                wp.media.model.settings.post.id = set_to_post_id;
                            }
                            // Create the media frame.
                            file_frame = wp.media.frames.file_frame = wp.media({
                                title: '대표 이미지 선택',
                                button: {
                                    text: '이 이미지 사용',
                                },
                                multiple: false	// Set to true to allow multiple files to be selected
                            });
                            // When an image is selected, run a callback.
                            file_frame.on( 'select', function() {
                                // We set multiple to false so only get one image from the uploader
                                attachment = file_frame.state().get('selection').first().toJSON();
                                // Do something with attachment.id and/or attachment.url here
                                $( '#ajrv_image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
                                $( '#ajrv_photo' ).val( attachment.id );
                                // Restore the main post ID
                                wp.media.model.settings.post.id = wp_media_post_id;
                            });
                                // Finally, open the modal
                                file_frame.open();
                        });
                        // Restore the main ID when the add media button is pressed
                        jQuery( 'a.add_media' ).on( 'click', function() {
                            wp.media.model.settings.post.id = wp_media_post_id;
                        });
                    });
                </script>
                <?php }?>
                <div class="form-group">
                    <div class="font-weight-bold" style="margin-bottom:4px;"><?php echo __('판매사', 'ajreview' )?></div>
                    <?php if($isupdate){ ?>
                    <input type="text" name="ajrv_publisher" class="ajrv_singleword form-control-sm mb-2" style="width:200px" value="<?php echo $row['publisher']?>">
                    <?php }else{ ?>
                    <input type="text" name="ajrv_publisher" class="ajrv_singleword form-control-sm mb-2" style="width:200px" value="">
                    <?php } ?>
                </div>
                <div class="form-group">
                    <div class="font-weight-bold" style="margin-bottom:4px;"><?php echo __('플랫폼', 'ajreview' )?></div>
                    <?php if($isupdate){ ?>
                    <input type="text" name="ajrv_platform" class="ajrv_platform form-control-sm mb-2" style="width:200px" value="<?php echo $row['platform']?>">
                    <?php }else{ ?>
                    <input type="text" name="ajrv_platform" class="ajrv_platform form-control-sm mb-2" style="width:200px" value="">
                    <?php } ?>
                </div>
                <div class="form-group">
                    <div class="font-weight-bold" style="margin-bottom:4px;"><?php echo __('한단어 평가', 'ajreview' )?></div>
                    <?php if($isupdate){ ?>
                    <input type="text" name="ajrv_singleword" class="ajrv_singleword form-control-sm mb-2" style="width:200px" value="<?php echo $row['singleword']?>">
                    <?php }else{ ?>
                    <input type="text" name="ajrv_singleword" class="ajrv_singleword form-control-sm mb-2" style="width:200px" value="">
                    <?php } ?>
                </div>
                <div class="form-group">
                    <div class="font-weight-bold" style="margin-bottom:4px;"><?php echo __('구매 적정가(가치)', 'ajreview' )?></div>
                    <div id="arjv_dv_select_category" class="form-inline">
                        <span class="lead"><?php echo $ajrv_opt_cur?>&nbsp;</span>
                        <?php if($isupdate){ ?>
                        <input type="number" value="<?php echo round($row["useramount"])?>" name="ajrv_reamount" class="form-control-sm" style="text-align:right;width:120px" />
                        <?php }else{ ?>
                        <input type="number" value="0" name="ajrv_reamount" class="form-control-sm" style="text-align:right;width:120px" />
                        <?php } ?>
                        <span class="lead">&nbsp;<?php echo $ajrv_opt_cur_mark?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<?php
function save_metabox($post_id){
    global $table_prefix;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
        return;
    if(!isset($_POST))
        return;
    if(!count($_POST))
        return;
    if(!isset($_POST['ajrv_title']))
        return;
    if(!$_POST['ajrv_title'])
        return;
    
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $user_id = get_current_user_id();
    $ajrv_category = $table_prefix . 'ajrv_category';
    $ajrv_review = $table_prefix . 'ajrv_review';
    $ajrv_review_item = $table_prefix . 'ajrv_review_item';

    $isnewcate      = sanitize_text_field( $_POST['ajrv_isnewcate'] );
    $title          = sanitize_text_field( $_POST['ajrv_title'] );
    $singleword     = sanitize_text_field( $_POST['ajrv_singleword'] );
    $reviewid       = sanitize_text_field( $_POST['ajrv_reviewid'] );
    $groupid 	    = sanitize_text_field( $_POST['ajrv_groupid'] );
    $categoryid     = sanitize_text_field( $_POST['ajrv_categoryid'] );
    $publisher  	= sanitize_text_field( $_POST['ajrv_publisher'] );
    $platform 	    = sanitize_text_field( $_POST['ajrv_platform'] );
    $reamount       = sanitize_text_field( $_POST['ajrv_reamount'] );
    $categoryname   = sanitize_text_field( $_POST['ajrv_categoryname'] );
    $onecomment     = sanitize_textarea_field( $_POST['ajrv_onelinecomment'] );
    $pros           = sanitize_textarea_field( $_POST['ajrv_pros'] );
    $cons           = sanitize_textarea_field( $_POST['ajrv_cons'] );
    $photo          = sanitize_text_field( $_POST['ajrv_photo'] );
    $nonce_name     = sanitize_text_field( $_POST['ajrv_nonce_action'] );
    $nonce_action   = 'ajrv_reviewbox_nonce';

    //if (!wp_verify_nonce($nonce_name, $nonce_action)){ return; }
    if (!current_user_can('edit_post', $post_id)){ return; }
    if (wp_is_post_autosave($post_id)){ return; }
    if (wp_is_post_revision($post_id)){ return; }

    $pre_categoryid = 0;
    if($reviewid){
        $resPre = $mysqli->query("select * from $ajrv_review where id = $reviewid;");
        if(mysqli_num_rows($resPre)){
            $rowPre = mysqli_fetch_assoc($resPre);
            $pre_categoryid = $rowPre["categoryid"];
        }
    }
    //Category
    error_log("Category OK? " .$isnewcate);
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
    $mysqli->query("update $ajrv_category set reviewcount = reviewcount + 1 where id = $categoryid;");
    if($categoryid != $pre_categoryid && $pre_categoryid){
        $mysqli->query("update $ajrv_category set reviewcount = reviewcount - 1 where id = $pre_categoryid;");
    }
    
    $r_item = array();
    $sqlitem = "";
    $overall = 0;
    $realcount = 0;
    $totalvalue = 0;
    //Review Items
    
    for($i = 0; $i < count($_POST['ajrv_item']); $i++){
        $itemname = sanitize_text_field($_POST['ajrv_item'][$i]);
        $itemvalue = sanitize_text_field($_POST['ajrv_itemvalue'][$i]);
        if($itemname){
            $realcount++;
            $totalvalue += (int)$itemvalue;
            $itemname = mysqli_real_escape_string($mysqli, $itemname);
            array_push($r_item, "insert into $ajrv_review_item(reviewid, title, overall) values(__RVID__, '$itemname', $itemvalue);");
        }
    }
    if($realcount > 0){
        $overall = round((float)$totalvalue / (float)$realcount, 3);
    }
    $res_rev = $mysqli->query("select id from $ajrv_review where postid = $post_id;");
    if(mysqli_num_rows($res_rev)){
        $row = mysqli_fetch_assoc($res_rev);
        $reviewid = $row["id"];
    }

    //Review
    if($reviewid){
        $sql = "update $ajrv_review set";
        $sql .= " groupid    	= $groupid ,";
        $sql .= " categoryid    = $categoryid ,";
        $sql .= " postid        = $post_id ,";
        $sql .= " authorid      = $user_id ,";
        $sql .= " title         = '$title' ,";
        $sql .= " publisher		= '$publisher' ,";
        $sql .= " platform      = '$platform' ,";
        $sql .= " singleword    = '$singleword' ,";
        $sql .= " onelinereview = '$onecomment' ,";
        $sql .= " overall       = $overall ,";
        $sql .= " pros          = '$pros' ,";
        $sql .= " cons          = '$cons' ,";
        $sql .= " photo          = $photo ,";
        $sql .= " useramount    = $reamount ,";
        $sql .= " updated       = '".date("Y-m-d H:i:s")."' where id = $reviewid ;";
        error_log($sql);
        $mysqli->query($sql);
    }else{
        $sql = "insert into $ajrv_review(groupid, categoryid, postid, authorid, title, publisher, platform, singleword, onelinereview, overall, pros, cons, photo, useramount, regdate) values(";
        $sql .= " $groupid, $categoryid, $post_id, $user_id, '$title', '$publisher', '$platform', '$singleword', '$onecomment', $overall, '$pros', '$cons', $photo, $reamount, '".date("Y-m-d H:i:s")."');";
        error_log($sql);
        $mysqli->query($sql);
        $reviewid = $mysqli->insert_id;
    }

    $mysqli->query("delete from $ajrv_review_item where reviewid = $reviewid;");

    foreach($r_item as $ritem){
        $ritem = str_replace("__RVID__", $reviewid, $ritem);
        $mysqli->query($ritem);
    }
}
?>
