@extends('layouts.app')
@section('main-content')
                <!-- Table Heading -->
                <div class="row heading">
                    <div class="col-md-6 col-xs-12 mt-3">
                        <h4 class="float-start mt-2">Roles Management</h4>
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
                
                <!-- Button -->
                <div class="row table-row">
                    <div class="col-12 mt-3">
                        <div class="float-end">
                            <a class="btn submit-button" href="{{ route('roles.create') }}"> Create Role</a>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="row mt-3 table-row">
                    <div class="col-12 table-section table-responsive">
                        <table class="table">
                            <thead>
                                <th class="">S.No</th>
                                <th class="">Name</th>
                                <th class="">Action</th>
                            </thead>
                            <tbody>
                                @php
                                    $serialNumber = $roles->firstItem();
                                @endphp
                                @foreach ($roles as $sno => $role)
                                <tr>
                                    <td class="">{{ $serialNumber++ }}</td>
                                    <td class="">{{ $role->name }}</td>
                                    <td class="">-</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="col-12 mt-3">
                        <div style="margin-left:40%;">
                            {{$roles->links("pagination::bootstrap-4")}}
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