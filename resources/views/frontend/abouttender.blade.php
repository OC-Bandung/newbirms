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
              <div class="h4 p-2 text-light">Daftar Isi</div>
              <div class="list-group text-light list-group-flush list-group-dark">
                <a class="list-group-item active" id="list-pendahuluan-list" doc="{{ url('about-tender-files/pendahuluan.md') }}">Pendahuluan</a>
                <a class="list-group-item" id="list-belanja-list" doc="{{ url('about-tender-files/belanja.md') }}">Belanja Barang/Jasa</a>
                <a class="list-group-item" id="list-barangjasa-list" doc="{{ url('about-tender-files/barangjasa.md') }}" >Apa itu Barang/Jasa</a>
                <a class="list-group-item" id="list-carapengadaan-list" doc="{{ url('about-tender-files/carapengadaan.md') }}" >Cara Pengadaan</a>
                <a class="list-group-item" id="list-pengadaan-list" doc="{{ url('about-tender-files/pengadaan.md') }}" >Apa itu Pengadaan?</a>
                <a class="list-group-item" id="list-istilah-list" doc="{{ url('about-tender-files/istilah.md') }}" >Daftar Istilah</a>
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