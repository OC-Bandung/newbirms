<section>
<div class="container-fluid m-0 p-0">
  <div class="row justify-content-center">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="{{ url('')}}"><img src="{{ url('img/birms.png') }}"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navBIRMS" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class="collapse navbar-collapse" id="navBIRMS">
            <ul class="navbar-nav mr-auto list-inline mb-0  mt-2 border-bottom-1px">
              <li class="nav-item @if(Request::url() === url('')) active @endif">
                <a class="nav-link" href="{{ url('')}}">Beranda <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  APPS
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  @foreach ($app as $x => $rw)
                  <div>
                      <a class="dropdown-item text-dark" href="{{ $rw['Link'] }}">{{ $rw['Name'] }}<br>
                      <small class="alert-link">{{ $rw['Desc'] }}</small>
                      </a>
                  </div>
                    @if ($loop->last)

                    @else
                    <div class="dropdown-divider"></div>
                    @endif
                  @endforeach
                </div>
              </li>
              <!--<li class="nav-item">
                <a class="nav-link" href="#">Berita</a>
              </li>-->
              <li class="nav-item">
                <a class="nav-link @if(Request::is('archive/*')) active @endif" href="{{ url('archive') }}">Arsip</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link @if(Request::url() === url('abouttender')) active @endif" href="{{ url('abouttender') }}">Tentang Pengadaan</a>
              </li>
              <li class="nav-item @if(Request::url() === url('documentation')) active @endif">
                  <a class="nav-link" href="{{ url('documentation') }}">Developer</a>
              </li>
              <li class="nav-item @if(Request::url() === url('download')) active @endif">
                <a class="nav-link" href="{{ url('download') }}">Download Data</a>
            </li>  
            </ul>
          </div>
      </nav>
  </div>
</section>