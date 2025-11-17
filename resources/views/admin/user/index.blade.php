@extends('layouts.admin')
@section('title', "Player")

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box p-2">

                <div class="row">
                    <div class="col-md-12">

                        <div class="text-right">
                            <button type="button" class="btn btn-dark waves-effect waves-light m-b-30" data-toggle="modal" data-target="#add_user_modal">
                                <i class="md md-add"></i> Add New User
                            </button>
                        </div>

                        <table class="table table-sm table-bordered table-striped table-hover mt-3">

                            <thead>
                            <tr>
                                <th></th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($users as $user)
                                <tr id="user_{{ $user->id }}">
                                    <th scope="row">
                                        <img src="/images/users/{{ $user->user_image }}" alt="image" class="img-fluid avatar-sm rounded-circle">
                                    </th>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>{{ formatDate($user->created_at) }}</td>
                                    <td>
                                        <button class="btn btn-xs btn-icon waves-effect waves-light btn-primary" onclick="editUser('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->user_image }}', '{{ $user->role }}')"> <i class="fe-edit"></i> </button>
                                        <button class="btn btn-xs btn-icon waves-effect waves-light btn-danger" onclick="deleteUser({{ $user->id }})"> <i class="fe-trash-2"></i> </button>
                                    </td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="add_user_modal" class="modal bounceInDown animated">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label">Name</label>
                                <input type="text" class="form-control" id="name" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="control-label">Username</label>
                                <input type="text" class="form-control" id="email" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password" class="control-label">Password</label>
                                <input type="text" class="form-control" id="password" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="role" class="control-label">Role</label>
                                <select id="role" class="form-control">
                                    <option value="player">Player</option>
                                    <option value="admin">Admin</option>
                                </select>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="designation" class="control-label">Designation</label>
                                <input type="text" class="form-control" id="designation" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="responsibility" class="control-label">Responsibility</label>
                                <textarea class="form-control" id="responsibility"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_image" class="control-label">User Image</label>
                                <input type="file" class="form-control" id="user_image" name="user_image" onchange="viewSelectedImage(this, 'add_user_image');">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <img id="add_user_image" src="" alt="logo" class="img-fluid rounded float-right" style="width: 50%" onerror="this.onerror=null; this.src='/images/users/default_user.png'">
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-blue waves-effect waves-light" data-dismiss="modal" id="add_user_button">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="edit_user_modal" class="modal bounceInDown animated">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">

                    <input type="hidden" id="user_id" value="0">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_name" class="control-label">Name</label>
                                <input type="text" class="form-control" id="edit_name" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_email" class="control-label">Username</label>
                                <input type="text" class="form-control" id="edit_email" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_role" class="control-label">Role</label>
                                <select id="edit_role" class="form-control">
                                    <option value="player">Player</option>
                                    <option value="admin">Admin</option>
                                </select>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_designation" class="control-label">Designation</label>
                                <input type="text" class="form-control" id="edit_designation" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_responsibility" class="control-label">Responsibility</label>
                                <textarea class="form-control" id="edit_responsibility"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_user_image" class="control-label">User Image</label>
                                <input type="file" class="form-control" id="edit_user_image" name="edit_user_image" onchange="viewSelectedImage(this, 'update_user_image');">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <img id="update_user_image" src="" alt="logo" class="img-fluid rounded float-right" style="width: 50%" onerror="this.onerror=null; this.src='/images/users/default_user.png'">
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-blue waves-effect waves-light" data-dismiss="modal" id="edit_user_button">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
