@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <h2>Manage Roles</h2>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
            Create Role
        </button>

        <!-- Modal -->
        <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
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
                            alert(response.message);
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
