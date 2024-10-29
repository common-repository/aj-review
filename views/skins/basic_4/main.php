<?php
$arjv_skin = "
<div class='ajrv_rbox_basic_4'>
<table>
	<tr>
		<td style='width:127px;'><img src='[IMG_BIG]' style='height:80px;'></td>
		<td style='padding:0px 8px;vertical-align: top;'>
			<table>
				<tr>
					<td class='title'>[PRODUCT]</td>
				</tr>
				<tr>
					<td>
<table class='ajrv_user_r_box_4' style='width: initial;'>
	<tr>
		<td>
			<div class='ajrv-rating-ro' data-rateyo-rated-fill='#FFE343' data-rateyo-max-value=[OVERALLMAX] data-rateyo-star-width='20px' data-rateyo-rating=[OVERALL] data-rateyo-read-only='true' style='float:left;'></div>
		</td>
		<td class='overall' style='padding-left:8px;'>[OVERALL]</td>
		<td>[U_RATING]</td>
	</tr>
</table>
					</td>
				</tr>
				<tr>
					<td>[SINGLE]&nbsp|&nbsp;[CATEGORY]&nbsp|&nbsp;[USERAMOUNT]</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan=3' style='padding: 0px 8px;'>
			<div style='padding:8px 0px' class='clearfix'>[ITEM_VAL]</div>
			<div style='padding:8px 0px'>[SUMMARY]</div>
			[PRS]
		</td>
	</tr>
</table>
</div>
";
$arjv_user_rating = "<div style='margin-left:4px;padding:2px;background:#454B49;color:#C6D5D2' class='ajrv_user_rating'>
		[USER_RATING_POINTS]&nbsp;([USER_RATING_COUNT] Reviews)
</div>";
$arjv_useramouont = "[AMOUNT_TEXT] : <span class='ajrv_color_8'>[AMOUNTCURR] [AMOUNT][AMOUNTCURRMARK]</span>";
$ajrv_skin_pros_cons = "
	<div style='padding:8px 0px;'>
        <div class='pros' style='padding: 0px;'>
            <div style='margin-bottom:4px;font-size:initial;'><i class='fas fa-thumbs-up'></i> [PROS_TITLE]</div>
            <ul>
            [PROS]
            </ul>
        </div>
        <div class='cons' style='padding: 0px;'>
            <div style='margin-bottom:4px;font-size:initial;'><i class='fas fa-thumbs-down'></i> [CONS_TITLE]</div>
            <ul>
            [CONS]
            </ul>
        </div>
    </div>
";
$arjv_item_skin = "
<div class='float-left' style='margin-right:12px'>
	<table class='ajrv_user_r_box_4' style='width: initial;'>
		<tr>
			<td style='padding-top:4px;padding-right:4px;'>[TITLE]</td>
			<td>
				<div class='ajrv-rating-ro' data-rateyo-rated-fill='#FFE343' data-rateyo-max-value=[OVERALL100] data-rateyo-star-width='14px' data-rateyo-rating=[OVERALL] data-rateyo-read-only='true' style='float:left;'></div>
			</td>
		</tr>
	</table>
</div>
";
$arjv_pros_skin = "
<li class='ajrv_proscons_item' style='padding:4px;'>
    + [PROS]
</li>";
$arjv_cons_skin = "
<li class='ajrv_proscons_item' style='padding:4px;'>
    - [CONS]
</li>";
?>
