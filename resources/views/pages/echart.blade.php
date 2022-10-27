@extends('layout')

@section('css')

@stop

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Chart</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Chart</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Data Grafik</h2>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
	            <div class="col-xl-6" style="margin-top: 30px;">
		            <div class="card">
			            <div class="card-body">
				            <div class="chart-container">
					            <div class="chart has-fixed-height" id="pie_basic"></div>
				            </div>
			            </div>
		            </div>
	            </div>	
            </div>
            <div class="col-md-12">
	            <div class="col-xl-6" style="margin-top: 30px;">
		            <div class="card">
			            <div class="card-body">
				            <div class="chart-container">
					            <div class="chart has-fixed-height" id="bars_basic"></div>
				            </div>
			            </div>
		            </div>
	            </div>	
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@stop

@section('js')
<script type="text/javascript">
var pie_basic_element = document.getElementById('pie_basic');
if (pie_basic_element) {
    var pie_basic = echarts.init(pie_basic_element);
    pie_basic.setOption({
        color: [
            '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'
        ],          
        
        /*textStyle: {
            fontFamily: 'Roboto, Arial, Verdana, sans-serif',
            fontSize: 13
        },*/

        title: {
            text: 'Status Presensi Karyawan',
            left: 'center',
            textStyle: {
                fontSize: 17,
                fontWeight: 500
            },
            subtextStyle: {
                fontSize: 12
            }
        },

        tooltip: {
            trigger: 'item',
            backgroundColor: 'rgba(0,0,0,0.75)',
            padding: [10, 15],
            textStyle: {
                fontSize: 13,
                fontFamily: 'Roboto, sans-serif'
            },
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },

        legend: {
            orient: 'horizontal',
            bottom: '0%',
            left: 'center',                   
            data: ['Masuk', 'Belum Masuk', 'Pulang', 'Alpha', 'Telat'],
            itemHeight: 8,
            itemWidth: 8
        },

        series: [{
            name: 'Status Presensi Karyawan',
            type: 'pie',
            radius: '70%',
            center: ['50%', '50%'],
            itemStyle: {
                normal: {
                    borderWidth: 1,
                    borderColor: '#fff'
                }
            },
            data: [
                {value: {{$masuk_count}}, name: 'Masuk'},
                {value: {{$belum_masuk_count}}, name: 'Belum Masuk'},
                {value: {{$pulang_count}}, name: 'Pulang'},
                {value: {{$alpha_count}}, name: 'Alpha'},
                {value: {{$telat_count}}, name: 'Telat'},
            ]
        }]
    });
}

var bars_basic_element = document.getElementById('bars_basic');
if (bars_basic_element) {
    var bars_basic = echarts.init(bars_basic_element);
    bars_basic.setOption({
      color: ['#3398DB', '#5528DB', '#ff00DB'],
        tooltip: {
            trigger: 'axis',
            axisPointer: {            
                type: 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: [
            {
                type: 'category',
                data: ['Produksi', 'Ketertiban', 'IT'],
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis: [
            {
                type: 'value'
            }
        ],

        title: {
            text: 'Total Karyawan Aktif Masing-masing Organisasi',
            
        },

        legend: {                  
            data: ['Produksi', 'Ketertiban', 'IT'],
            bottom: '88%',
        },

        series : [
	        {
	            name:'Produksi',
	            type:'bar',
		          stack: 'stack',
	            data:[{{$produksi_count}}, ,]
	        }, {
	            name:'Ketertiban',
	            type:'bar',
							stack: 'stack',
	            data:[,{{$ketertiban_count}},]
	        }, {
	            name:'IT',
	            type:'bar',
							stack: 'stack',
	            data:[, ,{{$it_count}}]
	        }
	      ]
    });
}
</script>
@stop