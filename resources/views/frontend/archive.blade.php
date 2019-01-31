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
            Arsip Aplikasi BIRMS Sepanjang Masa
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row">
        @for ($i = 2013; $i <= 2018; $i++)
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
              <img class="card-img-top" src="{{ url('img/archive/'.$i.'.jpg') }}" alt="Thumbnail BIRMS">
              <div class="card-body">
                <p class="card-text">Pengembangan BIRMS TA {{ $i }} </p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="location.href='{{ url($i)}}';">Lihat Detail</button>
                  </div>
                  <small class="text-muted">{{ $i }}</small>
                </div>
              </div>
            </div>
          </div>
        @endfor  
      </div>
    </div>
  </section>

@endsection

@section('footer')
@endsection