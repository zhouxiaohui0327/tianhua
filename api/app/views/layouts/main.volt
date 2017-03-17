<!DOCTYPE html>
<html>
<head lang="zh-cn">
    <meta charset="UTF-8">
    <title>天华服装厂</title>
    <link rel="stylesheet" type="text/css"  href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<!--    <link rel="stylesheet" type="text/css" href="css/pay.css">-->
<!--    <link rel="stylesheet" type="text/css" href="/css/normalize.css">-->
    <link rel="stylesheet" type="text/css" href="/css/htmleaf-demo.css">
    <link rel="stylesheet" type="text/css" href="/css/swipeslider.css">
    <link rel="stylesheet" type="text/css" href="/css/base.css">

    <script src="/js/jquery-2.1.4.js"></script>
    <script src="/js/myjs.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="http://cdn.bootcss.com/holder/2.0/holder.min.js"></script>
    <script src="/js/swipeslider.min.js"></script>
</head>
<body>
<div class="header container-fluid">
    <div class="w-1000 container">
        <a class="logo" href="index.php" title="天华服饰"></a>
        <div class="nav">
            <a id="indexBtn" href="/" title="首页">首页</a>
            <a href="/index/introduce" title="">工厂介绍</a>
            <a href="/index/pattern" title="生产模式">生产模式</a>
            <a href="/index/product" title="优质产品">优质产品</a>
            <a href="/index/contact" title="联系我们">联系我们</a>
        </div>
    </div>
</div>

<section>
    <figure id="responsiveness" class="swipslider">
        <ul class="sw-slides" style="transition-duration: 500ms; transition-timing-function: ease-out; transition-property: all; transform: translateX(-640px);"><li class="sw-slide">
                <img src="/images/banner1.jpg" alt="Another Concept for children game">
            </li>
            <li class="sw-slide">
                <img src="/images/banner2.jpg" alt="Concept for children game">
            </li>
        </ul>
        <ul class="sw-bullet">
            <li class="sw-slide-0 active">

            </li><li class="sw-slide-1"></li>
        </ul>
        <span class="sw-next-prev sw-next"></span>
        <span class="sw-next-prev sw-prev"></span>
    </figure>
</section>





<div class="content container-fluid">
    {{content()}}
    <div class="bg-white container-fluid">
        <div class="clump w-1000 container">
            <h3 class="title">优质产品</h3>
            <div class="product" style="position: relative;overflow: hidden">
                <ul class="clearfix" style="position: relative;overflow: hidden;padding: 0;">

                    {% for pic_list in pic_lists %}
                    <li style="float:left;width: 190px">
                        <a href="/index/product" class="icon" title="">
                            <img src="{{pic_list.pic}}" />
                        </a>
                    </li>
                    {% endfor %}
                </ul>
<!--                <a href="javascript:clickedPrev()" class="prev"></a>-->
<!--                <a href="javascript:clickedNext()" class="next"></a>-->
            </div>
        </div>
    </div>
</div>

<div class="footer container-fluid">
    <ul class="w-1000 container clearfix">
        <li class="tel">
            <h4><a href="" title="联系我们">联系方式</a></h4>
            <div>
                <p>联系人：董爱蓉</p>
                <p>QQ：1242564633</p>
                <p>邮箱：1242564633@qq.com</p>
                <p>电话：0577-65658957&nbsp&nbsp13566159723</p>
                <p>地址：浙江省东山工业区瑞光大道941号</p>
            </div>
        </li>

    </ul>
</div>
<div class="copyright">
    <p>Copyright ©2015版权所有 蓉易美服饰有限公司</p>
    <p>RuiAN RongYiMei （tianhuafs.com） All Rights Reserved. </p>
</div>


<script type="text/javascript">
    $(window).load(function() {
        $('#full_feature').swipeslider();
        $('#content_slider').swipeslider({
            transitionDuration: 600,
            autoPlayTimeout: 10000,
            sliderHeight: '300px'
        });
        $('#responsiveness').swipeslider();
        $('#customizability').swipeslider({
            transitionDuration: 1500,
            autoPlayTimeout: 4000,
            timingFunction: 'cubic-bezier(0.38, 0.96, 0.7, 0.07)',
            sliderHeight: '30%'});
    });
</script>

</body>
</html>