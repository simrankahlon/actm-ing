@extends('layouts.app')
@section('breadcrumb')
<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Ideas</a></li>
            <li class="breadcrumb-menu">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    
                    <a class="btn btn-secondary" href="{{ url('/projects/create') }}"><i class="icon-plus"></i> &nbsp;Create Project </a>
                </div>
            </li>
           
        </ol>
@endsection

@section('content')
@php
    $user_id=Auth::user()->id;
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <table class="table table-hover table-outline mb-0 hidden-sm-down">
                <thead class="thead-default">
                    <tr>
                        <th>Name</th>
                        <th>Admins</th>
                        <th>Activity</th>
                        <th><div class="float-xs-right">Action</div></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>
                                <div>
                                    <strong><a href="#">{{$project->name}}</a></strong>
                                </div>
                            </td>
                            <td>
                                <div class="float-xs-left">
                                        @php
                                            $user_name = array();
                                            foreach($project->users as $user)
                                            {
                                                $user_name[] = $user->name;
                                            }
                                            $user_array = implode(',', $user_name);
                                        @endphp
                                        @if(empty($user_array))
                                            <div class="float-xs-left text-muted"><strong>-</strong></div>
                                        @else
                                            <div class="float-xs-left text-muted"><strong>{{$user_array}}</strong></div>
                                        @endif
                                </div>
                            </td>
                            <td>
                                <div class="float-xs-left">
                                    <strong>
                                        {{ $project->updated_at->diffForHumans()}}
                                    </strong>                                               
                                </div>
                            </td>
                            <td>
                                <div class="float-xs-right">
                                    <button type="button" id="projectEdit-{{$project->id}}" class="btn btn-outline-primary btn-sm" onclick="window.location.href='{{ url('/projects/'.$project->id.'/edit') }}'">Edit</button>
                                    <button type="button" id="projectDelete-{{$project->id}}" class="btn btn-outline-danger btn-sm" onclick="javascript:confirmDelete('{{ url('/projects/'.$project->id.'/delete') }}')">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" align="right">
                            <nav>
                                {{$projects->links()}}
                            </nav>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('javascriptfunctions')
<script>
function confirmDelete(delUrl) 
{
  if (confirm("Are you sure you want to Delete?")) 
  {
    document.location = delUrl;
  }
}
</script>
@endsection
