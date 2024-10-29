<?php
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class AJRV_Group_Table extends WP_List_Table
{	
    public function prepare_items()
    {
		$search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';
		
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
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
			//'cb'			=>	'<input type="checkbox" />',
            'title'       	=> __('그룹 이름', 'ajreview' ),
            'id'          	=> __('그룹 번호', 'ajreview' ),
            'comment' 		=> __('설명', 'ajreview' ),
            'shortcode'		=> __('Shortcode', 'ajreview' ),
            'reviewcount'	=> __('리뷰 개수', 'ajreview' )
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

	/*
	public function get_bulk_actions() {
		 $actions = array(
			 'bulk-del' => __('삭제', 'ajreview')
		 );
		 return $actions;
	}

	public function handle_table_actions() {
		if(( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'bulk-del' )){
			$nonce = wp_unslash( $_REQUEST['_wpnonce'] );
			if (! wp_verify_nonce( $nonce, 'bulk-users' )){
				$this->invalid_nonce_redirect();
			} else {
				if('delete' === $this->current_action()) {
					$groups = $_REQUEST['groups'];
					foreach ( $groups as $id ) {
						$id = absint( $id );
						$wpdb->query( "delete from ".$tb_ajrv_group." where id = ". $id );
					}
				}
				$this->graceful_exit();
			}
		}
	}
	
	protected function column_cb( $item ) {
		return sprintf(		
			'<label class="screen-reader-text" for="group_' . $item['id'] . '">' 
			. sprintf( __( '선택 %s', 'ajreview' ), $item['id'] ) . '</label>'
			. "<input type='checkbox' name='groups[]' id='group_{$item['id']}' value='{$item['id']}' />"
		);
	}
	*/
	protected function column_title( $item ) {
		$actions['edit'] = "<a href='/wp-admin/admin.php?page=ajrv_rlist_group&ajrv_mode=new&ajrv_gid=".$item["id"]."'>" . __( '수정', 'ajreview' ) . '</a>';
		if(!($item["reviewcount"] > 0))
			$actions['del'] = "<a href='javascript:delgroup(".$item["id"].");'>" . __( '삭제', 'ajreview' ) . '</a>';
		$row_value = '<strong>' . $item['title'] . '</strong>';
		return $row_value . $this->row_actions( $actions );
	}

	public function get_hidden_columns()
    {
        return array();
    }
	
	public function get_sortable_columns()
    {
        return array('title' => array('title', false));
    }
	
	private function table_data()
    {
		global $wpdb;
		$tb_group = $wpdb->prefix . "ajrv_group";
        $data = array();
		$result = $wpdb->get_results("SELECT * FROM ".$tb_group);
		foreach($result as $item){
			$data[] = array(
				'title'	=>	$item->title,
				'id'	=>	$item->id,
				'comment'	=>	$item->comment,
				'shortcode'	=>	"[aj-review gid=".$item->id."]",
				'reviewcount'	=>	$item->reviewcount,
			);
		}
		return $data;
	}


	public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'id':
            case 'title':
            case 'comment':
            case 'shortcode':
            case 'reviewcount':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }
	
	private function sort_data( $a, $b )
    {
        $orderby = 'title';
        $order = 'asc';
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
?>
