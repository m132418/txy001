<?php
use yii\helpers\Url;

?>
<script type="text/javascript">
        // 路径配置
        require.config({
            paths: {
                echarts: 'http://echarts.baidu.com/build/dist'
            }
        });
        
        // 使用
        require(
            [
                'echarts',
                'echarts/chart/bar' ,// 使用柱状图就加载bar模块，按需加载
                'echarts/chart/pie' ,
                'echarts/chart/funnel' 
            ],
            function (ec) {
                // 基于准备好的dom，初始化echarts图表
                var myChart = ec.init(document.getElementById('chart1')); 
                
                var option = {
    title : {
        text: '卡使用情况',
        subtext: '详情',
        sublink: '<?=Url::to(["card/index",'CardSearch2[whoissue]'=> $id], true)?>',        		
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient : 'vertical',
        x : 'left',
        data:['未使用卡','已使用的卡']
    },
    toolbox: {
        show : true,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            magicType : {
                show: true, 
                type: ['pie', 'funnel'],
                option: {
                    funnel: {
                        x: '25%',
                        width: '50%',
                        funnelAlign: 'left',
                        max: 1548
                    }
                }
            },
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    series : [
        {
            name:'卡使用情况',
            type:'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:[
                {value:<?=$count_cards_all[0]?>, name:'未使用卡'},
                {value:<?=$count_cards_all[1]?>, name:'已使用的卡'}
            ]
        }
    ]
};
                    
        
                // 为echarts对象加载数据 
                myChart.setOption(option); 
            }
        );
    </script>