<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2015/11/6
 * Time: 12:16
 */


function connectDb(){
    $con = mysql_connect('localhost','root','123456');
    if(!$con){
        die('can not connect db');
    }
    mysql_select_db('tianhua');
    mysql_query("SET NAMES 'utf8'");
    return $con;
}
