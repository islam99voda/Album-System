@extends('layouts.admin.master')
@section('css')

@stop
@section('title')
    Add New Album
@stop

@section('content')
    <h1>All Albums</h1>
    <div class="col-lg-12 col-12  layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-md-nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-center fs-5">#</th>
                                <th scope="col" class="text-center fs-5">Name</th>
                                <th scope="col" class="text-center fs-5 text-info">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($albums as $album)
                                <tr>
                                    <td class="text-center fs-5"> {{ $loop->iteration }}</td>
                                    <td class="text-center fs-5">{{ $album->name }}</td>
                                    <td class="text-center fs-5">
                                        <div>
                                            <a href="{{ route('album.show', $album->id) }}"
                                                class="btn btn-lg btn-success d-inline-block">Show <i
                                                    class="bi bi-pencil-square"></i></a>
                                            <a href="{{ route('album.add_pic', $album->id) }}"
                                                class="btn btn-lg btn-info d-inline-block">Add pic <i
                                                    class="bi bi-pencil-square"></i></a>

                                                    <a href="{{ route('album.edit', $album->id) }}"
                                                        class="btn btn-lg btn-primary d-inline-block">Edit <i
                                                            class="bi bi-pencil-square"></i></a>

                                            <a data-media-count="{{ $album->getMedia('images')->count() }}"
                                                data-id="{{ $album->id }}"
                                                class="btn btn-lg btn-danger d-inline-block delete_album">Delete <i
                                                    class="bi bi-pencil-square"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $('.delete_album').click(function(e) {
            e.preventDefault();
            let $this = $(this);
            // console.log($this.parents('tbody').find('tr').length);
            let album = $this.data('id');
            Swal.fire({
                title: "What Do you want ?",
                showDenyButton:true ,
                showConfirmButton: ($this.parents('tbody').find('tr').length > 1),
                showCancelButton: true,
                confirmButtonText: "Move Photos",
                denyButtonText: $this.data('media-count') ? `Delete All Photos And Album` : "Delete Album",
            }).then((result) => {





                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    $.ajax({
                        url: `{{ route('album.albums_except') }}`,
                        data: {
                            id: album
                        },
                        success: async function(response) {
                            // console.log(response);
                            const {
                                value: newAlbum
                            } = await Swal.fire({
                                title: "album",
                                input: "select",
                                inputOptions: response.albums,
                                inputPlaceholder: "Select Another Album To Move",
                                showCancelButton: true,

                            });
                            if (newAlbum) {
                                console.log(newAlbum);
                                $.ajax({
                                    url: `{{ route('album.move_photos', 'item') }}`
                                        .replace('item', album),
                                    method: 'POST',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        new_album_id: newAlbum
                                    },
                                    success: function(response) {
                                        Swal.fire("Success Moved and delete", "",
                                            "success").then(function() {
                                            window.location.reload();
                                        });
                                    }
                                })
                            }


                        }
                    })
                } else if (result.isDenied) {
                    $.ajax({
                        url: `{{ route('album.delete', 'item') }}`.replace('item', album),
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire("Success Deleted", "", "success").then(function() {
                                window.location.reload();
                            });
                        }
                    })
                }
            });
        });
    </script>
@endpush
