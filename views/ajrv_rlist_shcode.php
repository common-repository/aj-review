<?php
function ajrv_rlist_shcode(){
?>
	<div class="wrap">
        <h2>
            <?php echo __('AJ 리뷰 Shortcodes', 'ajreview' )?> 
			<a href='/wp-admin/admin.php?page=ajrv_rlist_new' class='add-new-h2'><?php echo __('리뷰 등록', 'ajreview' )?></a>
        </h2>
		<div class="aj_bs_iso">
			<h5><?php echo __('개별 리뷰', 'ajreview' )?></h5>
			<p><?php echo __('옵션', 'ajreview' )?></p>
			<table class="table table-dark">
				<thead>
					<tr>
						<th scope="col" class="" style='width:600px'><?php echo __('옵션', 'ajreview' )?></th>
						<th scope="col"><?php echo __('설명', 'ajreview' )?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="">id</td>
						<td><?php echo __('post/page id(글의 고유 번호)', 'ajreview' )?></td>
					</tr>
					<tr>
						<td class="">rid</td>
						<td><?php echo __('review id(리뷰의 고유 번호)', 'ajreview' )?></td>
					</tr>
					<tr>
						<td class="">skin</td>
						<td><?php echo __('스킨 이름(box 또는 simple)', 'ajreview' )?> </td>
					</tr>
				</tbody>
			</table>
			<p><?php echo __('예시', 'ajreview' )?></p>
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col" style='width:600px'><?php echo __('예시', 'ajreview' )?></th>
						<th scope="col"><?php echo __('설명', 'ajreview' )?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>[aj-review <b>id</b>=358]</td>
						<td><?php echo __('post/page id가 358인 글에 연결된 리뷰', 'ajreview' )?></td>
					</tr>
					<tr>
						<td>[aj-review <b>rid</b>=3]</td>
						<td><?php echo __('review id가 3인 리뷰', 'ajreview' )?></td>
					</tr>
					<tr>
						<td>[aj-review <b>rid</b>=3 <b>skin</b>=box]</td>
						<td>
							<?php echo __('review id가 3인 리뷰를 \'box\' 스킨으로 표현', 'ajreview' )?><br/>
							<?php echo __('skin = box 또는 simple', 'ajreview' )?>
						</td>
					</tr>
				</tbody>
			</table>
			<h5><?php echo __('리뷰 목록', 'ajreview' )?></h5>
			<p><?php echo __('옵션', 'ajreview' )?></p>
			<table class="table table-dark">
				<thead>
					<tr>
						<th scope="col" class="" style='width:600px'><?php echo __('옵션', 'ajreview' )?></th>
						<th scope="col"><?php echo __('설명', 'ajreview' )?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="">rids</td>
						<td><?php echo __('표시할 리뷰의 고유 번호들(복수일 경우, 콤마로 구분)', 'ajreview' )?></td>
					</tr>
					<tr>
						<td class="">skin</td>
						<td><?php echo __('스킨 이름(box 또는 simple)', 'ajreview' )?> </td>
					</tr>
					<tr>
						<td class="">reviewcount</td>
						<td><?php echo __('목록의 개수', 'ajreview' )?></td>
					</tr>
					<tr>
						<td class="">category</td>
						<td><?php echo __('카테고리 이름(지정한 카테고리만)', 'ajreview' )?></td>
					</tr>
					<tr>
						<td class="">criteria</td>
						<td><?php echo __('리뷰 제목에 키워드(해당 단어가 포함된 리뷰만)', 'ajreview' )?></td>
					</tr>
					<tr>
						<td class="">order</td>
						<td><?php echo __('총점으로 오름차순/내림차순 정렬(desc(기본값) : 내림차순, asc : 오름차순)', 'ajreview' )?></td>
					</tr>
				</tbody>
			</table>
			<p>예시</p>
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col" style='width:600px'><?php echo __('예시', 'ajreview' )?></th>
						<th scope="col"><?php echo __('설명', 'ajreview' )?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>[aj-review-list]</td>
						<td><?php echo __('전체 리뷰 목록', 'ajreview' )?></td>
					</tr>
					<tr>
						<td>[aj-review-list <b>gid</b>=1]</td>
						<td><?php echo __('그룹 ID가 1인 리뷰 목록', 'ajreview' )?></td>
					</tr>
					<tr>
						<td>[aj-review-list <b>rids</b>=1,2,4]</td>
						<td>
							<?php echo __('review id가 1,2,4인 것만 표시', 'ajreview' )?><br/>
							<b><?php echo __('(공백 없이 콤마로 구분)', 'ajreview' )?></b>
						</td>
					</tr>
					<tr>
						<td>[aj-review-list <b>skin</b>=box]</td>
						<td>
							<?php echo __('리뷰를 \'box\' 스킨으로 표현', 'ajreview' )?><br/>
							<?php echo __('skin = box 또는 simple', 'ajreview' )?>skin = box 또는 simple
						</td>
					</tr>
					<tr>
						<td>[aj-review-list <b>displaytype</b>=list]</td>
						<td>
							<?php echo __('리뷰 항목을 표현하는 방식', 'ajreview' )?><br/>
							<?php echo __('displaytype = list 또는 inline', 'ajreview' )?>
						</td>
					</tr>
					<tr>
						<td>[aj-review-list <b>skin</b>=box <b>reviewcount</b>=10]</td>
						<td>
							<?php echo __('리뷰를 \'box\' 스킨으로 표현, 목록의 개수는 reviewcount만큼 표시', 'ajreview' )?>
						</td>
					</tr>
					<tr>
						<td>[aj-review-list <b>skin</b>=box <b>reviewcount</b>=10 <b>category</b>=전략]</td>
						<td>
							<?php echo __('카테고리가 \'전략\'인 리뷰를 \'box\' 스킨으로 표현, 목록의 개수는 reviewcount만큼 표시', 'ajreview' )?>
						</td>
					</tr>
					<tr>
						<td>[aj-review-list <b>skin</b>=box <b>reviewcount</b>=10 <b>category</b>=전략 <b>criteria</b>=최고]</td>
						<td>
							<?php echo __('제목에 \'최고\'라는 단어가 표시되면서 카테고리가 \'전략\'인 리뷰를 \'box\' 스킨으로 표현', 'ajreview' )?><br>
							<?php echo __('목록의 개수는 reviewcount만큼 표시', 'ajreview' )?>
						</td>
					</tr>
					<tr>
						<td>[aj-review-list <b>skin</b>=box <b>reviewcount</b>=10 <b>category</b>=전략 <b>criteria</b>=최고 <b>order</b>=asc]</td>
						<td>
							<?php echo __('제목에 \'최고\'라는 단어가 포함되면서 카테고리가 \'전략\'인 리뷰를 \'box\' 스킨으로 표현', 'ajreview' )?><br>
							<?php echo __('목록의 개수는 reviewcount만큼 표시 정렬은 총점이 낮은 순으로...(반대는 desc, 기본값은 \'높은 순\')', 'ajreview' )?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
<?php
}
?>