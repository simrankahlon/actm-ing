<style>
.remark {
    display: inline-block;
    width: 200px;
    white-space: nowrap;
    overflow: hidden !important;
    text-overflow: ellipsis;
}
</style>
@extends('layouts.app')
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Ideas</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/projects') }}">Projects</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/projects/'.$project->id.'/ideas') }}">{{$project->name}}</a></li>
    <li class="breadcrumb-item active">{{$idea->problem_statement}}</li>
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
                        <th>Status</th>
                        <th>Remark</th>
                        <th>Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($idea_status as $i_status)
                        <tr>
                            <td class="text-xs-center">
                                <div class="avatar">
                                    <img src="{{ asset('img/user-icon.png') }}" class="img-avatar" alt="Client Logo">
                                </div>
                            </td>
                            <td>
                                <div class="text-muted bold">
                                    <strong>
                                        @if(empty($i_status->user_id))
                                            -
                                        @else
                                            {{App\Idea::userName($i_status->user_id)}}
                                        @endif
                                    </strong>
                                </div>
                            </td>
                            <td>
                                @if($i_status->status=='RETURNFORUPDATION' or $i_status->status=='REJECTED')
                                    <div class="float-xs-left text-danger">
                                        <strong>{{App\Http\IngeniousUtilities\IdeaStatus::lookup($i_status->status)}}</strong>
                                    </div>
                                @elseif($i_status->status=='ACCEPTED' or $i_status->status=='SHAREDFORAPPROVAL')
                                    <div class="float-xs-left text-success">
                                        <strong>{{App\Http\IngeniousUtilities\IdeaStatus::lookup($i_status->status)}}</strong>
                                    </div>
                                @else
                                    <div class="float-xs-left text-info">
                                        <strong>{{$i_status->status}}
                                    </div>
                                @endif 
                            </td>
                            <td>
                                <div class="float-xs-left remark" id="tool-tip" data-html="true" data-toggle="tooltip" data-placement="top" title="{{$i_status->remark}}" style="font-size:115%;">
                                    {{$i_status->remark}}
                                </div>
                            </td>
                            <td>
                                <div class="float-xs-left">
                                    <strong>
                                        {{ \Carbon\Carbon::parse($i_status->updated_at)->diffForHumans() }}
                                    </strong>                                               
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" align="right">
                            <nav>
                                {{$idea_status->links()}}
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
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection
