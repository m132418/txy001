<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">



    <div class="body-content">
        <div class="row">
            <div class="col-lg-6">
                <h2>公告</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">更多内容 &raquo;</a></p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <h2>卡的库存和使用情况</h2>

                <p>库存<?=$cards_count_all[2]?>张卡，已使用了<?=$cards_count_all[1]?>多少张，还有<?=$cards_count_all[0]?>张未使用</p>
               <p>今日生成<?=$cards_count_today[2]?>张卡，已使用了<?=$cards_count_today[1]?>多少张，还有<?=$cards_count_today[0]?>张未使用</p>

                
            </div>
            <div class="col-lg-6">
                <h2>充值统计</h2>

                <p>一共充值了<?=$count_in_money[0]?>元,今日充了<?=$count_in_money[1]?>元.</p>

                
            </div>

        </div>

    </div>
</div>
