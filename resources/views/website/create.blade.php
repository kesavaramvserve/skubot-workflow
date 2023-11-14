@extends('layouts.main')

@section('main-content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('website.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="website_name" class="form-label">Website Name</label>
                            <input class="form-control" type="text" name="website_name">
                            @error('website_name')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Website Description</label>
                            <input class="form-control" type="text" name="description">
                        </div>
                        <div class="mb-3">
                            <input class="form-control btn btn-primary" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection