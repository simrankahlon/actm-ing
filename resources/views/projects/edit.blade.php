@extends('layouts.app')

@section('breadcrumb')
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="{{ url('/home') }}">Ideas</a></li>
   <li class="breadcrumb-item"><a href="{{url('/projects')}}">Projects</a></li>
   <li class="breadcrumb-item active">Edit Project</li>
   <li class="breadcrumb-item active">{{$project->name}}</li>
</ol>
@endsection

@section('content')
<div class="card">
    <form action="{{ url('/projects/'.$project->id.'/edit') }}" method="post" id="editForm">
        {{ csrf_field() }}
        <div class="card-header">
            <strong>Edit Project</strong>
        </div>
        <div class="card-block">
            <div class="form-group">
                <label for="name">Name</label> <span style="color:red">*</span>
                <input name ="name" type="text" class="form-control" id="name" placeholder="Project name" value="{{ $project->name }}">
                <span style="color:red">{{ $errors->first('name') }}</span>
            </div>
                            
            <div class="form-group">
                <label for="project_admin">Project Admin</label>&nbsp;<small>(Multi-Select)</small>
                <select id="project_admin" name="project_admin[]" multiple="multiple" data-placeholder="Please Select" class="form-control chosen-select">
                    @php
                        $found = 0;
                    @endphp
                        
                    @foreach($users as $user)
                        @foreach($project->users as $selecteduser)
                            @if($user->id == $selecteduser->id)
                                @php
                                    $found = 1;
                                @endphp
                            @endif  
                        @endforeach     
                        
                        @if($found == 1)
                            <option value="{{$user->id}}" selected="">{{$user->name}}</option>
                        @else
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endif

                        @php
                            $found=0;
                        @endphp        
                    @endforeach
                </select>
            </div>
        </div>
                            
        <div class="card-footer">
            <button type="submit" id="save" class="btn btn-primary">Save changes</button>
            <a href="{{ url('/projects') }}" class="btn btn-default">Cancel</a>
        </div>                      
    </form>
</div>
@endsection
@section('javascriptfunctions')
<script type="text/javascript"> 
$(document).ready(function() {
  $(".chosen-select").chosen({width: "100%"});

});
</script>
@endsection

