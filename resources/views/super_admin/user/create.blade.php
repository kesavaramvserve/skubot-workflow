@extends('layouts.app')
@section('main-content')
                <!-- Page Heading -->
                <div class="row heading">
                    <div class="col-md-12 col-xs-12 mt-3">
                        <h4 class="float-start mt-2">Create New User</h4>
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

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif



                {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group mb-3">
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group mb-3">
                            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group mb-3">
                            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group mb-3">
                            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group mb-3">
                            <select name="roles" id="roles" class="form-control">
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group mb-3">
                            <select name="status" id="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12" id="tl_div">

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-3">
                        <button type="submit" class="btn submit-button">Submit</button>
                    </div>
                </div>
                {!! Form::close() !!}
    <script>
        // Append TL Feild
        $(document).on("change","#roles",function() {
            var role = $( "#roles option:selected" ).text();
            if(role == 'PA' || role == 'QC' || role == 'DA' || role == 'QA'){
                $("#tl_div").empty();
                $("#tl_div").append('<div class="form-group mb-3"><select name="tl_id" id="tl_id" class="form-control" required><option value="">Select TL</option>@foreach($tls as $tl)<option value="{{$tl->id}}">{{$tl->first_name." ".$tl->last_name}}</option>@endforeach</select></div>');
            }else{
                $("#tl_div").empty();
            }
        });
    </script>
</body>
</html>
@endsection