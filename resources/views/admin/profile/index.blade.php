@extends('layouts.admin')
@section('title', $user->name)

@section('content')

    <div class="row">

        <div class="col-md-4">
            <div class="card-box text-center">
                <img src="{{ env('APP_PATH') }}/images/users/{{ $user->user_image }}" class="rounded-circle avatar-lg img-thumbnail"
                     alt="profile-image">

                <h4 class="mb-2">{{ $user->name }}</h4>

                <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Change Password</button>

                <div class="text-left mt-3">

                    <p class="mb-2 font-13"><strong>Name :</strong> <span class="ml-2">{{ $user->name }}</span></p>
                    <p class="mb-2 font-13"><strong>Email :</strong> <span class="ml-2">{{ $user->email }}</span></p>
                    <p class="mb-2 font-13"><strong>Role :</strong> <span class="ml-2">{{ ucfirst($user->role) }}</span></p>
                    @if($user->position != 'none')
                        <p class="mb-2 font-13"><strong>Position :</strong> <span class="ml-2">{{ ucfirst($user->position) }}</span></p>
                    @endif
                    <p class="mb-2 font-13"><strong>Phone :</strong> <span class="ml-2">{{ $user->phone }}</span></p>
                    <p class="mb-2 font-13"><strong>Address :</strong> <span class="ml-2">{{ $user->address }}</span></p>

                </div>

            </div>

        </div>

        <div class="col-md-8">
            <div class="card-box">
                <ul class="nav nav-pills navtab-bg nav-justified">

                    <li class="nav-item">
                        <a href="#profile-information" data-toggle="tab" aria-expanded="true" class="nav-link active">
                            Profile Information
                        </a>
                    </li>

                </ul>

                <div class="tab-content">

                    <div class="tab-pane show active" id="profile-information">

                        @if (session()->get('status') == 'success')
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                User Information Has Been Updated!
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" action="{{ route('profile.edit') }}" method="post" enctype="multipart/form-data" autocomplete="off">

                            @csrf

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone No.</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <select class="form-control" id="position" name="position">
                                            <option value="none" {{ $user->position == 'none' ? 'selected':'' }}>None</option>
                                            <option value="defender" {{ $user->position == 'defender' ? 'selected':'' }}>Defender</option>
                                            <option value="midfielder" {{ $user->position == 'midfielder' ? 'selected':'' }}>Midfielder</option>
                                            <option value="striker" {{ $user->position == 'striker' ? 'selected':'' }}>Striker</option>
                                            <option value="goalkeeper" {{ $user->position == 'goalkeeper' ? 'selected':'' }}>Goal Keeper</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control" id="address" name="address">{{ $user->address }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_image">Profile Picture</label>
                                        <input type="file" name="user_image" accept="image/*" onchange="viewSelectedImage(this, 'user_image');" class="form-control-file @error('user_image') parsley-error @enderror">
                                        @if ($errors->has('user_image'))
                                            <p class="float-left text-danger">
                                                <strong>{{ $errors->first('user_image') }}</strong>
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="product-box">
                                        <div class="product-action">
                                            {{--<a href="javascript: void(0);" class="btn btn-success btn-xs waves-effect waves-light"><i class="mdi mdi-pencil"></i></a>--}}
                                            <a href="javascript: void(0);" onclick="removeProfilePicture();" class="btn btn-danger btn-xs waves-effect waves-light">
                                                <i class="mdi mdi-close mr-1"></i>Remove
                                            </a>
                                        </div>

                                        <div>
                                            <img id="user_image" src="/images/users/{{ Auth::user()->user_image }}" alt="{{ Auth::user()->name }}" class="img-fluid rounded float-right">
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                            </div>

                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
