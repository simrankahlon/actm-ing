@extends('layouts.app')

@section('breadcrumb')
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
   <li class="breadcrumb-item"><a href="{{ url('/posts') }}">Posts</a></li>
   <li class="breadcrumb-item active">Add Post</li>
</ol>
@endsection

@section('content')
<div class="card">
    <form action="{{ url('/posts/create') }}" method="post">
        {{ csrf_field() }}
        <div class="card-header">
            <strong>New Post</strong>
        </div>
        <div class="card-block">
            <div class="form-group">
                <label for="post_title">Post Title</label> <span style="color:red">*</span>
                <input name ="post_title" type="text" class="form-control" id="name" placeholder="Post title" value={{ old('post_title') }}>
                <span style="color:red">{{ $errors->first('post_title') }}</span>
            </div>
                            
            <div class="form-group">
                <label for="description">Description</label> <span style="color:red">*</span>
                <textarea name ="description" class="form-control" id="description" placeholder="Description">{{old('description')}}</textarea>
                <span style="color:red">{{ $errors->first('description') }}</span>
            </div>
        </div>
                            
        <div class="card-footer">
            <button type="submit" id="save" class="btn btn-primary">Save changes</button>
            <a href="{{ old('page') }}" class="btn btn-default">Cancel</a> 
        </div>                      
    </form>
</div>
@endsection



