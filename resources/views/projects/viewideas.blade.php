@extends('layouts.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Ideas</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/projects') }}">Projects</a></li>
    <li class="breadcrumb-item active">{{$project->name}}</li>
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
                <th>Problem Statement</th>
                <th>Activity</th>
                <th>Tagged</th>
                <th>Current Status</th>
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
                            <div><small class="text-muted bold">{{ App\Idea::getProjectName($idea->project_id)}}</small></div>
                    	</div>
                	</td>
                	<td>
                		<div class="float-xs-left">
                        	<a href="#">{{$idea->problem_statement}}</a>
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
                        @if($idea->current_status=='RETURNFORUPDATION' or $idea->current_status=='REJECTED')
                            <div class="float-xs-left text-danger">
                                <strong>{{App\Http\IngeniousUtilities\IdeaStatus::lookup($idea->current_status)}}</strong>
                            </div>
                        @elseif($idea->current_status=='ACCEPTED' or $idea->current_status=='SHAREDFORAPPROVAL')
                            <div class="float-xs-left text-success">
                                <strong>{{App\Http\IngeniousUtilities\IdeaStatus::lookup($idea->current_status)}}</strong>
                            </div>
                        @else
                            <div class="float-xs-left text-info">
                                <strong>{{$idea->current_status}}
                            </div>
                        @endif  
                    </td>
                	<td>
                    	<div class="float-xs-right">
                            <button type="button" id="ideaComment-{{$idea->id}}" class="btn btn-outline-primary btn-sm" onclick="window.location.href='{{ url('/project/'.$project->id.'/ideas/'.$idea->id.'/comments') }}'">View</button>
                            @if($idea->current_status == 'ACCEPTED' or $idea->current_status == 'SHAREDFORAPPROVAL' or $idea->current_status == 'REJECTED')
                                @if(auth()->user()->can('add_admin'))
                                    <button type="button" id="ideaStatus-{{$idea->id}}" class="btn btn-outline-success btn-sm" onclick="window.location.href='{{ url('/project/'.$project->id.'/ideas/'.$idea->id.'/status') }}'">Status</button>
                                @else
                                    <button type="button" id="ideaStatus-{{$idea->id}}" class="btn btn-outline-success btn-sm" onclick="window.location.href='{{ url('/project/'.$project->id.'/ideas/'.$idea->id.'/status') }}'" disabled>Status</button>
                                @endif
                            @else
                                <button type="button" id="ideaStatus-{{$idea->id}}" class="btn btn-outline-success btn-sm" onclick="window.location.href='{{ url('/project/'.$project->id.'/ideas/'.$idea->id.'/status') }}'">Status</button>
                            @endif
                            <button type="button" id="StatusHistory-{{$idea->id}}" class="btn btn-link btn-sm"  onclick="window.location.href='{{ url('/project/'.$project->id.'/ideas/'.$idea->id.'/statushistory') }}'" style="color:grey;">Status History</button>
                        </div>
                	</td>
            	</tr>
           @endforeach
           <tr>
               <td colspan="7" align="right">
                   <nav>
                       {{$ideas->links()}}
                   </nav>
               </td>
           </tr>
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