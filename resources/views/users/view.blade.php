@extends('layouts.app')
@section('breadcrumb')
<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Ideas</a></li>
</ol>
@endsection

@section('content')
@php
    $user_id=Auth::user()->id;
    $url= url("/");
@endphp
<input type="hidden"  value="{{$url}}" id="url" class="url"/>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <table class="table table-hover table-outline mb-0 hidden-sm-down">
                <thead class="thead-default">
                    <tr>
                        <th class="text-xs-center"><i class="icon-people"></i>
                        <th>User</th>
                        <th>Project Admin</th>
                        <th>Activity</th>
                        <th><div class="float-xs-right">Admin</div></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="text-xs-center">
                                <div class="avatar">
                                    <img src="{{ asset('img/user-icon.png') }}" class="img-avatar" alt="Client Logo">
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong><a href="#">{{$user->name}}</a></strong>
                                </div>
                            </td>
                            <td>
                                <div class="float-xs-left">
                                    @php
                                        $user_projects = array();
                                        foreach($user->projects as $project)
                                        {
                                            $user_projects[] = $project->name;
                                        }
                                        $project_array = implode(',', $user_projects);
                                    @endphp
                                    @if(empty($project_array))
                                        <div class="float-xs-left text-muted"><strong>-</strong></div>
                                    @else
                                        <div class="float-xs-left text-muted"><strong>{{$project_array}}</strong></div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="float-xs-left">
                                    <strong>
                                        {{ $user->updated_at->diffForHumans()}}
                                    </strong>                                               
                                </div>
                            </td>
                            <td>
                                <div class="float-xs-right">
                                    <strong>
                                        @if(App\User::checkifAdmin($user))
                                            @if($user_id==$user->id)
                                                <input class="form-check-input admin" type="checkbox" id="{{$user->id}}" value="{{$user->id}}" checked disabled>
                                            @else
                                                <input class="form-check-input admin" type="checkbox" id="{{$user->id}}" value="{{$user->id}}" checked>
                                            @endif
                                        @else
                                            <input class="form-check-input admin" type="checkbox" id="{{$user->id}}" value="{{$user->id}}">
                                        @endif
                                    </strong>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" align="right">
                            <nav>
                                {{$users->links()}}
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
$('.admin').click(function() {
    var checked = 0;
    var user_id=$(this).val();
    var url= $('#url').val();
    if($(this).is(':checked'))
    {
        checked=1;
    }

    $.ajax
    ({
        type: "GET",
        url: url + '/ajax/admin/' + user_id + '/' +checked,
        success: function (data) {

        },
        statusCode: 
        {
            401: function()
            { 
                window.location.href =url+'/login';
            }
        },
        error: function (data) 
        {
            console.log('Error:', data);
        }
    })

});

</script>
@endsection
