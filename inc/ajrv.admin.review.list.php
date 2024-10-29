<?php
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class AJRV_Review_Table extends WP_List_Table
{	
	public function __construct() {
        parent::__construct(
            array(
                'singular' => 'singular_form',
                'plural'   => 'plural_form',
                'ajax'     => false
            )
        );
    }
	
    public function prepare_items()
    {
		$search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';
		$current = ( !empty($_REQUEST['ajrv_group']) ? $_REQUEST['ajrv_group'] : 'all');
		
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
		
		$this->process_bulk_action();
		
        $data = $this->table_data();
		
		if( $search_key ) {
			$data = $this->filter_table_data( $data, $search_key );
		}	
	
        usort( $data, array( &$this, 'sort_data' ) );
        $perPage = 10;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }
	
	public function get_columns()
    {
        $columns = array(
			'cb'			=>	'<input type="checkbox" />',
            'title'          	=> __('리뷰 제목', 'ajreview' ),
            'grouptitle'       	=> __('그룹', 'ajreview' ),
            'categorytitle' 		=> __('카테고리', 'ajreview' ),
            'overall'		=> __('총점', 'ajreview' ),
            'userrating'		=> __('사용자 점수', 'ajreview' ),
            'useramount'	=> __('가치', 'ajreview' ),
            'post_title'	=> __('연결된 글', 'ajreview' ),
            'shortcode'	=> __('Shortcode', 'ajreview' ),
            'regdate'	=> __('등록일', 'ajreview' )
        );
        return $columns;
    }
	
	public function filter_table_data( $table_data, $search_key ) {
		$filtered_table_data = array_values( array_filter( $table_data, function( $row ) use( $search_key ) {
			foreach( $row as $row_val ) {
				if( stripos( $row_val, $search_key ) !== false ) {
					return true;
				}
			}
		} ) );
		return $filtered_table_data;
	}

	protected function get_views() { 
		global $wpdb;
		$tb_group = $wpdb->prefix . "ajrv_group";
		$sql = "SELECT * FROM ".$tb_group;
		$group_list = $wpdb->get_results($sql);
		
		$views = array();
		$current = ( !empty($_REQUEST['ajrv_group']) ? sanitize_text_field($_REQUEST['ajrv_group']) : 'all');

		//All link
		$class = ($current == 'all' ? ' class="current"' :'');
		$all_url = remove_query_arg('ajrv_group');
		$views[__('모두', 'ajreview' )] = "<a href='{$all_url}' {$class} >".__('모두', 'ajreview' )."</a>";

		foreach($group_list as $group){
			$url = add_query_arg('ajrv_group', $group->id);
			$class = ($current == $group->id ? ' class="current"' :'');
			$views[$group->title] = "<a href='{$url}' {$class} >".$group->title."(".$group->reviewcount.")</a>";
		}

		return $views;
	}

	public function get_bulk_actions() {
		 $actions = array(
			 'del' => __('삭제', 'ajreview')
		 );
		 return $actions;
	}

	public function process_bulk_action() {
		global $wpdb;
		if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {
            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['plural'];
            if ( ! wp_verify_nonce( $nonce, $action ) )
                wp_die( 'Nope! Security check failed!' );
        }
		$action = $this->current_action();
        switch($action) {
            case 'del':
				foreach($_POST["reviews"] as $rid){
					$wpdb->delete($wpdb->prefix.'ajrv_review_item', array('reviewid' => sanitize_text_field($rid)));
					$wpdb->delete($wpdb->prefix.'ajrv_review', array('id' => sanitize_text_field($rid)));
				}
                break;

            default:
                return;
                break;
        }
        return;
	}
	
	protected function column_cb( $item ) {
		return sprintf(		
			'<label class="screen-reader-text" for="group_' . $item['id'] . '">' 
			. sprintf( __( '선택 %s', 'ajreview' ), $item['id'] ) . '</label>'
			. "<input type='checkbox' name='reviews[]' id='group_{$item['id']}' value='{$item['id']}' />"
		);
	}
	
	
	protected function column_post_title( $item ) {
		$row_value = '<strong>' . $item['post_title'] . '</strong>';
		return "<div>".$item["post_type"]."</div>".$row_value;
	}
	
	protected function column_title( $item ) {
		$actions['edit'] = "<a href='/wp-admin/admin.php?page=ajrv_rlist&ajrv_rid=".$item["id"]."&ajrv_view=edit'>" . __( '수정', 'ajreview' ) . '</a>';
		$actions['view'] = "<a href='/wp-admin/admin.php?page=ajrv_rlist&ajrv_view=review_view&ajrv_rid=".$item["id"]."'>" . __( '보기', 'ajreview' ) . '</a>';
		$actions['del'] = "<a href='javascript:delreview(".$item["id"].");'>" . __( '삭제', 'ajreview' ) . '</a>';
		if($item["postid"]){
			$actions['unlink'] = "<a href='javascript:unlinkreview(".$item["id"].");'>" . __( '글 연결 해제', 'ajreview' ) . '</a>';
		}else{
			$actions['link'] = "<a href='/wp-admin/admin.php?page=ajrv_rlist&ajrv_view=link&ajrv_rid=".$item["id"]."'>" . __( '글 연결', 'ajreview' ) . '</a>';
		}
		$row_value = '<strong>' . $item['title'] . '</strong>';
		return $row_value.$this->row_actions( $actions );
	}

	public function get_hidden_columns()
    {
        return array('postid' => '', 'id' => '', 'photo' => '');
    }
	
	public function get_sortable_columns()
    {
        return array(
			'title' => array('title', false),
			'regdate' => array('regdate', true),
		);
    }
	
	private function table_data()
    {
		global $wpdb;
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $data = array();
		$ajrv_opt_cur_mark = get_option('ajrv_opt_cur_mark', "");
		$ajrv_group = ( isset($_REQUEST['ajrv_group']) ? sanitize_text_field($_REQUEST['ajrv_group']) : '');
		
		$ajrv_review_user = $wpdb->prefix . 'ajrv_review_user';
		$tb_group = $wpdb->prefix . "ajrv_group";
		$tb_review = $wpdb->prefix . "ajrv_review";
		$tb_review_category = $wpdb->prefix . "ajrv_category";
		$tb_post = $wpdb->prefix . "posts";
		
		$sql = "SELECT a.*, b.title as categorytitle, c.post_title, c.post_type, c.post_name, d.title as grouptitle ";
		$sql .= " FROM ".$tb_review." as a ";
		$sql .= " join ".$tb_review_category." as b on a.categoryid = b.id ";
		$sql .= " left join ".$tb_post." as c on a.postid = c.id ";
		if($ajrv_group){
			$sql .= " join ".$tb_group." as d on a.groupid = d.id and d.id = ".$ajrv_group;
		}else{
			$sql .= " left join ".$tb_group." as d on a.groupid = d.id ";
		}
		$sql .= " order by a.regdate desc ";

		$result = $wpdb->get_results($sql);
		foreach($result as $item){
			if($item->photo){
				$title = "<a href='/wp-admin/admin.php?page=ajrv_rlist&ajrv_view=review_view&ajrv_rid=".$item->id."'>".$item->title." <i class='far fa-image'></i></a>";
			}else{
				$title = "<a href='/wp-admin/admin.php?page=ajrv_rlist&ajrv_view=review_view&ajrv_rid=".$item->id."'>".$item->title."</a>";
			}
			$u_rating = "";
			if($item->postid){
				$user_rating_count = 0;
				$user_rating_points = 0;
				$q = "SELECT overall FROM $ajrv_review_user as a join ";
				$q .= $wpdb->prefix . "comments as b on a.commentid = b.comment_ID ";
				$q .= " and b.comment_approved = '1' and a.reviewid = ".$item->id;
				$res_com = $mysqli->query($q);
				$user_rating_count = mysqli_num_rows($res_com);
				while($row_com = mysqli_fetch_assoc($res_com)){
					$user_rating_points += $row_com["overall"];
				}
				if($user_rating_count){
					$u_rating = round($user_rating_points / $user_rating_count, 1) . "(".$user_rating_count.")";
				}
			}
			$data[] = array(
				'id'	=> $item->id,
				'grouptitle'	=>	$item->grouptitle,
				'title'	=>	$title,
				'categorytitle'	=>	$item->categorytitle,
				'overall'	=>	round($item->overall,1),
				'userrating'	=>	$u_rating,
				'useramount'	=>	number_format($item->useramount).$ajrv_opt_cur_mark,
				'post_type'	=>	$item->post_type,
				'post_title'	=>	"<a href='".$item->post_name."' target='_blank'>".$item->post_title."</a>",
				'shortcode'	=>	"[aj-review rid=".$item->id."]",
				'regdate'	=>	$item->regdate,
				'postid'	=> 	$item->postid
			);
		}
		return $data;
	}

	public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'photo':
            case 'grouptitle':
            case 'title':
            case 'categorytitle':
            case 'overall':
            case 'userrating':
            case 'useramount':
            case 'post_title':
            case 'shortcode':
            case 'regdate':
                return $item[ $column_name ];
			//case 'control' :
			//	return $this->getControl( $item );
            default:
                return print_r( $item, true ) ;
        }
    }
	
	private function sort_data( $a, $b )
    {
		if(isset($_GET['orderby']) && isset($_GET['order'])){
			if(!empty($_GET['orderby']))
			{
				$orderby = sanitize_text_field( $_GET['orderby'] );
			}
			if(!empty($_GET['order']))
			{
				$order = sanitize_text_field( $_GET['order'] );
			}
			$result = strcmp( $a[$orderby], $b[$orderby] );
			if($order === 'asc')
			{
				return $result;
			}
			return -$result;	
		}
    }
}
?>
