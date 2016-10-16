<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\BaseController;

use App\Product;

use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return $this->response->array($products->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'alpha'],
            'price' => ['required', 'min:7'],
            'quantity' => ['required', 'min:7']
        ];

        $product = app('request')->only('name', 'price', 'quantity', 'image');
        
        $validator = app('validator')->make($product, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create new product.', $validator->errors());
        }

        Product::create($product);
        return $this->response->created();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return $this->response->array($product->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $rules = [
            'name' => ['required', 'alpha'],
            'price' => ['required', 'min:7'],
            'quantity' => ['required', 'min:7']
        ];

        $data = app('request')->only('name', 'price', 'quantity', 'image');
        
        $validator = app('validator')->make($data, $rules);

        if ($validator->fails()) {
            throw new UpdateResourceFailedException('Could not update new product.', $validator->errors());
        }
        $product = Product::findOrFail($id);
        
        $product->update($data);

        return $this->response->array($product->toArray());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
                
        $product->delete();

        return $this->response->array($product->toArray());

    }
}
