<?php

header("Content-type: text/html; charset=utf-8");
require_once "mysql.php";
connectDb();
$id = $_POST['id'];
$pic = $_POST['pic'];

$time =date("Y-m-d H:i:s");
$sql="UPDATE picture SET  last_time='$time', pic = '$pic' WHERE id=$id";

if(mysql_query($sql)){
    $result=array();
    $result['state']=true;
    $result['data']='修改成功';

    echo json_encode($result);
    die();
}else{
    $result=array();
    $result['state']=false;
    $result['data']='修改失败';
    echo json_encode($result);
    die();
}
