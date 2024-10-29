<?php
global $table_prefix, $wpdb;
$ajrv_opt_debug = get_option('ajrv_opt_debug', "N");
//$lic_match = false;
?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=ajrv_options_page_html&tab=basic" class="nav-tab ajsi_tab"><?php echo __('기본 설정', 'ajreview' )?></a>
        <a href="?page=ajrv_options_page_html&tab=lic" class="nav-tab nav-tab-active"><?php echo __('라이센스 정보', 'ajreview' )?></a>
    </h2>
    <div style="vertical-align:middle;">
        <?php if($lic_match){?>
        <div class="ajrv_setting" style="padding-left:10px;margin-bottom:10px;">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php echo __('라이센스 키', 'ajreview' )?></th>
                        <td>
                            <i><?php echo $pinfo["licensekey"]?></i>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('도메인', 'ajreview' )?></th>
                        <td>
                            <?php echo $pinfo["domain"]?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('라이센스 발급일시', 'ajreview' )?></th>
                        <td>
                            <?php echo $pinfo["created"]?>
                        </td>
                    </tr>
                    <?php if($pinfo["expire"]){?>
                    <tr>
                        <th scope="row"><?php echo __('라이센스 만료일시', 'ajreview' )?></th>
                        <td>
                            <?php echo $pinfo["expire"] ? $pinfo["expire"] : "무제한"?>
                        </td>
                    </tr>
                    <?php }?>
                    <tr>
                        <th scope="row"><?php echo __('Plugin Version', 'ajreview' )?></th>
                        <td>
                            <?php echo $pinfo["version"]?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php }else{?>
        <div class="ajrv_setting" style="padding-left:10px;margin-bottom:10px;">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php echo __('도메인', 'ajreview' )?></th>
                        <td>
                            <input type="text" name="domain" id="domain" value="<?php echo $_SERVER["HTTP_HOST"];?>">
                            <div><span><?php echo __('지정한 도메인으로 접속된 사이트에서만 사용이 가능합니다.', 'ajreview' )?></span></div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo __('인증키', 'ajreview' )?></th>
                        <td>
                            <input type="text" name="authkey" id="authkey" value="" style="width:600px">
                            <div><span><a href="https://www.2p1d.com" target="_blank">2P1D</a> - <?php echo __('홈페이지에서 구입한 인증키를 입력해주세요.', 'ajreview' )?></span></div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-primary" id="btnRequestKey">발급 요청하기</button>
        </div>
        <?php }?>
    </div>