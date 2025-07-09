@extends('layout.app')
@section('title', 'Chi tiết ')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-6 text-left"></div>
            <div class="col-6 text-right">
                @include('include.btn.cancel', [
                    'href' => route($params['prefix'] . '.' . $params['controller'] . '.index'),
                ])
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="" style="background: radial-gradient( rgba(144, 214, 255, .336) 0, hsla(0, 0%, 100%, .5) 100%), #fff;">
    <div class="" style="width:90% ; margin:20px auto;text-align:center; background-color: #fff">

        <h1> {!!$params['item']['name']!!}</h1>
    </div>

    <div class="" style="width:90% ; margin:20px auto; background-color: #fff">

        {!!$params['item']['content']!!}
    </div>
</div>
@endsection
