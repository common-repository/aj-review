<?php
$fbox = "
<div class='col-md-3 ajrv_listitem_basic_1'>
    <div class='ajrv_color_1'>
        <div>
            <div class='ajrv_color_9' style='font-size:14px;padding:8px;'>게임 검색(리뷰 제목)</div>
			<div style='background: #fff;padding: 8px;' class='form-group'>
				<input type='text' class='form-control' id='ajrv_fbox_title' value='".($filter_title ? $filter_title : "")."' style='font-size:14px;'>
			</div>
        </div>
    </div>
    <div class='ajrv_color_1'>
        <div>
            <div class='ajrv_color_9' style='font-size:14px;padding:8px;'>장르</div>
			<div style='background: #fff;padding: 8px;' class='form-group'>
            <select class='form-control' id='ajrv_fbox_category' style='font-size:14px;'>";
$fbox .= "<option value='' ".($filter_category == "" ? "selected" : "").">모두</option>";
foreach($list_category as $item){
	$fbox .= "<option value='".$item->title."' ".($filter_category == $item->title ? "selected" : "").">".$item->title."</option>";
}
$fbox .= "      </select>
			</div>
        </div>
    </div>
    <div class='ajrv_color_1'>
        <div class=''>
            <div class='ajrv_color_9' style='font-size:14px;padding:8px;'>정렬 옵션</div>
			<div style='background: #fff;padding: 8px;' class='form-group'>
				<select class='form-control' id='ajrv_fbox_criteria' style='font-size:14px;'>";
$fbox .= "<option value='' ".($filter_criteria == "" ? "selected" : "").">총점</option>";
foreach($list_criteria as $item){
	$fbox .= "<option value='".$item->title."' ".($filter_criteria == $item->title ? "selected" : "").">".$item->title."</option>";
}
$fbox .= "      </select>
			</div>
        </div>
    </div>
    <div class='ajrv_color_1'>
        <div class=''>
            <div class='ajrv_color_9' style='font-size:14px;padding:8px;'>정렬 방식</div>
			<div style='background: #fff;padding: 8px;' class='form-group'>
				<select class='form-control' id='ajrv_fbox_order' style='font-size:14px;'>
					<option value='desc' ".($ordering == "desc" ? "selected" : "").">높은 점수순</option>
					<option value='asc' ".($ordering == "asc" ? "selected" : "").">낮은 점수순</option>
				</select>
			</div>
        </div>
    </div>
    <div class='ajrv_color_1'>
        <div class=''>
            <div class='ajrv_color_9' style='font-size:14px;padding:8px;'>표시 개수</div>
			<div style='background: #fff;padding: 8px;' class='form-group'>
				<select class='form-control' id='ajrv_fbox_itemcount' style='font-size:14px;'>
					<option value='10' ".($reviewcount == "10" ? "selected" : "").">10개</option>
					<option value='50' ".($reviewcount == "50" ? "selected" : "").">50개</option>
					<option value='100' ".($reviewcount == "100" ? "selected" : "").">100개</option>
					<option value='200' ".($reviewcount == "200" ? "selected" : "").">200개</option>
				</select>
			</div>
        </div>
    </div>
    <div class='ajrv_color_1'>
        <div class=''>
            <div class='ajrv_color_9' style='font-size:14px;padding:8px;'>상세 리뷰 보기</div>
			<div style='background: #fff;padding: 8px;' class='form-group'>
				<select class='form-control' id='ajrv_fbox_detailshow' style='font-size:14px;'>
					<option value='0' ".($detailshow == "0" ? "selected" : "").">모두 가리기</option>
					<option value='1' ".($detailshow == "1" ? "selected" : "").">TOP 1개만</option>
					<option value='3' ".($detailshow == "3" ? "selected" : "").">TOP 3개만</option>
					<option value='5' ".($detailshow == "5" ? "selected" : "").">TOP 5개만</option>
					<option value='10' ".($detailshow == "10" ? "selected" : "").">TOP 10개만</option>
				</select>
			</div>
        </div>
    </div>
</div>";
