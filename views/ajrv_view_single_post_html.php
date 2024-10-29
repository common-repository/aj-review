<?php
function getCur($val){
    if ($val == (int)$val)
        return number_format($val, 0);
    else
        return number_format($val, 2);
}
function ajrv_shcode_review_single($atts){
    global $post;
    $skin = isset($atts["skin"]) ? trim($atts["skin"]) : "";
    $ajrv_opt_reviewskin = $skin ? $skin : get_option('ajrv_opt_reviewskin', "basic_2");
    wp_enqueue_style('ajrvcss_'.ajrv_getskinbyname($ajrv_opt_reviewskin), plugins_url("skins/".ajrv_getskinbyname($ajrv_opt_reviewskin)."/style.css", __FILE__));
    if($atts){
        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        if(isset($atts["id"])){
            return ajrv_review_single($atts["id"], "", ajrv_getskinbyname($ajrv_opt_reviewskin));
        }else if(isset($atts["rid"])){
            return ajrv_review_single("", $atts["rid"], ajrv_getskinbyname($ajrv_opt_reviewskin));
        }
    }else if (is_single()){
        return ajrv_review_single($post->ID, "", ajrv_getskinbyname($ajrv_opt_reviewskin));
    }
}
function ajrv_review_snipper($row, $rcount, $bestrating){
	$pre = "<script type='application/ld+json'>";
	$next = "</script>";
	$snippet = array(
			"review" => array(
				"reviewBody" => "",
				"@type" => "Review",
				"author" => array(
					"@type" => "Person",
					"name" => "아재방"
					),
				"reviewRating" => array(
					"@type" => "Rating",
					"worstRating" => 0,
					"bestRating" => $bestrating,
					"ratingValue" => round($row["overall"]),
				),
			),
			"publisher" => array(
				"@type" => "Organization",
				"name" => $row["publisher"]
			),
			"description" => nl2br($row["onelinereview"]),
			"name" => $row["title"],
			"aggregateRating" => array(
				"@type" => "AggregateRating",
				"worstRating" => 0,
				"bestRating" => $bestrating,
				"ratingValue" => round($row["overall"]),
				"reviewCount" => $rcount,
			),
			"image" => get_the_post_thumbnail_url($row['postid']),
			"@type" => "Videogame",
			"applicationCategory" => "Game",
			"genre" => $row["categoryname"],
			"operatingSystem" => $row["categoryname"],
			"@context" => "https://schema.org",
			"operatingSystem" => $row["platform"],
			"gamePlatform" => $row["platform"],

	);
	return $pre.json_encode($snippet).$next;
}
function ajrv_review_single($postid, $reviewid, $skinname) {
    global $table_prefix;

    $ajrv_category = $table_prefix . 'ajrv_category';
    $ajrv_review = $table_prefix . 'ajrv_review';
    $ajrv_review_item = $table_prefix . 'ajrv_review_item';
	$ajrv_review_user = $table_prefix . 'ajrv_review_user';
    $ajrv_opt_headertext = get_option('ajrv_opt_headertext', __('리뷰', 'ajreview' ));
    $ajrv_opt_maxval = get_option('ajrv_opt_maxval', "10");
    $ajrv_opt_useproscons = get_option('ajrv_opt_useproscons', "1");
    $ajrv_opt_useamount = get_option('ajrv_opt_useamount', "1");
    $ajrv_opt_cur = get_option('ajrv_opt_cur', "KRW");
    $ajrv_opt_cur_mark = get_option('ajrv_opt_cur_mark', "");
    $ajrv_opt_cur_text = get_option('ajrv_opt_cur_text', __('구매 적정가', 'ajreview' ));
    $ajrv_opt_cur_undefined = get_option('ajrv_opt_cur_undefined', __('미정', 'ajreview' ));
    $ajrv_opt_reviewskin = get_option('ajrv_opt_reviewskin', "basic_1");
    $ajrv_opt_pros_title = get_option('ajrv_opt_pros_title', __('장점', 'ajreview' ));
    $ajrv_opt_cons_title = get_option('ajrv_opt_cons_title', __('단점', 'ajreview' ));

	$ajrv_opt_userrating = get_option('ajrv_opt_userrating', "");
	$ajrv_opt_userrating = 1;

    include(plugin_dir_path(__FILE__)."skins/".$skinname."/main.php");
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$user_rating_count = 0;
	$user_rating_points = 0;
	
    if($postid){
        $q = "select a.*, b.title as categoryname from $ajrv_review as a join $ajrv_category as b on a.categoryid = b.id where postid = $postid;";
    }else if($reviewid){
        $q = "select a.*, b.title as categoryname from $ajrv_review as a join $ajrv_category as b on a.categoryid = b.id where a.id = $reviewid;";
    }
    $res = $mysqli->query($q);
    $ritemdata = array();
    if(mysqli_num_rows($res)){
        $row = mysqli_fetch_assoc($res);
        $arjv_skin = str_replace("[HEADER_TEXT]", $ajrv_opt_headertext, $arjv_skin);
        $arjv_skin = str_replace("[TITLE]", "", $arjv_skin);
        $arjv_skin = str_replace("[OVERALLMAX]", $ajrv_opt_maxval, $arjv_skin);
        $arjv_skin = str_replace("[CATEGORY]", $row["categoryname"], $arjv_skin);
        $arjv_skin = str_replace("[SINGLE]", $row["singleword"] ? $row["singleword"] : "&nbsp;", $arjv_skin);
        $arjv_skin = str_replace("[PRODUCT]", $row["title"] ?  $row["title"] : "", $arjv_skin);
        if($ajrv_opt_useamount == "1"){
            if($row["useramount"]){
                if(getCur($row["useramount"])){
                    $arjv_useramouont = str_replace("[AMOUNT]", number_format($row["useramount"], 0), $arjv_useramouont);
                }else{
                    $arjv_useramouont = str_replace("[AMOUNT]", number_format($row["useramount"], 2), $arjv_useramouont);
                }
                $arjv_useramouont = str_replace("[AMOUNTCURR]", $ajrv_opt_cur, $arjv_useramouont);
                $arjv_useramouont = str_replace("[AMOUNTCURRMARK]", $ajrv_opt_cur_mark, $arjv_useramouont);
            }else{
                $arjv_useramouont = str_replace("[AMOUNT]", $ajrv_opt_cur_undefined, $arjv_useramouont);
                $arjv_useramouont = str_replace("[AMOUNTCURR]", "", $arjv_useramouont);
                $arjv_useramouont = str_replace("[AMOUNTCURRMARK]", "", $arjv_useramouont);
            }
            $arjv_useramouont = str_replace("[AMOUNT_TEXT]", $ajrv_opt_cur_text, $arjv_useramouont);
            $arjv_skin = str_replace("[USERAMOUNT]", $arjv_useramouont, $arjv_skin);
        }else{
            $arjv_skin = str_replace("[USERAMOUNT]", "", $arjv_skin);
        }
        $arjv_skin = str_replace("[SUMMARY]", nl2br($row["onelinereview"]), $arjv_skin);
        $arjv_skin = str_replace("[OVERALL]", round($row["overall"], 1), $arjv_skin);
        $arjv_skin = str_replace("[OVERALL100]", $ajrv_opt_maxval, $arjv_skin);
        $arjv_skin = str_replace("[DEGREE]", round($row["overall"], 1) * 180 / $ajrv_opt_maxval, $arjv_skin);
        if($ajrv_opt_userrating && $row['postid']){
			$q = "SELECT overall FROM $ajrv_review_user as a join ";
			$q .= $table_prefix."comments as b on a.commentid = b.comment_ID ";
			$q .= " and b.comment_approved = '1' and a.reviewid = ".$row["id"];
			$res_com = $mysqli->query($q);
			if($res_com){
				$user_rating_count = mysqli_num_rows($res_com);
				while($row_com = mysqli_fetch_assoc($res_com)){
					$user_rating_points += $row_com["overall"];
				}
			}
			if($user_rating_count){
				$arjv_user_rating = str_replace("[USER_RATING_POINTS]", round($user_rating_points / $user_rating_count, 1), $arjv_user_rating);
				$arjv_user_rating = str_replace("[USER_RATING_COUNT]", $user_rating_count, $arjv_user_rating);
				$arjv_skin = str_replace("[U_RATING]", $arjv_user_rating, $arjv_skin);
				$arjv_skin = str_replace("[U_RATING_STYLE]", "width:104px;", $arjv_skin);
			}else{
				$arjv_skin = str_replace("[U_RATING]", "", $arjv_skin);
				$arjv_skin = str_replace("[U_RATING_STYLE]", "", $arjv_skin);
			}
		}else{
			$arjv_skin = str_replace("[U_RATING]", "", $arjv_skin);
			$arjv_skin = str_replace("[U_RATING_STYLE]", "", $arjv_skin);
		}
		$ajrv_post_photo = "";
        if($row['postid']){
			$ajrv_post_photo = get_the_post_thumbnail_url($row['postid']);
			if($ajrv_post_photo){
				$arjv_skin = str_replace("[IMG_BIG]", $ajrv_post_photo, $arjv_skin);
			}
		}
        if(!$ajrv_post_photo && $row['photo']){
			$attr = wp_get_attachment_image_src($row['photo'], array(107, 60));
            $arjv_skin = str_replace("[IMG_BIG]", $attr[0], $arjv_skin);
        }else{
            $arjv_skin = str_replace("[IMG_BIG]", "", $arjv_skin);
        }
        
        //Pros & Cons
        if($ajrv_opt_useproscons == "1"){
            $arjv_pros_skin_data = "";
            $arjv_cons_skin_data = "";
            foreach(explode("\n", $row["pros"]) as $pros){
                $arjv_pros_skin_data .= str_replace("[PROS]", $pros, $arjv_pros_skin);
            }
            $ajrv_skin_pros_cons = str_replace("[PROS]", $arjv_pros_skin_data, $ajrv_skin_pros_cons);

            foreach(explode("\n", $row["cons"]) as $cons){
                $arjv_cons_skin_data .= str_replace("[CONS]", $cons, $arjv_cons_skin);
            }
            $ajrv_skin_pros_cons = str_replace("[CONS]", $arjv_cons_skin_data, $ajrv_skin_pros_cons);
            $ajrv_skin_pros_cons = str_replace("[PROS_TITLE]", $ajrv_opt_pros_title, $ajrv_skin_pros_cons);
            $ajrv_skin_pros_cons = str_replace("[CONS_TITLE]", $ajrv_opt_cons_title, $ajrv_skin_pros_cons);
            if(strstr($arjv_skin, "[PRS]")){
                $arjv_skin = str_replace("[PRS]", $ajrv_skin_pros_cons, $arjv_skin);
            }else{
                $arjv_skin .= "<div>".$ajrv_skin_pros_cons."</div>";
            }
        }

        $resitem = $mysqli->query("select * from $ajrv_review_item where reviewid = ". $row['id'] . ";");
        $reviewitems = "";
        while ($ritem = mysqli_fetch_assoc($resitem)) {
            $arjv_item_skin_tmp = str_replace("[TITLE]", $ritem["title"], $arjv_item_skin);
            $arjv_item_skin_tmp = str_replace("[OVERALL]", $ritem["overall"], $arjv_item_skin_tmp);
            $arjv_item_skin_tmp = str_replace("[OVERALL100]", $ajrv_opt_maxval, $arjv_item_skin_tmp);
            $arjv_item_skin_tmp = str_replace("[OVAL]", (((int)$ritem["overall"] * 100) / (int)$ajrv_opt_maxval), $arjv_item_skin_tmp);
            $val = (((int)$ritem["overall"] * 100) / (int)$ajrv_opt_maxval);
            $arjv_item_skin_tmp = str_replace("[DEOVALGREE]", 
                round($ritem["overall"], 1) * 180 / $ajrv_opt_maxval,
                $arjv_item_skin_tmp);
            $reviewitems .= $arjv_item_skin_tmp;
        }
        $arjv_skin = str_replace("[ITEM_VAL]", $reviewitems, $arjv_skin);

		$snippet = "";
		if($postid){
			$snippet = ajrv_review_snipper($row, $user_rating_count + 1, $ajrv_opt_maxval);
		}
        return "<div class='aj_bs_iso'>".$arjv_skin."</div>".$snippet;
    }
    return "";
}
function ajrv_content_filter($content) {
    global $post;
    wp_register_script('ajrvjs', AJRV_PLUGIN_JS, array('jquery'));
    wp_enqueue_script('ajrvjs');

    $ajrv_opt_meta_show = get_option('ajrv_opt_meta_show', "postpage");
    if(is_single()){
        if(!strstr($ajrv_opt_meta_show, "post"))
            return "";
    }
    if(is_page()){
        if(!strstr($ajrv_opt_meta_show, "page"))
            return "";
    }

    $ajrv_opt_reviewskin = get_option('ajrv_opt_reviewskin', "basic_2");
    wp_enqueue_style('ajrvcss_'.ajrv_getskinbyname($ajrv_opt_reviewskin), plugins_url("skins/".ajrv_getskinbyname($ajrv_opt_reviewskin)."/style.css", __FILE__));
    $ajrv_opt_showpos = get_option('ajrv_opt_showpos', "1");
    $arjv_skin = ajrv_review_single($post->ID, "", ajrv_getskinbyname($ajrv_opt_reviewskin));

    if($ajrv_opt_showpos == "1"){
        $content .= $arjv_skin;
    }else if($ajrv_opt_showpos == "2"){
        $content = $arjv_skin . $content;
    }else{
        $content = $arjv_skin . $content . $arjv_skin;
    }
    return $content;
}
?>
