<div class="bg-grey container-fluid">
    <div class="clump w-1000 container">
        <h3 class="title">优质产品库</h3>
        <div style="margin-top: 30px;border: 2px solid gainsboro;padding: 10px">
            {% for product in products %}
                <div style="display: inline-block;width: 240px;margin-top: 20px">
                    <img style="width: 150px;height: 220px;margin:0 auto;display: block" src="{{product.pic}}"/>
                </div>
            {% endfor %}
        </div>
    </div>



    <div class="container">
        <nav style="  text-align: -webkit-center;">
            <ul class="pagination">
                <li>
                    <a href="/index/product?page={{page-1}}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                for ($i=$page;$i<=$page+$b&&$i<=$totalPage;$i++) {
                    ?>
                    <li><a href="/index/product?page=<?php echo $i;?>"><?php echo $i ;?></a></li>
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
                        <a href="/index/product?page={{page+1}}" aria-label="Next">
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

<script>
    $(function(){
        $(".header .nav a").eq(3).addClass("active");
        $(".bg-white").hide();
    })
</script>