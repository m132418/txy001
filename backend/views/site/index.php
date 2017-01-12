<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">



    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>代理商</h2>

            <table class="table table-hover table-bordered">
			  <tr>
			    <th>代理商总数</th>  <th>今日注册</th> 
			    </tr>
			    <tr>
			     <td><?=$inusers[0]?></td>  <td><?=$inusers[1]?></td>
			   </tr>
			</table>

                
            </div>
            <div class="col-lg-4">
                <h2>卡</h2>

            
            <table class="table table-hover table-bordered">
			  <tr>
			    <th>卡总量</th>  <th>已使用</th> <th>未使用</th>
			    </tr>
			    <tr>
			    <td><?=$cards_all[2]?></td>  <td><?=$cards_all[1]?></td> <td><?=$cards_all[0]?></td>
			   </tr>
			</table>
            <table class="table table-hover table-bordered">
			  <tr>
			    <th>今日卡总量</th>  <th>今日已使用</th> <th>今日未使用</th>
			    </tr>
			    <tr>
			     <td><?=$cards_today[2]?></td>  <td><?=$cards_today[1]?></td> <td><?=$cards_today[0]?></td>
			   </tr>
			</table>
                
            </div>
            <div class="col-lg-4">
                <h2>充值</h2>

            <table class="table table-hover table-bordered">
			  <tr>
			    <th>充值总额</th>  <th>今日充值</th> 
			    </tr>
			    <tr>
			    <td><?=$inmoney[0]?></td>  <td><?=$inmoney[1]?></td> 
			   </tr>
			</table>

                
            </div>
        </div>

    </div>
</div>
