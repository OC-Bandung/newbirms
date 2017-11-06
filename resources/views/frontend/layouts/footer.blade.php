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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmGnhhccwog6j_hFmAo8zg1VaYWE_m7Ak&callback=initMap">
    </script>
    <script src="{{ url('js/map.js') }}"></script>

    <script type="text/javascript">
Highcharts.chart('graph01', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Lelang Umum vs Pengadaan Langsung'
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
            '<td style="padding:0"><b>{point.y:.1f} Milyar</b></td></tr>',
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
        data: [49.9, 71.5, 106.4, 129.2, 144.0]

    }, {
        name: 'Pengadaan Langsung',
        data: [83.6, 78.8, 98.5, 93.4, 106.0]

    }]
});


Highcharts.chart('graph02', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'SKPD Anggaran Terbesar Tahun 2017'
    },
    subtitle: {
        text: 'Indikator Efektif'
    },
    credits: false,
    xAxis: {
        categories: [
            'Dinas Perhubungan',
            'Dinas Pangan Dan Pertanian',
            'Dinas Kesehatan',
            'Badan Pengelolaan Pendapatan Daerah',
            'Dinas Pemuda Dan Olah Raga'
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
            '<td style="padding:0"><b>Rp. {point.y:.1f}</b></td></tr>',
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
        name: 'Nilai Kontrak',
        data: [20136816864, 10292959665, 8292752999, 8178939745, 7876687127]
    }]
});

// Build the chart
Highcharts.chart('graph03', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Jenis Pengadaan'
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
                format: '{point.percentage:,.1f}',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Jenis Pengadaan',
        data: [
            { name: 'Konstruksi', y: 258976287321 },
            { name: 'Pengadaan Barang', y: 220375748634 },
            { name: 'Jasa Konsultansi', y: 33990951527 },
            { name: 'Jasa Lainnya', y: 33990951527 },
            { name: 'N/A', y: 84429619412 }
        ]
    }]
});


Highcharts.chart('graph04', {
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
            '<td style="padding:0"><b>{point.y:.1f} Paket</b></td></tr>',
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
});
        </script>