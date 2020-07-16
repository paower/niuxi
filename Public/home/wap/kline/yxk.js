$(function(){
	$('#retu').click(function(){
	window.history.back(-1);
	})
})
$(function(){
	$(".gg_ul li").eq(0).clone().appendTo('.gg_ul')
	var li_len = $(".gg_ul").children("li").length;
	var ul_w = li_len * 100 + '%';
	var li_w = 100 / li_len + '%'; 
	var i = 0;
	$(".gg_ul").css('width',ul_w);
	$(".gg_ul").children("li").css('width',li_w);
	setInterval(
		function(){
			i++;
			if(i >= (li_len)){
				$(".gg_ul").css('margin-left',0);
				i=0
				return;
			}
			$(".gg_ul").animate({'margin-left':-i*100+'%'},600);
		
		},2000
	)
})



function jiajian(num1,num2){
	$('#jian').click(function(){
		
		var mony_vlu = parseInt($('#mony').val());
		
		if(mony_vlu > num2) {
			$('#mony').val(mony_vlu-num1);
			
			
		}
	})
	$('#jia').click(function(){
		var mony_vlu = parseInt($('#mony').val());
		$('#mony').val((mony_vlu+num1))
	})
	$('#mony').blur(function(){
		if($(this).val() < num2){
			$(this).val(num2)
		}
	})
}
	
$(function () {
    $('#container').highcharts({
    	 chart: {
            backgroundColor:'#202020'
        },
        style: {
		    color: '#fff'
		},
//      tooltip: {
////          crosshairs: true,
////          shared: true
//      },
        title: {
            text: 'k币走势图',
          	x: -60, //center
            y: 20,
            style:{
            	color: '#fff',
            	fontSize:'14',
            	height: '16px'
            },
//          floating:'true'
        },
        xAxis: {
        	categories: ['周一', '周二', '周三', '周四', '周五', '周六','周日'],
            tickmarkPlacement: 'on'
        },
        yAxis: {
            title: {
                text: '单位 (元)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        credits: {
          enabled:false
		},
		exporting: {
            enabled:false
		},
        tooltip: {
            valueSuffix: ' 元',
            crosshairs: true,
            shared: true
        },
        series: [{
            name: '买入',
            color : "#BC332F",
            data: [1.2, 1.5, 3.6, 2.5, 1.2, 1.5, 2.2]
        },{
            name: '卖出',
            color : "#248C85",
            data: [1.4, 1.2, 1.6, 1.5, 2.2, 2.5, 1.2]
        }],
        legend:{
//      	floating: true,
        	verticalAlign: 'top',
        	x: 40,
        	itemDistance: 10,
        	itemStyle: {color:'#fff'}
        }
    });
});