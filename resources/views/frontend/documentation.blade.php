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
              <div class="h4 p-2 text-light">Table of Contents</div>
              <div class="list-group text-light list-group-flush list-group-dark">
                <a class="list-group-item active" id="list-summary-list" doc="{{ url('documentation-files/1-summary.md') }}">Summary (TLDR;)</a>
                <a class="list-group-item" id="list-operations-list"  doc="{{ url('documentation-files/2-queries.md') }}">Endpoints</a>
                <a class="list-group-item" id="list-ocds-list"        doc="{{ url('documentation-files/ocds.md') }}">Data fields</a>
                <a class="list-group-item" id="list-curl-list"        doc="{{ url('documentation-files/3-download.md') }}">Downloading the data & converting to CSV</a>
                <a class="list-group-item" id="list-queries-list"     doc="{{ url('documentation-files/queries.md') }}">Advanced queries</a>
                <a class="list-group-item" id="list-ocds-list"        doc="{{ url('documentation-files/usecase.md') }}">Use cases: ideas for what to build</a>
                <a class="list-group-item" id="list-opensource-list"  doc="{{ url('documentation-files/opensource.md') }}">Open source directory: projects using the data</a>
                <a class="list-group-item" id="list-help-list"        doc="{{ url('documentation-files/help.md') }}">Help and community</a>
              </div>
            </div>

            <div id="documentation-content" class="col p-3">

            </div>
          </div>
    </div>
  </section>

@endsection

@section('footer')
  <script type="text/javascript" src="{{ url('js/documentation/markdown-it.min.js') }}"> </script>
  <script type="text/javascript" src="{{ url('js/documentation/ui.js') }}"> </script>
@endsection