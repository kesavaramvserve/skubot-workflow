@extends('layouts.app')
@section('main-content')
                <!-- Table Heading -->
                <div class="row heading">
                    <div class="col-md-6 col-xs-12 mt-3">
                        <h4 class="float-start mt-2">Add Project</h4>
                    </div>
                    <div class="col-md-6 col-xs-12 mt-3">
                        
                    </div>
                </div>

                <!-- Back Project Button -->
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{route('super-admin.index')}}" class="btn submit-button-reverse" style="margin-left:87%;">Back</a>
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

                <form action="{{route('super-admin.store_project')}}" method="post" id="">
                    @csrf
                    <div class="row content-section mt-3">                         
                        <!-- Project Name -->
                        <div class="col-12 text-left">
                            <div class="mb-2"><input class="input form-control" type="text" name="project_name" id="project_name" placeholder="Project Name" value="{{old('project_name')}}"></div>
                            @if($errors->has('project_name'))
                            <div class="error">{{ $errors->first('project_name') }}</div>
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