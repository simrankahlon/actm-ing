@php
    $project_id="";
    if(Session::has('is_projectadmin'))
    {
        $project_id=Session::get('is_projectadmin');
    }
@endphp
<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link nav-dropdown-toggle" href="{{ url('/home') }}"><i class="icon-bubbles fa-lg mt-4"></i>Ideas</a>
            </li>
            @can('add_admin')
            <li class="divider"></li>
            <li class="nav-title">
                Admin
            </li>
            @if(auth()->user()->can('project_admin_'.$project_id) or auth()->user()->can('add_admin'))
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
            @endif
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="{{url('/users')}}"><i class="icon-people"></i>Users</a>
                </li>
            @endcan
        </ul>
    </nav>
</div>



