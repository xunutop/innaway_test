@extends('base')

@section('main')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="display-3"></h1>

            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Mã cổ phiếu</td>
                    <td>Nắm giữ dài nhất (ngày)</td>
                    <td>Nắm giữ ngắn nhất ( ngày )</td>
                    <td>Còn lại</td>
                </tr>
                </thead>
                <tbody>

                @foreach($dashboard['transactions'] as $transaction)
                    <tr>
                        <td>{{$transaction->code}}</td>
                        <td>{{$transaction->max_hold_time}}</td>
                        <td>{{$transaction->min_hold_time}}</td>
                        <td>{{$transaction->available}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
            </div>
@endsection