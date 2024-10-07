@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h2>Manage Permissions Assignment</h2>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignPermissionRoleModel">
                Assign Permission to Role
            </button>
        </div>
        <div class="container mt-2 p-0">
            <table class="table table-bordered table-striped mt-2">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Role</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>



        <!--Assign Permission to Role Modal -->
        <div class="modal fade" id="assignPermissionRoleModel" tabindex="-1" aria-labelledby="createPermissionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="assignPermissionRoleForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPermissionModalLabel">Assign Permission to Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="roleId">Role</label>
                                <select name="role_id" id="roleId" class="form-control" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="permissionId">Permission</label>
                                <select name="permission_id" id="permissionId" class="form-control" required>
                                    <option value="">Select Permission</option>
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary assignPermissionRoleBtn">Assign</button>
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
            // Create Role
            $('#assignPermissionRoleForm').on('submit', function(e) {
                e.preventDefault();
                $('.assignPermissionRoleBtn').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('createPermissionRole') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('.assignPermissionRoleBtn').prop('disabled', false);
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
