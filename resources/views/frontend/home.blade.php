@extends('frontend.layouts.main')

@section('header')

    @include('frontend.layouts.nav')

    @include('frontend.homepage.search')

@endsection

@section('content')

    @include('frontend.homepage.dashboard')

    @include('frontend.homepage.aboutnews')

    @include('frontend.homepage.statistic')

    @include('frontend.homepage.procurementmap')

    @include('frontend.homepage.currprocurement')

    <!--include('frontend.homepage.ocinformation')-->

    @include('frontend.homepage.newsupdate')

    @include('frontend.homepage.appsquestion')

@endsection

@section('footer')
<script type="text/javascript" src="{{ url('js/homepage/graph.js') }}"></script>
<script type="text/javascript" src="{{ url('js/homepage/recent.js') }}"></script>
@endsection