<?php
class AJ_Review extends WP_Widget {
	// class constructor
    public function __construct(){
        wp_register_script('ajrvjs', AJRV_PLUGIN_JS, array('jquery'));
        wp_enqueue_script('ajrvjs');

        $widget_ops = array(
            'classname' => 'aj_review',
            'description' => __('AJ Review 목록', 'ajreview' ),
        );
        parent::__construct('aj_review', 'AJ Review', $widget_ops);
    }

    public $args = array(
        'before_widget'  => "<div class='aj_bs_iso'>",
        'after_widget'  => "</div>"
    );
	
    public function widget($args, $instance){
        global $table_prefix, $post;
        $ajrv_category = $table_prefix . 'ajrv_category';
        $ajrv_review = $table_prefix . 'ajrv_review';
        $ajrv_review_item = $table_prefix . 'ajrv_review_item';

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $ajrv_opt_maxval = get_option('ajrv_opt_maxval', "10");

        $title = !empty($instance['title']) ? $instance['title'] : "";
        $group = !empty($instance['group']) ? $instance['group'] : "";
        $filtervalue = !empty($instance['filtervalue']) ? $instance['filtervalue'] : "";
        $itemcount = !empty($instance['itemcount']) ? $instance['itemcount'] : "3";
        $skin = !empty($instance['skin']) ? $instance['skin'] : "basic_1";
        $morelinktext = !empty($instance['morelinktext']) ? $instance['morelinktext'] : "";
        $morelinklink = !empty($instance['morelinklink']) ? $instance['morelinklink'] : "";

        //wp_enqueue_style('ajrvcss_basic_1', plugins_url("views/skins/".$skin."/style.css", __FILE__));
        include(AJRV_PLUGIN_PATH."views/skins/".$skin."/widgetitem.php");

        $categorytitle = "";
        if($filtervalue == "RELATED"){
            if(is_single()){
                $sql = "select categoryid, b.title as title from $ajrv_review as a join $ajrv_category as b on a.categoryid = b.id where postid = ".$post->ID;
                $rescate = $mysqli->query($sql);
                if(mysqli_num_rows($rescate)){
                    $datacate = mysqli_fetch_assoc($rescate);
                    $filtervalue = $datacate["categoryid"];
                    $categorytitle = $datacate["title"];
                }else{
                    $filtervalue = "";
                }
            }else{
                $filtervalue = "";
            }
        }
		echo "<div class='aj_bs_iso'>";
        if($title){
			echo "<h3 style='margin-bottom:8px;'>".$title."</h3>";
		}
        $sql_where = "";
        if($filtervalue){
            $sql_where = " and categoryid = " . $filtervalue;
        }
        if($group){
            $sql_where = " and groupid = " . $group;
        }
        $sql = "select postid, overall, useramount, title from $ajrv_review where 0 = 0 " . $sql_where . " order by overall desc limit ".$itemcount;
        $res = $mysqli->query($sql);
        if(mysqli_num_rows($res)){
            $itemdata = "";
            $i = 1;
            while($data = mysqli_fetch_assoc($res)){
                $ovalper = ((float)$data["overall"] * 100) / (int)$ajrv_opt_maxval;
                $starttemplate = $ajrv_widget_item;
                $itemdata = str_replace("[RANK]", $i, $starttemplate);
				$itemdata = str_replace("[PRODUCT]", $data["title"] ?  $data["title"] : "", $itemdata);
				if($i == 1){
					$itemdata = str_replace("[CROWN]", "<i class='fas fa-crown'></i><br/>", $itemdata);
					$itemdata = str_replace("[TOPNO]", "", $itemdata);
				}else{
					$itemdata = str_replace("[CROWN]", "", $itemdata);
					$itemdata = str_replace("[TOPNO]", $i, $itemdata);
				}
				$itemdata = str_replace("[ONLYONE]", "", $itemdata);
				$itemdata = str_replace("[TONEDOWN-SKIN1]", "background:#f3f3f3", $itemdata);
				$itemdata = str_replace("[TONEDOWN-SKIN2]", "background:#4c4f5d", $itemdata);
				if($data["postid"]){
					$itemdata = str_replace("[URL]", get_permalink($data["postid"]), $itemdata);
					$itemdata = str_replace("[URLTAG]", "a", $itemdata);
					$itemdata = str_replace("[URLCURSOR]", "cursor: pointer;", $itemdata);
					$itemdata = str_replace("[URLCSS]", "arjv_url", $itemdata);
					$itemdata = str_replace("[DOCICON]", "<i class='fas fa-file-alt'></i>", $itemdata);
				}else{
					$itemdata = str_replace("[URL]", "#", $itemdata);
					$itemdata = str_replace("[URLTAG]", "span", $itemdata);
					$itemdata = str_replace("[URLCURSOR]", "cursor: initial;", $itemdata);
					$itemdata = str_replace("[URLCSS]", "", $itemdata);
					$itemdata = str_replace("[DOCICON]", "", $itemdata);
				}
                $itemdata = str_replace("[TITLE]", $data["title"], $itemdata);
                $itemdata = str_replace("[OVAL]", $ovalper, $itemdata);
                $itemdata = str_replace("[OVERALL]", round($data["overall"],1), $itemdata);
                if($data['postid']){
                    $postitem = get_post($data['postid']);
                    $img = get_the_post_thumbnail_url($postitem->ID,'medium');
                    if($postitem->ID){
                        $itemdata = str_replace("[URL]", get_permalink($postitem->ID), $itemdata);
                    }else{
                        $itemdata = str_replace("[URL]", "#", $itemdata);
                    }
                    $itemdata = str_replace("[IMG]", get_the_post_thumbnail_url($postitem->ID,'medium'), $itemdata);
                }
                $i++;
                echo $itemdata;
            }
			if($morelinktext && $morelinklink){
                $ajrv_widget_morelink = str_replace("[MORETEXT]", $morelinktext, $ajrv_widget_morelink);
                $ajrv_widget_morelink = str_replace("[MORELINK]", $morelinklink, $ajrv_widget_morelink);
				echo $ajrv_widget_morelink;
			}
        }else{
            echo esc_html__( '리뷰가 없습니다.', 'ajreview' );
        }
		echo "</div>";
    }

