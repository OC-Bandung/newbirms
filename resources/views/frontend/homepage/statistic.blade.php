<section class="bg-light pb-5">
    <div class="container mt-5 pt-5">
    <div class="row">
        <div class="col">
        <h3>@lang('homepage.statistic_title')</h3>
        <p>@lang('homepage.statistic_description')</p>
        </div>
    </div>

    <div class="row">

        <div class="col-6">
        <div id="graph01" style="min-width: 100%;  height: 400px; margin: 0 auto"></div>
        <div class="text-right bg-white pr-3 pb-3">
                <a target="_blank" href="{{ url('api/graph/1') }}"><i class="material-icons align-bottom pr-1">code</i>json</a>

                <a class="pl-3" id="open-data-graph1" href="{{ url('api/graph/csv/1') }}" target="_blank">   <i class="material-icons align-bottom pr-1">description</i>csv   </a>
        </div>
        </div>

        <div class="col-6">
        <div id="graph02" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
        <div class="text-right bg-white pr-3 pb-3">
                <a target="_blank" href="{{ url('api/graph/2/2017') }}"><i class="material-icons align-bottom pr-1">code</i>json</a>

                <a class="pl-3" id="open-data-graph1" href="{{ url('api/graph/csv/2/2017') }}" target="_blank">   <i class="material-icons align-bottom pr-1">description</i>csv   </a>
        </div>
        </div>
    </div>

    <div class="row pt-3">
        <div class="col-6">
        <div id="graph03" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
        <div class="text-right bg-white pr-3 pb-3">
                <a target="_blank" href="{{ url('api/graph/3/2017') }}"><i class="material-icons align-bottom pr-1">code</i>json</a>

                <a class="pl-3" id="open-data-graph1" href="{{ url('api/graph/csv/3/2017') }}" target="_blank">   <i class="material-icons align-bottom pr-1">description</i>csv   </a>
        </div>
        </div>

        <div class="col-6">
        <div id="graph04" style="min-width: 100%; height: 400px; margin: 0 auto"></div>
        <div class="text-right bg-white pr-3 pb-3">
                <a target="_blank" href="{{ url('api/graph/4/2017') }}"><i class="material-icons align-bottom pr-1">code</i>json</a>

                <a class="pl-3" id="open-data-graph1" href="{{ url('api/graph/csv/4/2017') }}" target="_blank">   <i class="material-icons align-bottom pr-1">description</i>csv   </a>
        </div>

        </div>
    </div>

    <div class="row text-center pt-5">
        <div class="col">
        
        </div>
    </div>

    </div>
</section>
