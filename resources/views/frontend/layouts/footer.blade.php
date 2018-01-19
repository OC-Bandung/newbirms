	<!--footer-->
	<footer>
        <a href="https://www.bandung.go.id" target="_blank"><img src="{{ url('img/bandung-branding.png') }}"></a>
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="{{ url('js/clipboard.min.js') }}"></script>
    <script src="{{ url('js/classie.js') }}"></script>
    <script src="{{ url('js/menu.js') }}"></script>
    <script src="{{ url('js/search.js') }}"></script>
    <script src="{{ url('js/homepage-slider.js') }}"></script>
    <script src="{{ url('js/ui.js') }}"></script>
    <script src="{{ url('js/moment.js') }}"></script>
    <script src="{{ url('js/recent.js') }}"></script>
    <script src="{{ url('js/map.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmGnhhccwog6j_hFmAo8zg1VaYWE_m7Ak&callback=initMap"></script>
    <script src="{{ url('js/graph.js') }}"></script>

    <script type="text/javascript">   
    
    /*$(document).ready(function() {

       var options = {
         chart: {
            renderTo: 'graph01',
            type: 'column'
         },
         title: {
             text: 'Lelang Umum vs Pengadaan Langsung'
         },
         credits: false,
         xAxis: {
             crosshair: true
         },
         yAxis: {
             min: 0,
             title: {
                 text: 'Nilai Kontrak (Rp)'
             }
         },
         tooltip: {
             headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
             pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                 '<td style="padding:0"><b>Rp. {point.y:,.2f} Milyar</b></td></tr>',
             footerFormat: '</table>',
             shared: true,
             useHTML: true
         },
         plotOptions: {
             column: {
                 pointPadding: 0.2,
                 borderWidth: 0
             }
         },
         lang: {
            decimalPoint: ',',
            thousandsSep: '.'
         },
         series: []
       }

        $.getJSON("{{ url('api/graph/1') }}", function(list) {
          var newseries;

          $.each(list, function (i, item) {
              newseries = {}
              newseries.name = item.name;
              newseries.data = item.data;
              options.series.push(newseries);
          });
          //console.log(options);

          var chart = new Highcharts.chart(options);

        });
    });

    $(document).ready(function() {

       var options = {
         chart: {
            renderTo: 'graph02',
            type: 'column'
         },
         title: {
             text: 'SKPD Anggaran Terbesar Tahun {{ date('Y')}}'
         },
         subtitle: {
            text: 'Lelang dan Pengadaan Langsung'
         },
         credits: false,
         xAxis: {
             categories:[],
             crosshair: true
         },
         yAxis: {
             min: 0,
             title: {
                 text: 'Nilai Kontrak (Rp.)'
             }
         },
         tooltip: {
             headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
             pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                 '<td style="padding:0"><b>Rp. {point.y:,.0f} Milyar</b></td></tr>',
             footerFormat: '</table>',
             shared: true,
             useHTML: true
         },
         plotOptions: {
             column: {
                 pointPadding: 0.2,
                 borderWidth: 0
             }
         },
         lang: {
            decimalPoint: ',',
            thousandsSep: '.'
         },
         series: []
       }

        $.getJSON("{{ url('api/graph/2') }}/{{ date('Y') }}", function(list) {
          var newseries, categories;

          $.each(list, function (i, item) {
              newseries = {};
              newseries.name = item.name;
              newseries.data = item.data;
              options.series.push(newseries);
          });

          //console.log(newseries);
          $.each(newseries.data, function(j, item) {
                categories = {};
                categories = item[0];
                //console.log(item[0]);
                options.xAxis.categories.push(categories);
          });

          //console.log(options);

          var chart = new Highcharts.chart(options);

        });
    });

    $(document).ready(function() {
        var options = {
         chart: {
            renderTo: 'graph03',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
         },
         title: {
            text: 'Pengadaan Langsung {{ date('Y')}}'
        },
        subtitle: {
            text: 'Berdasarkan Jenis Pengadaan melalui BIRMS'
        },
        credits: false,
        lang: {
            decimalPoint: ',',
            thousandsSep: '.'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>Rp. {point.y:.,0f}</b>',
            yDecimals: 2 // If you want to add 2 decimals
        },

        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Total Nilai Kontrak',
            colorByPoint: true,
            data: []
        }]
       }

       $.getJSON("{{ url('api/graph/3') }}/{{ date('Y')}}", function(list) {
          var newdata;

          $.each(list, function (i, item) {
              newdata = {}
              newdata.name = item.name;
              newdata.y = item.y;
              options.series[0].data.push(newdata);
          });
          //console.log(options);

          var chart = new Highcharts.chart(options);

        });
    });  

    $(document).ready(function() {

       var options = {
         chart: {
            renderTo: 'graph04',
            type: 'column'
         },
         title: {
             text: 'Total Paket Pengadaan'
         },
         subtitle: {
            text: 'Lelang dan Pengadaan Langsung'
         },
         credits: false,
         xAxis: {
             crosshair: true
         },
         yAxis: {
             min: 0,
             title: {
                 text: 'Jumlah Paket'
             }
         },
         tooltip: {
             headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
             pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                 '<td style="padding:0"><b>{point.y:,.2f} Paket</b></td></tr>',
             footerFormat: '</table>',
             shared: true,
             useHTML: true
         },
         plotOptions: {
             column: {
                 pointPadding: 0.2,
                 borderWidth: 0
             }
         },
         lang: {
            decimalPoint: ',',
            thousandsSep: '.'
         },
         series: []
       }

        $.getJSON("{{ url('api/graph/4') }}", function(list) {
          var newseries;

          $.each(list, function (i, item) {
              newseries = {}
              newseries.name = item.name;
              newseries.data = item.data;
              options.series.push(newseries);
          });
          //console.log(options);

          var chart = new Highcharts.chart(options);

        });
    });*/

      

// Build the chart
/*Highcharts.chart('graph03', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Pengadaan Langsung'
    },
    subtitle: {
        text: 'Berdasarkan Jenis Pengadaan melalui BIRMS'
    },
    credits: false,
    lang: {
        decimalPoint: ',',
        thousandsSep: '.'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>Rp. {point.y:.,0f}</b>',
        yDecimals: 2 // If you want to add 2 decimals
    },

    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Total Nilai Kontrak',
        colorByPoint: true,
        data: [
            { name: 'Konstruksi', y: 258976287321 },
            { name: 'Pengadaan Barang', y: 220375748634 },
            { name: 'Jasa Konsultansi', y: 33990951527 },
            { name: 'Jasa Lainnya', y: 33990951527 },
            { name: 'N/A', y: 84429619412 }
        ]
    }]
});*/

/*Highcharts.chart('graph04', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Total Paket Pengadaan'
    },
    subtitle: {
        text: 'Indikator Efektif'
    },
    credits: false,
    xAxis: {
        categories: [
            '2013',
            '2014',
            '2015',
            '2016',
            '2017'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nilai Kontrak (Rp)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:,.0f} Paket</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Lelang Umum',
        data: [561, 736, 401, 736, 367]

    }, {
        name: 'Pengadaan Langsung',
        data: [2847, 5007, 7633, 8706, 3731]

    }]
});*/
        </script>