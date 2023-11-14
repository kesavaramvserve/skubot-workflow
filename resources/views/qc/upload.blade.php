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
    <link rel="stylesheet" href="{{ asset('css/pm_dashboard.css') }}">
    <style>
        .table-section{
            text-align : left;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row header">
            <div class="col-md-3 col-xs-12">
                <img src="{{asset('assets/images/logo.jpg')}}" alt="logo">
            </div>
            <div class="col-md-6 col-xs-12 menu-list">
                <a class="menu-item " href="{{route('qc.index')}}">QC In Progress</a>
                <a class="menu-item " href="{{route('qa_reject')}}">QA Rejected</a>
                <a class="menu-item " href="{{route('qc_complete')}}">QC Completed</a>
                <a class="menu-item active" href="{{route('qc.create')}}">Upload</a>
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
                    <span class="website_list">Upload File</span>
                </div>
            </div>
            <div class="col-12 table-section">
                <form action="{{route('qc.store')}}" method="post" enctype="multipart/form-data" id="import_form">
                    @csrf
                    <div class="mb-3">
                        <label for="file">Import File</label>
                        <input type="file" name="file" class="form-control" id="fileinput">
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Import Form Submit with Validation
        $("#import_form").on("submit", function (e) {
            var data = $("#fileinput").val();
            $(".error").empty();
            if(data.length < 1){
                e.preventDefault();
                $("#fileinput").after('<span class="error">This field is required </span>');
            }
        });
    </script>
</body>
</html>