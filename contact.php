
<?php
include "header.php";
?>

<?php
include "carousel.php";
?>
<script>
    $(".header .nav a").eq(4).addClass("active");
    $(".carousel-inner .item").eq(0).addClass("active");
</script>


<div class="content container-fluid">
    <div class="bg-grey container-fluid">
        <div class="clump w-1000 container">
            <h3 class="title">联系方式</h3>
            <h5>联系人</h5>
            <p class="explain_1"><span>Ø</span>&nbsp&nbsp董爱蓉</p>
            <h5>QQ</h5>
            <p class="explain_1" style="margin-top: 20px"><span>Ø</span>&nbsp&nbsp1242564633</p>
            <h5>邮箱</h5>
            <p class="explain_1"><span>Ø</span>&nbsp&nbsp1242564633@qq.com</p>
            <h5>电话</h5>
            <p class="explain_1"><span>Ø</span>&nbsp&nbsp0577-65658957&nbsp&nbsp13566159723</p>
            <h5>地址</h5>
            <p class="explain_1"><span>Ø</span>&nbsp&nbsp浙江省瑞安市东山工业区瑞光大道941号</p>
        </div>
    </div>
    <?php
    include "carousel-multi.php";
    ?>
</div>
<?php
include "footer.php";
?>