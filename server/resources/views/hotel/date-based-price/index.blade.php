@extends('layout.app')
@section('title', 'Giá và phòng trống')

@section('main')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    th, td {
        /* border: 1px solid #ddd; */
        /* padding: 8px; */
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
    <!-- Content Header (Page header) -->
    <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
        enctype="multipart/form-data" method="POST"
        action="">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="">
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
        <div class="col-12 p-2">
            <div class="card card-default">
                <div class="card-body p-2">
                    <div class="row m-0 pt-2">

                        <div class="form-group col-3 p-2 mb-0">
                            <label for="name" class="font-weight-normal">Phòng</label>
                            <select name="" id="" class="form-control select2 select2-blue">
                                <option value="" data-select2-id="9">Tất cả phòng</option>
                            </select>
                        </div>
                        <div class="form-group col-3 p-2 mb-0">
                            <label for="created_at" class="font-weight-normal">Thời gian</label>
                            <input id="created_at" name="created_at" value="" type="text" class="form-control event-enter" placeholder="Chọn ngày tạo">
                        </div>
                        <form class="form-horizontal app-container" id="admin-{{ $params['prefix'] }}-form" name="admin-{{ $params['prefix'] }}-form"
                            enctype="multipart/form-data" method="POST"
                            action="">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $params['item']['id'] }}">
                            <div class="modal fade" id="modal-lg" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title">Thiết lập giá</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="col-12">
                                            @foreach ($params['item']['roomTypes'] as $room_types)
                                                @foreach ($room_types['priceTypes'] as $price_types)

                                                <div class="card-header">
                                                    <h3 class="card-title font-weight-bold">{{$room_types['name']}}</h3>
                                                    <br>
                                                    <p>{{$price_types['name']}}</p>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body table-responsive p-0">
                                                    <table class="table table-head-fixed text-nowrap">
                                                        <thead>
                                                        <tr>
                                                            <th>Sức chứa</th>
                                                            <th>Giá</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($price_types['priceRules']->sortByDesc('capacity') as $index => $price_rule)
                                                        @if ($price_rule['room_type_id'] == $room_types['id'] && $price_rule['price_type_id']== $price_types['id'])
                                                        <tr>
                                                            <td>
                                                                x{{$price_rule['capacity']}} {{$price_rule['capacity'] == $room_types['standard_capacity'] ? '(Tiêu chuẩn)' : ''}}
                                                            </td>
                                                            <td class="row">
                                                                <div class="col-6 p-2">
                                                                {{
                                                                    $price_rule['type'] == 'increase' ? 'Tăng thêm trên giá tiêu chuẩn' :
                                                                    ($price_rule['type'] == 'decrease' ? 'Giảm trên giá tiêu chuẩn' : 'Giá tiêu chuẩn')
                                                                }}
                                                                </div>
                                                                @if ($price_rule['capacity'] != $room_types['standard_capacity'])
                                                                    <div class="input-group col-6">
                                                                        <input type="hidden" name="rules[{{$room_types['id']}}][{{$price_types['id']}}][type][]" value="{{$price_rule['type']}}">
                                                                        <input type="hidden" name="rules[{{$room_types['id']}}][{{$price_types['id']}}][price_standard]" value="{{$room_types['price_standard']}}">
                                                                        <input type="hidden" name="rules[{{$room_types['id']}}][{{$price_types['id']}}][capacity][]" value="{{$price_rule['capacity']}}">
                                                                        <input type="text" class="form-control number_format status_{{$room_types['id']}}_{{$price_types['id']}}_{{$index}}" id="price"
                                                                                name="rules[{{$room_types['id']}}][{{$price_types['id']}}][price][]" value="{{$price_rule['price'] ?? ''}}">
                                                                        <div class="input-group-append">
                                                                            <div class="input-group-text">VND</div>
                                                                        </div>


                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($price_rule['capacity'] != $room_types['standard_capacity'])
                                                                <div class="form-group mt-2">
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" class="custom-control-input" name="rules[{{$room_types['id']}}][{{$price_types['id']}}][status][]"
                                                                        id="status_{{$room_types['id']}}_{{$price_types['id']}}_{{$index}}" {{!empty($price_rule['price']) ? 'checked' : ''}} value="active">
                                                                        <label class="custom-control-label" for="status_{{$room_types['id']}}_{{$price_types['id']}}_{{$index}}"></label>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Huỷ</button>
                                    @include('include.btn.save')
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </form>
                    </div>
                    <div class="row p-2">
                        <div class="col-12 text-right">
                            <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modal-lg">
                                Thiết lập giá
                            </button>
                            <button type="submit" class="btn btn-sm btn-search btn-primary">
                                <i class="fa fa-search "></i> Tìm kiếm
                            </button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <table class="table nowrap table-bordered no-footer text-left table-striped">
                                <thead>
                                    <tr class="date-header" style="overflow-x: 200px">
                                        @php
                                            // Lấy tất cả các ngày từ date_based_prices
                                            $dates = [];
                                            foreach ($params['item']['roomTypes'] as $room_type) {
                                                foreach ($room_type['priceTypes'] as $price_type) {
                                                    foreach ($price_type['date_based_prices'] as $price) {
                                                        $dates[] = $price['date'];
                                                    }
                                                }
                                            }
                                            // Lọc ra các ngày duy nhất
                                            $unique_dates = array_unique($dates);

                                            // Lấy các giá trị capacity duy nhất
                                            $unique_capacities = collect($params['item']['roomTypes'])
                                                ->flatMap(function ($room_type) {
                                                    return collect($room_type['priceTypes'])
                                                        ->flatMap(function ($price_type) {
                                                            return collect($price_type['date_based_prices'])
                                                                ->flatMap(function ($date_based_price) {
                                                                    return $date_based_price['capacity_prices'];
                                                                });
                                                        });
                                                })->pluck('capacity')->unique();
                                        @endphp
                                        <th></th>
                                        @foreach ($unique_dates as $date)
                                            <th>{{ ucfirst(\Carbon\Carbon::parse($date)->isoFormat('dddd [Ngày] D')) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>

                                @foreach ($params['item']['roomTypes'] as $room_type)
                                <tbody>
                                    <tr class="room-row">
                                        <td class="room-title font-weight-bold" rowspan="1">{{ $room_type['name'] }}</td>
                                    </tr>

                                    <tr class="room-row">
                                        <td>Trạng thái</td>
                                        @foreach ($room_type['priceTypes'][0]['date_based_prices'] ?? [] as $date_based_price)
                                            <td>{{ $date_based_price['status'] == 'active' ? 'Mở' : 'Đóng' }}</td>
                                        @endforeach
                                    </tr>

                                    <tr class="room-row">
                                        <td>Số phòng tiêu chuẩn</td>
                                        @foreach ($room_type['priceTypes'][0]['date_based_prices'] ?? [] as $date_based_price)
                                            <td>{{ $date_based_price['quantity'] }}</td>
                                        @endforeach
                                    </tr>

                                    @foreach ($room_type['priceTypes'] as $price_type)
                                    <tr class="room-row">
                                        <td>{{ $price_type['name'] }}<br> x{{ $room_type['standard_capacity'] }} <a href="#">Chỉnh sửa</a></td>

                                        @foreach ($unique_dates as $date)
                                            @php
                                                // Lọc date_based_price theo ngày
                                                $date_based_price = collect($price_type['date_based_prices'])->firstWhere('date', $date);
                                            @endphp

                                            @if ($date_based_price)
                                                <td>{{ number_format($date_based_price['price'], 0, ',', '.') . ' ₫' }}</td>

                                            @endif
                                        @endforeach
                                    </tr>

                                    <!-- Dòng cho các giá trị capacity -->
                                    @foreach ($unique_capacities as $capacity)
                                        <tr class="room-row">
                                            <td>x{{ $capacity }}</td>
                                            @foreach ($unique_dates as $date)
                                                @php
                                                    $capacity_price_for_date = null;
                                                    // Tìm date_based_price cho từng ngày
                                                    foreach ($room_type['priceTypes'] as $price_type) {
                                                        $date_based_price = collect($price_type['date_based_prices'])->firstWhere('date', $date);
                                                        if ($date_based_price) {
                                                            // Tìm capacity_price cho từng capacity
                                                            $capacity_price_for_date = collect($date_based_price['capacity_prices'])->firstWhere('capacity', $capacity);
                                                            if ($capacity_price_for_date) {
                                                                break;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @if ($capacity_price_for_date)
                                                    <td>{{ number_format($capacity_price_for_date['price'], 0, ',', '.') . ' ₫' }}</td>

                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">&nbsp;</div>
    </form>
    <script>
        $(document).ready(function() {
            $('#admin-{{ $params['prefix'] }}-form').submit(function(e) {

                $('.input-error').html('');
                $('.form-group row p-0 m-0 mb-2 input').removeClass('is-invalid');
                e.preventDefault();
                var formData = new FormData(this);const formEl = $(this)
                $.ajax({
                    type: 'POST',
                    url: "{{ route($params['prefix'] . '.price-rule' . '.update', ['price_rule' => $params['item']['id']]) }}",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {

                        //
                        // setTimeout(() => {
                        //     location.reload();
                        // }, "1000");
                    },
                    error: function(data) {

                        for (x in data.responseJSON.errors) {
                            console.log('data.responseJSON.errors', $('#' + x).parents());
                            $('#' + x).parents('.form-group').find('.input-error').html(data
                                .responseJSON.errors[x]);
                            $('#' + x).parents('.form-group').find('.input-error').show();
                            $('#' + x).addClass('is-invalid');
                        }
                    }
                });
            });
            adminIndex("{{$params['prefix']}}","{{$params['controller']}}","{{$params['action']}}",'{{route($params["prefix"]. '.' . $params["controller"] . ".index")}}');
            dateFromTo('#created_at', null, null, 'YYYY/MM/DD');
            $('input[type="checkbox"].custom-control-input').change(function() {
                var checkboxId = $(this).attr('id');
                var priceInput = $('.' + checkboxId);

                if ($(this).prop('checked')) {
                    priceInput.prop('readonly', false);
                } else {
                    priceInput.val('');
                    priceInput.prop('readonly', true);
                }
            });
            $('input[type="checkbox"].custom-control-input').each(function() {
                var checkboxId = $(this).attr('id');
                var priceInput = $('.' + checkboxId);
                if ($(this).prop('checked')) {
                    priceInput.prop('readonly', false);
                } else {
                    priceInput.prop('readonly', true);
                }
            });
        });
    </script>
@endsection
