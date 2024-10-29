<?php
function ajrv_shcode_review_list($atts, $content = null){
    return ajrv_review_list($atts, $content);
}
function ajrv_review_list($atts, $content = null) {
    global $table_prefix, $wpdb;

    $groupid = isset($atts["gid"]) ? trim($atts["gid"]) : "";
    $filterbox = isset($atts["filterbox"]) ? trim($atts["filterbox"]) : "Y";
    $displaytype = isset($atts["displaytype"]) ? trim($atts["displaytype"]) : "inline";
    $skin = isset($atts["skin"]) ? trim($atts["skin"]) : "";
    $rids = isset($atts["rids"]) ? trim($atts["rids"]) : "";
    $reviewcount = isset($atts["reviewcount"]) ? trim($atts["reviewcount"]) : "50";
    $showpage = isset($atts["showpage"]) ? trim($atts["showpage"]) : "N";
    $filter_category = isset($atts["category"]) ? trim($atts["category"]) : "";
    $filter_criteria = isset($atts["criteria"]) ? trim($atts["criteria"]) : "";
    $filter_title = isset($atts["title"]) ? trim($atts["title"]) : "";
    $ordertype = isset($atts["ordertype"]) ? trim($atts["ordertype"]) : "overall";
    $ordering = isset($atts["order"]) ? trim($atts["order"]) : "desc";
    $detailshow = isset($atts["detailshow"]) ? trim($atts["detailshow"]) : "0";

	$filter_title = isset($_GET["search"]) ? sanitize_text_field($_GET["search"]) : $filter_title;
	$filter_category = isset($_GET["category"]) ? sanitize_text_field($_GET["category"]) : $filter_category;
	$filter_criteria = isset($_GET["criteria"]) ? sanitize_text_field($_GET["criteria"]) : $filter_criteria;
	$ordering = isset($_GET["order"]) ? sanitize_text_field($_GET["order"]) : $ordering;
	$reviewcount = isset($_GET["itemcount"]) ? sanitize_text_field($_GET["itemcount"]) : $reviewcount;
	$detailshow = isset($_GET["detailshow"]) ? sanitize_text_field($_GET["detailshow"]) : $detailshow;

    $ajrv_category = $table_prefix . 'ajrv_category';
    $ajrv_review = $table_prefix . 'ajrv_review';
    $ajrv_review_item = $table_prefix . 'ajrv_review_item';

    $ajrv_opt_reviewskin = $skin ? $skin : get_option('ajrv_opt_reviewskin', "basic_1");
    wp_enqueue_style('ajrvcss_'.ajrv_getskinbyname($ajrv_opt_reviewskin), plugins_url("skins/".ajrv_getskinbyname($ajrv_opt_reviewskin)."/style.css", __FILE__));
    if($displaytype == "list"){
        include(plugin_dir_path(__FILE__)."skins/".ajrv_getskinbyname($ajrv_opt_reviewskin)."/listitem.php");
    }else if($displaytype == "inline"){
        include(plugin_dir_path(__FILE__)."skins/".ajrv_getskinbyname($ajrv_opt_reviewskin)."/inlinelistitem.php");
    }else{
        include(plugin_dir_path(__FILE__)."skins/".ajrv_getskinbyname($ajrv_opt_reviewskin)."/main.php");
    }
    //wp_register_style('ajrvskincss', plugins_url("aj-review/views/skins/".$ajrv_opt_reviewskin."/style.css"));
    //wp_enqueue_style('ajrvskincss');

    if($groupid){
		$list_category = $wpdb->get_results('select id, title from '.$ajrv_category.' where groupid = '.$groupid.' order by reviewcount desc');
		$list_criteria = $wpdb->get_results('select title from '.$ajrv_review_item.' where groupid = '.$groupid.' group by title');
	}else{
		$list_category = $wpdb->get_results('select id, title from '.$ajrv_category.' order by reviewcount desc');
		$list_criteria = $wpdb->get_results('select title from '.$ajrv_review_item.' group by title');
	}
	
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $sqladd = "";
    $sql = "select a.*, b.title as categoryname ";
    if($filter_criteria){
        $sql .= ", c.overall as crioverall ";
        $sql .= " from $ajrv_review as a join $ajrv_category as b on a.categoryid = b.id ";
        $sql .= " join $ajrv_review_item as c on a.id = c.reviewid and c.title like '$filter_criteria' ";
        $sql .= " where 0 = 0";
        $sqlorder = " order by c.overall $ordering ";
    }else{
        $sql .= " from $ajrv_review as a join $ajrv_category as b on a.categoryid = b.id ";
        $sql .= " where 0 = 0";
        $sqlorder = " order by $ordertype $ordering ";
    }
    if($groupid)
        $sqladd .= " and a.groupid = $groupid ";
    if($filter_title)
        $sqladd .= " and a.title like '%$filter_title%' ";
    if($filter_category)
        $sqladd .= " and b.title = '$filter_category' ";
    if($rids == 'latest'){
        $sqlorder = " order by a.id desc";
		$reviewcount = 1;
	}else if($rids){
        $sqladd .= " and a.id in (".$rids.") ";
	}

    $sql .= $sqladd . $sqlorder . ($reviewcount ? " limit $reviewcount " : "");

    $res = $mysqli->query($sql);
    $ritemdata = array();
    $all_review = "";
    if(trim($content)){
        $all_review .= "<h3>".$content."</h3>";
    }
    $itemdata = "<div class='aj_bs_iso'>";
    if($filterbox == "Y"){
        $itemdata .= "<div class='row'>";
        $itemdata .= "  <div class='col-md-9'>";
    }
	$ajrv_skin_url = plugins_url("skins/".ajrv_getskinbyname($ajrv_opt_reviewskin), __FILE__);
	$i = 1;
    if(mysqli_num_rows($res)){
        while($row = mysqli_fetch_assoc($res)){
            /*
            $review_item_box = getReviewBox($row, $mysqli, 
                $arjv_skin, 
                $arjv_useramouont, 
                $arjv_item_skin, 
                $ajrv_skin_pros_cons, 
                $arjv_pros_skin, 
                $arjv_cons_skin,
                $filter_criteria);
            */
            $review_item_list = getReviewListItem($row, $mysqli, 
                $arjv_skin, 
                $arjv_useramouont, 
                $arjv_item_skin, 
                $ajrv_skin_pros_cons, 
                $arjv_pros_skin, 
                $arjv_cons_skin,
				$arjv_user_rating,
                $filter_criteria,
                $i,
                $ajrv_onlyone,
				$detailshow,
				$ajrv_skin_url
            );

            $itemdata .= $review_item_list;
			$i++;
        }
        if($filterbox == "Y"){
            include(plugin_dir_path(__FILE__)."skins/".ajrv_getskinbyname($ajrv_opt_reviewskin)."/filterbox.php");
            $itemdata .= "  </div>";
            $itemdata .= $fbox;
            $itemdata .= "</div>";
        }
		$itemdata .= "</div>";
        return $all_review.$itemdata;
    }
    return "";
}
function getReviewListItem($row, $mysqli, $arjv_skin, $arjv_useramouont, $arjv_item_skin, $ajrv_skin_pros_cons, 
		$arjv_pros_skin, $arjv_cons_skin, $arjv_user_rating, $filter_criteria, $top, $ajrv_onlyone, $detailshow, $ajrv_skin_url){
    global $table_prefix;
    $ajrv_category = $table_prefix . 'ajrv_category';
    $ajrv_review = $table_prefix . 'ajrv_review';
    $ajrv_review_item = $table_prefix . 'ajrv_review_item';
	$ajrv_review_user = $table_prefix . 'ajrv_review_user';

    $ajrv_opt_headertext = get_option('ajrv_opt_headertext', __('리뷰', 'ajreview' ));
    $ajrv_opt_maxval = get_option('ajrv_opt_maxval', "10");
    $ajrv_opt_useproscons = get_option('ajrv_opt_useproscons', "1");
    $ajrv_opt_useamount = get_option('ajrv_opt_useamount', "1");
    $ajrv_opt_cur = get_option('ajrv_opt_cur', "USD");
    $ajrv_opt_cur_mark = get_option('ajrv_opt_cur_mark', "");
    $ajrv_opt_cur_text = get_option('ajrv_opt_cur_text', "USD");
    $ajrv_opt_cur_undefined = get_option('ajrv_opt_cur_undefined', "USD");
    $ajrv_opt_pros_title = get_option('ajrv_opt_pros_title', __('장점', 'ajreview' ));
    $ajrv_opt_cons_title = get_option('ajrv_opt_cons_title', __('단점', 'ajreview' ));
	$ajrv_opt_userrating = get_option('ajrv_opt_userrating', "");
	$ajrv_opt_userrating = 1;

    $review_item = $arjv_skin;
	$no_image = $ajrv_skin_url."/aj-review-no-image.png";

	if($ajrv_opt_userrating && $row["postid"]){
		$user_rating_count = 0;
		$user_rating_points = 0;
		$q = "SELECT overall FROM $ajrv_review_user as a join ";
		$q .= $table_prefix."comments as b on a.commentid = b.comment_ID ";
		$q .= " and b.comment_approved = '1' and a.reviewid = ".$row["id"];
		$res_com = $mysqli->query($q);
		$user_rating_count = mysqli_num_rows($res_com);
        while($row_com = mysqli_fetch_assoc($res_com)){
			$user_rating_points += $row_com["overall"];
		}
		if($user_rating_count){
			$arjv_user_rating = str_replace("[USER_OVERALL]", round($user_rating_points / $user_rating_count, 1), $arjv_user_rating);
			$arjv_user_rating = str_replace("[USER_RATING_COUNT]", $user_rating_count, $arjv_user_rating);
			$review_item = str_replace("[U_RATING]", $arjv_user_rating, $review_item);
		}else{
			$review_item = str_replace("[U_RATING]", "", $review_item);
			$review_item = str_replace("[USER_RATING_COUNT]", "", $review_item);
		}
	}else{
		$review_item = str_replace("[U_RATING]", "", $review_item);
		$review_item = str_replace("[USER_RATING_COUNT]", "", $review_item);
	}
    if($top == 1){
        $review_item = str_replace("[CROWN]", "<i class='fas fa-crown'></i><br/>", $review_item);
        $review_item = str_replace("[TOPNO]", "", $review_item);
    }else{
        $review_item = str_replace("[CROWN]", "", $review_item);
        $review_item = str_replace("[TOPNO]", $top, $review_item);
    }
    if($top <= $detailshow){
        $review_item = str_replace("[ONLYONE]", $ajrv_onlyone, $review_item);
        $review_item = str_replace("[TONEDOWN-SKIN1]", "", $review_item);
        $review_item = str_replace("[TONEDOWN-SKIN2]", "", $review_item);
    }else{
        $review_item = str_replace("[ONLYONE]", "", $review_item);
        $review_item = str_replace("[TONEDOWN-SKIN1]", "background:#7c7f84", $review_item);
        $review_item = str_replace("[TONEDOWN-SKIN2]", "background:#7f8084", $review_item);
    }
    $review_item = str_replace("[HEADER_TEXT]", $ajrv_opt_headertext, $review_item);
    $review_item = str_replace("[TITLE]", "", $review_item);
	$review_item = str_replace("[PRODUCT]", $row["title"] ?  $row["title"] : "", $review_item);
    if($row["postid"]){
		$review_item = str_replace("[URL]", get_permalink($row["postid"]), $review_item);
		$review_item = str_replace("[URLTAG]", "a", $review_item);
		$review_item = str_replace("[URLCURSOR]", "cursor: pointer;", $review_item);
		$review_item = str_replace("[URLCSS]", "arjv_url", $review_item);
		$review_item = str_replace("[DOCICON]", "<i class='fas fa-file-alt'></i>", $review_item);
    }else{
		$review_item = str_replace("[URL]", "#", $review_item);
		$review_item = str_replace("[URLTAG]", "span", $review_item);
		$review_item = str_replace("[URLCURSOR]", "cursor: initial;", $review_item);
		$review_item = str_replace("[URLCSS]", "", $review_item);
		$review_item = str_replace("[DOCICON]", "", $review_item);
    }
	$ajrv_post_photo = "";
	if($row['photo']){
		//$attr = wp_get_attachment_image_src($row['photo'], array(200, 80));
		$attr = wp_get_attachment_image_src($row['photo'], 'gallery_min');
		$ajrv_post_photo = $attr[0];
		$review_item = str_replace("[IMG_BIG]", $attr[0], $review_item);
	}
	if(!$ajrv_post_photo){
		if($row['postid']){
			//$attr = wp_get_attachment_image_src(get_post_thumbnail_id($row['postid']), array(200, 80));
			$attr = wp_get_attachment_image_src(get_post_thumbnail_id($row['postid']), 'gallery_min');
			$ajrv_post_photo = $attr[0];
			if($ajrv_post_photo){
				$review_item = str_replace("[IMG_BIG]", $attr[0], $review_item);
			}
		}else{
			$review_item = str_replace("[IMG_BIG]", $no_image, $review_item);
		}
	}
    $review_item = str_replace("[CATEGORY]", $row["categoryname"], $review_item);
    $review_item = str_replace("[SINGLE]", $row["singleword"] ? $row["singleword"] : "&nbsp;", $review_item);
    $review_useramount = $arjv_useramouont;
    if($ajrv_opt_useamount == "1"){
        if($row["useramount"]){
            if(getCur($row["useramount"])){
                $review_useramount = str_replace("[AMOUNT]", number_format($row["useramount"], 0), $review_useramount);
            }else{
                $review_useramount = str_replace("[AMOUNT]", number_format($row["useramount"], 2), $review_useramount);
            }
            $review_useramount = str_replace("[AMOUNTCURR]", $ajrv_opt_cur, $review_useramount);
            $review_useramount = str_replace("[AMOUNTCURRMARK]", $ajrv_opt_cur_mark, $review_useramount);
        }else{
            $review_useramount = str_replace("[AMOUNT]", $ajrv_opt_cur_undefined, $review_useramount);
            $review_useramount = str_replace("[AMOUNTCURR]", "", $review_useramount);
            $review_useramount = str_replace("[AMOUNTCURRMARK]", "", $review_useramount);
        }
        $review_useramount = str_replace("[AMOUNT_TEXT]", $ajrv_opt_cur_text, $review_useramount);
        $review_item = str_replace("[USERAMOUNT]", $review_useramount, $review_item);
    }else{
        $review_item = str_replace("[USERAMOUNT]", "", $review_item);
    }
    $review_item = str_replace("[SUMMARY]", nl2br($row["onelinereview"]), $review_item);
    $review_item = str_replace("[OVERALL]", round($row["overall"], 1), $review_item);
    $review_item = str_replace("[OVERALL100]", $ajrv_opt_maxval, $review_item);
    $review_item = str_replace("[OVERALLMAX]", $ajrv_opt_maxval, $review_item);
    
    //Pros & Cons
    if($ajrv_opt_useproscons == "1"){
        $ajrv_skin_pros_cons_data = $ajrv_skin_pros_cons;
        $arjv_pros_skin_data = "";
        $arjv_cons_skin_data = "";
        $cnt = 0;
        foreach(explode("\n", $row["pros"]) as $pros){
            if(trim($pros)){
                $arjv_pros_skin_data .= str_replace("[PROS]", $pros, $arjv_pros_skin);
                $cnt++;
            }
        }
        if($cnt > 0){
            $ajrv_skin_pros_cons_data = str_replace("[PROS]", $arjv_pros_skin_data, $ajrv_skin_pros_cons_data);
        }else{
            $ajrv_skin_pros_cons_data = str_replace("[PROS]", "", $ajrv_skin_pros_cons_data);
        }
        $cnt = 0;
        foreach(explode("\n", $row["cons"]) as $cons){
            if(trim($cons)){
                $arjv_cons_skin_data .= str_replace("[CONS]", $cons, $arjv_cons_skin);
                $cnt++;
            }
        }
        if($cnt > 0){
            $ajrv_skin_pros_cons_data = str_replace("[CONS]", $arjv_cons_skin_data, $ajrv_skin_pros_cons_data);
        }else{
            $ajrv_skin_pros_cons_data = str_replace("[CONS]", "", $ajrv_skin_pros_cons_data);
        }
        $ajrv_skin_pros_cons_data = str_replace("[PROS_TITLE]", $ajrv_opt_pros_title, $ajrv_skin_pros_cons_data);
        $ajrv_skin_pros_cons_data = str_replace("[CONS_TITLE]", $ajrv_opt_cons_title, $ajrv_skin_pros_cons_data);
        $review_item = str_replace("[PROSCONS]", $ajrv_skin_pros_cons_data, $review_item);
    }else{
        $review_item = str_replace("[PROSCONS]", "", $review_item);
    }
    if($row['postid']){
        $review_item = str_replace("[IMG]", get_the_post_thumbnail_url($row['postid'],'thumbnail'), $review_item);
        $review_item = str_replace("[IMG_BIG]", get_the_post_thumbnail_url($row['postid']), $review_item);
    }else if($row['photo']){
        $review_item = str_replace("[IMG]", wp_get_attachment_url($row['photo']), $review_item);
        $review_item = str_replace("[IMG_BIG]", wp_get_attachment_url($row['photo']), $review_item);
    }else{
        $review_item = str_replace("[IMG]", "", $review_item);
        $review_item = str_replace("[IMG_BIG]", "", $review_item);
    }

    $resitem = $mysqli->query("select * from $ajrv_review_item where reviewid = ". $row['id'] . ";");
    $reviewitems = "";
    while ($ritem = mysqli_fetch_assoc($resitem)) {
        if($filter_criteria == $ritem["title"]){
            $arjv_item_skin_tmp = str_replace("[HILIGHT]", "ajrv_color_10", $arjv_item_skin);
            $arjv_item_skin_tmp = str_replace("[HILIGHT-TEXT]", "", $arjv_item_skin_tmp);
        }else{
            $arjv_item_skin_tmp = str_replace("[HILIGHT]", "ajrv_color_2", $arjv_item_skin);
            $arjv_item_skin_tmp = str_replace("[HILIGHT-TEXT]", "", $arjv_item_skin_tmp);
        }
        $arjv_item_skin_tmp = str_replace("[TITLE]", $ritem["title"], $arjv_item_skin_tmp);
        $arjv_item_skin_tmp = str_replace("[OVERALL]", $ritem["overall"], $arjv_item_skin_tmp);
        $arjv_item_skin_tmp = str_replace("[OVERALL100]", $ajrv_opt_maxval, $arjv_item_skin_tmp);
        $arjv_item_skin_tmp = str_replace("[OVAL]", (((int)$ritem["overall"] * 100) / (int)$ajrv_opt_maxval), $arjv_item_skin_tmp);
        $arjv_item_skin_tmp = str_replace("[DEOVALGREE]", 
            round($ritem["overall"], 1) * 180 / $ajrv_opt_maxval,
            $arjv_item_skin_tmp);
        $reviewitems .= $arjv_item_skin_tmp;
    }
    $review_item = str_replace("[ITEM_VAL]", $reviewitems, $review_item);
    return $review_item;
}
function getReviewBox($row, $mysqli, $arjv_skin, $arjv_useramouont, $arjv_item_skin, $ajrv_skin_pros_cons, $arjv_pros_skin, $arjv_cons_skin, $filter_criteria){
    global $table_prefix;
    $ajrv_category = $table_prefix . 'ajrv_category';
    $ajrv_review = $table_prefix . 'ajrv_review';
    $ajrv_review_item = $table_prefix . 'ajrv_review_item';

    $ajrv_opt_headertext = get_option('ajrv_opt_headertext', "1");
    $ajrv_opt_maxval = get_option('ajrv_opt_maxval', "10");
    $ajrv_opt_useproscons = get_option('ajrv_opt_useproscons', "1");
    $ajrv_opt_useamount = get_option('ajrv_opt_useamount', "1");
    $ajrv_opt_cur = get_option('ajrv_opt_cur', "USD");
    $ajrv_opt_cur_mark = get_option('ajrv_opt_cur_mark', "");
    $ajrv_opt_cur_text = get_option('ajrv_opt_cur_text', "USD");
    $ajrv_opt_cur_undefined = get_option('ajrv_opt_cur_undefined', "USD");

    $review_item = $arjv_skin;
    $review_item = str_replace("[HEADER_TEXT]", $ajrv_opt_headertext, $review_item);
    $review_item = str_replace("[TITLE]", "", $review_item);
    $review_item = str_replace("[CATEGORY]", $row["categoryname"], $review_item);
    $review_item = str_replace("[SINGLE]", $row["singleword"] ? $row["singleword"] : "&nbsp;", $review_item);
    $review_item = str_replace("[PRODUCT]", $row["title"] ?  $row["title"] : "", $review_item);
    $review_useramount = $arjv_useramouont;
    if($ajrv_opt_useamount == "1"){
        if($row["useramount"]){
            if(getCur($row["useramount"])){
                $review_useramount = str_replace("[AMOUNT]", number_format($row["useramount"], 0), $review_useramount);
            }else{
                $review_useramount = str_replace("[AMOUNT]", number_format($row["useramount"], 2), $review_useramount);
            }
            $review_useramount = str_replace("[AMOUNTCURR]", $ajrv_opt_cur, $review_useramount);
            $review_useramount = str_replace("[AMOUNTCURRMARK]", $ajrv_opt_cur_mark, $review_useramount);
        }else{
            $review_useramount = str_replace("[AMOUNT]", $ajrv_opt_cur_undefined, $review_useramount);
            $review_useramount = str_replace("[AMOUNTCURR]", "", $review_useramount);
            $review_useramount = str_replace("[AMOUNTCURRMARK]", "", $review_useramount);
        }
        $review_useramount = str_replace("[AMOUNT_TEXT]", $ajrv_opt_cur_text, $review_useramount);
        $review_item = str_replace("[USERAMOUNT]", $review_useramount, $review_item);
    }else{
        $review_item = str_replace("[USERAMOUNT]", "", $review_item);
    }
    $review_item = str_replace("[SUMMARY]", nl2br($row["onelinereview"]), $review_item);
    $review_item = str_replace("[OVERALL]", round($row["overall"], 1), $review_item);
    $review_item = str_replace("[OVERALL100]", $ajrv_opt_maxval, $review_item);
    
    //Pros & Cons
    if($ajrv_opt_useproscons == "1"){
        $ajrv_skin_pros_cons_data = $ajrv_skin_pros_cons;
        $arjv_pros_skin_data = "";
        $arjv_cons_skin_data = "";
        $cnt = 0;
        foreach(explode("\n", $row["pros"]) as $pros){
            if(trim($pros)){
                $arjv_pros_skin_data .= str_replace("[PROS]", $pros, $arjv_pros_skin);
                $cnt++;
            }
        }
        if($cnt > 0){
            $ajrv_skin_pros_cons_data = str_replace("[PROS]", $arjv_pros_skin_data, $ajrv_skin_pros_cons_data);
        }else{
            $ajrv_skin_pros_cons_data = str_replace("[PROS]", "", $ajrv_skin_pros_cons_data);
        }
        $cnt = 0;
        foreach(explode("\n", $row["cons"]) as $cons){
            if(trim($cons)){
                $arjv_cons_skin_data .= str_replace("[CONS]", $cons, $arjv_cons_skin);
                $cnt++;
            }
        }
        if($cnt > 0){
            $ajrv_skin_pros_cons_data = str_replace("[CONS]", $arjv_cons_skin_data, $ajrv_skin_pros_cons_data);
        }else{
            $ajrv_skin_pros_cons_data = str_replace("[CONS]", "", $ajrv_skin_pros_cons_data);
        }
        $review_item .= $ajrv_skin_pros_cons_data;
    }

    $resitem = $mysqli->query("select * from $ajrv_review_item where reviewid = ". $row['id'] . ";");
    $reviewitems = "";
    while ($ritem = mysqli_fetch_assoc($resitem)) {
        if($filter_criteria == $ritem["title"]){
            $arjv_item_skin_tmp = str_replace("[HILIGHT]", "ajrv_color_6", $arjv_item_skin);
            $arjv_item_skin_tmp = str_replace("[HILIGHT-TEXT]", "ajrv_color_6", $arjv_item_skin_tmp);
        }else{
            $arjv_item_skin_tmp = str_replace("[HILIGHT]", "ajrv_color_2", $arjv_item_skin);
            $arjv_item_skin_tmp = str_replace("[HILIGHT-TEXT]", "ajrv_color_6", $arjv_item_skin_tmp);
        }
        $arjv_item_skin_tmp = str_replace("[TITLE]", $ritem["title"], $arjv_item_skin);
        $arjv_item_skin_tmp = str_replace("[OVERALL]", $ritem["overall"], $arjv_item_skin_tmp);
        $arjv_item_skin_tmp = str_replace("[OVERALL100]", $ajrv_opt_maxval, $arjv_item_skin_tmp);
        $arjv_item_skin_tmp = str_replace("[OVAL]", (((int)$ritem["overall"] * 100) / (int)$ajrv_opt_maxval), $arjv_item_skin_tmp);
        $reviewitems .= $arjv_item_skin_tmp;
    }
    $review_item = str_replace("[ITEM_VAL]", $reviewitems, $review_item);
    return $review_item;
}
?>
