
<section>
    <div class="container mt-5">
      <div class="row">
        <div class="col">
          <h3>@lang('homepage.news_title')</h3>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col">

          <div class="card-columns">

                  @foreach ($article as $idx => $row)
                  <div class="card">
                    <div class="card-body">
                      <!--<img class="card-img-top" src="{{ url("assets/media")}}/{{ $row->filename }}" alt="{{ $row->title }}">-->
                      <img class="card-img-top" src="http://localhost/birms2016/assets/media/{{ $row->filename }}" alt="{{ $row->title }}">
                      <a class="text-dark " href="{{ url("post")}}/{{ $row->pst_id }}"> <h5 class="card-title">{{ $row->title }}</h5></a>
                      <p class="card-text">{{ $row->summary }}</p>
                      <p class="card-text"><small class="text-muted">{{ MyGlobals::indo_date($row->created) }}</small> </p>
                      <a href="{{ url("post")}}/{{ $row->pst_id }}" class="btn btn-primary">Selengkapnya</a>
                    </div>
                  </div>
                  @endforeach

            </div>
        </div>
      </div>

      <!--<div class="row">
          <div class="col pt-3 text-center">
              <button type="button" class="btn btn-outline-dark font-primary">Load more</button>
          </div>
        </div>-->
    </div>
</section>