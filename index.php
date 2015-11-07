

<?php
include 'header.php';
?>

<?php
include "carousel.php";
?>
<script>
    $(".header .nav a").eq(0).addClass("active");
    $(".carousel-inner .item").eq(0).addClass("active");
</script>

<!--    <div class="notice container-fluid ">-->
<!--        <div class="w-1000 container">-->
<!--                <ul style="height:208px;position:relative;padding:0;margin: 0;top: 0">-->
<!--                    <li class="clone" style="height:52px;">-->
<!--                        <a href="" title="新版上线，欢迎试用！" >-->
<!--                            新版上线，欢迎试用！-->
<!--                        </a>-->
<!--                        <span>2015-07-01</span>-->
<!--                    </li>-->
<!--                    <li class="clone" style="height:52px;">-->
<!--                        <a href="" title="新版上线，欢迎试用！" >-->
<!--                            新版上线，欢迎试用！-->
<!--                        </a>-->
<!--                        <span>2014-03-26</span>-->
<!--                    </li>-->
<!--                    <li style="height:52px;">-->
<!--                        <a href="" title="新版上线，欢迎试用！" >-->
<!--                            新版上线，欢迎试用！-->
<!--                        </a>-->
<!--                        <span>2015-07-01</span>-->
<!--                    </li>-->
<!--                </ul>-->
<!--        </div>-->
<!--    </div>-->
<div class="content container-fluid">
    <?php
    include "carousel-multi.php";
    ?>

</div>
<?php
include "footer.php";
?>

