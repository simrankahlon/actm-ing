@extends('layouts.app')

@section('breadcrumb')
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="{{ url('/user/ideas/drafts') }}">Drafts</a></li>
   <li class="breadcrumb-item active">Edit Draft</li>
</ol>
@endsection

@section('content')
<div class="card">
    <form action="{{ url('/drafts/'.$draft->id.'/edit') }}" method="post" id="editForm">
        {{ csrf_field() }}
        <div class="card-header">
            <strong>Edit Draft</strong>
        </div>
        <div class="card-block">
            <div class="form-group">
                <label for="problem_statement">Problem Statement</label> <span style="color:red">*</span>
                <input name ="problem_statement" type="text" class="form-control" id="name" placeholder="Problem Statement" value="{{$draft->problem_statement}}">
                <span style="color:red">{{ $errors->first('problem_statement') }}</span>
            </div>

            <div class="form-group">
                <label for="project">Project</label> <span style="color:red">*</span>
                <select id="project" name="project" class="form-control" size="1">
                    <option value="">Please select</option>
                    @foreach($projects as $project)
                        @if($project->id == $draft->project_id)
                            <option value="{{$project->id}}" selected>{{$project->name}}</option>
                        @else
                            <option value="{{$project->id}}">{{$project->name}}</option>
                        @endif
                    @endforeach
                </select>
                <span style="color:red">{{ $errors->first('project') }}</span>
            </div>
                            
            <div class="form-group">
                <label for="opportunity">Opportunity</label> <span style="color:red">*</span>
                <textarea name ="opportunity" class="form-control" id="opportunity" placeholder="Opportunity">{{$draft->opportunity}}</textarea>
                <span style="color:red">{{ $errors->first('opportunity') }}</span>
            </div>

            <div class="form-group">
                <label for="implementation">What goes into Implementing this ?</label>
                <textarea name ="implementation" class="form-control" id="implementation" placeholder="What goes into Implementing this ?">{{ $draft->implementation}}</textarea>
                <span style="color:red">{{ $errors->first('implementation') }}</span>
            </div>

            <div class="form-group">
                <label for="added_benefits">Added Benefits</label>
                <textarea name ="added_benefits" class="form-control" id="added_benefits" placeholder="Added Benefits">{{$draft->benefits}}</textarea>
                <span style="color:red">{{ $errors->first('added_benefits') }}</span>
            </div>

            <div class="form-group">
                <label for="tag_users">Tag Users</label>&nbsp;<small>(Multi-Select)</small>
                <select id="tag_users" name="tag_users[]" multiple="multiple" data-placeholder="Please Select" class="form-control chosen-select">
                    @php
                        $found = 0;
                    @endphp
                        
                    @foreach($users as $user)
                        @foreach($draft->users as $selecteduser)
                            @if($user->id == $selecteduser->id)
                                @php
                                    $found = 1;
                                @endphp
                            @endif  
                        @endforeach     
                        
                        @if($found == 1)
                            <option value="{{$user->id}}" selected="">{{$user->name}}</option>
                        @else
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endif

                        @php
                            $found=0;
                        @endphp        
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" id="save" name="save" class="btn btn-primary" value="save">Save as Idea</button>
            <button type="submit" id="save" name="save" class="btn btn-primary" value="draft">Save as Draft</button>
            <a href="{{ url('/user/ideas/drafts') }}" class="btn btn-default">Cancel</a>
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

