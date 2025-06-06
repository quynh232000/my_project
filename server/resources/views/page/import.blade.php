@extends('layout.root')
@section('view_title')
    Tổng quan
@endsection
@section('root')
    <div class="container m-auto py-5">
        <div class="row">
            <div class="col-6 m-auto">
                <form action="{{ route('test') }}" method="POST" class="form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="file" class="form-control">
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
