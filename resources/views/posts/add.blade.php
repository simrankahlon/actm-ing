@extends('layouts.app')

@section('breadcrumb')
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
   <li class="breadcrumb-item"><a href="{{ url('/posts') }}">Ideas</a></li>
   <li class="breadcrumb-item active">Add Post</li>
</ol>
@endsection

@section('content')
<div class="card">
    <form action="{{ url('/posts/create') }}" method="post">
        {{ csrf_field() }}
        <div class="card-header">
            <strong>New Idea</strong>
        </div>
        <div class="card-block">
            <div class="form-group">
                <label for="title">Title</label> <span style="color:red">*</span>
                <input name ="title" type="text" class="form-control" id="name" placeholder="Title" value="{{ old('title') }}">
                <span style="color:red">{{ $errors->first('post_title') }}</span>
            </div>
                            
            <div class="form-group">
                <label for="details">Details</label> <span style="color:red">*</span>
                <textarea name ="details" class="form-control" id="details" placeholder="Details">{{old('details')}}</textarea>
                <span style="color:red">{{ $errors->first('details') }}</span>
            </div>
            
            <div class="form-group">
                <label for="tag_users">Tag Users</label>&nbsp;<small>(Multi-Select)</small>
                <select id="tag_users" name="tag_users[]" multiple="multiple" data-placeholder="Please Select" class="form-control chosen-select">
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>

        </div>
                            
        <div class="card-footer">
            <button type="submit" id="save" class="btn btn-primary">Save changes</button>
            <a href="{{ url('posts') }}" class="btn btn-default">Cancel</a> 
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




