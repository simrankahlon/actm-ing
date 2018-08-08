@extends('layouts.app')


@section('breadcrumb')
<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">{{$client_name}}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/saas') }}">SaaS</a></li>
            <li class="breadcrumb-item active">{{ $saas->name }}</li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
@endsection

@section('content')
<div class="card">
                            <form action="{{ url('/saasedit/'.$saas->id) }}" method="post">
                                 {{ method_field('PATCH') }}
                                {{ csrf_field() }}
                            <div class="card-header">
                                <strong>Software as a Service</strong>
                            </div>
                            <div class="card-block">
                            	    <div class="form-group">
                                        <label for="category_id">Category</label> <span style="color:red">*</span>
                                        <select id="category_id" name="category_id" class="form-control" size="1">
                                        
                                            <option value="">Please select</option>
                                            @foreach($categories as $category)
                                                     @if($saas->category_id == $category->id)
                                                    <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                                     @else
                                                     <option value="{{$category->id}}">{{$category->name}}</option>
                                                     @endif
                                            @endforeach
                                        </select>
                                      <span style="color:red">{{ $errors->first('category_id') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name</label> <span style="color:red">*</span>
                                        <input name ="name" type="text" class="form-control" id="name" placeholder="Enter name" value="{{ $saas->name }}">
                                       <span style="color:red">{{ $errors->first('name') }}</span>
                                       
                                    </div>
                                     <div class="form-group">
                                        <label for="description">URL</label> <span style="color:red">*</span>
                                        <input name ="url" type="text" class="form-control" id="url" placeholder="URL" value="{{ $saas->url }}">
                                        <span style="color:red">{{ $errors->first('url') }}</span>
                                    </div> 
                                     <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name ="description" class="form-control" id="description" placeholder="Description">{{$saas->description}}</textarea>
                                        <span style="color:red">{{ $errors->first('description') }}</span>
                                      </div> 
                                      
                                 @if(old('page', null) == null)
                                 <input name ="page" type="hidden" class="form-control" id="page" value="{{ App\Http\AcatUtilities\GeneralUtilities::getCancelURL('SAAS_EDIT',URL::previous()) }}">
                                 @else
                                 <input name ="page" type="hidden" class="form-control" id="page" value={{ old('page') }}>
                                 @endif
                            

                            </div>
                            <div class="card-footer">
                                <button type="submit" id="save" class="btn btn-primary">Save changes</button>
                                @if(old('page', null) == null)
                                   <a href="{{ App\Http\AcatUtilities\GeneralUtilities::getCancelURL('SAAS_EDIT',URL::previous()) }}" class="btn btn-default">Cancel</a> 
                                  @else
                                   <a href="{{ old('page') }}" class="btn btn-default">Cancel</a> 
                                  @endif
                            </div>
                            </form>

                        </div>
@endsection
