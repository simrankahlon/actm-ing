@extends('layouts.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item active">Dashboard
    </li>
    <li class="breadcrumb-menu">
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-secondary" href="{{ url('/ideas/create') }}"><i class="icon-plus"></i> &nbsp;Create Ideas </a>
        </div>
    </li>
</ol>
@endsection
@section('content')
    @php
        $user_id=Auth::user()->id;
    @endphp

<h5 class="nav-item" style="color:#737373">Ideas</h5>
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
            @foreach ($ideas as $idea)
            	<tr>
                	<td class="text-xs-center">
                        @if(App\Idea::checkIfTagged($idea))
                            <strong><i class="icon-tag"></i></strong>
                        @endif
                    	<div class="avatar">
                            <img src="{{ asset('img/user-icon.png') }}" class="img-avatar" alt="Client Logo">
                    	</div>
                	</td>
                	<td>
                    	<div>
                        	<strong><a href="#">{{App\Idea::userName($idea->user_id)}}</a></strong>
                    	</div>
                	</td>
                	<td>
                		<div class="float-xs-left">
                        	<a href="#">{{$idea->title}}</a>
                		</div>
                 	</td>
                 	<td>
                 		<div class="float-xs-left">
                    		<strong>
                        		{{ $idea->updated_at->diffForHumans()}}
                    		</strong>                                               
                 		</div>
                 	</td>
                    <td>
                        <div class="float-xs-left">
                            @php
                                $user_name = array();
                                $users=App\Idea::getTaggedUsers($idea);
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
                            @if($idea->user_id == $user_id)
                                <button type="button" id="ideaEdit-{{$idea->id}}" class="btn btn-outline-primary btn-sm" onclick="window.location.href='{{ url('/ideas/'.$idea->id.'/edit') }}'">Edit</button>
                                <button type="button" id="ideaDelete-{{$idea->id}}" class="btn btn-outline-danger btn-sm" onclick="javascript:confirmDelete('{{ url('/ideas/'.$idea->id.'/delete') }}')">Delete</button>
                            @else
                                @if(App\Idea::checkIfLiked($idea))
                                    <button type="button" id="ideaDelete-{{$idea->id}}" class="btn btn-danger btn-sm" onclick="window.location.href='{{ url('/ideas/'.$idea->id.'/dislike') }}'"><i class="icon-dislike"></i> Dislike</button>
                                @else
                                    <button type="button" id="ideaDelete-{{$idea->id}}" class="btn btn-success btn-sm" onclick="window.location.href='{{ url('/ideas/'.$idea->id.'/like') }}'"><i class="icon-like"></i> Like</button>
                                @endif
                            @endif
                            <button type="button" id="ideaComment-{{$idea->id}}" class="btn btn-outline-secondary btn-sm" onclick="window.location.href='{{ url('/ideas/'.$idea->id.'/comments') }}'">View</button>
                        </div>
                	</td>
            	</tr>
           @endforeach
        </tbody>
     </table>
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