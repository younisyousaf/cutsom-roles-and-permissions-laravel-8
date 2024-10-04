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
        })
    </script>
@endpush
