@extends('app')

@section('content')
<form action="{{ route('product.search') }}" method="GET" class="mb-3" id="searchForm">
    <div class="row">
        <div class="col">
            <input type="text" name="syouhinmei" class="form-control" placeholder="商品名で検索">
        </div>

        <div class="col">
            <input type="number" name="price_min" class="form-control" placeholder="最小価格">

        </div>

        <div class="col">
            <input type="number" name="price_max" class="form-control" placeholder="最大価格">
        </div>

        <div class="col">
            <input type="number" name="stock_min" class="form-control" placeholder="最小在庫数">
        </div>

        <div class="col">
            <input type="number" name="stock_max" class="form-control" placeholder="最大在庫数">
        </div>
            
        <div class="col">
            <select name="company_name" class="form-control">
                <option value="" selected>メーカーを選択</option>

                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary">検索</button>
        </div>
    </div>
</form>
    <div class="text-right">
    <a class="btn btn-success" href="{{ route('product.create')}}">新規登録</a>
    </div>
</div>
</div>
<div class="col-lg-12">
    @if ($message =Session::get('success'))
        <div class="alert-success mt-1"><p>{{$message}}</p></div>
    @endif
</div>
</div>

<div id="searchResults">
<table class="table table-bordered" id="productTable">
    <thead>
        <tr>
            <th data-sort="id">ID</th>
            <th data-sort="image">商品画像</th>
            <th data-sort="syouhinmei">商品名</th>
            <th data-sort="kakaku">価格</th>
            <th data-sort="zaikosuu">在庫数</th>
            <th data-sort="company_name">メーカー名</th>
            <th></th>
            <th></th>

        </tr>
    </thead>
        <tbody>
        @foreach ($products as $product)
        <tr>
            <td style="text-align:right">{{$product->id}}</td>
            <td>
                @if ($product->image)
                <img src="{{ asset('storage/images/' . $product->image) }}" alt="商品画像" class="img-thumbnail" width="100">
                @else
                画像なし
                @endif
            </td>
            <td><a class="" href="{{ route('product.show', $product->id) }}">{{$product->syouhinmei}}</a></td>
            <td style="text-align:right">{{$product->kakaku}}円</td>
            <td style="text-align:right">{{$product->zaikosuu}}</td>
            <td style="text-align:right">{{$product->company_name}}</td>
            <td style="text-align:center">
                <a class="btn btn-primary" href="{{ route('product.show', $product->id) }}">詳細</a>
            </td>
            <td style="text-align:center">
                <form id="deleteForm{{$product->id}}" action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteProduct({{ $product->id }})">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

    {!! $products->links('pagination::bootstrap-5') !!}
    </div>

    <script>
        $(document).ready(function() {
            function initializeTableSorter() {
            $('#productTable').tablesorter();
            }

            initializeTableSorter();

            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: $(this).attr('action'),
                    data: {
                        syouhinmei: $('input[name="syouhinmei"]').val(),
                        company_name: $('select[name="company_name"]').val(),
                        price_min: $('input[name="price_min"]').val(),
                        price_max: $('input[name="price_max"]').val(),
                        stock_min: $('input[name="stock_min"]').val(),
                        stock_max: $('input[name="stock_max"]').val(),
                    },
                    success: function(response) {
                        $('#searchResults').html(response);
                        initializeTableSorter();
                    }
                });
            });
        });

    function deleteProduct(productId) {
        if (confirm("削除しますか？")) {
            $.ajax({
                type: 'DELETE',
                url: '/products/' + productId,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.success) {
                        // 削除が成功したら、該当の行を非表示にする
                        $('#row' + productId).hide();
                        alert('削除が完了しました');
                    } else {
                        alert('削除に失敗しました');
                    }
                },
                error: function () {
                    alert('エラーが発生しました');
                }
            });
        }
    }
    </script>

@endsection