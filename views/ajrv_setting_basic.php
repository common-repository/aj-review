<?php
if($_POST){
    update_option( 'ajrv_opt_meta_show', sanitize_text_field($_POST['ajrv_opt_meta_show'] ));
    update_option( 'ajrv_opt_headertext', sanitize_text_field($_POST['ajrv_opt_headertext'] ));
    update_option( 'ajrv_opt_showpos', sanitize_text_field($_POST['ajrv_opt_showpos'] ));
    update_option( 'ajrv_opt_maxval', sanitize_text_field($_POST['ajrv_opt_maxval'] ));
    update_option( 'ajrv_opt_reviewskin', sanitize_text_field($_POST['ajrv_opt_reviewskin'] ));
    update_option( 'ajrv_opt_useproscons', sanitize_text_field($_POST['ajrv_opt_useproscons'] ));
    update_option( 'ajrv_opt_useamount', sanitize_text_field($_POST['ajrv_opt_useamount'] ));
    update_option( 'ajrv_opt_cur', sanitize_text_field($_POST['ajrv_opt_cur'] ));
    update_option( 'ajrv_opt_cur_mark', sanitize_text_field($_POST['ajrv_opt_cur_mark'] ));
    update_option( 'ajrv_opt_cur_text', sanitize_text_field($_POST['ajrv_opt_cur_text'] ));
    update_option( 'ajrv_opt_cur_undefined', sanitize_text_field($_POST['ajrv_opt_cur_undefined'] ));
    update_option( 'ajrv_opt_pros_title', sanitize_text_field($_POST['ajrv_opt_pros_title'] ));
    update_option( 'ajrv_opt_cons_title', sanitize_text_field($_POST['ajrv_opt_cons_title'] ));
}

