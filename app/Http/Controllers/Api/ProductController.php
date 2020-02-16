<?php

namespace App\Http\Controllers\Api;
use App\Product;
use App\ProductImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use Carbon\Carbon;
class ProductController extends Controller
{
  public function getAll(Request $request)
    {

      $limit = 20;
      $offset = 0;
      if($request->get('offset')) {
        $offset = $request->get('offset');
      }
      $total = Product::count();

      $row_count = ($offset + 1) * $limit;
      $is_data_exists = false;
      if($row_count < $total) {
        $is_data_exists = true;
      }
      $products = Product::with([ 'category' ])->limit($limit)->skip($offset)->get();

      return response([ 'products' => $products, 'is_data_exists' => $is_data_exists ]);
    }
    public function save(Request $request)
    {
      // echo json_encode(["test" => 1]);die;
       $validated_data = $request->validate([
        "name" => "required|max:55",
        "quantity" => "required",
        "price" => "required",
        "description" => "required",
        "category_id" => "required",
      ]);
       
      $product = Product::create($validated_data);

      $files = $request->file('images');

      $file_data = [];
        if($request->hasFile('images'))
        {
            foreach ($files as $file) {
               /*$path = Storage::putFileAs(
                  'images', $file, $product->id
              );*/
              $path = Storage::putFile('images', $file);
               $file_data[] = [ 'product_id' => $product->id, 'image_name' => basename($path), 'created_at' => Carbon::now() ];
            }
        }

      if(count($file_data)) {
      ProductImage::insert($file_data);
      }

      return response([ 'product' => $product, 'file_data' => $file_data ]);
    }
}
