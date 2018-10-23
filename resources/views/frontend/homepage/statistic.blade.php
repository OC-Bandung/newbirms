<section id="statistik" class="bg-primary pb-5">
    <div class="container mt-5 pt-5">
    <div class="row">
        <div class="col">
        <h3>@lang('homepage.statistic_title')</h3>
        <p>@lang('homepage.statistic_description')</p>
        </div>
    </div>

    <div class="row">

        <div class="col">
        <div id="graph01"></div>
        <div class="text-right bg-white pr-3 pb-3">
                <a target="_blank" href="{{ url('api/graph/1') }}"><i class="material-icons align-bottom pr-1">code</i>json</a>

                <!--<a class="pl-3" id="open-data-graph1" href="{{ url('api/graph/csv/1') }}" target="_blank">   <i class="material-icons align-bottom pr-1">description</i>csv   </a>-->
        </div>
        </div>

        <div class="col">
        <div id="graph02"></div>
        <div class="text-right bg-white pr-3 pb-3">
                <a target="_blank" href="{{ url('api/graph/2') }}/{{ date('Y') }}"><i class="material-icons align-bottom pr-1">code</i>json</a>

                <!--<a class="pl-3" id="open-data-graph1" href="{{ url('api/graph/csv/2') }}/{{ date('Y') }}" target="_blank">   <i class="material-icons align-bottom pr-1">description</i>csv   </a>-->
        </div>
        </div>
    </div>

    <div class="row pt-3">
        <div class="col">
        <div id="graph03"></div>
        <div class="text-right bg-white pr-3 pb-3">
                <a target="_blank" href="{{ url('api/graph/3') }}/{{ date('Y') }}"><i class="material-icons align-bottom pr-1">code</i>json</a>

                <!--<a class="pl-3" id="open-data-graph1" href="{{ url('api/graph/csv/3') }}/{{ date('Y') }}" target="_blank">   <i class="material-icons align-bottom pr-1">description</i>csv   </a>-->
        </div>
        </div>

        <div class="col">
        <div id="graph04"></div>
        <div class="text-right bg-white pr-3 pb-3">
                <a target="_blank" href="{{ url('api/graph/4/') }}{{ date('Y') }}"><i class="material-icons align-bottom pr-1">code</i>json</a>

                <!--<a class="pl-3" id="open-data-graph1" href="{{ url('api/graph/csv/4') }}/{{ date('Y') }}" target="_blank">   <i class="material-icons align-bottom pr-1">description</i>csv   </a>-->
        </div>

        </div>
    </div>

    <div class="row text-center pt-5">
        <div class="col">

        </div>
    </div>

    </div>
</section>