$ajrv_opt_debug = get_option('ajrv_opt_debug', "N");
$ajrv_opt_meta_show = get_option('ajrv_opt_meta_show', "postpage");
$ajrv_opt_headertext = get_option('ajrv_opt_headertext', __('리뷰', 'ajreview' ));
$ajrv_opt_showpos = get_option('ajrv_opt_showpos', "1");
$ajrv_opt_maxval = get_option('ajrv_opt_maxval', "10");
$ajrv_opt_reviewskin = get_option('ajrv_opt_reviewskin', "basic_1");
$ajrv_opt_useproscons = get_option('ajrv_opt_useproscons', "1");
$ajrv_opt_useamount = get_option('ajrv_opt_useamount', "1");
$ajrv_opt_cur = get_option('ajrv_opt_cur', "KRW");
$ajrv_opt_cur_mark = get_option('ajrv_opt_cur_mark', "");
$ajrv_opt_cur_text = get_option('ajrv_opt_cur_text', __('구매 적정가', 'ajreview' ));
$ajrv_opt_cur_undefined = get_option('ajrv_opt_cur_undefined', __('미정', 'ajreview' ));
$ajrv_opt_pros_title = get_option('ajrv_opt_pros_title', __('장점', 'ajreview' ));
$ajrv_opt_cons_title = get_option('ajrv_opt_cons_title', __('단점', 'ajreview' ));
?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=ajrv_options_page_html&tab=basic" class="nav-tab nav-tab-active"><?php echo __('기본 설정', 'ajreview' )?></a>
        <a href="?page=ajrv_options_page_html&tab=userrating" class="nav-tab ajsi_tab"><?php echo __('댓글 리뷰', 'ajreview' )?></a>
    </h2>
    <div style="vertical-align:middle;">
        <?php 
		if($lic_match){?>
            <form method="post" action="" class="ajrv_setting">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php echo __('사용 범위', 'ajreview' )?></th>
                        <td>
                            <input type="radio" id="ajrv_show_1" value="postpage" name="ajrv_opt_meta_show" <?php if($ajrv_opt_meta_show == "postpage"){ echo "checked"; }?>><label for="ajrv_show_1"><?php echo __('포스트/페이지', 'ajreview' )?></label>
                            <input type="radio" id="ajrv_show_2" value="post" name="ajrv_opt_meta_show" <?php if($ajrv_opt_meta_show == "post"){ echo "checked"; }?>><label for="ajrv_show_2"><?php echo __('포스트', 'ajreview' )?></label>
                            <input type="radio" id="ajrv_show_3" value="page" name="ajrv_opt_meta_show" <?php if($ajrv_opt_meta_show == "page"){ echo "checked"; }?>><label for="ajrv_show_3"><?php echo __('페이지', 'ajreview' )?></label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('리뷰 헤더 텍스트', 'ajreview' )?></th>
                        <td><input type="text" name="ajrv_opt_headertext" value="<?php echo $ajrv_opt_headertext;?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('리뷰 위치', 'ajreview' )?></th>
                        <td>
                            <input type="radio" id="ajrv_pos_1" value="1" name="ajrv_opt_showpos" <?php if($ajrv_opt_showpos == "1"){ echo "checked"; }?>><label for="ajrv_pos_1"><?php echo __('글 하단', 'ajreview' )?></label>
                            <input type="radio" id="ajrv_pos_2" value="2" name="ajrv_opt_showpos" <?php if($ajrv_opt_showpos == "2"){ echo "checked"; }?>><label for="ajrv_pos_2"><?php echo __('글 상단', 'ajreview' )?></label>
                            <input type="radio" id="ajrv_pos_3" value="3" name="ajrv_opt_showpos" <?php if($ajrv_opt_showpos == "3"){ echo "checked"; }?>><label for="ajrv_pos_3"><?php echo __('모두', 'ajreview' )?></label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('점수 최대값', 'ajreview' )?></th>
                        <td><input type="number" name="ajrv_opt_maxval" max=100 min=5 value=<?php echo $ajrv_opt_maxval;?> style="width:80px;"></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('리뷰 스타일', 'ajreview' )?></th>
                        <td style='padding:0px;'>
							<table>
								<tr>
									<td style="vertical-align:top">
										<input type="radio" id="ajrv_ovstyle_1" value="basic_1" name="ajrv_opt_reviewskin" <?php if($ajrv_opt_reviewskin == "basic_1"){ echo "checked"; }?>>
										<label for="ajrv_ovstyle_1"><?php echo __('박스형', 'ajreview' )?></label><br/>
										<a href="<?php echo AJRV_PLUGIN_URL?>/images/aj-review-skin-box.png" target='_blank'><img src="<?php echo AJRV_PLUGIN_URL?>/images/aj-review-skin-box.png" width=250></a>
									</td>
									<td style="vertical-align:top">
										<input type="radio" id="ajrv_ovstyle_2" value="basic_2" name="ajrv_opt_reviewskin" <?php if($ajrv_opt_reviewskin == "basic_2"){ echo "checked"; }?>>
										<label for="ajrv_ovstyle_2"><?php echo __('심플형', 'ajreview' )?></label><br/>
										<a href="<?php echo AJRV_PLUGIN_URL?>/images/aj-review-skin-simple.png" target='_blank'><img src="<?php echo AJRV_PLUGIN_URL?>/images/aj-review-skin-simple.png" width=250></a>
									</td>
									<td style="vertical-align:top">
										<input type="radio" id="ajrv_ovstyle_3" value="basic_3" name="ajrv_opt_reviewskin" <?php if($ajrv_opt_reviewskin == "basic_3"){ echo "checked"; }?>>
										<label for="ajrv_ovstyle_3"><?php echo __('White', 'ajreview' )?></label><br/>
										<a href="<?php echo AJRV_PLUGIN_URL?>/images/aj-review-skin-white.png" target='_blank'><img src="<?php echo AJRV_PLUGIN_URL?>/images/aj-review-skin-white.png" width=250></a>
									</td>
									<td style="vertical-align:top">
										<input type="radio" id="ajrv_ovstyle_4" value="basic_4" name="ajrv_opt_reviewskin" <?php if($ajrv_opt_reviewskin == "basic_4"){ echo "checked"; }?>>
										<label for="ajrv_ovstyle_4"><?php echo __('Dark', 'ajreview' )?></label><br/>
										<a href="<?php echo AJRV_PLUGIN_URL?>/images/aj-review-skin-dark.png" target='_blank'><img src="<?php echo AJRV_PLUGIN_URL?>/images/aj-review-skin-dark.png" width=250></a>
									</td>
								</tr>
							</table>
                            <!--<input type="radio" id="ajrv_ovstyle_3" value="basic_3" name="ajrv_opt_reviewskin" <?php if($ajrv_opt_reviewskin == "basic_3"){ echo "checked"; }?>><label for="ajrv_ovstyle_3">Gauage</label> 
                            <input type="radio" id="ajrv_ovstyle_4" value="basic_4" name="ajrv_opt_reviewskin" <?php if($ajrv_opt_reviewskin == "basic_4"){ echo "checked"; }?>><label for="ajrv_ovstyle_4">Slider</label>-->
                            <!--<input type="radio" id="ajrv_ovstyle_5" value="basic_5" name="ajrv_opt_reviewskin" <?php if($ajrv_opt_reviewskin == "basic_5"){ echo "checked"; }?>><label for="ajrv_ovstyle_5">Point</label>-->
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('구매 적정 가격', 'ajreview' )?></th>
                        <td>
                            <input type="radio" id="ajrv_use_amount_1" value="1" name="ajrv_opt_useamount" <?php if($ajrv_opt_useamount == "1"){ echo "checked"; }?>><label for="ajrv_use_amount_1"><?php echo __('사용', 'ajreview' )?></label>
                            <input type="radio" id="ajrv_use_amount_2" value="2" name="ajrv_opt_useamount" <?php if($ajrv_opt_useamount == "2"){ echo "checked"; }?>><label for="ajrv_use_amount_2"><?php echo __('사용 안함', 'ajreview' )?></label>
                            <div id="ajrv_use_amount_opt" <?php if($ajrv_opt_useamount == "2"){ echo "style='display:none;'"; }?>>
                                <div style="margin-top:4px;">
                                    <p><strong><?php echo __('가격 단위(앞에 표시)', 'ajreview' )?></strong></p>
                                    <input type="text" name="ajrv_opt_cur" value="<?php echo $ajrv_opt_cur;?>">(Ex, USD / KRW ...)
                                </div>
                                <div>
                                    <p><strong><?php echo __('가격 단위(뒤에 표시)', 'ajreview' )?></strong></p>
                                    <input type="text" name="ajrv_opt_cur_mark" value="<?php echo $ajrv_opt_cur_mark;?>">(Ex, 원...)
                                </div>
                                <div>
                                    <p><strong><?php echo __('구매 적정가 텍스트', 'ajreview' )?></strong></p>
                                    <input type="text" name="ajrv_opt_cur_text" value="<?php echo $ajrv_opt_cur_text;?>">(Ex, 이 가격이 적당)
                                </div>
                                <div>
                                    <p><strong><?php echo __('미설정 텍스트', 'ajreview' )?></strong></p>
                                    <input type="text" name="ajrv_opt_cur_undefined" value="<?php echo $ajrv_opt_cur_undefined;?>">(Ex, 예정)
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('장점/단점 사용여부', 'ajreview' )?></th>
                        <td>
                            <input type="radio" id="ajrv_proscons_1" value="1" name="ajrv_opt_useproscons" <?php if($ajrv_opt_useproscons == "1"){ echo "checked"; }?>><label for="ajrv_proscons_1"><?php echo __('사용', 'ajreview' )?></label>
                            <input type="radio" id="ajrv_proscons_2" value="2" name="ajrv_opt_useproscons" <?php if($ajrv_opt_useproscons == "2"){ echo "checked"; }?>><label for="ajrv_proscons_2"><?php echo __('사용 안함', 'ajreview' )?></label>
                            <div id="dv_proscons" <?php if($ajrv_opt_useproscons == "2"){ echo "style='display:none;'"; }?>>
                                <div class="form-inline" style="margin-bottom:4px;">
                                    <label><strong><?php echo __('장점 타이틀', 'ajreview' )?></strong></label>
                                    <input type="text" name="ajrv_opt_pros_title" value="<?php echo $ajrv_opt_pros_title;?>"><?php echo __('(Ex, 장점, Good)', 'ajreview' )?>
                                </div>
                                <div class="form-inline">
                                    <label><strong><?php echo __('단점 타이틀', 'ajreview' )?></strong></label>
                                    <input type="text" name="ajrv_opt_cons_title" value="<?php echo $ajrv_opt_cons_title;?>"><?php echo __('(Ex, 단점, Bad)', 'ajreview' )?>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="submit" class="button button-primary" value="<?php echo __('변경 사항 적용', 'ajreview' )?>">
        </form>
        <?php }else{?>
        <div method="post" action="" class="ajrv_setting">
            <div class="alert alert-danger" style="margin-bottom:0px;">
                <p>
                    <?php echo __('라이센스가 없습니다.', 'ajreview' )?>
				</p>
				<p>
                    <a href="?page=ajrv-plugin-setting&tab=lic"><?php echo __('라이센스 정보', 'ajreview' )?></a><?php echo __(' - 라이센스를 등록하면 정상적으로 모든 기능을 이용할 수 있습니다.', 'ajreview' )?>
                </p>
            </div>
        </div>
        <?php }?>
    </div>
