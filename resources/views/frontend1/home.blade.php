@extends('frontend.layouts.main')

@section('header')
    
    <div class="intro">
        <!--nav-->
        @include('frontend.layouts.pages-nav') 

        @include('frontend.homepage.search')

    </div>  

    @include('frontend.homepage.statistics')

@endsection


@section('content')

    @include('frontend.homepage.welcome')

    @include('frontend.homepage.graphs')

    @include ('frontend.homepage.map')

    @include('frontend.homepage.recent-procurement')

    @include ('frontend.homepage.open-data')

    @include ('frontend.homepage.blog')


    @include ('frontend.homepage.contact')

@endsection