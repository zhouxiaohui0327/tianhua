

<?php
require_once "mysql.php";

connectDb();
function get_list($table_name,$offset,$limit,$orderBy="order by id desc") {
    $list = array();
    $query = mysql_query("SELECT * FROM $table_name $orderBy limit  $offset,$limit");
    $count = mysql_num_rows($query);
    if($count <= 0) {
        return $list;
    } else {
        for($i = 0; $i<$count; $i++) {
            $list[] = mysql_fetch_assoc($query);
        }
        return $list;
    }
}
$index_list = get_list('picture',0,5);
