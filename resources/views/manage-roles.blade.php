@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h2>Manage Roles</h2>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                Create Role
            </button>
        </div>
        <div class="container mt-2">
            <table class="table table-bordered table-striped mt-2">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($roles as $role)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $role->name }}</td>
                            <td>
                                @if (strtolower($role->name) != 'user')
                                    <button href="" class="btn btn-primary">Edit</button>
                                    <button type="button" class="btn btn-danger deleteRoleBtn"
                                        data-id="{{ $role->id }}" data-name="{{ $role->name }}" data-bs-toggle="modal"
                                        data-bs-target="#deleteRoleModal">Delete</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!--Delete Role Modal -->
        <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deleteRoleForm">
                        @csrf
                        {{-- @method('DELETE') --}}
                        <div class="modal-header">

                            <h5 class="modal-title" id="deleteRoleModalLabel">Delete Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="role_id" id="deleteRoleId">
                            <p>Are you sure you want to delete this <strong><span class="delete-role"></span></strong> Role?
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


        <!--Create Role Modal -->
        <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('createRole') }}" id="createRoleForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createRoleModalLabel">Create Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <input type="text" class="form-control" id="role" name="role"
                                    placeholder="Enter role">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary createRoleBtn">Create</button>
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
            $('#createRoleForm').on('submit', function(e) {
                e.preventDefault();
                $('.createRoleBtn').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('createRole') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('.createRoleBtn').prop('disabled', false);
                        if (response.success) {
                            // alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            // Delete Role

            $('.deleteRoleBtn').on('click', function() {
                var roleId = $(this).data('id');
                var roleName = $(this).data('name');

                $('#deleteRoleId').val(roleId);
                $('.delete-role').text(roleName);
            })

            $('#deleteRoleForm').on('submit', function(e) {
                e.preventDefault();
                $('.confirmDeleteBtn').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('deleteRole') }}",
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

        });
    </script>
@endpush
