@extends('layouts.app')
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Ideas</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/projects') }}">Projects</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/projects/'.$project->id.'/ideas') }}">{{$project->name}}</a></li>
    <li class="breadcrumb-item active">Idea</li>
</ol>
@endsection

@section('content')
@php
    $url= url("/");
    $user_id=Auth::user()->id;
    $rating_type="";
    if(!empty($idea_rating))
    {
        $rating_type=$idea_rating->rating_type;
    }                                            
@endphp
<meta name="_token1" content="{!! csrf_token() !!}" />
<input type="hidden"  value="{{$url}}" id="url"/>
        <div class="card">
            <div class="card-header">
                <h3>
                    <i class="icon-bubbles"></i> 
                    {{$idea->problem_statement}}
                </h3>
                <div class="col-md-5">
                    <strong><i class="icon-user"></i>&nbsp;
                    <small class="text-info">{{App\Idea::userName($idea->user_id)}}</small></strong>
                    <div>
                        <strong><i class="icon-layers"></i>&nbsp;
                        <small class="text-info">{{App\Idea::getProjectName($idea->project_id)}}</small></strong>       
                    </div>
                    <div>
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
                </div>
                <div class="col-md-7">
                    <h6>
                        <strong>

                            <!-- Like -->
                            @if($user_id==$idea->user_id)
                                <i class="icon-like" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="Like" style="font-size:115%;">
                                </i>
                            @else
                                <a href="#" class="nav-link addRating" style="color:black;" id="like">
                                    @if($rating_type=='like')
                                        <i class="icon-like text-danger" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="Like" style="font-size:115%;">
                                        </i>
                                    @else
                                        <i class="icon-like" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="Like" style="font-size:115%;">
                                        </i>
                                    @endif
                                </a>
                            @endif
                            <span class="text-info" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="@php
                                $list=App\Idea::getList($idea,'like');
                                foreach($list as $user)
                                {
                                    echo $user->name;
                                    echo "<br>";
                                }
                                @endphp">
                                {{App\Idea::getCount($idea,'like')}}
                            </span>
                            &nbsp;

                            <!-- DisLike -->
                            @if($user_id==$idea->user_id)
                                <i class="icon-dislike" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="DisLike" style="font-size:115%;">
                                </i>
                            @else
                                <a href="#" class="nav-link addRating" style="color:black;" id="dislike">
                                    @if($rating_type=='dislike')
                                        <i class="icon-dislike text-danger" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="DisLike" style="font-size:115%;">
                                        </i>
                                    @else
                                        <i class="icon-dislike" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="DisLike" style="font-size:115%;">
                                        </i>
                                    @endif
                                </a>
                            @endif
                            <span class="text-info" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="@php
                                $list=App\Idea::getList($idea,'dislike');
                                foreach($list as $user)
                                {
                                    echo $user->name;
                                    echo "<br>";
                                }
                                @endphp">
                                {{App\Idea::getCount($idea,'dislike')}}
                            </span>
                            &nbsp;

                            <!-- Needs work -->
                            @if($user_id==$idea->user_id)
                                <i class="icon-pencil" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="needs work">
                                </i>
                            @else
                                <a href="#" class="nav-link addRating" style="color:black;" id="needs_work">
                                    @if($rating_type=='needs_work')
                                        <i class="icon-pencil text-danger" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="needs work">
                                        </i>
                                    @else
                                        <i class="icon-pencil" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="needs work">
                                        </i>
                                    @endif
                                </a>
                            @endif
                            <span class="text-info" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="@php
                                $list=App\Idea::getList($idea,'needs_work');
                                foreach($list as $user)
                                {
                                    echo $user->name;
                                    echo "<br>";
                                }
                                @endphp">
                                {{App\Idea::getCount($idea,'needs_work')}}
                            </span>
                            &nbsp;

                            <!-- vague -->
                            @if($user_id==$idea->user_id)
                                <i class="icon-puzzle" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="vague">
                                </i>
                            @else
                                <a href="#" class="nav-link addRating" style="color:black;" id="vague">
                                    @if($rating_type=='vague')
                                        <i class="icon-puzzle text-danger" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="vague">
                                        </i>
                                    @else
                                        <i class="icon-puzzle" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="vague">
                                        </i>
                                    @endif
                                </a>
                            @endif
                            <span class="text-info" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="@php
                                $list=App\Idea::getList($idea,'vague');
                                foreach($list as $user)
                                {
                                    echo $user->name;
                                    echo "<br>";
                                }
                                @endphp">
                                {{App\Idea::getCount($idea,'vague')}}
                            </span>
                            &nbsp;

                            <!-- complex -->
                            @if($user_id==$idea->user_id)
                                <i class="icon-user-unfollow" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="too complex">
                                </i>
                            @else
                                <a href="#" class="nav-link addRating" style="color:black;" id="complex">
                                    @if($rating_type=='complex')
                                        <i class="icon-user-unfollow text-danger" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="too complex">
                                        </i>
                                    @else
                                        <i class="icon-user-unfollow" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="too complex">
                                        </i>
                                    @endif
                                </a>
                            @endif
                            <span class="text-info" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="@php
                                $list=App\Idea::getList($idea,'complex');
                                foreach($list as $user)
                                {
                                    echo $user->name;
                                    echo "<br>";
                                }
                                @endphp">
                                {{App\Idea::getCount($idea,'complex')}}
                            </span>
                            &nbsp;

                            <!-- No of views -->
                            <i class="icon-user-following" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="bottom" title="@php
                                $list=App\Idea::getViewList($idea);
                                foreach($list as $user)
                                {
                                    echo $user->name;
                                    echo "<br>";
                                }
                                @endphp" style="font-size:115%;">
                            </i>
                            <span class="text-info">{{App\Idea::getViewCount($idea)}}</span>
                        </strong>
                    </h6>
                </div>
            </div>

            <div class="card-block" id="comment-list">
                <div class="form-group">
                    <p id="displayDetails">
                        @php
                            echo $idea->opportunity;
                        @endphp
                    </p>
                    <p> <strong class="text-info">Implementation : </strong><span class="text-muted">{{$idea->implementation}}</span></p>
                    <p> <strong class="text-info">Added Benefits : </strong><span class="text-muted">{{$idea->benefits}}</span></p>
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

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

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

$('.addRating').on('click',function(e)
{ 
    var idea_id=$("#idea_id").val();
    console.log(idea_id);

    var rating_type=$(this).attr('id');

    console.log(rating_type);
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token1"]').attr('content')
        }
    })

    e.preventDefault();

    var formData = {
        rating_type: $(this).attr('id'),
        idea_id :$("#idea_id").val(),
    }

    var url = $('#url').val();
    
    var type = "GET";

    $.ajax({
        type: type,
        url: url + '/ajax/addRatings/',
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
