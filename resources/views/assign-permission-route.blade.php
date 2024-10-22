@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        {{-- Button triger Modal --}}
        <div class="d-flex justify-content-between">
            <h2>Manage Permissions Assignment</h2>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                data-bs-target="#assignPermissionRouteModel">
                Assign Permission to Route
            </button>

        </div>
        <div class="container mt-2 p-0">
            <table class="table table-bordered table-striped mt-2">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Permissions</th>
                        <th scope="col">Route Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($routerPermissions as $permission)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>{{ $permission->permission->name }}</td>
                            <td>{{ $permission->router }}</td>

                            <td>
                                <button class="btn btn-primary editPermissionBtn" data-id="{{ $permission->id }}"
                                    data-permission-id="{{ $permission->permission_id }}"
                                    data-router="{{ $permission->router }}" data-bs-toggle="modal"
                                    data-bs-target="#updatePermissionRouteModel">Edit</button>
                                <button class="btn btn-danger deletePermissionBtn" data-id="{{ $permission->id }}"
                                    data-name="{{ $permission->permission->name }}" data-bs-toggle="modal"
                                    data-bs-target="#deletePermissionRouteModal">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!--Assign Permission to Role Modal -->
        <div class="modal fade" id="assignPermissionRouteModel" tabindex="-1" aria-labelledby="createPermissionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="assignPermissionRouteForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPermissionModalLabel">Assign Permission to Route</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="permissionId">Permission</label>
                                <select name="permission_id" id="permissionId" class="form-control" required>
                                    <option value="">Select Permission</option>
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="route">Route</label>
                                <select name="route" class="form-control" required>
                                    <option value="">Select Route</option>
                                    @foreach ($routeDetails as $route)
                                        <option value="{{ $route['name'] }}">{{ $route['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary assignPermissionRouteBtn">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Update Assign Permission to Role Model --}}
        <div class="modal fade" id="updatePermissionRouteModel" tabindex="-1" aria-labelledby="updatePermissionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="updatePermissionRouteForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="updatePermissionModalLabel"> Update Assign Permission to Route</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="updatePermissionRouteId">

                            <div class="form-group">
                                <label for="permissionId">Permission</label>
                                <select name="permission_id" id="permissionUpdateId" class="form-control" required>
                                    <option value="">Select Permission</option>
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="route">Route</label>
                                <select name="router" class="form-control" id="updateRoute" required>
                                    <option value="">Select Route</option>
                                    @foreach ($routeDetails as $route)
                                        <option value="{{ $route['name'] }}">{{ $route['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary updateAssignPermissionRouteBtn">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Delete Assign Permission to Role Model --}}
        <div class="modal fade" id="deletePermissionRouteModal" tabindex="-1"
            aria-labelledby="deletePermissionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deletePermissionRouteForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="deletePermissionModalLabel">Delete Assign Permission to Route</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="deletePermissionRouteId">
                            <p>Are you sure you want to delete <strong><span
                                        class="delete-permission-role"></span></strong>
                                Permission?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger deleteAssignPermissionRouteBtn">Delete</button>
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

            // Assign Permission to Route
            $('#assignPermissionRouteForm').on('submit', function(e) {
                e.preventDefault();
                $('.assignPermissionRouteBtn').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('createPermissionRoute') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('.assignPermissionRouteBtn').prop('disabled', false);
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            // Update Assign Permission to Route
            $('.editPermissionBtn').on('click', function() {
                var id = $(this).data('id');
                var permissionId = $(this).data('permission-id');
                var route = $(this).data('router');
                console.log(route, id, permissionId);
                $('#updatePermissionRouteId').val(id);
                $('#permissionUpdateId').val(permissionId);
                $('#updateRoute').val(route);
            });

            $('#updatePermissionRouteForm').on('submit', function(e) {
                e.preventDefault();
                $('.updateAssignPermissionRouteBtn').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('updatePermissionRoute') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('.updateAssignPermissionRouteBtn').prop('disabled', false);
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
            // Delete Assign Permission to Route
            $('.deletePermissionBtn').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                $('#deletePermissionRouteId').val(id);
                $('.delete-permission-role').text(name);
            });
            $('#deletePermissionRouteForm').on('submit', function(e) {
                e.preventDefault();
                $('.deleteAssignPermissionRouteBtn').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('deletePermissionRoute') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('.deleteAssignPermissionRouteBtn').prop('disabled', false);
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
