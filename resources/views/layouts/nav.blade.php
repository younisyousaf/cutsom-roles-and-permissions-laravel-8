<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href={{ route('loadDashboard') }}>{{ auth()->user()->name }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                @if (auth()->user()->hasPermissionsToRoute('users'))
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="{{ route('users') }}">Users</a>
                    </li>
                @endif
                @if (auth()->user()->hasPermissionsToRoute('manageRole'))
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="{{ route('manageRole') }}">Roles</a>
                    </li>
                @endif
                @if (auth()->user()->hasPermissionsToRoute('managePermission'))
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="{{ route('managePermission') }}">Permissions</a>
                    </li>
                @endif
                @if (auth()->user()->hasPermissionsToRoute('assignPermissionRole'))
                    <li class="nav-item">
                        <a href="{{ route('assignPermissionRole') }}" class="nav-link">Assign Permission - Role</a>
                    </li>
                @endif
                @if (auth()->user()->hasPermissionsToRoute('assignPermissionRoute'))
                    <li class="nav-item">
                        <a href="{{ route('assignPermissionRoute') }}" class="nav-link">Assign Permission - Route</a>
                    </li>
                @endif

            </ul>
            <button class="btn btn-danger float-end logout-user">Logout</button>

        </div>
    </div>
</nav>
