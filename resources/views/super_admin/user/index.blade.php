@extends('layouts.app')
@section('main-content')
                <!-- Table Heading -->
                <div class="row heading">
                    <div class="col-md-6 col-xs-12 mt-3">
                        <h4 class="float-start mt-2">Users Management</h4>
                    </div>
                    <div class="col-md-6 col-xs-12 mt-3">
                        <div class="float-end">
                            <?php $route = Route::current()->getName(); ?>
                            <a class="menu-item {{$route =='super-admin.index' ? 'active' : '' }}" href="{{route('super-admin.index')}}">Projects</a>
                            <a class="menu-item {{$route =='users.index' ? 'active' : '' }}" href="{{route('users.index')}}">Users</a>
                            <a class="menu-item {{$route =='roles.index' ? 'active' : '' }}" href="{{route('roles.index')}}">Roles</a>
                        </div>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="row table-row">
                    <div class="col-12 mt-3 mb-3">
                        <div class="float-end">
                            <a class="btn submit-button" href="{{ route('user.create_client') }}"> Create Client</a>
                            <a class="btn submit-button-reverse" href="{{ route('users.create') }}"> Create User</a>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="row table-row">
                    <div class="col-12 table-section table-responsive">
                        <table class="table">
                            <thead>
                                <th class="">S.No</th>
                                <th class="">Name</th>
                                <th class="">Email</th>
                                <th class="">Role</th>
                                <th class="">Status</th>
                                <th class="">Action</th>
                            </thead>
                            <tbody>
                            @php
                                $serialNumber = $data->firstItem();
                            @endphp
                                @foreach($data as $sno => $user)
                                <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($user->id); ?>
                                <tr>
                                    <td class="">{{ $serialNumber++ }}</td>
                                    <td class="">{{ $user->first_name.' '.$user->last_name }}</td>
                                    <td class="">{{ $user->email }}</td>
                                    <td class="">
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                        {{ $v }}
                                        @endforeach
                                    @endif
                                    </td>
                                    <td class="">
                                        @if($user->status == '1')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="">
                                    <a class="" href="{{ route('users.edit',$enc_id) }}"><img src="{{asset('client/images/edit.png')}}" alt="Edit" title="Edit"></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="col-12 mt-3">
                        <div style="margin-left:40%;">
                            {{$data->links("pagination::bootstrap-4")}}
                        </div>
                    </div>
                </div>

            </div>
        <div class="col-1"></div>
    </div>
</div>


</body>
</html>
@endsection