    public function form($instance){
        global $table_prefix;
        $ajrv_group = $table_prefix . 'ajrv_group';
        $ajrv_category = $table_prefix . 'ajrv_category';
        $ajrv_review = $table_prefix . 'ajrv_review';
        $ajrv_review_item = $table_prefix . 'ajrv_review_item';

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__( __('Top 3 Items', 'ajreview' ), 'ajreview' );
        $group = !empty( $instance['group'] ) ? $instance['group'] : esc_html__( __('리뷰 그룹', 'ajreview' ), 'ajreview' );
        $skin = !empty( $instance['skin'] ) ? $instance['skin'] : esc_html__( __('스킨', 'ajreview' ), 'ajreview' );
        $itemcount = !empty( $instance['itemcount'] ) ? $instance['itemcount'] : esc_html__( 3, 'ajreview' );
        $filtervalue = !empty( $instance['filtervalue'] ) ? $instance['filtervalue'] : esc_html__( __('모두', 'ajreview' ), 'ajreview' );
        $morelinktext = !empty( $instance['morelinktext'] ) ? $instance['morelinktext'] : esc_html__( __('더보기', 'ajreview' ), 'ajreview' );
        $morelinklink = !empty( $instance['morelinklink'] ) ? $instance['morelinklink'] : '';
?>
	<p>
        <label for="skins">
            <?php esc_attr_e( '스킨', 'ajreview' ); ?>
        </label>
        <select name="<?php echo esc_attr($this->get_field_name('skin'));?>" class="widefat" id="skin" type="text">
            <option value="basic_1" <?php if(esc_attr($skin) == "basic_1"){ echo "selected"; }?>><?php echo __('박스 스킨', 'ajreview' )?></option>
            <option value="basic_2" <?php if(esc_attr($skin) == "basic_2"){ echo "selected"; }?>><?php echo __('심플 스킨', 'ajreview' )?></option>
            <option value="basic_3" <?php if(esc_attr($skin) == "basic_3"){ echo "selected"; }?>><?php echo __('White 스킨', 'ajreview' )?></option>
        </select>
	</p>
	<p>
        <label for="group">
            <?php esc_attr_e( __('리뷰 그룹', 'ajreview' ), 'ajreview' ); ?>
        </label>
        <select name="<?php echo esc_attr($this->get_field_name('group'));?>" class="widefat" id="group" type="text">
            <option value="" <?php if(esc_attr($group) == ""){ echo "selected"; }?>><?php echo __('모두', 'ajreview' )?></option>
<?php
        $res = $mysqli->query("select * from $ajrv_group order by reviewcount desc");
        while($data = mysqli_fetch_assoc($res)){
?>
            <option value="<?php echo $data['id'];?>" <?php if(esc_attr($group) == $data['id']){ echo "selected"; }?>><?php echo $data['title'];?> (<?php echo $data['reviewcount'];?>)</option>
<?php
        }
?>
        </select>
	</p>
	<p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
            <?php esc_attr_e(__('제목', 'ajreview' ), 'ajreview' ); ?>
        </label>
        <input
            class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
            name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text"
            value="<?php echo esc_attr($title);?>">
	</p>
	<p>
        <label for="itemcount">
            <?php esc_attr_e( __('표시 개수', 'ajreview'), 'ajreview' ); ?>
        </label>
        <input type="number" class="widefat" id="itemcount" name="<?php echo esc_attr($this->get_field_name('itemcount'));?>" 
            value=<?php echo esc_attr($itemcount);?>>
	</p>
<!--
	<p>
        <label for="filtertype">
            <?php //esc_attr_e( 'Filter Type', 'ajreview' ); ?>
        </label>
        <input type="number" class="widefat" id="filtertype" name="<?php echo esc_attr($this->get_field_name('filtertype'));?>" 
            value=<?php //echo esc_attr($filtertype);?>>
	</p>
-->
	<p>
        <label for="filtervalue">
            <?php esc_attr_e( __('카테고리', 'ajreview'), 'ajreview' ); ?>
        </label>
        <select name="<?php echo esc_attr($this->get_field_name('filtervalue'));?>" class="widefat" id="filtervalue" type="text">
            <option value="" <?php if(esc_attr($filtervalue) == ""){ echo "selected"; }?>>모두</option>
            <option value="RELATED" <?php if(esc_attr($filtervalue) == "RELATED"){ echo "selected"; }?>><?php echo __('연관된 카테고리', 'ajreview' )?></option>
<?php
        $res = $mysqli->query("select * from $ajrv_category order by reviewcount desc");
        while($data = mysqli_fetch_assoc($res)){
?>
            <option value="<?php echo $data['id'];?>" <?php if(esc_attr($filtervalue) == $data['id']){ echo "selected"; }?>><?php echo $data['title'];?></option>
<?php
        }
?>
        </select>
	</p>
	<p>
        <label for="ordervalue">
            <?php esc_attr_e( __('정렬 방식', 'ajreview'), 'ajreview' ); ?>
        </label>
        <select name="<?php echo esc_attr($this->get_field_name('ordervalue'));?>" class="widefat" id="ordervalue" type="text">
            <option value="desc" <?php if(esc_attr($ordervalue) == ""){ echo "selected"; }?>><?php echo __('총점이 높은순', 'ajreview' )?></option>
            <option value="asc" <?php if(esc_attr($ordervalue) == "RELATED"){ echo "selected"; }?>><?php echo __('총점이 낮은순', 'ajreview' )?></option>
        </select>
	</p>
	<p>
        <label for="morelinktext">
            <?php esc_attr_e( __('더보기 링크 Text', 'ajreview'), 'ajreview' ); ?>
        </label>
        <input
            class="widefat" id="<?php echo esc_attr($this->get_field_id('morelinktext')); ?>"
            name="<?php echo esc_attr($this->get_field_name( 'morelinktext' )); ?>" type="text"
            value="<?php echo esc_attr($morelinktext);?>">
	</p>
	<p>
        <label for="morelinklink">
            <?php esc_attr_e( __('더보기 링크 Link', 'ajreview'), 'ajreview' ); ?>
        </label>
        <input
            class="widefat" id="<?php echo esc_attr($this->get_field_id('morelinklink')); ?>"
            name="<?php echo esc_attr($this->get_field_name( 'morelinklink' )); ?>" type="text"
            value="<?php echo esc_attr($morelinklink);?>">
	</p>
<?php
    }

	// save options
    public function update( $new_instance, $old_instance){
        $instance = array();
        $instance['skin'] = ( !empty($new_instance['skin']) ) ? strip_tags( $new_instance['skin'] ) : '';
        $instance['title'] = ( !empty($new_instance['title']) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['group'] = ( !empty($new_instance['group']) ) ? strip_tags( $new_instance['group'] ) : '';
        $instance['itemcount'] = ( !empty($new_instance['itemcount']) ) ? strip_tags( $new_instance['itemcount'] ) : '';
        $instance['filtervalue'] = ( !empty($new_instance['filtervalue']) ) ? strip_tags( $new_instance['filtervalue'] ) : '';
        $instance['ordervalue'] = ( !empty($new_instance['ordervalue']) ) ? strip_tags( $new_instance['ordervalue'] ) : '';
        $instance['morelinktext'] = ( !empty($new_instance['morelinktext']) ) ? strip_tags( $new_instance['morelinktext'] ) : '';
        $instance['morelinklink'] = ( !empty($new_instance['morelinklink']) ) ? strip_tags( $new_instance['morelinklink'] ) : '';
        return $instance;
    }
}
