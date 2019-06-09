@extends('base')
@section('main')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Sửa</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
            @endif
            <form method="post" action="{{ route('transactions.update', $transaction->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="code">Mã cổ phiếu</label>
                    <input type="text" class="form-control" name="code" value="{{$transaction->code}}"/>
                </div>

                <div class="form-group">
                    <label for="date">Ngày</label>
                    <input type="date" class="form-control" name="date" value="{{$transaction->date}}"/>
                </div>

                <div class="form-group">
                    <label for="type">Loại giao dịch</label>
                    <select class="form-control" id="type" name="type" value="{{$transaction->type}}">
                        @foreach(Helper::transactionType() as $transaction_type)
                            <option value="{{$transaction_type}}" @if($transaction->type == $transaction_type) selected @endif>{{Helper::transactionTypeLabel($transaction_type)}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Số lượng</label>
                    <input type="text" class="form-control" name="quantity" value="{{$transaction->quantity}}"/>
                </div>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </form>
        </div>
    </div>
@endsection