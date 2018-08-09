@extends('frontend.layouts.main')

@section('header')

    @extends('frontend.layouts.nav')

    @include('frontend.homepage.search')

@endsection

@section('content')

    @include('frontend.homepage.dashboard')

    @include('frontend.homepage.aboutnews')

    @include('frontend.homepage.statistic')

    @include('frontend.homepage.procurementmap')

    @include('frontend.homepage.currprocurement')

    @include('frontend.homepage.ocinformation')

    @include('frontend.homepage.newsupdate')

    @include('frontend.homepage.appsquestion')

@endsection

@section('footer')

@endsection