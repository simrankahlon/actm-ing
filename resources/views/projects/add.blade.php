@extends('layouts.app')

@section('breadcrumb')
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="{{ url('/home') }}">Ideas</a></li>
   <li class="breadcrumb-item"><a href="{{url('/projects')}}">Projects</a></li>
   <li class="breadcrumb-item active">Add Project</li>
</ol>
@endsection

@section('content')
<div class="card">
    <form action="{{ url('/projects/create') }}" method="post" id="addForm">
        {{ csrf_field() }}
        <div class="card-header">
            <strong>New Project</strong>
        </div>
        <div class="card-block">
            <div class="form-group">
                <label for="name">Project Name</label> <span style="color:red">*</span>
                <input name ="name" type="text" class="form-control" id="name" placeholder="Project name" value="{{ old('name') }}">
                <span style="color:red">{{ $errors->first('name') }}</span>
            </div>         
           
            <div class="form-group">
                <label for="project_admin">Project Admins</label>&nbsp;<small>(Multi-Select)</small>
                <select id="project_admin" name="project_admin[]" multiple="multiple" data-placeholder="Please Select" class="form-control chosen-select">
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
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




