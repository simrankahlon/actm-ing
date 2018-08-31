@php
    $project_id="";
    if(Session::has('project_id'))
    {
        $project_id=Session::get('project_id');
    }
@endphp
<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link nav-dropdown-toggle" href="{{ url('/home') }}"><i class="icon-bubbles fa-lg mt-4"></i>Ideas</a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user fa-lg mt-4"></i>My Ideas</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/user/ideas') }}" target="_top"><i class="icon-arrow-right"></i>Ideas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/user/ideas/drafts') }}" target="_top"><i class="icon-arrow-right"></i>Drafts</a>
                    </li>
                </ul>
            </li>
            @canany(['admin_project_'.$project_id,'add_admin'])
            <li class="divider"></li>
            <li class="nav-title">
                Admin
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-layers"></i>Projects</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/projects/create') }}" target="_top"><i class="icon-arrow-right"></i>Create</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/projects') }}" target="_top"><i class="icon-arrow-right"></i>List</a>
                    </li>
                </ul>
            </li>
            @endcanany
            @can('add_admin')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="{{url('/users')}}"><i class="icon-people"></i>Users</a>
                </li>
            @endcan
        </ul>
    </nav>
</div>



