<?php
function ajrv_delete_review($post_id)
{
    global $table_prefix, $wpdb;

    $ajrv_category = $table_prefix . 'ajrv_category';
    $ajrv_review = $table_prefix . 'ajrv_review';
    $ajrv_review_item = $table_prefix . 'ajrv_review_item';

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $res = $mysqli->query("select * from $ajrv_review where postid = $post_id ;");
    if(mysqli_num_rows($res)){
        $row = mysqli_fetch_assoc($res);
        $mysqli->query("update $ajrv_category set reviewcount = reviewcount - 1 where id = ". $row["categoryid"] ." ;");
        $mysqli->query("delete from $ajrv_review_item where reviewid = ". $row["id"] ." ;");
        $mysqli->query("delete from $ajrv_review where postid = $post_id ;");
    }
}
?>
