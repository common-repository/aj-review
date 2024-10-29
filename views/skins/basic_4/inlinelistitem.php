<?php
$arjv_skin = "
<div class='ajrv_rbox_basic_4'>
<table>
	<tbody style='width: 100%;display: inline-table;'>
	<tr>
		<td style='width:70px;background-image:url([IMG_BIG]);background-size: 100% 100%;height:45px;'></td>
		<td style='padding:0px 8px;vertical-align: top;'>
			<table>
				<tr>
					<td class='ajrv_color_8'>
						<[URLTAG] href='[URL]' class='ajrv_color_8' style='font-size:16px;font-weight:bold;'>[PRODUCT] [DOCICON]</[URLTAG]>
					</td>
				</tr>
				<tr>
					<td>
<table class='ajrv_user_r_box_4' style='width: initial;'>
	<tr>
		<td>
			<div class='ajrv-rating-ro' data-rateyo-rated-fill='#FFE343' data-rateyo-max-value=[OVERALLMAX] data-rateyo-star-width='14px' data-rateyo-rating=[OVERALL] data-rateyo-read-only='true' style='float:left;'></div>
		</td>
		<td style='padding-left:8px;'><strong>[OVERALL]</strong>[U_RATING]</td>
	</tr>
</table>
					</td>
				</tr>
			</table>
		</td>
		<td style='text-align:right;vertical-align:middle'>
			<div style='font-size:12px;'>[CATEGORY]&nbsp|&nbsp;[SINGLE]&nbsp|&nbsp;[USERAMOUNT]</div>
		</td>
	</tr>
	[ONLYONE]
	</tbody>
</table>
</div>
";
$arjv_user_rating = "<span style='margin-left:4px;padding:2px;color:#bdce9e;font-size:12px;' class='ajrv_user_rating'>
		[USER_OVERALL]&nbsp;([USER_RATING_COUNT] Reviews)
</span>";
$ajrv_onlyone = "
	<tr>
		<td colspan=3' style='padding: 0px 8px;'>
			<div style='padding:8px 0px' class='clearfix'>[ITEM_VAL]</div>
			<div style='padding:8px 0px'>[SUMMARY]</div>
			[PROSCONS]
		</td>
	</tr>";
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
