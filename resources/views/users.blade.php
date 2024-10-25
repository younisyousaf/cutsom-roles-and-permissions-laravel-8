@extends('layouts.layout')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h2>Manage Users</h2>
            <!-- Button trigger modal -->
            {{-- This will check the permission if this route has permission to create user, If not the button will not show --}}
            @if (auth()->user()->hasPermissionsToRoute('createUser'))
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModel">
                    Create User
                </button>
            @endif

        </div>

        <div class="mt-4">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hasEditPermission = auth()->user()->hasPermissionsToRoute('editUser');
                        $hasDeletePermission = auth()->user()->hasPermissionsToRoute('deleteUser');
                    @endphp
                    @foreach ($users as $user)
                        {{-- dd($user); --}}
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role->name }}</td>
                            <td>
                                @if ($hasEditPermission)
                                    <button class="btn btn-primary editUserBtn" data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                        data-role-id="{{ $user->role->id }}" data-bs-toggle="modal"
                                        data-bs-target="#updateUserModal">Edit</button>
                                @endif
                                @if ($hasDeletePermission)
                                    <button class="btn btn-danger deleteUserBtn" data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}" data-bs-toggle="modal"
                                        data-bs-target="#deleteUserModal">Delete</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Create User Modal --}}
        <div class="modal fade" id="createUserModel" tabindex="-1" aria-labelledby="createUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="createUserForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">User Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter user name">

                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email address">

                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password">

                            </div>
                            <div class="form-group">
                                <label for="roleId">Role</label>
                                <select name="role" id="roleId" class="form-control">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary createUserBtn">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Update User Modal --}}
        <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="updateUserForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateUserModalLabel">Update User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="updateUserId">
                            <div class="form-group">
                                <label for="">User Name</label>
                                <input type="text" name="name" id="updateName" class="form-control"
                                    placeholder="Enter user name">

                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" id="updateEmail" class="form-control"
                                    placeholder="Enter email address">

                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Enter password">

                            </div>
                            <div class="form-group">
                                <label for="updateRoleId">Role</label>
                                <select name="role" id="updateRoleId" class="form-control">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary updateUserBtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Delete User Modal --}}
        <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deleteUserForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel">Update User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="deleteUserId">
                            <p>Are you sure you want to delete <strong class="delete-user"></strong></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger confirmDeleteUserBtn">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            // Create User
            $('#createUserForm').on('submit', function(e) {
                e.preventDefault();
                $('.createUserBtn').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('createUser') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('.createUserBtn').prop('disabled', false);
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
            // Update User
            $('.editUserBtn').on('click', function() {
                $('#updateUserId').val($(this).data('id'));
                $('#updateName').val($(this).data('name'));
                $('#updateEmail').val($(this).data('email'));
                $('#updateRoleId').val($(this).data('role-id'));

            });
            $('#updateUserForm').on('submit', function(e) {
                e.preventDefault();
                $('.updateUserBtn').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('updateUser') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('.updateUserBtn').prop('disabled', false);
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
            // Delete User
            $('.deleteUserBtn').on('click', function() {
                $('#deleteUserId').val($(this).data('id'));
                $('.delete-user').text($(this).data('name'));

            });
            $('#deleteUserForm').on('submit', function(e) {
                e.preventDefault();
                $('.confirmDeleteUserBtn').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('deleteUser') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('.confirmDeleteUserBtn').prop('disabled', false);
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
@endpush
