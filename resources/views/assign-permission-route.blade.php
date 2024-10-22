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
                                <button class="btn btn-primary editPermissionBtn">Edit</button>
                                <button class="btn btn-danger deletePermissionBtn">Delete</button>
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
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {


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

        });
    </script>
@endpush
