@extends('layouts.app')


@section('breadcrumb')
<ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
            <li class="breadcrumb-item active">Change Password</li>
        </ol>
@endsection
@section('content')
    <div class="card">
                    <form action="{{url('/home/changepassword')}}" method="post">
                                {{ csrf_field() }}
                            <div class="card-header">
                                <strong>Change Password</strong>
                            </div>
                            <div class="card-block">
                                    <div class="form-group">
                                        <label for="password">Current Password</label><span style="color:red">*</span>
                                        <input name ="current_password" type="password" class="form-control" id="current_password" placeholder="Current Password">
                                        <span style="color:red">{{ $errors->first('current_password') }}{{Session::get('current_password')}}</span> 
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label><span style="color:red">*</span>
                                        <input name ="password" type="password" class="form-control" id="password" placeholder="New Password">
                                         <span style="color:red">{{ $errors->first('password') }}{{Session::get('password')}}</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label><span style="color:red">*</span>
                                        <input name ="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Confirm New Password">
                                       <span style="color:red">{{ $errors->first('password_confirmation') }}</span>
                                    </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                               <a href="{{ url('/home') }}" class="btn btn-default">Cancel</a> 
                                  </div>
                    </form>
    </div> <!--END CARD-BLOCK-->
@endsection