@extends('layouts.app')

@section('breadcrumb')
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
   <li class="breadcrumb-item"><a href="{{ url('/posts') }}">Posts</a></li>
   <li class="breadcrumb-item active">Edit Post</li>
</ol>
@endsection

@section('content')
<div class="card">
    <form action="{{ url('/posts/'.$post->id.'/edit') }}" method="post">
        {{ csrf_field() }}
        <div class="card-header">
            <strong>Edit Post</strong>
        </div>
        <div class="card-block">
            <div class="form-group">
                <label for="post_title">Post Title</label> <span style="color:red">*</span>
                <input name ="post_title" type="text" class="form-control" id="name" placeholder="Post title" value="{{ $post->title }}">
                <span style="color:red">{{ $errors->first('post_title') }}</span>
            </div>
                            
            <div class="form-group">
                <label for="description">Description</label> <span style="color:red">*</span>
                <textarea name ="description" class="form-control" id="description" placeholder="Description">{{$post->description}}</textarea>
                <span style="color:red">{{ $errors->first('description') }}</span>
            </div>

            <div class="form-group">
                <label for="tag_users">Tag Users</label>&nbsp;<small>(Multi-Select)</small>
                <select id="tag_users" name="tag_users[]" multiple="multiple" data-placeholder="Please Select" class="form-control chosen-select">
                    @php
                        $found = 0;
                    @endphp
                        
                    @foreach($users as $user)
                        @foreach($post->users as $selecteduser)
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

