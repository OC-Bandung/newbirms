$(function() {

var procurement_data = [
	{
        "y": "2013",
        "competitive": 561,
        "direct": 2847
    }, {
        "y": "2014",
        "competitive": 736,
        "direct": 5007
    }, {
        "y": "2015",
        "competitive": 401,
        "direct": 7633
    }, {
        "y": "2016",
        "competitive": 736,
        "direct": 8711
    }, {
        "y": "2017",
        "competitive": 37,
        "direct": 608
    }];

var sector_data = [
	{
		"s" : "Otonomi Daerah, Pemerintahan Umum, Adm KeuDa, Perangkat Daerah, Kepegawaian",
		"paket" : 3590,
		"anggaran" : 261251366440,
		"hps" : 233866281582,
		"kontrak" : 206179142597
	},
	{
		"s" : "Pekerjaan Umum",
		"paket" : 1543,
		"anggaran" : 269694527510,
		"hps" : 193807364283,
		"kontrak" : 191911113538
	},
	{
		"s" : "Pendidikan",
		"paket" : 426,
		"anggaran" : 230724392330,
		"hps" : 26408277596,
		"kontrak" : 25769835633
	},
	{
		"s" : "Perumahan",
		"paket" : 387,
		"anggaran" : 58398100469,
		"hps" : 50372289158,
		"kontrak" : 49635590774
	},
	{
		"s" : "Komunikasi dan Informatika",
		"paket" : 348,
		"anggaran" : 18336642845,
		"hps" : 21995106233,
		"kontrak" : 21371019140
	}];
 // Line Chart
    Morris.Line({
        element: 'competitive',
        data: procurement_data,
        xkey: 'y',
		xlabels: 'Tahun',
        ykeys: ['competitive', 'direct'],
        labels: ['Competitive', 'Direct Procurement']
    });
	
	// Bar Chart
    Morris.Bar({
        element: 'performance',
        data: procurement_data,
        xkey: 'y',
		xlabels: 'Tahun',
        ykeys: ['competitive', 'direct'],
        labels: ['Competitive', 'Direct Procurement']
    });
	
	// Donut Chart
    Morris.Donut({
        element: 'proc_category',
        data: [
			{label: "Konstruksi", value: 1106},
			{label: "Pengadaan Barang", value: 1045},
			{label: "Jasa Konsultansi", value: 152},
			{label: "Jasa Lainnya", value: 54}
		]
    });
	
	// Bar Chart
    Morris.Bar({
        element: 'sectors',
        data: sector_data,
        xkey: 's',
        ykeys: ['paket', 'anggaran', 'hps', 'kontrak'],
        labels: ['Paket', 'Anggaran', 'HPS', 'Nilai Kontrak']
    });
	
});	
