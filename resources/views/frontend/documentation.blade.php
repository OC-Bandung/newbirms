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
            Developer Documentation
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container-fluid p-0 ">
        <div class="row no-gutters">
            <div class="col-3 bg-dark h6">
              <div class="h4 p-3 text-light">Table of Contents</div>
              <div class="list-group text-light list-group-flush list-group-dark">
                <a class="list-group-item active" id="list-summary-list" doc="{{ url('documentation-files/summary.md') }}">Summary (TLDR;)</a>
                <a class="list-group-item" id="list-request-list" doc="{{ url('documentation-files/request.md') }}">How to request the data</a>
                <a class="list-group-item" id="list-operations-list"   doc="{{ url('documentation-files/operations.md') }}" >The three types of operations (find, list and count)</a>
                <a class="list-group-item" id="list-settings-list"  doc="{{ url('documentation-files/settings.md') }}">The query parameters</a>
                <a class="list-group-item" id="list-http-list" doc="{{ url('documentation-files/http.md') }}" >Getting the data via http requests</a>
                <a class="list-group-item" id="list-curl-list"  doc="{{ url('documentation-files/curl.md') }}" >Downloading the data via curl requests</a>
                <a class="list-group-item" id="list-code-list" doc="{{ url('documentation-files/code.md') }}" >Examples with Javascript, Python and R</a>
                <a class="list-group-item" id="list-csv-list" doc="{{ url('documentation-files/csv.md') }}">Turning the data into csv</a>
                <a class="list-group-item" id="list-queries-list"    doc="{{ url('documentation-files/queries.md') }}"  >Advanced queries</a>
                <a class="list-group-item" id="list-ocds-list"   doc="{{ url('documentation-files/ocds.md') }}"  >Understanding the fields - Data Standard documentation</a>
                <a class="list-group-item" id="list-ocds-list"  doc="{{ url('documentation-files/usecase.md') }}" >Use cases: ideas for what to build</a>
                <a class="list-group-item" id="list-opensource-list"  doc="{{ url('documentation-files/opensource.md') }}" >Open source directory: projects using the data</a>
                <a class="list-group-item" id="list-help-list"  doc="{{ url('documentation-files/help.md') }}">Help and community</a>
              </div>
            </div>

            <div id="documentation-content" class="col p-5">

            </div>
          </div>
    </div>
  </section>

@endsection

@section('footer')
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ url('js/documentation/markdown-it.min.js') }}"> </script>
  <script type="text/javascript" src="{{ url('js/documentation/ui.js') }}"> </script>
@endsection