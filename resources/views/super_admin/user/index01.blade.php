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
              <a class="menu-item {{$route =='users.index' ? 'active' : '' }}" href="{{route('users.index')}}">Users</a>
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
        <!-- Title Section -->
        <div class="row content-section">
            <div class="col-12 title">
                <div class="mt-2">
                    <span class="dot"></span>
                    <span class="website_list">Users Management</span>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="float-end">
                    <a class="btn btn-primary" href="{{ route('user.create_client') }}"> Create Client</a>
                    <a class="btn btn-success" href="{{ route('users.create') }}"> Create User</a>
                </div>
            </div>
            <div class="col-12 table-section table-responsive">
                <table class="">
                    <thead>
                        <th class="head1 first_head">S.No</th>
                        <th class="head2">Name</th>
                        <th class="head1">Email</th>
                        <th class="head2">Role</th>
                        <th class="head1 last_head">Action</th>
                    </thead>
                    <tbody>
                    @php
                        $serialNumber = $data->firstItem();
                    @endphp
                        @foreach($data as $sno => $user)
                        <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($user->id); ?>
                        <tr>
                            <td class="data1">{{ $serialNumber++ }}</td>
                            <td class="data2">{{ $user->first_name.' '.$user->last_name }}</td>
                            <td class="data1">{{ $user->email }}</td>
                            <td class="data2">
                              @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                  {{ $v }}
                                @endforeach
                              @endif
                            </td>
                            <td class="data1">
                              <a class="" href="{{ route('users.edit',$enc_id) }}"><img src="{{asset('client/images/edit.png')}}" alt="Edit" title="Edit"></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="c0l-12 mt-3">
                <div style="margin-left:40%;">
                    {{$data->links("pagination::bootstrap-4")}}
                </div>
            </div>
        </div>
    </div>
</body>
</html>