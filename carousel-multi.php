<?php
require_once "include_index.php";
?>
<div class="bg-white container-fluid">
    <div class="clump w-1000 container">
        <h3 class="title">优质产品</h3>
        <div class="product" style="position: relative;overflow: hidden">
            <ul class="clearfix" style="width:2500px;position: relative;overflow: hidden;padding: 0;left:-250px">
                <?php foreach($index_list as $one):?>
                    <li style="float:left;width: 190px">
                        <a href="" class="icon" title="">
                            <img src="<?php echo $one['pic'] ;?>" alt=""/>
                        </a>
                    </li>
                <?php endforeach;?>

                <?php foreach($index_list as $one):?>
                    <li style="float:left;width: 190px">
                        <a href="" class="icon" title="">
                            <img src="<?php echo $one['pic'] ;?>" alt=""/>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
            <a href="javascript:clickedPrev()" class="prev"></a>
            <a href="javascript:clickedNext()" class="next"></a>
        </div>
    </div>
</div>
