@extends('frontend.layouts.main')

@section('header')
    @include('frontend.layouts.nav')
@endsection

@section('content')

<section class="bg-primary inner-image-banner">
      <div class="container">
        <div class="row  pt-5 pb-5">
          <div class="col">
            <div class="text-white">
              <div class="h3 d-inline-block">OC-Explorer</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container pt-5">
        <div class="row">
          <div class="col">
            <h3>My lists</h3>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <h5> <a id="watch-list-create" href="#"> + create a new list </a></h5>
          </div>
        </div>
        <div id="watch-list-input-container" class="row pb-5 d-none">
          <div class="col-4 bg-dark text-light p-3 ml-3">
                <div class="alert alert-danger d-none" role="alert">
                    List name already exists, please choose another.
                </div>
                <label> List name</label>
                <input id="watch-list-input" type="text" class="form-control rounded-0" aria-label="Create watch list" aria-describedby="inputGroup-sizing-default">
                <button id="watch-list-input-submit" type="button" class="btn btn-outline-light btn-secondary btn-sm mt-2 float-right rounded-0">Create</button>
          </div>
        </div>
      </div>
    </section>

    <section>

       <div id="watch-list-sample" class="watch-list border-bottom d-none">
         <div class="row p-3 watch-list-header bg-dark text-white ">
          <div class="col-8">
            <div class="h5  watch-list-title "></div>
          </div>
          <div class="col-4 float-right text-uppercase">
            <div class="fetch-update small d-inline mr-2"><a class="text-white"  href="#"> <div class="lds-dual-ring d-none"></div> fetch updates</a></div>
            <div class="small d-inline mr-2">export</div>
            <div class="small d-inline mr-2">delete</div>
          </div>
        </div>
        <div class="watch-list-content row  d-none">
          <div class="col-12">
            <ul class="watch-list-ocid list-group list-group-flush">
            </ul>
          </div>
        </div>

      </div>
      <div id="watch-list-container" class="container">
      </div>
    </section>

    <section>
      <div class="container mt-5">
        <div class="row">
          <div class="col-6 h3"> <i class="material-icons">trending_up</i> Trending tenders  <small>(> 10 tenderers)</small> </div>
        </div>
        <div class="row">
          <div id="trending-tender-container"></div>
          <div id="trending-tender-sample" class="col d-none">
            <div class="card">
              <div class="card-body">
                <div class="trending-tender-numberOfTenderers-container">
                  <div class="h6 trending-tender-numberOfTenderers d-inline"></div> <div class=" d-inline"> Tenderers</div>
                </div>
                <a href="#"><div class="trending-tender-title card-title h5"></div></a>
                <div class="trending-tender-subtitle card-subtitle mb-2 text-muted mb-3"></div>
                <div class="card-text">
                  <div class="row">
                    <div class="col trending-tender-status-container">
                      <div class="h6">Status</div>
                      <div class="trending-tender-status h5"></div>
                    </div>
                    <div class="col trending-tender-value-amount-container">
                      <div class="h6">Value</div>
                      <div class="trending-tender-value-amount h5"></div>
                    </div>
                    <div class="col trending-tender-mainProcurementCategory-container">
                      <div class="h6">Category</div>
                      <div class="trending-tender-mainProcurementCategory h5"></div>
                    </div>
                    <div class="col trending-tender-tenderPeriod-endDate-container">
                      <div class="h6">End Date</div>
                      <div class="trending-tender-tenderPeriod-endDate h5"></div>
                    </div>
                  </div>
                </div>
                <a href="#" class="card-link">View</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
@endsection

@section('footer')
    <script type="text/javascript" src="{{ url('js/shared.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/watched-lists/ui.js') }}"></script>  
@endsection