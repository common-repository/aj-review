<?php
function ajrv_options_page_html(){
    if( isset( $_GET["tab"] ) ) {
        $active_tab = sanitize_text_field( $_GET["tab"] );
    }else{
        $active_tab = "basic";
    }
    $pinfo = ajrv_getLicense();
    $lic_match = false;
    if($pinfo){
        $lic_match = true;
    }
    $latestver = ajrv_getLatestVer();
?>
<div class="wrap">
    <h2>
        <?php echo __( 'AJ 리뷰 플러그인 설정', 'ajreview' )?> - v0.9.2 <a href="mailto:2p1d@2p1d.com" class='add-new-h2'>Contact US</a>
    </h2>
<?php
    if($active_tab == "basic"){
        require_once(AJRV_PLUGIN_PATH . "views/ajrv_setting_basic.php");
    }else if($active_tab == "userrating"){
        require_once(AJRV_PLUGIN_PATH . "views/ajrv_setting_userrating.php");
    }else if($active_tab == "debug"){
        require_once(AJRV_PLUGIN_PATH . "views/ajrv_setting_basic.php");
    }else if($active_tab == "lic"){
        require_once(AJRV_PLUGIN_PATH . "views/ajrv_setting_lic.php");
    }
?>
</div>
<?php
}
?>
