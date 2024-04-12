@extends('layouts.admin.master')

@push('css')
    <link href="{{ asset('admin/assets/css/file-pond.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/file-pond-image-perview.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/file-pond-image-edit.css') }}" rel="stylesheet" />
@endpush

@section('title', "Add New Pic / Album $album->name")

@section('content')
    <h1>Add New Pic / Album {{ $album->name }} </h1>
    <div>
        <button type="button" class="btn btn-primary btn-sm add_image">Add Another Image</button>
    </div>
    <hr class="my-2">
    <form autocomplete="off" method="POST" enctype="multipart/form-data"
        action="{{ route('album.store_photos', $album->id) }}">
        @csrf
        <div class="row images">

        </div>
        <hr>
        <button class="btn btn-primary mt-3" type="submit">Save</button>
    </form>



@endsection


@push('js')
    <script src="{{ asset('admin/assets/js/file-pond-image-edit.js') }}"></script>
    <script src="{{ asset('admin/assets/js/file-pond-exif.js') }}"></script>
    <script src="{{ asset('admin/assets/js/file-pond-validate-size.js') }}"></script>
    <script src="{{ asset('admin/assets/js/file-pond-image-perview.js') }}"></script>
    <script src="{{ asset('admin/assets/js/file-pond.js') }}?v=12"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        let index = 0;
        $(document).ready(function() {
            appendNewImageUploader();
        });
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageExifOrientation,
            FilePondPluginFileValidateSize,
            FilePondPluginImageEdit
        );

        $('.add_image').click(appendNewImageUploader);

        function appendNewImageUploader() {
            let componentImage = document.createElement('div');
            componentImage.className = 'col-4';
            componentImage.innerHTML = `<div class="border rounded-2 p-2">
                    <div class="form-group mb-4">
                        <label class="fs-5">Name</label>
                        <input type="text" placeholder="type Name Album" required name="data[${index}][name]" class="form-control" >
                    </div>

                    <div class="form-group mb-4">
                        <label class="fs-5">Upload Images</label>
                        <input type="file" required multiple class="filepond" name="data[${index}][filepond]" data-max-file-size="2MB">
                    </div></div>`;

            document.querySelector('.row.images').appendChild(componentImage);
            let pond = FilePond.create(
                componentImage.querySelector('.filepond')
            );

            pond.setOptions({
                server: {
                    process: {
                        url: "{{ route('store_temp') }}", //url where the image will be uploaded
                        ondata: (formData) => {
                            formData.append('_token', '{{ csrf_token() }}');
                            return formData;
                        },
                    },

                    revert: {
                        url: `{{ route('delete_temp') }}`,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            '_method': 'DELETE'
                        }
                    },
                },
            });
            console.log(pond.getFiles());
            index++;
        }
    </script>
@endpush
