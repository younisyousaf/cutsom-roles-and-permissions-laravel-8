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
                        <th scope="col">Permissions</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissionsWithRoles as $permission)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                @foreach ($permission->roles as $role)
                                    @if (!$loop->last)
                                        {{ $role->name }},
                                    @else
                                        {{ $role->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-primary editPermissionBtn" data-id="{{ $permission->id }}"
                                    data-bs-toggle="modal" data-bs-target="#updateAssignPermissionRoleModel">Edit</button>
                                <button class="btn btn-danger deletePermissionBtn" data-bs-toggle="modal"
                                    data-bs-target="#deleteAssignPermissionRoleModel" data-id="{{ $permission->id }}"
                                    data-name="{{ $permission->name }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
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
                                <label for="permissionId">Permission</label>
                                <select name="permission_id" id="permissionId" class="form-control" required>
                                    <option value="">Select Permission</option>
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="dropdown">
                                <button type="button"
                                    class="form-control dropdown-toggle w-100 d-flex align-items-center justify-content-between">Select
                                    Roles</button>
                                <div class="dropdown-content w-100">
                                    @foreach ($roles as $role)
                                        <label>
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <label for="roleId">Role</label>
                                <select name="role_id" id="roleId" class="form-control" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
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
        {{-- Update Assign Permission to Role Model --}}
        <div class="modal fade" id="updateAssignPermissionRoleModel" tabindex="-1"
            aria-labelledby="updateAssignPermissionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="updateAssignPermissionRoleForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateAssignPermissionModalLabel">Update Assign Permission
                                to Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="permissionId">Permission</label>
                                <select name="permission_id" id="updatePermissionId" class="form-control" required>
                                    <option value="">Select Permission</option>
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="roleId">Role</label>

                                <!-- Dropdown for multi-select -->
                                <div class="dropdown">
                                    <button type="button"
                                        class="form-control dropdown-toggle w-100 d-flex align-items-center justify-content-between">Select
                                        Roles</button>
                                    <input type="hidden" name="roles" id="selectedOptions">
                                    <div class="dropdown-content w-100">
                                        @foreach ($roles as $role)
                                            <label>
                                                <input type="checkbox" name="roles[]" value="{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary updateAssignPermissionRoleBtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Delete Assign Permission to Role Model --}}
        <div class="modal fade" id="deleteAssignPermissionRoleModel" tabindex="-1"
            aria-labelledby="deleteAssignPermissionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deleteAssignPermissionRoleForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteAssignPermissionModalLabel">Delete Assign Permission
                                to Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="permission_id" id="deleteAssignPermissionId">
                            <p>Are you sure you want to delete <strong><span
                                        class="delete-permission-role"></span></strong>
                                Permission?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger deleteAssignPermissionRoleBtn">Delete</button>
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
            // Update Role
            $('#updateAssignPermissionRoleForm').on('submit', function(e) {
                e.preventDefault();
                $('.updateAssignPermissionRoleBtn').prop('disabled', true);
                if ($('#selectedOptions').val() == "") {
                    alert('Please select at least one role');
                    return false;
                }

                let formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('updatePermissionRole') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('.updateAssignPermissionRoleBtn').prop('disabled', false);
                        if (response.success) {
                            // alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                })
            })
        });
        // Delete Assign Permission-Role
        $('.deletePermissionBtn').on('click', function(e) {
            e.preventDefault();
            var permissionId = $(this).data('id');
            var permissionName = $(this).data('name');
            $('#deleteAssignPermissionId').val(permissionId);
            $('.delete-permission-role').text(permissionName);

        });
        $('#deleteAssignPermissionRoleForm').on('submit', function(e) {
            e.preventDefault();
            $('.deleteAssignPermissionRoleBtn').prop('disabled', true);
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('deletePermissionRole') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    $('.deleteAssignPermissionRoleBtn').prop('disabled', false);
                    if (response.success) {
                        // alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        });

        // Dropdown
        document.addEventListener('DOMContentLoaded', function() {
            // Select the button and dropdown content
            const dropdownButton = document.querySelector('.dropdown button');
            const dropdownContent = document.querySelector('.dropdown-content');
            const selectedRoles = [];

            // Toggle the dropdown when the button is clicked
            dropdownButton.addEventListener('click', function(event) {
                event.stopPropagation();
                dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' :
                    'block';
            });

            // Close the dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!dropdownContent.contains(event.target) && !event.target.closest('.dropdown')) {
                    dropdownContent.style.display = 'none';
                }
            });

            // Listen for checkbox changes and update the button text
            const checkboxes = dropdownContent.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        selectedRoles.push(this.nextSibling.textContent.trim());
                    } else {
                        const index = selectedRoles.indexOf(this.nextSibling.textContent.trim());
                        if (index !== -1) {
                            selectedRoles.splice(index, 1);
                        }
                    }

                    updateSelectedRoles();
                });
            });

            // Function to update the hidden input field with selected role IDs
            function updateSelectedRoles() {
                if (selectedRoles.length > 0) {
                    dropdownButton.textContent = selectedRoles.join(', ');
                    $('#selectedOptions').val(selectedRoles.join(',')); // Update hidden input field
                } else {
                    dropdownButton.textContent = 'Select Roles';
                    $('#selectedOptions').val(''); // Clear hidden input if no roles are selected
                }
            }
        });
    </script>
@endpush
