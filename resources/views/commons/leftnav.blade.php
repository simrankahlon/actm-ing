<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link nav-dropdown-toggle" href="{{ url('/home') }}"><i class="icon-bubbles fa-lg mt-4"></i>Ideas</a>
            </li>
            @can('add_projectadmin')
            <li class="divider"></li>
            <li class="nav-title">
                Admin
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i>Projects</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/projects/create') }}" target="_top"><i class="icon-arrow-right"></i>Create</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/projects') }}" target="_top"><i class="icon-arrow-right"></i>List</a>
                    </li>
                </ul>
            </li>
            @endcan
        </ul>
    </nav>
</div>



