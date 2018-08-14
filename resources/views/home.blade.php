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
<div class="card-group">
    <div class="card">
        <div class="card-block">
            <div class="h1 text-muted text-xs-right mb-2">
                <i class="icon-user-follow"></i>
            </div>
            <div class="h4 mb-0">{{$user_count}}</div>
            <small class="text-muted text-uppercase font-weight-bold">Users</small>
            <progress class="progress progress-xs progress-success mt-1 mb-0" value="25" max="100">25%</progress>
        </div>
    </div>
    <div class="card">
        <div class="card-block">
            <div class="h1 text-muted text-xs-right mb-2">
                <i class="icon-bubbles"></i>
            </div>
            <div class="h4 mb-0">{{$idea_count}}</div>
            <small class="text-muted text-uppercase font-weight-bold">Ideas</small>
            <progress class="progress progress-xs progress-primary mt-1 mb-0" value="25" max="100">25%</progress>
        </div>
    </div>
    <div class="card">
        <div class="card-block">
            <div class="h1 text-muted text-xs-right mb-2">
                <i class="icon-speech"></i>
            </div>
            <div class="h4 mb-0">{{$comment_count}}</div>
            <small class="text-muted text-uppercase font-weight-bold">Comments</small>
            <progress class="progress progress-xs progress-warning mt-1 mb-0" value="25" max="100">25%</progress>
        </div>
    </div>
    <div class="card">
        <div class="card-block">
            <div class="h1 text-muted text-xs-right mb-2">
                <i class="icon-bubble"></i>
            </div>
            <div class="h4 mb-0">{{$myidea_count}}</div>
            <small class="text-muted text-uppercase font-weight-bold">My Ideas</small>
            <progress class="progress progress-xs progress-danger mt-1 mb-0" value="25" max="100">25%</progress>
        </div>
    </div>
</div>


<h5 class="nav-item" style="color:#737373">Recently Tagged</h5>
<div class="card">
    <table class="table table-hover table-outline mb-0 hidden-sm-down">
        <thead class="thead-default">
            <tr>
                <th class="text-xs-center"><i class="icon-people"></i>
                <th>User</th>
                <th>Title</th>
                <th>Activity</th>
                <th><div class="float-xs-right">Action</div></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tag_ideas as $idea)
            	<tr>
                	<td class="text-xs-center">
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
                    	<div class="float-xs-right">
                        	@php
                            	$user_id=Auth::user()->id;
                        	@endphp
                        	@if($idea->user_id == $user_id)
                            	<button type="button" id="ideaEdit-{{$idea->id}}" class="btn btn-outline-primary btn-sm" onclick="window.location.href='{{ url('/ideas/'.$idea->id.'/edit') }}'">Edit</button>
                            	<button type="button" id="ideaDelete-{{$idea->id}}" class="btn btn-outline-danger btn-sm" onclick="javascript:confirmDelete('{{ url('/ideas/'.$idea->id.'/delete') }}')">Delete</button>
                        	@endif
                        	<button type="button" id="ideaComment-{{$idea->id}}" class="btn btn-outline-success btn-sm" onclick="window.location.href='{{ url('/ideas/'.$idea->id.'/comments') }}'">View</button>
                    	</div>
                	</td>
            	</tr>
           @endforeach
        </tbody>
     </table>
</div>

<h5 class="nav-item" style="color:#737373">Recent Ideas</h5>
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
                        	@endif
                        	<button type="button" id="ideaComment-{{$idea->id}}" class="btn btn-outline-success btn-sm" onclick="window.location.href='{{ url('/ideas/'.$idea->id.'/comments') }}'">View</button>
                    	</div>
                	</td>
            	</tr>
           @endforeach
        </tbody>
     </table>
</div>
@endsection
