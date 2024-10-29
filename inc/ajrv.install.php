<?php
function ajrv_create_plugin_database_table()
{
    global $table_prefix, $wpdb, $ajReviewDBVersion;

    $charset_collate = $wpdb->get_charset_collate();
    $sql = array();

    $installed_db_ver = get_option("ajrv_db_version");

    if($installed_db_ver !== $ajReviewDBVersion) {
        $ajrv_group = $table_prefix . 'ajrv_group';
        $sql[] = "CREATE TABLE " . $ajrv_group . " (
            id int(11) NOT NULL AUTO_INCREMENT,
            title varchar(100) NOT NULL,
            comment varchar(255) NOT NULL,
            reviewcount int(11) DEFAULT 0,
            regdate datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
            ) " . $charset_collate . ";";
			
        $ajrv_category = $table_prefix . 'ajrv_category';
        $sql[] = "CREATE TABLE " . $ajrv_category . " (
            id int(11) NOT NULL AUTO_INCREMENT,
			groupid int(11) NOT NULL,
            title varchar(100) NOT NULL,
            comment varchar(255) NOT NULL,
            reviewcount int(11) DEFAULT 0,
            regdate datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
            ) " . $charset_collate . ";";

        $ajrv_review = $table_prefix . 'ajrv_review';
        $sql[] = "CREATE TABLE $ajrv_review (
            id int(11) NOT NULL AUTO_INCREMENT,
			groupid int(11) NOT NULL,
            categoryid int(11) NOT NULL,
            postid int(11) NULL,
            authorid int(11) NOT NULL,
            title varchar(100) NOT NULL,
            publisher varchar(100) NULL,
            platform varchar(100) NULL,
            singleword varchar(30) NOT NULL,
            useramount decimal(15,2) NULL,
            onelinereview varchar(500) NOT NULL,
            overall double DEFAULT 0,
            pros varchar(1000),
            cons varchar(1000),
            photo int(11) NULL,
            regdate datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated datetime,
            PRIMARY KEY  (id)
            ) $charset_collate;";

        $ajrv_review_item = $table_prefix . 'ajrv_review_item';
        $sql[] = "CREATE TABLE $ajrv_review_item (
            id int(11) NOT NULL AUTO_INCREMENT,
			groupid int(11) NOT NULL,
            reviewid int(11) NOT NULL,
            title varchar(100) NOT NULL,
            overall tinyint DEFAULT 0,
            PRIMARY KEY  (id)
            ) $charset_collate;";

        $ajrv_review_user = $table_prefix . 'ajrv_review_user';
        $sql[] = "CREATE TABLE $ajrv_review_user (
            id int(11) NOT NULL AUTO_INCREMENT,
            reviewid int(11) NOT NULL,
			commentid int(11) NOT NULL,
            useremail varchar(100) NOT NULL,
            overall double DEFAULT 0,
            regdate datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
            ) $charset_collate;";
    }

    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    update_option('ajrv_db_version', $ajReviewDBVersion);
}
?>
