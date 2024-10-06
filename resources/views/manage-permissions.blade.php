@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h2>Manage Permissions</h2>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                Create Permission
            </button>
        </div>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Permission</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $permission->name }}</td>
                        <td>
                            <button href="" class="btn btn-primary editPermissionBtn" data-id="{{ $permission->id }}"
                                data-name="{{ $permission->name }}" data-bs-toggle="modal"
                                data-bs-target="#updatePermissionModal">Edit</button>
                            <button type="button" class="btn btn-danger deletePermissionBtn"
                                data-id="{{ $permission->id }}" data-name="{{ $permission->name }}" data-bs-toggle="modal"
                                data-bs-target="#deletePermissionModal">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Create Permission Model --}}
    <div class="modal fade" id="createPermissionModal" tabindex="-1" aria-labelledby="createPermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('createPermission') }}" id="createPermissionForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPermissionModalLabel">Create Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="permission">Permission</label>
                            <input type="text" class="form-control" id="permission" name="permission"
                                placeholder="Enter permission">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary createPermissionBtn">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Update Permission Modal --}}
    <div class="modal fade" id="updatePermissionModal" tabindex="-1" aria-labelledby="updatePermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="updatePermissionForm">
                    @csrf
                    <input type="hidden" name="permission_id" id="updatePermissionId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updatePermissionModalLabel">Update Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="permission">Permission</label>
                            <input type="text" class="form-control" id="updatePermissionName" name="permission"
                                placeholder="Enter permission">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary updatePermissionBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Delete Permission Modal  --}}
    <div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-labelledby="deletePermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="deletePermissionForm">
                    @csrf
                    <div class="modal-header">

                        <h5 class="modal-title" id="deletePermissionModalLabel">Delete Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="permission_id" id="deletePermissionId">
                        <p>Are you sure you want to delete this <strong><span class="delete-permission"></span></strong>
                            Permission?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger confirmDeleteBtn">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- Script --}}
@push('script')
    <script>
        $(document).ready(function() {
            // Create Permission
            $('#createPermissionForm').on('submit', function(e) {
                e.preventDefault();
                $('.createPermissionBtn').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('createPermission') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('.createPermissionBtn').prop('disabled', false);
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                })
            })
            //Update Permission
            $('.editPermissionBtn').on('click', function() {
                var permissionId = $(this).data('id');
                var permissionName = $(this).data('name');

                $('#updatePermissionId').val(permissionId);
                $('#updatePermissionName').val(permissionName);

            })

            $('#updatePermissionForm').on('submit', function(e) {
                e.preventDefault();
                $('.updatePermissionBtn').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('updatePermission') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('.updatePermissionBtn').prop('disabled', false);
                        if (response.success) {
                            // alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
            // Delete Permission
            $('.deletePermissionBtn').on('click', function() {
                var permissionId = $(this).data('id');
                var permissionName = $(this).data('name');

                $('#deletePermissionId').val(permissionId);
                $('.delete-permission').text(permissionName);
            })

            $('#deletePermissionForm').on('submit', function(e) {
                e.preventDefault();
                $('.confirmDeleteBtn').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('deletePermission') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('.confirmDeleteBtn').prop('disabled', false);
                        if (response.success) {
                            // alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        })
    </script>
@endpush
