

<?php
include "header.php";
?>
<?php
include "carousel.php";
?>
<script>
    $(".header .nav a").eq(2).addClass("active");
    $(".carousel-inner .item").eq(0).addClass("active");
</script>

<div class="content container-fluid">
    <div class="bg-grey container-fluid">
        <div class="clump w-1000 container">
            <h3 class="title">生产模式</h3>
            <p class="explain_1" style="margin-top: 30px">我们有完善的公司制度，严格的检验标准，保证优良的出库产品质量</p>
            <div style="text-align: center;border:1px solid grey;margin-top: 30px;border-radius: 5px">
                <img src="images/moshi.jpg" alt=""/>
            </div>
        </div>
    </div>
    <?php
    include "carousel-multi.php";
    ?>

</div>
<?php
include "footer.php";
?>
