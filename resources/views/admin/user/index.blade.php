@extends('layouts.admin')
@section('title', 'Users')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box p-2">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="form-inline">
                            <div class="form-group mr-2">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search by name or email..." value="{{ isset($filters['search']) ? $filters['search'] : '' }}">
                            </div>
                            <div class="form-group mr-2">
                                <select class="form-control" id="roleFilter">
                                    <option value="">All Roles</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}" {{ ( isset($filters['role']) ? $filters['role'] : '') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-primary" onclick="applyFilters()">
                                <i class="fe-search mr-1"></i> Search
                            </button>
                            <button class="btn btn-secondary ml-1" onclick="clearFilters()">
                                <i class="fe-refresh-cw mr-1"></i> Clear
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <button type="button" class="btn btn-dark waves-effect waves-light" data-toggle="modal" data-target="#add_user_modal">
                            <i class="fe-plus mr-1"></i> Add New User
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th width="50px"></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th width="120px" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr id="user_{{ $user->id }}">
                                        <td>
                                            <img src="/admin/images/users/{{ $user->user_image }}" alt="image" class="img-fluid avatar-sm rounded-circle" onerror="this.src='/admin/images/users/default_user.png'">
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'manager' ? 'info' : 'primary') }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $user->user_status == '1' ? 'success' : 'secondary' }}">
                                                {{ $user->user_status == '1' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-primary mr-1" onclick="editUser('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->user_image }}', '{{ $user->role }}')">
                                                    <i class="fe-edit"></i>
                                                </button>
                                                <button class="btn btn-info mr-1" onclick="changePasswordModal('{{ $user->id }}', '{{ $user->name }}')">
                                                    <i class="fe-lock"></i>
                                                </button>
                                                <button class="btn btn-danger" onclick="deleteUser({{ $user->id }})">
                                                    <i class="fe-trash-2"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fe-users display-4 text-muted"></i>
                                            <h5 class="text-muted mt-2">No Users Found</h5>
                                            <p class="text-muted">No users match your search criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="add_user_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label">Name *</label>
                                <input type="text" class="form-control" id="name" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="control-label">Email *</label>
                                <input type="email" class="form-control" id="email" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="control-label">Password *</label>
                                <input type="password" class="form-control" id="password" autocomplete="new-password" required>
                                <small class="form-text text-muted">Minimum 6 characters</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role" class="control-label">Role *</label>
                                <select id="role" class="form-control" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="control-label">Phone</label>
                                <input type="text" class="form-control" id="phone" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_image" class="control-label">User Image</label>
                                <input type="file" class="form-control" id="user_image" name="user_image" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address" class="control-label">Address</label>
                                <textarea class="form-control" id="address" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add_user_button">Save User</button>
                </div>
            </div>
        </div>
    </div>

    <div id="edit_user_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-2">
                    <input type="hidden" id="user_id" value="0">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_name" class="control-label">Name *</label>
                                <input type="text" class="form-control" id="edit_name" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_email" class="control-label">Email *</label>
                                <input type="email" class="form-control" id="edit_email" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_phone" class="control-label">Phone</label>
                                <input type="text" class="form-control" id="edit_phone" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_role" class="control-label">Role *</label>
                                <select id="edit_role" class="form-control" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_team_id" class="control-label">Team</label>
                                <select id="edit_team_id" class="form-control">
                                    <option value="0">Select Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_address" class="control-label">Address</label>
                                <textarea class="form-control" id="edit_address" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_user_image" class="control-label">User Image</label>
                                <input type="file" class="form-control" id="edit_user_image" name="edit_user_image" accept="image/*">
                                <small class="form-text text-muted">Leave empty to keep current image</small>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="edit_user_button">Update User</button>
                </div>
            </div>
        </div>
    </div>

    <div id="changePasswordModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Change Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="password_user_id">
                    <div class="form-group">
                        <label for="new_password">New Password *</label>
                        <input type="password" class="form-control" id="new_password" required>
                        <small class="form-text text-muted">Minimum 6 characters</small>
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password *</label>
                        <input type="password" class="form-control" id="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="change_password_button">Change Password</button>
                </div>
            </div>
        </div>
    </div>

@endsection
