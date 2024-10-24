<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">{{ auth()->user()->name }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="{{ route('users') }}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="{{ route('manageRole') }}">Roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="{{ route('managePermission') }}">Permissions</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('assignPermissionRole') }}" class="nav-link">Assign Permission - Role</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('assignPermissionRoute') }}" class="nav-link">Assign Permission - Route</a>
                </li>

            </ul>
            <button class="btn btn-danger float-end logout-user">Logout</button>

        </div>
    </div>
</nav>
