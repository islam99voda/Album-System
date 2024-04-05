@extends('layouts.admin.master')
@section('css')
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('admin/src') }}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/layouts') }}/semi-dark-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/layouts') }}/semi-dark-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
@stop
@section('title', 'Album')

@section('content')
    <h1>App pictuers for Album : {{ $album->name }}</h1>

    <div class="row">
        @foreach ($media as $image)
        <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-4">
            <a class="card style-6" href="{{ $image->getFullUrl() }}">
                <img src="{{ $image->getFullUrl() }}" style="width: 100%; height: 200px; object-fit: cover;" class="card-img-top" alt="...">
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <p>{{ $image->name }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>



@endsection
@section('js')
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <script src="{{ asset('admin/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('admin/src/plugins/src/waves/waves.min.js') }}"></script>
    <script src="{{ asset('admin/layouts/semi-dark-menu/app.js') }}"></script>
    <!-- END GLOBAL MANDATORY STYLES -->
@endsection
