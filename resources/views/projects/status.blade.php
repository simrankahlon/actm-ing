@extends('layouts.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Ideas</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/projects') }}">Projects</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/projects/'.$project->id.'/ideas') }}">{{$project->name}}</a></li>
    <li class="breadcrumb-item active">{{$idea->problem_statement}}</li>
    <li class="breadcrumb-menu ">
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-secondary" href="{{ url('/project/'.$project->id.'/ideas/'.$idea->id.'/statushistory') }}"><i class="icon-note"></i> &nbsp;Status History </a>
        </div>
    </li>
</ol>
@endsection

@section('content')
<div class="card">
    <form action="{{ url('/project/'.$project->id.'/ideas/'.$idea->id.'/status') }}" method="post" id="addForm">
        {{ csrf_field() }}
        <div class="card-header">
            <strong>{{$idea->problem_statement}}</strong>
        </div>
        <div class="card-block">
            <div>
                <label for="current_status">Current Status : </label>
                <strong>{{$idea->current_status}}</strong>
            </div>
            <div class="form-group">
                <label for="status">Status</label> <span style="color:red">*</span>
                <select id="status" name="status" class="form-control" size="1">
                    <option value="">Please select</option>
                    @foreach(App\Http\IngeniousUtilities\IdeaStatus::all() as $value => $code)
                        <option value="{{$code}}" @if (old('status') == $code) selected="selected" @endif>{{$value}}</option>
                    @endforeach
                </select>
                <span style="color:red">{{ $errors->first('status') }}</span>
            </div>

            <div class="form-group">
                <label for="remark">Remark</label> <span style="color:red">*</span>
                <textarea name ="remark" class="form-control" id="remark" placeholder="Remark">{{old('remark')}}</textarea>
                <span style="color:red">{{ $errors->first('remark') }}</span>
            </div>
        </div>
                            
        <div class="card-footer">
            <button type="submit" id="save" class="btn btn-primary">Save changes</button>
            <a href="{{ url('/projects') }}" class="btn btn-default">Cancel</a> 
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




