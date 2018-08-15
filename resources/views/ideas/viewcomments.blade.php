@extends('layouts.app')
@section('breadcrumb')
<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
           
            <li class="breadcrumb-item"><a href="{{ url('/ideas') }}">Ideas</a></li>
            <li class="breadcrumb-item active">Comments</li>
            <li class="breadcrumb-menu">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <a class="btn btn-secondary" href="{{ url('/ideas/create') }}"><i class="icon-plus"></i> &nbsp;Create Idea </a>
                </div>
            </li>
           
        </ol>
@endsection

@section('content')
@php
    $url= url("/");
    $user_id=Auth::user()->id;                                               
@endphp
<input type="hidden"  value="{{$url}}" id="url"/>
        <div class="card">
            <div class="card-header">
                <h3>
                    <i class="icon-bubbles"></i> 
                    {{$idea->title}}
                </h3>
                <div class="col-md-2">
                    <strong><i class="icon-user"></i>&nbsp;
                    <small class="text-info">{{App\Idea::userName($idea->user_id)}}</small></strong>
                </div>
                <div class="col-md-8">
                        @php
                            $user_name = array();
                            $users=App\Idea::getTaggedUsers($idea);
                            foreach($users as $user)
                            {
                                $user_name[] = $user->name;
                            }
                            $user_array = implode(',', $user_name);
                        @endphp
                        <strong>
                            <i class="icon-tag"></i>&nbsp;<small class="text-info">{{$user_array}}</small>
                        </strong>
                </div>
                <div class="col-md-2">
                    <h6>
                        <strong>
                            <i class="icon-like"></i>&nbsp;
                            <span class="text-info">{{App\Idea::getLikeCount($idea)}}</span>
                            &nbsp;&nbsp;
                            <i class="icon-user-following"></i>
                            <span class="text-info">{{App\Idea::getViewCount($idea)}}</span>
                        </strong>
                    </h6>
                </div>
            </div>

            <div class="card-block" id="comment-list">
                <div class="form-group">
                    <p id="displayDetails">
                        @php
                            echo $idea->details;
                        @endphp
                    </p>
                    @foreach($idea->comments as $comment)
                        @if($comment->user_id == $user_id)
                            <div class="alert alert-info" role="alert">
                                <div class="text-xs-left">
                                    <div class="row">
                                            <strong style="color:black;"><i class="icon-user"></i>&nbsp;&nbsp;{{App\Comment::userName($comment->user_id)}}</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong><span class="small text-muted">{{ $comment->updated_at->diffForHumans()}}</span>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-10">
                                            &nbsp;&nbsp;&nbsp;{{$comment->comment}}
                                        </div>
                                        <div class="col-md-2">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" value="{{$comment->id}}" class="btn btn-link edit-commentbox" style="color:black;">Edit</button>
                                            <button type="button" value="{{$comment->id}}" class="btn btn-link" style="color:red;" onclick="javascript:confirmDelete('{{ url('/comments/'.$comment->id.'/delete') }}')">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-success" role="alert">
                                <div class="text-xs-left">
                                    <div class="row">
                                        <strong style="color:black;"><i class="icon-user"></i>&nbsp;&nbsp;{{App\Comment::userName($comment->user_id)}}</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong><span class="small text-muted">{{ $comment->updated_at->diffForHumans()}}</span>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$comment->comment}}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="float-xs-right">
                        <button type="button" value="{{$idea->id}}" class="btn btn-block btn-outline-info open-commentbox">Add Comment</button>
                        <input type="hidden" value="{{$idea->id}}" id="idea_id"/>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('modalfun')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label for="comment">Comment</label> <span style="color:red">*</span>
                <textarea name ="comment" class="form-control" id="comment" placeholder="Comment">{{old('comment')}}</textarea>
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btn-save" value="add">Save Changes</button>&nbsp;
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="hidden" id="comment_id" name="comment_id" value="">
      </div>
    </div>
  </div>
</div>
<meta name="_token" content="{!! csrf_token() !!}" />
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

$(document).ready(function()
{
    $('#comment-list').on('click', '.open-commentbox',function()
    { 
        $('#myModal').modal('show');

    });

    $('#comment-list').on('click', '.edit-commentbox',function()
    {  
        var comment_id=$(this).val();
        console.log(comment_id);
        var url = $('#url').val();
        console.log(url);
        $.get(url + '/ajax/comment/'+comment_id, function (data) {
                $('#comment').val(data.comment);
                $('#comment_id').val(data.id);
                $('#myModal').modal('show');
            })

    });

    
});

$(document).ready(function(){ 
    
    $("#displayDetails").html();
});

$('#btn-save').on('click',function(e){ 

        var comment=$("#comment").val();
        var idea_id=$("#idea_id").val();

        var comment_id=$('#comment_id').val();
        

        if(comment=="")
        {
            alert("Please add a Comment");
            return false;
        }

        $('#myModal').modal('hide');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault(); 
        var formData = {
            comment: $("#comment").val(),
            comment_id: $("#comment_id").val(),
        }
        var url = $('#url').val();
        
        var type = "POST";
        

        $.ajax({
            type: type,
            url: url + '/ajax/comment/'+idea_id,
            data: formData,
            dataType: 'json',
            success: function (data) {

                location.reload();

            },
            statusCode: 
                    {
                        401: function()
                        { 
                            window.location.href =url+'/login';
                        }
                    },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
</script>
@endsection
