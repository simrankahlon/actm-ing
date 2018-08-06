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
                                <p class="text-strong"><strong>Create New Client Request</strong></p>
                                @if (session('connection_error'))
                                    <div class="alert alert-warning">
                                        {{ session('connection_error') }}
                                    </div>
                                @endif
                                
                                <div class="input-group mb-1">
                                    <label for="name">Name</label> <span style="color:red">* </span>
                                    <input name ="name" type="text" class="form-control" id="name" placeholder="Enter Client's name" value={{ old('name') }}>
                                    <span style="color:red">{{ $errors->first('name') }}</span>
                                </div>

                                <div class="input-group mb-1">
                                    <label for="first_name">Contact First Name</label> <span style="color:red">* </span>
                                    <input name ="first_name" type="text" class="form-control" id="first_name" placeholder="Contact First Name" value={{ old('first_name') }}>
                                    <span style="color:red">{{ $errors->first('first_name') }}</span>
                                </div>

                                <div class="input-group mb-1">
                                    <label for="last_name">Contact Last Name</label> <span style="color:red">* </span>
                                    <input name ="last_name" type="text" class="form-control" id="last_name" placeholder="Contact Last Name" value={{ old('last_name') }}>
                                    <span style="color:red">{{ $errors->first('last_name') }}</span>
                                </div>

                                <div class="input-group mb-1">
                                    <label for="first_name">Email</label> <span style="color:red">* </span>
                                    <input name ="email" type="email" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}">
                                    <span style="color:red">{{ $errors->first('email') }}</span>
                                </div>

                               
                                
                                <div class="input-group mb-1">
                                    <label for="url">URL</label>
                                    <input name ="url" type="url" class="form-control" id="url" placeholder="Url" value="{{ old('url') }}">
                                    <span style="color:red">{{ $errors->first('url') }}</span>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <button type="submit" class="btn btn-primary px-2">Submit</button>
                                        <a href="{{ url('/switchclient') }}" class="btn btn-default">Cancel</a>
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

