<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request, $column = 'id', $direction = 'asc')
    {
        $products = Product::getAllProducts($column, $direction);
        $companies = Company::all();

        return view('index', compact('products', 'companies'))
            ->with('page_id', request()->page)
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $companies = Company::all();
        $page_id = request()->page_id; 
        return view('create', compact('page_id', 'companies'));
    }

    public function store(Request $request)
    {
        try{
        Product::createProduct($request);

            return redirect()->route('products.index')->with('success', '登録しました');
        } catch (\Exception $e) {
            \Log::error($e);

            return redirect()->route('products.index')->with('error', '登録中にエラーが発生しました'); 
    }
    }

    public function show(Product $product)
    {
        $companies = Company::all();
        return view('show', compact('product', 'companies'))->with('page_id', request()->page_id);
    }

    public function edit(Product $product)
    {
        $companies = Company::all();
        return view('edit', compact('product', 'companies'))->with('page_id', request()->page_id);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->all();

        Product::updateProduct($product, $data);

        return redirect()->route('products.index')
            ->with('success', '変更しました');
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);
            $product->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('削除中にエラーが発生しました: ' . $e->getMessage());
            DB::rollback();
            return response()->json(['success' => false]);

        }
    }
    

    public function search(Request $request,$price_min = null, $price_max = null)
    {
        $syouhinmei = $request->input('syouhinmei');
        $company_name = $request->input('company_name');
        $price_min = $request->input('price_min');
        $price_max = $request->input('price_max');
        $stock_min = $request->input('stock_min');
        $stock_max = $request->input('stock_max');

        $products = Product::searchProducts($syouhinmei, $company_name, $price_min, $price_max,$stock_min,$stock_max);
        $page_id = $request->input('page_id');

        $companies = Company::all();

        return view('index', compact('products', 'companies', 'page_id'));
    }
    
}


