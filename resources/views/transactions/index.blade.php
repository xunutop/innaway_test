@extends('base')

@section('main')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="display-3">Lịch sử giao dịch</h1>
            <h3><a href="{{ route('transactions.create')}}" class="btn btn-primary">Tạo mới </a></h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Mã cổ phiếu</td>
                    <td>Ngày</td>
                    <td>Lệnh</td>
                    <td>Số lượng</td>
{{--                    <td colspan = 2>Actions</td>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transactions)
                    <tr>
                        <td>{{$transactions->id}}</td>
                        <td>{{$transactions->code}}</td>
                        <td>{{$transactions->date}}</td>
                        <td>{{Helper::transactionTypeLabel($transactions->type)}}</td>
                        <td>{{$transactions->quantity}}</td>
{{--                        <td>--}}
{{--                            <a href="{{ route('transactions.edit',$transactions->id)}}" class="btn btn-primary">Sửa</a>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <form action="{{ route('transactions.destroy', $transactions->id)}}" method="post">--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <button class="btn btn-danger" type="submit">Xóa</button>--}}
{{--                            </form>--}}
{{--                        </td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
            </div>
@endsection