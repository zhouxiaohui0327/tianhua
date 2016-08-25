
<?php
include "header.php";
?>
<?php
include "carousel.php";
?>
<script>
    $(".header .nav a").eq(1).addClass("active");
    $(".carousel-inner .item").eq(0).addClass("active");
</script>

<div class="content container-fluid">
    <div class="bg-grey container-fluid">
        <div class="clump w-1000 container">
            <h3 class="title">工厂介绍</h3>
            <p class="explain_1">天华服装厂是一家集专业设计、生产和销售于一体的现代化女装工厂。公司自成立以来一直致力于引领都市时尚潮流女性的时尚穿衣品味；崇尚个性化、多元化搭配而又不失经典的着装理念和服饰文化；倾情塑造端庄、知性、优雅的美好女性形象。得到广大客户的好评。</p>
            <p class="explain_1">凭藉准确的市场定位，经典、时尚而又结合消费群需求的设计风格和人性化的管理理念，得到业界人士的广泛认同，在全国各级客户中拥有良好的口碑和美誉度，公司将不懈努力，深入强化精细化生产管理，强化终端支持和服务客户的理念，秉承“品质、信誉至上”为宗旨，努力将公司品牌打造成艺术追求与商业运作完美融合的时尚潮流知性女装品牌！</p>
            <p class="explain_1">以优良的质量保证，良好的服务水准赢得了国内外客户、贸易公司、厂商的青眯和好评，诚觅新的客商共同合作。</p>
            <p class="explain_1">公司风格定位意在塑造优雅、知性、浪漫而有气质的美好女性形象。对优雅、大气的美好女性形象的执着追求，崇尚知识女性通过外在的高品味着装，体现内在丰富的文化内涵和气质修养，对真爱的追求，对事业和生活的热爱！ 爱是女性生命中最重要的部分，通过修炼自己的内心，汲取知识的养分，丰富自身的内涵转而散发着智慧和自然如华的美好气质，吸引他人的关爱；自身关注亲人、朋友和爱人之间的亲情、友情和爱情，懂得如何去爱，享受幸福的生活! </p>
            <p class="explain_1">联系我们公司地址：浙江省东山工业区瑞光大道941号</p>
            <div style="width:100%;text-align: center">
                <img src="./images/IMG_5112.JPG" style="width:70%""/>
                <p style="margin:20px auto">办公区</p>
                <img src="./images/bangong.jpg" style="width:70%" alt="">
                <p style="margin:20px auto">样品区</p>
                <img src="./images/yangpin.jpg" style="width:70%" alt="">
                <p style="margin:20px auto">生产区</p>
                <img src="./images/shengchan.jpg" style="width:70%" alt="">
                <p style="margin:20px auto">后道</p>
                <img src="./images/houdao.jpg" style="width:70%" alt="">
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

