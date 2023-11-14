<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merch Metric</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- Website Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/super_admin/users.css') }}">
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row header">
            <div class="col-md-4 col-xs-12">
              <img src="{{asset('assets/images/logo.jpg')}}" alt="logo">
            </div>
            <?php $route = Route::current()->getName(); ?>
            <div class="col-md-5 col-xs-12 menu-list">
              <a class="menu-item {{$route =='super-admin.index' ? 'active' : '' }}" href="{{route('super-admin.index')}}">Websites</a>
              <a class="menu-item active {{$route =='users.index' ? 'active' : '' }}" href="{{route('users.index')}}">Users</a>
              <a class="menu-item {{$route =='roles.index' ? 'active' : '' }}" href="{{route('roles.index')}}">Roles</a>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="float-end mt-4">
                    <span class="user_role">{{ auth()->user()->first_name }} ({{ auth()->user()->getRole->name }})</span>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-danger">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
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
            <!-- Title Section -->
            <div class="row content-section"> 
                <div class="col-12 title">
                    <div class="mt-2">
                        <span class="dot"></span>
                        <span class="website_list">Create Client</span>
                    </div>
                </div>
                
                <!-- First Name -->
                <div class="col-2 mt-5">
                    <div class="mb-2 float-end"><label for="">First Name<span style="color:red">*</span></label></div>
                </div>
                <div class="col-10 mt-5 text-left">
                    <div class="mb-2"><input class="input form-control" type="text" name="first_name" id="first_name" placeholder="John" value="{{old('first_name')}}"></div>
                    @if($errors->has('first_name'))
                    <div class="error">{{ $errors->first('first_name') }}</div>
                    @endif
                </div>
                <!-- Last Name -->
                <div class="col-2 text-right">
                    <div class="mb-2 float-end"><label for="">Last Name</label></div>
                </div>
                <div class="col-10 text-left">
                    <div class="mb-2"><input class="input form-control" type="text" name="last_name" id="last_name" placeholder="Doe" value="{{old('last_name')}}"></div>
                    @if($errors->has('last_name'))
                    <div class="error">{{ $errors->first('last_name') }}</div>
                    @endif
                </div>
                <!-- Email -->
                <div class="col-2 text-right">
                    <div class="mb-2 float-end"><label for="">Email<span style="color:red">*</span></label></div>
                </div>
                <div class="col-10 text-left">
                    <div class="mb-2"><input class="input form-control" type="email" name="email" id="email" placeholder="abc@abc.com" value="{{old('email')}}"></div>
                    @if($errors->has('email'))
                    <div class="error">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <!-- Company -->
                <div class="col-2 text-right">
                    <div class="mb-2 float-end"><label for="">Company<span style="color:red">*</span></label></div>
                </div>
                <div class="col-10 text-left">
                    <div class="mb-2"><input class="input form-control" type="text" name="company_name" id="company_name" placeholder="John Pvt Ltd" value="{{old('company_name')}}"></div>
                    @if($errors->has('company_name'))
                    <div class="error">{{ $errors->first('company_name') }}</div>
                    @endif
                </div>
                <!-- Website URL -->
                <div class="col-2 text-right">
                    <div class="mb-2 float-end"><label for="">Website URL<span style="color:red">*</span></label></div>
                </div>
                <div class="col-10 text-left">
                    <div class="mb-2"><input class="input form-control" type="url" name="website" id="website" placeholder="https://website.com/" value="{{old('website')}}"></div>
                    @if($errors->has('website'))
                    <div class="error">{{ $errors->first('website') }}</div>
                    @endif
                </div>
                <!-- Project Manager -->
                <div class="col-2 text-right">
                    <div class="mb-2 float-end"><label for="">Select Project Manager<span style="color:red">*</span></label></div>
                </div>
                <div class="col-10 text-left">
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
                    <input class="submit-btn" type="submit" value="SUBMIT">
                </div>
            </div>
        </form>
    </div>
</body>
</html>