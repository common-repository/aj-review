<?php
$arjv_skin = "
<div class='ajrv_rbox_basic_2'>
    <div class='d-none d-md-block d-lg-block d-xl-block'>
        <div class='row'>
            <div class='col' style='max-width:180px;padding-right:0px;'>
                <div class='box_border ajrv_color_4' style='padding-bottom:6px;'>
                    <div class='category'>[CATEGORY]</div>
                    <div class='text-center'>
                        <div class='small'>[SINGLE]</div>
                        <div style='font-size:48px;font-weight:bold;margin-bottom:8px;'>[OVERALL]</div>
						[U_RATING]
                    </div>
                    [USERAMOUNT]
                </div>
            </div>
            <div class='col'>
                <div class='ajrv_color_4 box_border'>
                    <div class='ajrv_color_4' style='padding:8px 14px'>
                        <div class='' style='font-size:small'>[HEADER_TEXT]</div>
                        <div class='title'>[PRODUCT]</div>
                        <div class='summary_content ajrv_color_6'> [SUMMARY]</div>
                    </div>
                    <div style='padding:8px 2px;font-size: initial;'>[ITEM_VAL]</div>
                    <div style='padding:8px 2px;font-size: initial;'>[PRS]</div>
                </div>
            </div>
        </div>
    </div>
    <div class='d-block d-md-none d-lg-none d-xl-none'>
        <div class='box_border ajrv_color_4' style='padding-bottom:6px;'>
            <div class='category'>[CATEGORY]</div>
            <div class='text-center'>
                <div class='small'>[SINGLE]</div>
                <div style='font-size:48px;font-weight:bold;'>[OVERALL]</div>
				[U_RATING]
            </div>
            <div style='margin-bottom:12px;'>[USERAMOUNT]</div>
            <div class='ajrv_color_4' style='padding:8px 14px'>
                <div class='text-center' style='margin-bottom:-4px;'>[HEADER_TEXT]</div>
                <div class='title text-center'>[PRODUCT]</div>
                <div class='summary_content ajrv_color_6'> [SUMMARY]</div>
            </div>
            <hr style='margin:4px 12px'/>
            <div style='font-size: initial;'>[ITEM_VAL]</div>
            <hr style='margin:4px 12px'/>
            <div style='font-size: initial;'>[PRS]</div>
        </div>
    </div>
</div>";
$arjv_user_rating = "<div style='font-size: 13px;margin: -6px 0px 4px 0px;font-weight: bold;'>[USER_RATING_POINTS]([USER_RATING_COUNT] Users)</div>";
$arjv_useramouont = "<div class='ajrv_color_6 text-center' style='font-size:14px;'>[AMOUNT_TEXT] : <span class='ajrv_color_8'>[AMOUNTCURR] [AMOUNT][AMOUNTCURRMARK]</span></div>";
$ajrv_skin_pros_cons = "
<div class='ajrv_color_4'>
    <div class='pros'>
        <div class='pros_title ajrv_color_7'>[PROS_TITLE]</div>
        <ul style='padding-bottom:4px'>
        [PROS]
        </ul>
    </div>
    <div class='cons'>
        <div class='cons_title ajrv_color_5'>[CONS_TITLE]</div>
        <ul style='padding-bottom:4px'>
        [CONS]
        </ul>
    </div>
</div>";
$arjv_item_skin = "
<div class='ajrv_val_bar'>
    <span>[TITLE] : [OVERALL]</span>
    <div class='ajrv_val_bar_item ajrv_color_2' style='width:[OVAL]%'>
    </div>
</div>";
$arjv_pros_skin = "
<li class='ajrv_proscons_item ajrv_color_6' style='font-size:14px; padding: 4px 0px;'>
    + [PROS]
</li>";
$arjv_cons_skin = "
<li class='ajrv_proscons_item ajrv_color_6' style='font-size:14px; padding: 4px 0px;'>
    - [CONS]
</li>";
?>
