@extends('frontend.layouts.main')

@section('header')
    @include('frontend.layouts.nav')
@endsection

@section('content')

<section class="bg-primary inner-image-banner">
    <div class="container">
      <div class="row  pt-3 pb-5">
        <div class="col">
          <div class="h3 text-white">
            Tentang Pengadaan
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container-fluid p-0 ">
        <div class="row no-gutters">
            <div class="col-3 bg-dark h6">
              <div class="list-group text-light list-group-flush list-group-dark">
                <a class="list-group-item active" id="list-sekilas-list" doc="{{ url('about-tender-files/1-sekilas.md') }}">Sekilas tentang Pengadaan Barang/Jasa</a>
                <a class="list-group-item" id="list-pelaksanaan-list" doc="{{ url('about-tender-files/2-pelaksanaan.md') }}">Pelaksanaan Pengadaan Barang/Jasa Melalui Penyedia</a>
                <a class="list-group-item" id="list-tahapan-list" doc="{{ url('about-tender-files/3-tahapan.md') }}">Untuk Dipahami Tahapan Pengadaan Menggunakan OC Explorer</a>
                <a class="list-group-item" id="list-belanja-list" doc="{{ url('about-tender-files/4-belanja.md') }}">Apa yang dibelanjakan Pemerintah Kota Bandung melalui proses Pengadaan Barang dan Jasa?</a>
              </div>
            </div>

            <div id="documentation-content" class="col p-5">

            </div>
          </div>
    </div>
  </section>

@endsection

@section('footer')
  <script type="text/javascript" src="{{ url('js/documentation/markdown-it.min.js') }}"> </script>
  <script type="text/javascript" src="{{ url('js/documentation/ui.js') }}"> </script>
@endsection