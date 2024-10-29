<?php
$arjv_skin = "<div class='ajrv_rbox_basic_1' style='padding-left:15px;padding-right:15px;font-size:initial;'>
    <div class='row ajrv_color_1'>
        <div class='col-md-6'>
            <div class='title'>[HEADER_TEXT] <span class='ajrv_color_9'>[PRODUCT]</span>
                <span class='d-inline d-md-none d-lg-none d-xl-none d-sm-inline' style='font-weight:normal'>&nbsp;|&nbsp;[CATEGORY]</span>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='category d-none d-md-block d-lg-block d-xl-block' style='padding: 12px 0px;'>
				[CATEGORY]
			</div>
        </div>
    </div>
    <div class='base_box ajrv_color_4 row'>
        <table>
            <tr>
                <td style='width:96px;'>
                    <div class='overall ajrv_color_1' style='padding-bottom: 14px;[U_RATING_STYLE]'>
                        <div class='small ajrv_color_9'>[SINGLE]</div>
                        <div style='font-size: 48px;'>[OVERALL]</div>
						[U_RATING]
                    </div>
                </td>
				
                <td style='padding-left:12px;'>
                    [USERAMOUNT]
                    <div class='summary_content ajrv_color_6'> [SUMMARY]</div>
                </td>
            </tr>
        </table>
    </div>
    <div class='ajrv_clfix row'>[ITEM_VAL]</div>";
$arjv_user_rating = "<div style='font-size: 12px;'>[USER_RATING_POINTS]([USER_RATING_COUNT] Users)</div>";
$arjv_useramouont = "<div class='useramount ajrv_color_6' style='font-size: 20px;'>[AMOUNT_TEXT] : <span class='ajrv_color_8'>[AMOUNTCURR] [AMOUNT][AMOUNTCURRMARK]</span></div>";
$ajrv_skin_pros_cons = "<div class='row ajrv_color_4'>
        <div class='col-md-6 pros' style='padding: 0px;'>
            <div class='pros_title ajrv_color_7'>[PROS_TITLE]</div>
            <ul>
            [PROS]
            </ul>
        </div>
        <div class='col-md-6 cons' style='padding: 0px;'>
            <div class='cons_title ajrv_color_5'>[CONS_TITLE]</div>
            <ul>
            [CONS]
            </ul>
        </div>
    </div>
</div>";
$arjv_item_skin = "
<div class='ajrv_val_bar ajrv_color_3'>
    <div class='ajrv_val_bar_item ajrv_color_2' style='width:[OVAL]%'>
        <span class='ajrv_color_6'>[TITLE] : <b>[OVERALL] / [OVERALL100]</b></span>
    </div>
</div>";
$arjv_pros_skin = "
<li class='ajrv_proscons_item ajrv_color_6' style='padding: 4px 0px;'>
    + [PROS]
</li>";
$arjv_cons_skin = "
<li class='ajrv_proscons_item ajrv_color_6' style='padding: 4px 0px;'>
    - [CONS]
</li>";
?>
