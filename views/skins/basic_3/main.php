<?php
$arjv_skin = "
<div class='ajrv_rbox_basic_3' style='margin:0px;padding:8px 12px;background:#fff;'>
        <div style='border-bottom: 1px solid #D7DADB;width:100%;'>
                <div class='overall ajrv_color_1' style='float:left;padding: 0px 4px;'>
                        <div style='font-size: 48px;'>[OVERALL]</div>
                </div>
                <div style='padding:8px;float:left'>
                        <div class='' style='font-weight:normal;font-size:12px;'>[SINGLE]&nbsp|&nbsp;[CATEGORY]&nbsp|&nbsp;[USERAMOUNT]</div>
                        <div class='title'><span class='ajrv_color_9'>[PRODUCT]</span></div>
                </div>
				[U_RATING]
				<div class='clearfix'></div>
        </div>
	<div class='ajrv_color_1' style='font-size: initial;'>
		<div style='padding:8px 0px'>[ITEM_VAL]</div>
		<div style='padding-bottom:8px' class='summary_content'> [SUMMARY]</div>
	</div>
";
$arjv_user_rating = "<div style='padding:8px;float:right;background:#ff6e6e;color:#ffffff' class='ajrv_user_rating'>
		<div class='' style='font-weight:normal;font-size:12px;text-align:center'>[USER_RATING_COUNT] Reviews</div>
		<div class='title' style='text-align: center;'><span class=''>[USER_RATING_POINTS]</span></div>
</div>";
$arjv_useramouont = "[AMOUNT_TEXT] : <span class='ajrv_color_8'>[AMOUNTCURR] [AMOUNT][AMOUNTCURRMARK]</span>";
$ajrv_skin_pros_cons = "<div style='padding:0px;'>
        <div class='pros' style='padding: 0px;'>
            <div class='ajrv_color_9' style='margin-bottom:4px;font-size:initial;'><b>[PROS_TITLE]</b></div>
            <ul>
            [PROS]
            </ul>
        </div>
        <div class='cons' style='padding: 0px;'>
            <div class='ajrv_color_9' style='margin-bottom:4px;font-size:initial;'><b>[CONS_TITLE]</b></div>
            <ul>
            [CONS]
            </ul>
        </div>
    </div>
</div>";
$arjv_item_skin = "<span style='color:#2C3E50'>[TITLE] : </span><span style='color:#FC4349'><b>[OVERALL]</span><span style='color:#2C3E50'> / [OVERALL100]</b></span>&nbsp;&nbsp;";
$arjv_pros_skin = "
<li class='ajrv_proscons_item' style='padding:0px;'>
    + [PROS]
</li>";
$arjv_cons_skin = "
<li class='ajrv_proscons_item' style='padding:0px;'>
    - [CONS]
</li>";
?>
