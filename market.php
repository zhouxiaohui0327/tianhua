<?php
require_once "mysql.php";
connectDb();
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
$limit = 8;
$count=mysql_query("SELECT * FROM picture");
$totalNumber = mysql_num_rows($count);
$totalPage=ceil($totalNumber/$limit);
$b = 3 ;
function get_row($table_name){
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    $limit=8;
    $startCount = ($page - 1) * $limit;
    $list = array();
    $query = mysql_query("SELECT * FROM $table_name order by id desc limit $startCount ,$limit");
    $count1 = mysql_num_rows($query);
    if ($count1 <= 0) {
        return $list;
    } else {
        for ($i = 0; $i < $count1; $i++) {
            $list[] = mysql_fetch_assoc($query);
        }
        return $list;
    }
}
$ku_list=get_row('picture');
?>

<?php
include "header.php";
include "carousel.php";
?>

<script>
    $(".header .nav a").eq(3).addClass("active");
    $(".carousel-inner .item").eq(0).addClass("active");
</script>

<div class="content container-fluid">
    <div class="bg-grey container-fluid">
        <div class="clump w-1000 container">
            <h3 class="title">优质产品库</h3>
            <div style="margin-top: 30px;border: 2px solid gainsboro;padding: 10px">
                <?php foreach($ku_list as $one):?>
                        <div style="display: inline-block;width: 240px;margin-top: 20px">
                            <img style="width: 150px;height: 220px;margin:0 auto;display: block" src="<?php echo $one['pic'] ;?>"/>
                        </div>
                <?php endforeach;?>

            </div>
        </div>



        <div class="container">
            <nav style="  text-align: -webkit-center;">
                <ul class="pagination">
                    <li>
                        <a href="add.php?page=<?php echo $page - 1;?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php
                    for ($i=$page;$i<=$page+$b&&$i<=$totalPage;$i++) {
                        ?>
                        <li><a href="add.php?page=<?php echo $i;?>"><?php echo $i ;?></a></li>
                    <?php
                    }
                    ?>
                    <?php
                    if($page>=$totalPage){
                        ?>
                        <li>
                            <a aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                            <span class="total"><?php echo "共（".$totalNumber."）条"."(".$totalPage.")"."页";?></span>
                        </li>
                    <?php
                    }else {
                        ?>
                        <li>
                            <a href="add.php?page=<?php echo $page + 1;?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>

        </div>
    </div>
    <?php
    include "carousel-multi.php";
    ?>
</div>
<?php
include "footer.php";
?>

