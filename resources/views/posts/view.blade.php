@extends('layouts.app')
@section('breadcrumb')
<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
           
            <li class="breadcrumb-item active">Posts</li>
            <li class="breadcrumb-menu">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    
                    <a class="btn btn-secondary" href="{{ url('/posts/create') }}"><i class="icon-plus"></i> &nbsp;Create Post </a>
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
                        <th class="text-xs-center"><i class="icon-people"></i>
                        <th>User</th>
                        <th>Title</th>
                        <th>Activity</th>
                        <th>Tagged</th>
                        <th><div class="float-xs-right">Action</div></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td class="text-xs-center">
                            @if(App\Post::checkIfTagged($post))
                                <strong><i class="icon-tag"></i></strong>
                            @endif
                                
                                <div class="avatar">
                                    <img src="{{ asset('img/user-icon.png') }}" class="img-avatar" alt="Client Logo">
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong><a href="#">{{App\Post::userName($post->user_id)}}</a></strong>
                                </div>
                            </td>
                            <td>
                                <div class="float-xs-left">
                                    <a href="#">{{$post->title}}</a>
                                </div>
                            </td>
                            <td>
                                <div class="float-xs-left">
                                    <strong>
                                        {{ $post->updated_at->diffForHumans()}}
                                    </strong>                                               
                                </div>
                            </td>
                            <td>
                                <div class="float-xs-left">
                                        @php
                                            $user_name = array();
                                            $users=App\Post::getTaggedUsers($post);
                                            foreach($users as $user)
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
                                <div class="float-xs-right">
                                    @if($post->user_id == $user_id)
                                        <button type="button" id="postEdit-{{$post->id}}" class="btn btn-outline-primary btn-sm" onclick="window.location.href='{{ url('/posts/'.$post->id.'/edit') }}'">Edit</button>
                                        <button type="button" id="postDelete-{{$post->id}}" class="btn btn-outline-danger btn-sm" onclick="javascript:confirmDelete('{{ url('/posts/'.$post->id.'/delete') }}')">Delete</button>
                                    @endif
                                    <button type="button" id="postComment-{{$post->id}}" class="btn btn-outline-success btn-sm" onclick="window.location.href='{{ url('/posts/'.$post->id.'/comments') }}'">View</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" align="right">
                            <nav>
                                {{$posts->links()}}
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
