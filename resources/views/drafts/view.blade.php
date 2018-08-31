@extends('layouts.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item active">Drafts
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

<div class="card">
    <table class="table table-hover table-outline mb-0 hidden-sm-down">
        <thead class="thead-default">
            <tr>
                <th class="text-xs-center"><i class="icon-people"></i>
                <th>User</th>
                <th>Problem Statement</th>
                <th>Activity</th>
                <th>Tagged</th>
                <th><div class="float-xs-right">Action</div></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($drafts as $draft)
                <tr>
                    <td class="text-xs-center">
                        <div class="avatar">
                            <img src="{{ asset('img/user-icon.png') }}" class="img-avatar" alt="Client Logo">
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong><a href="#">{{App\Draft::userName($draft->user_id)}}</a></strong>
                            @if(!empty($draft->project_id))
                                <div><small class="text-muted bold">{{ App\Draft::getProjectName($draft->project_id)}}</small></div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="float-xs-left">
                            <a href="#">{{$draft->problem_statement}}</a>
                        </div>
                    </td>
                    <td>
                        <div class="float-xs-left">
                            <strong>
                                {{ $draft->updated_at->diffForHumans()}}
                            </strong>                                               
                        </div>
                    </td>
                    <td>
                        <div class="float-xs-left">
                            @php
                                $user_name = array();
                                $users=App\Draft::getTaggedUsers($draft);
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
                            <button type="button" id="draftEdit-{{$draft->id}}" class="btn btn-outline-primary btn-sm" onclick="window.location.href='{{ url('/drafts/'.$draft->id.'/edit') }}'">Edit</button>
                            <button type="button" id="draftDelete-{{$draft->id}}" class="btn btn-outline-danger btn-sm" onclick="javascript:confirmDelete('{{ url('/drafts/'.$draft->id.'/delete') }}')">Delete</button>
                        </div>
                    </td>
                </tr>
           @endforeach
           <tr>
               <td colspan="6" align="right">
                   <nav>
                       {{$drafts->links()}}
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