<?php
if($_POST){
    update_option( 'ajrv_opt_userrating', sanitize_text_field($_POST['ajrv_opt_userrating'] ));
    update_option( 'ajrv_opt_userrating_onlyloggeduser', sanitize_text_field($_POST['ajrv_opt_userrating_onlyloggeduser'] ));
    update_option( 'ajrv_opt_userrating_show', sanitize_text_field($_POST['ajrv_opt_userrating_show'] ));
}
$ajrv_opt_userrating = get_option('ajrv_opt_userrating', "");
$ajrv_opt_userrating_onlyloggeduser = get_option('ajrv_opt_userrating_onlyloggeduser', "N");
$ajrv_opt_userrating_show = get_option('ajrv_opt_userrating_show', "Y");
?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=ajrv_options_page_html&tab=basic" class="nav-tab ajsi_tab"><?php echo __('기본 설정', 'ajreview' )?></a>
        <a href="?page=ajrv_options_page_html&tab=userrating" class="nav-tab  nav-tab-active ajsi_tab"><?php echo __('댓글 리뷰', 'ajreview' )?></a>
    </h2>
    <div style="vertical-align:middle;">
		<div style="border: 1px solid #8e8e8e; background: #ffff; padding: 4px 16px;">
			<ul>
				<li><?php echo __('승인된 댓글의 사용자 점수들만 반영됩니다.', 'ajreview')?></li>
				<li><?php echo __('댓글 리뷰의 사용자 키는 사용자의 Email입니다.', 'ajreview')?></li>
			</ul>
		</div>
        <?php 
		if($lic_match){?>
            <form method="post" action="" class="ajrv_setting">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php echo __('댓글 리뷰 허용', 'ajreview' )?></th>
                        <td>
                            <input type="radio" id="ajrv_opt_userrating_1" value="Y" name="ajrv_opt_userrating" <?php if($ajrv_opt_userrating == "Y"){ echo "checked"; }?>><label for="ajrv_opt_userrating_1"><?php echo __('허용', 'ajreview' )?></label>
                            <input type="radio" id="ajrv_opt_userrating_2" value="" name="ajrv_opt_userrating" <?php if($ajrv_opt_userrating == ""){ echo "checked"; }?>><label for="ajrv_opt_userrating_2"><?php echo __('허용 안함', 'ajreview' )?></label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('로그인 사용자만 댓글 리뷰', 'ajreview' )?></th>
                        <td>
                            <input type="radio" id="ajrv_opt_userrating_onlyloggeduser_1" value="N" name="ajrv_opt_userrating_onlyloggeduser" <?php if($ajrv_opt_userrating_onlyloggeduser == "N"){ echo "checked"; }?>><label for="ajrv_opt_userrating_onlyloggeduser_1"><?php echo __('로그인 안한 사용자도 허용', 'ajreview' )?></label>
                            <input type="radio" id="ajrv_opt_userrating_onlyloggeduser_2" value="Y" name="ajrv_opt_userrating_onlyloggeduser" <?php if($ajrv_opt_userrating_onlyloggeduser == "Y"){ echo "checked"; }?>><label for="ajrv_opt_userrating_onlyloggeduser_2"><?php echo __('로그인 한 사용자만 허용', 'ajreview' )?></label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('사용자 점수 보이기', 'ajreview' )?></th>
                        <td>
                            <input type="radio" id="ajrv_opt_userrating_show_1" value="Y" name="ajrv_opt_userrating_show" <?php if($ajrv_opt_userrating_show == "Y"){ echo "checked"; }?>><label for="ajrv_opt_userrating_show_1"><?php echo __('보이기', 'ajreview' )?></label>
                            <input type="radio" id="ajrv_opt_userrating_show_2" value="N" name="ajrv_opt_userrating_show" <?php if($ajrv_opt_userrating_show == "N"){ echo "checked"; }?>><label for="ajrv_opt_userrating_show_2"><?php echo __('가리기', 'ajreview' )?></label>
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
