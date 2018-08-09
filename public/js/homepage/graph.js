$(document).ready(function() {

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

       var getUrl = window.location;
       var virtualUrl = "/newbirms_json/public";
       var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1]+virtualUrl;

       //console.log(baseUrl);
        $.getJSON(baseUrl+"/api/graph/1", function(list) {
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

       var $currentDate = new Date();
       $currYear = $currentDate.getFullYear();

       var options = {
         chart: {
            renderTo: 'graph02',
            type: 'column'
         },
         title: {
             text: 'SKPD Anggaran Terbesar Tahun Ini / Telah Berjalan'
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

       $.getJSON("https://birms.bandung.go.id/beta/api/graph/2/"+$currYear, function(list) {

         console.log(list);
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
        var $currentDate = new Date();
        $currYear = $currentDate.getFullYear();

        var options = {
         chart: {
            renderTo: 'graph03',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
         },
         title: {
            text: 'Pengadaan Langsung Tahun Ini / Telah Berjalan'
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

       $.getJSON("https://birms.bandung.go.id/beta/api/graph/3/"+$currYear, function(list) {
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

        $.getJSON("https://birms.bandung.go.id/beta/api/graph/4", function(list) {
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
