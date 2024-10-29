<?php
$arjv_skin = "<div class='ajrv_listitem_basic_2' style='margin-bottom:28px;'>
    <div style='position:relative;' class='ajrv_color_4 box_border'>
        <div class='ajrv_container d-block d-lg-none d-md-none d-xl-none' style='min-height:70px;'>
            <div>
                <img src='[IMG_BIG]' style='width:100%'>
            </div>
            <div class='ajrv_overlay [URLCSS]' value='[URL]' style='[URLCURSOR]'>
                <div class='ajrv_p8 row' style='margin-left:0px;margin-left:0px'>
                    <div class='ajrv_color_5' style='width:68px;'>
                        <div class='li_overall' style='line-height: initial;text-align:center;'>[OVERALL]</div>
                    </div>
                    <div style='margin-left:8px;'>
                        <div class='ajrv_color_9' style='font-size:12px;'>[SINGLE] / [CATEGORY] / [USERAMOUNT]</div>
                        <[URLTAG] href='[URL]' class='ajrv_product_title' style=''>[PRODUCT] [DOCICON]</[URLTAG]>
                    </div>
                </div>
            </div>
        </div>
        <div class='ajrv_container d-none d-lg-block d-md-block d-xl-block' style='min-height:130px;'>
            <div>
                <img src='[IMG_BIG]' style='width:100%'>
            </div>
            <div class='ajrv_overlay [URLCSS]' value='[URL]' style='[URLCURSOR]'>
                <div class='ajrv_p18'>
                    <div class='ajrv_color_5'>
                        <div class='li_overall' style='margin-top: -12px;line-height: initial;'>[OVERALL]</div>
                    </div>
                    <div>
                        <div class='ajrv_small ajrv_color_9' style='font-size: 12px;'>[SINGLE] / [CATEGORY] / [USERAMOUNT]</div>
						<[URLTAG] href='[URL]' class='ajrv_color_9' style='font-size:28px;font-weight:bold;line-height: initial;'>[PRODUCT] [DOCICON]</[URLTAG]>
                    </div>
                </div>
            </div>
        </div>
        <div class='d-block d-lg-none d-md-none d-xl-none' style='padding:12px'>
            <div class='ajrv_mt4 ajrv_color_6' style='padding-right:8px;line-height: normal;font-size: 14px;'>[SUMMARY]</div>
            <div class='ajrv_basic_item_cri' style=''>
                [ITEM_VAL]
            </div>
            [PROSCONS]
        </div>
        <div class='d-none d-lg-block d-md-block d-xl-block' style='padding:8px 12px'>
            <div class='row'>
                <div class='col-md-8'>
                    <div class='ajrv_mt4 ajrv_color_6' style='padding-right:8px;line-height: normal;font-size: 14px;'>[SUMMARY]</div>
                    [PROSCONS]
                </div>
                <div class='col-md-4'>
                    <div class='ajrv_basic_item_cri' style='font-size: 14px;'>
                        [ITEM_VAL]
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>";
$arjv_useramouont = "[AMOUNT_TEXT] : <span style='font-weight:bold'>[AMOUNTCURR] [AMOUNT][AMOUNTCURRMARK]</span>";
$arjv_useramouont_bk = " / [AMOUNT][AMOUNTCURRMARK]";
$ajrv_skin_pros_cons = "
    <div class='ajrv_mt8'>
        <div class='' style='margin-top:12px'>
            <div style='font-weight:bold'>[PROS_TITLE]</div>
            <div class='ajrv_pr4'>[PROS]</div>
        </div>
        <div class='' style='margin-top:18px'>
            <div style='font-weight:bold'>[CONS_TITLE]</div>
            <div class='ajrv_pr4'>[CONS]</div>
        </div>
    </div>
";
$arjv_item_skin = "
<div class='ajrv_val_bar ajrv_mb12 ajrv_color_6' style='padding-top:12px;'>
    <div class='[HILIGHT-TEXT]' style='font-size: 14px;'>[TITLE] : [OVERALL] / [OVERALL100]</div>
    <div class='ajrv_val_bar_item [HILIGHT]' style='width:[OVAL]%;height:4px;'></div>
</div>";
$arjv_pros_skin = "
<div class='ajrv_proscons_item ajrv_small ajrv_lhnormal ajrv_mb8 ajrv_color_6' style='font-size: 14px;margin-top:4px;'>
    + [PROS]
</div>";
$arjv_cons_skin = "
<div class='ajrv_proscons_item ajrv_small ajrv_lhnormal ajrv_mb8 ajrv_color_6' style='font-size: 14px;margin-top:4px;'>
    - [CONS]
</div>";
?>
