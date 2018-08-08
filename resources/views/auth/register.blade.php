@extends('layouts.auth')
@section('content')
<div class="container d-table">
        <div class="d-100vh-va-middle">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card-group">
                        <div class="card p-2">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                            <div class="card-block">
                                <div align="center"><img src="{{ asset('img/logoforpdf.jpg') }}" alt="Logo" align="center"></div>
                                <br>
                                <p class="text-strong"><strong>Register</strong></p>
                                @if (session('connection_error'))
                                    <div class="alert alert-warning">
                                        {{ session('connection_error') }}
                                    </div>
                                @endif
                                
                                <div class="form-group mb-1">
                                    <label for="name">Name</label> <span style="color:red">*</span>
                                    <input name ="name" type="text" class="form-control" id="name" placeholder="Enter name" value="{{ old('name') }}">
                                    <span style="color:red">{{ $errors->first('name') }}</span>
                                </div>
                                <div class="form-group mb-1">
                                    <label for="first_name">Email</label> <span style="color:red">*</span>
                                    <input name ="email" type="email" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}">
                                    <span style="color:red">{{ $errors->first('email') }}</span>
                                </div>

                                <div class="form-group mb-1">
                                    <label for="password">Password</label> <span style="color:red">*</span>
                                    <input name ="password" type="password" class="form-control" id="password" placeholder="Password">
                                    <span style="color:red">{{ $errors->first('password') }}</span>
                                </div>

                                <div class="form-group mb-1">
                                    <label for="password_confirmation">Confirm Password</label> <span style="color:red">*</span>
                                    <input name ="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Password">
                                    <span style="color:red">{{ $errors->first('password_confirmation') }}</span>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <button type="submit" class="btn btn-primary px-2">Submit</button>
                                        <a href="{{ url('/') }}" class="btn btn-default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

