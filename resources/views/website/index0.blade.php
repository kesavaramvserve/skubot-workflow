@extends('layouts.main')

@section('main-content')
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1031; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 60%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  /* float: right; */
  font-size: 28px;
  font-weight: bold;
  margin-left: 96%;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.btn{
    padding:0px !important;
}
</style>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="">
        <div class="content-wrapper">
            <!-- <div class="row">
                <a class="btn btn-primary" href="{{route('website.create')}}">Add</a>
            </div> -->
            <div class="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client Name</th>
                            <th>Client Email</th>
                            <th>Company Name</th>
                            <th>Website Url</th>
                            <th>Action</th>
                            <th>Updated at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $data)
                        <tr>
                            <?php $enc_id = Illuminate\Support\Facades\Crypt::encryptString($data->id); ?>
                            <td>{{$data->id}}</td>
                            <td>{{$data->getClient->getUser->first_name}}</td>
                            <td>{{$data->getClient->getUser->email}}</td>
                            <td>{{$data->getClient->company_name}}</td>
                            <td>{{$data->website}}</td>
                            <!-- Scraper -->
                            @if(auth()->user()->getrole->name == 'Scraper') 
                                @if(blank($data->getScrapeData))
                                    <td><a href="javascript:void(0)" class="btn btn-primary upload" data-id="{{ $data->id }}">Upload</a></td>
                                    <td>-</td>
                                @else
                                    <td><a href="{{asset('scraper-data/'.$data->getScrapeData->path)}}" class="btn btn-success">Download</a></td>
                                    <td>{{$data->getScrapeData->updated_at}}</td>
                                @endif
                            <!-- Support -->
                            @elseif(auth()->user()->getrole->name == 'Support')
                                <td>
                                    <!-- Set Price -->
                                    <a href="{{route('support.show',$enc_id)}}" class="btn btn-info">Set Price</a>
                                    <!-- Import -->
                                    <a href="javascript:void(0)" class="btn btn-primary import" data-id="{{ $data->id }}">Import</a>
                                    <!-- Download -->
                                    @if(!blank($data->getScrapeData))
                                        <a href="{{asset('scraper-data/'.$data->getScrapeData->path)}}" class="btn btn-success">Download</a>
                                    @endif
                                    <!-- Clent View -->
                                    @if(!blank($data->getWebsiteData))
                                        <a href="{{route('scrape_view',$enc_id)}}" style="margin-left:3%"><img src="{{asset('assets/images/view.png')}}" alt="view" title="view"></a>
                                    @endif
                                    @if(!blank($data->getClientRequiremnet))
                                        @if(!blank($data->getClientRequestData))
                                            <a href="{{asset('client-requirements/'.$data->getClientRequestData->path)}}" class="btn btn-success">Download client Details</a>
                                            <a href="javascript:void(0)" class="btn btn-primary enhance-import" data-id="{{ $data->id }}">Import Enhanced</a>
                                            @if(!blank($data->getWebsiteEnhancedData))
                                                <a href="{{route('enhance_result',$enc_id)}}" style="margin-left:3%"><img src="{{asset('assets/images/view.png')}}" alt="view" title="view"></a>
                                            @endif
                                        @else
                                            <a href="{{route('generate_excel',$data->id)}}" style="margin-left:3%" class="btn btn-success">Generate Excel</a>
                                        @endif
                                    @endif
                                </td>
                                @if(!blank($data->getWebsiteData))
                                    <td>{{$data->getWebsiteData->updated_at}}</td>
                                @else
                                    <td>-</td>
                                @endif
                            <!-- Reviewer -->
                            @elseif(auth()->user()->getrole->name == 'Reviewer')
                                <td>
                                    @if(!blank($data->getWebsiteEnhancedData))
                                        <a href="{{route('enhance_result',$enc_id)}}" style="margin-left:3%"><img src="{{asset('assets/images/view.png')}}" alt="view" title="view"></a>
                                    @endif
                                </td>
                                <td>-</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row mt-3" style="margin-left:40%;">
                {{$datas->links("pagination::bootstrap-4")}}
            </div>
        </div>
    </div>
<!-- The Scraper Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="row">
        <form action="{{route('scraper_upload')}}" method="post" enctype="multipart/form-data" id="scraper_data">
            @csrf
            <input type="hidden" name="website_id" value="" id="website_id"> 
            <div class="mb-3">
                <label for="file">Scrap File</label>
                <input type="file" name="file" class="form-control" id="fileinput">
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
  </div>

</div>

<!-- The Support Modal (Scrape data import)-->
<div id="myModal2" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="row">
        <form action="{{route('import_scrape_data')}}" method="post" enctype="multipart/form-data" id="support_import">
            @csrf
            <input type="hidden" name="website_id" value="" id="website_id2"> 
            <div class="mb-3">
                <label for="file">Import File</label>
                <input type="file" name="file" class="form-control" id="fileinput2">
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
  </div>

</div>

<!-- The Support Modal (enhance data import)-->
<div id="myModal3" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="row">
        <form action="{{route('enhance_data')}}" method="post" enctype="multipart/form-data" id="support_enhance">
            @csrf
            <input type="hidden" name="website_id" value="" id="website_id3"> 
            <div class="mb-3">
                <label for="file">Import File</label>
                <input type="file" name="file" class="form-control" id="fileinput3">
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
  </div>

</div>
<script>
    $(document).ready(function() {
        // Scraper Close Button
        $(document).on("click",".close",function() {
            $("#myModal").hide();
        });

        // Support Close Button
        $(document).on("click",".close",function() {
            $("#myModal2").hide();
        });

        // Support Close Button
        $(document).on("click",".close",function() {
            $("#myModal3").hide();
        });

        // Scraper Upload
        $(document).on("click",".upload",function() {
            $("#myModal").show();
            var website_id = $(this).attr('data-id');
            $("#website_id").val(website_id);
        });

        // Support Import scrapped Data
        $(document).on("click",".import",function() {
            $("#myModal2").show();
            var website_id = $(this).attr('data-id');
            $("#website_id2").val(website_id);
        });

        // Support Import enhanced Data
        $(document).on("click",".enhance-import",function() {
            $("#myModal3").show();
            var website_id = $(this).attr('data-id');
            $("#website_id3").val(website_id);
        });
        
        // Scraper Form Submit
        $("#scraper_data").on("submit", function (e) {
            var data = $("#fileinput").val();
            if(data.length < 1){
                e.preventDefault();
                $("#fileinput").after('<span style="color:red;">This field is required </span>');
            }
        });

        // Support Form Submit(Scrapped Data)
        $("#support_import").on("submit", function (e) {
            var data = $("#fileinput2").val();
            if(data.length < 1){
                e.preventDefault();
                $("#fileinput2").after('<span style="color:red;">This field is required </span>');
            }
        });

        // Support Form Submit(Enhanced Data)
        $("#support_enhance").on("submit", function (e) {
            var data = $("#fileinput3").val();
            // alert(data);
            if(data.length < 1){
                e.preventDefault();
                $("#fileinput3").after('<span style="color:red;">This field is required </span>');
            }
        });

    });
</script>
@endsection