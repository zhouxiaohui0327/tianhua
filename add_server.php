<?php


header("Content-type: text/html; charset=utf-8");

$id = $_POST['id'];
$pic =$_POST['pic'];

require_once "mysql.php";
connectDb();
$sql="INSERT INTO picture(id,pic)VALUES('$id','$pic')";
if (!mysql_query($sql))
{
    die('Error: ' . mysql_error());
}
echo "添加一条记录";

mysql_close();

header("Location:./add.php");