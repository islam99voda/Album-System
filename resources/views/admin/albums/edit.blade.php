@extends('layouts.admin.master')
@section('css')

@stop
@section('title')
    Edit Album
@stop

@section('content')

    <h1>Edit Album :</h1>
    <div class="col-lg-12 col-12  layout-spacing">
        <div class="statbox widget box box-shadow">

            <div class="widget-content widget-content-area">
                @if (session('edit'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('edit') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form autocomplete="off" method="POST" action="{{ route('album.update', $album->id) }}">
                    @csrf
                    @method('put')
                        <div class="form-group mb-4">
                        <input type="text" placeholder="new name" name="name"
                        value="{{ $album->name }}" class="form-control " id="name">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-reply-all-fill"></i> Submit
                    </button>
                    </form>
                <hr>


            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
