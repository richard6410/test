<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Response;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        // リクエストから必要な情報を取得
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // 商品の存在チェック
        $product = Product::findOrFail($productId);

        // 在庫があるかチェック
        if ($product->zaikosuu < $quantity) {
            return response()->json(['error' => '在庫が不足しています。'], Response::HTTP_BAD_REQUEST);
        }

        // トランザクションを開始
        try {
            \DB::beginTransaction();

            // salesテーブルにレコード追加
            $sale = new Sale();
            $sale->product_id = $productId;
            $sale->quantity = $quantity;
            $sale->save();

            // productsテーブルの在庫減算
            $product->zaikosuu -= $quantity;
            $product->save();

            // トランザクションのコミット
            \DB::commit();

            return response()->json(['success' => true], Response::HTTP_OK);
        } catch (\Exception $e) {
            // エラー時はロールバック
            \DB::rollBack();
            return response()->json(['error' => '購入処理に失敗しました。'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
