<?php
use common\models\User;
$uname =null;$level =null ;
if (Yii::$app->user->identity) {
$u = User::findOne(['id'=>Yii::$app->user->identity->id]);
$uname =$u->username  ?$u->username: '--null--' ;
$level = $u->level  ?  $u->level : '--null--' ;
}

?>
<div class="site-index">



	<div class="body-content">


		<div class="row">
			<table class="table table-hover table-bordered">
			    <tr>
			    <th>用户名</th><th>积分</th> <th>级别</th> <th>总额</th> <th>今日充值</th>
			    </tr>
			    <tr>
			    <td><?=$uname?></td> <td><?=$count_score[0]?></td> <td><?=$level?></td> <td><?=$count_in_money[0]?></td> <td><?=$count_in_money[1]?></td>
			    </tr>
			</table>
		</div>
		
		<div class="row">
			<table class="table table-hover table-bordered">
			    <tr>
			    <th>总库存卡量</th> <th>今日使用</th> <th>累计使用</th> <th>未使用</th>
			    </tr>
			    <tr>
			    <td><?=$cards_count_all[2]?></td> <td><?=$cards_count_today[1]?></td> <td><?=$cards_count_all[1]?></td> <td><?=$cards_count_all[0]?></td>
			    </tr>
			</table>
		</div>
		
		<div class="row">
		<h3>公告</h3>
		
		<?php 
		foreach ($boards as $value) {
		    ?>
		 <div  class="alert alert-success alert-dismissible" role="alert">
		
		 <?=$value["content"]?>  
		 </div>   
		<?php 
		}
		?>
		
		
		</div>

	</div>
</div>
