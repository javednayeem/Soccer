@extends('layouts.admin')
@section('title', 'Gallery')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box p-3">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Upload form --}}
                <form action="{{ route('admin.gallery.upload') }}" method="POST" enctype="multipart/form-data" class="form-inline mb-3">
                    @csrf
                    <input type="file" name="images[]" class="form-control-file mr-2 mb-1" accept="image/*" multiple required>
                    <button type="submit" class="btn btn-sm btn-dark waves-effect waves-light mb-1">
                        <i class="mdi mdi-upload mr-1"></i>Upload Images
                    </button>
                    <small class="text-muted ml-2">jpg, png, gif, webp &middot; max 5MB each</small>
                </form>

                <h5 class="mb-3">Gallery ({{ count($images) }})</h5>

                <div class="row">
                    @forelse($images as $image)
                        <div class="col-6 col-md-4 col-lg-3 mb-3">
                            <div class="card h-100 mb-0">
                                <a href="{{ $image['url'] }}" target="_blank">
                                    <img src="{{ $image['url'] }}" alt="{{ $image['name'] }}" class="card-img-top"
                                         style="height: 180px; object-fit: cover;">
                                </a>
                                <div class="card-body p-2 d-flex justify-content-between align-items-center">
                                    <small class="text-truncate mr-2" title="{{ $image['name'] }}">{{ $image['name'] }}</small>

                                    <form action="{{ route('admin.gallery.delete') }}" method="POST"
                                          onsubmit="return confirm('Delete this image permanently?');">
                                        @csrf
                                        <input type="hidden" name="image" value="{{ $image['name'] }}">
                                        <button type="submit" class="btn btn-xs btn-danger waves-effect waves-light" title="Delete Image">
                                            <i class="fe-trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted py-5">No images found in the gallery.</div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

@endsection
