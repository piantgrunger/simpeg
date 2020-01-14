<?php

/* @var $this yii\web\View */
use miloschuman\highcharts\Highcharts;


?>
<div class="site-index">
<div class="row">
<div class="col-md-6">  <div class="card">
    <div class="card-header">
     <h4 class="text-center">Grafik Data Pegawai <br> Pemerintah Kota Banjarbaru</h4>
    </div>
    <div class="card-body">

    
<?= Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/grid-light',
    ],
    
    'options' => [
        'credits' => ['enabled' => false],
        'title' => [
            'text' => 'Jumlah Pegawai <br> Dilingkungan Pemerintah Kota Banjarbaru',
             ],
        'series' => [
            [

                'type' => 'pie',
                'name' => 'Jumlah Pegawai',
                'data' => $series,
                'showInLegend' => false,
                'dataLabels' => [
                    'enabled' => true,
                    'formatter' => new \yii\web\JSExpression("function() {
                        return this.key + ': ' + this.y; ; 
                      } ")
                ],
            ],
          
        ],
    ],
]);

?>

    
    </div>
  </div>
  </div>
  <div class="col-md-6">  <div class="card">
    <div class="card-header">
     <h4 class="text-center">Grafik Data Pegawai <br> Golongan Pangkat</h4>
    </div>
    <div class="card-body">

    
<?= Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/grid-light',
    ],
    
    'options' => [
        'credits' => ['enabled' => false],
        'title' => [
            'text' => 'Pangkat Golongan Pegawai <br> Dilingkungan Pemerintah Kota Banjarbaru',
             ],
             'xAxis' => [
                'categories' => $xSeries2,
             ],
            'yAxis' => [
                'title' => ['text' => 'Jumlah '],
            ],
             'labels' => [
                'items' => [
                    [
                        'html' => 'Jumlah Pegawai',
                        'style' => [
                       
                            'color' => new \yii\web\JSExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                        ],
                    ],
                ]
                ],
        'series' => [
            [

                'type' => 'line',
                'name' => 'Jumlah Pangkat Golongan Pegawai',
                'data' => $series2,
                'showInLegend' => false,
                'dataLabels' => [
                    'enabled' => true,
                    'formatter' => new \yii\web\JSExpression("function() {
                        return this.key + ': ' + this.y; ; 
                      } ")
                ],
            ],
          
        ],
    ],
]);

?>

    
    </div>
  </div>
  </div>

  </div>  
  <div class="row">
  <div class="col-md-6">  <div class="card">
    <div class="card-header">
     <h4 class="text-center">Grafik Data Pejabat <br> Eselon</h4>
    </div>
    <div class="card-body">

    
<?= Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/grid-light',
    ],
    
    'options' => [
        'credits' => ['enabled' => false],
        'title' => [
            'text' => 'Pejabat Eselon Pegawai <br> Dilingkungan Pemerintah Kota Banjarbaru',
             ],
             'xAxis' => [
                'categories' => $xSeries3,
             ],
            'yAxis' => [
                'title' => ['text' => 'Jumlah '],
            ],
             'labels' => [
                'items' => [
                    [
                        'html' => 'Jumlah Pegawai',
                        'style' => [
                       
                            'color' => new \yii\web\JSExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                        ],
                    ],
                ]
                ],
        'series' => [
            [

                'type' => 'column',
                'name' => 'Jumlah Pejabat Eselon',
                'data' => $series3,
                'showInLegend' => false,
                'dataLabels' => [
                    'enabled' => true,
                    'formatter' => new \yii\web\JSExpression("function() {
                        return this.key + ': ' + this.y; ; 
                      } ")
                ],
            ],
          
        ],
    ],
]);

?>

    
    </div>
  </div>
  </div>


  </div>
</div>
