@extends('layouts.app')
@section('main-content')
                <!-- Page Heading -->
                <div class="row heading">
                    <div class="col-md-12 col-xs-12 mt-3">
                        <h4 class="float-start mt-2">Create Client</h4>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="row table-row">
                    <div class="col-12 mt-3 mb-3">
                        <div class="float-end">
                            <a class="btn submit-button-reverse" href="{{ route('users.index') }}"> Back</a>
                        </div>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-3 text-center p-0">
                        <h3 class="mt-2">{{ $message }}</h3>
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger mt-3 text-center p-0">
                        <h3 class="mt-2">{{ $message }}</h3>
                    </div>
                @endif

                <form action="{{route('user.store_client')}}" method="post" id="">
                    @csrf
                    <div class="row content-section">                         
                        <!-- First Name -->
                        <div class="col-12 text-left">
                            <div class="mb-2"><input class="input form-control" type="text" name="first_name" id="first_name" placeholder="John" value="{{old('first_name')}}"></div>
                            @if($errors->has('first_name'))
                            <div class="error">{{ $errors->first('first_name') }}</div>
                            @endif
                        </div>
                        <!-- Last Name -->
                        
                        <div class="col-12 text-left">
                            <div class="mb-2"><input class="input form-control" type="text" name="last_name" id="last_name" placeholder="Doe" value="{{old('last_name')}}"></div>
                            @if($errors->has('last_name'))
                            <div class="error">{{ $errors->first('last_name') }}</div>
                            @endif
                        </div>
                        <!-- Email -->
                        
                        <div class="col-12 text-left">
                            <div class="mb-2"><input class="input form-control" type="email" name="email" id="email" placeholder="abc@abc.com" value="{{old('email')}}"></div>
                            @if($errors->has('email'))
                            <div class="error">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <!-- Company -->
                       
                        <div class="col-12 text-left">
                            <div class="mb-2"><input class="input form-control" type="text" name="company_name" id="company_name" placeholder="John Pvt Ltd" value="{{old('company_name')}}"></div>
                            @if($errors->has('company_name'))
                            <div class="error">{{ $errors->first('company_name') }}</div>
                            @endif
                        </div>
                        <!-- Website URL -->
                        
                        <div class="col-12 text-left">
                            <div class="mb-2"><input class="input form-control" type="url" name="website" id="website" placeholder="https://website.com/" value="{{old('website')}}"></div>
                            @if($errors->has('website'))
                            <div class="error">{{ $errors->first('website') }}</div>
                            @endif
                        </div>
                        <!-- Project Manager -->
                       
                        <div class="col-12 text-left">
                            <div class="mb-2">
                                <select name="pm_id" id="pm_id" class="form-control">
                                    <option value="">Select Project Manager</option>
                                    @foreach($pm_list as $pm_lists)
                                    <option value="{{$pm_lists->id}}">{{$pm_lists->first_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->has('pm_id'))
                            <div class="error">{{ $errors->first('pm_id') }}</div>
                            @endif
                        </div>
                        
                        <!-- Submit -->
                        <div class="col-12 mt-3 mb-3 text-center">
                            <input class="btn submit-button mb-3" type="submit" value="SUBMIT">
                        </div>
                    </div>
                </form>
                </div>
            <div class="col-1"></div>
        </div>
    </div>
</body>
</html>
@endsection