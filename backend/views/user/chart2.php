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
                var myChart = ec.init(document.getElementById('chart2')); 
                
                var 
               
                option = {
                	    title : {
                	        text: '充值积分情况',
                	        subtext: '详情',
                	        sublink: '<?=Url::to(["order/index",'OrderSearchAll[whose]'=> $id], true)?>',      
                	    },
                	    tooltip : {
                	        trigger: 'axis',
                	        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                	            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                	        },
                	        formatter: function (params){
                	            return params[0].name + '<br/>'
                	                   + params[0].seriesName + ' : ' + params[0].value + '<br/>'
                	                   + params[1].seriesName + ' : ' + (params[1].value + params[0].value);
                	        }
                	    },
                	    legend: {
                	        selectedMode:false,
                	        data:['充值积分', '赠送积分']
                	    },
                	    toolbox: {
                	        show : true,
                	        feature : {
                	            mark : {show: true},
                	            dataView : {show: true, readOnly: false},
                	            restore : {show: true},
                	            saveAsImage : {show: true}
                	        }
                	    },
                	    calculable : true,
                	    xAxis : [
                	        {
                	            type : 'category',
                	            data : <?="['" . implode("','", $sum_2nd[0]) . "']" ?>
                	        }
                	    ],
                	    yAxis : [
                	        {
                	            type : 'value',
                	            boundaryGap: [0, 0.1]
                	        }
                	    ],
                	    series : [
                	        {
                	            name:'充值积分',
                	            type:'bar',
                	            stack: 'sum',
                	            barCategoryGap: '50%',
                	            itemStyle: {
                	                normal: {
                	                    color: 'tomato',
                	                    barBorderColor: 'tomato',
                	                    barBorderWidth: 6,
                	                    barBorderRadius:0,
                	                    label : {
                	                        show: true, position: 'insideTop'
                	                    }
                	                }
                	            },
                	            data:<?="[" . implode(",", $sum_2nd[1]) . "]" ?>
                	        },
                	        {
                	            name:'赠送积分',
                	            type:'bar',
                	            stack: 'sum',
                	            itemStyle: {
                	                normal: {
                	                    color: '#fff',
                	                    barBorderColor: 'tomato',
                	                    barBorderWidth: 6,
                	                    barBorderRadius:0,
                	                    label : {
                	                        show: true, 
                	                        position: 'top',
                	                        formatter: function (params) {
                	                            for (var i = 0, l = option.xAxis[0].data.length; i < l; i++) {
                	                                if (option.xAxis[0].data[i] == params.name) {
                	                                    return option.series[0].data[i] + params.value;
                	                                }
                	                            }
                	                        },
                	                        textStyle: {
                	                            color: 'tomato'
                	                        }
                	                    }
                	                }
                	            },
                	            data:<?="[" . implode(",", $sum_2nd[2]) . "]" ?>
                	        }
                	    ]
                	};
                	                    


                // 为echarts对象加载数据 
                myChart.setOption(option); 
            }
        );
    </script>