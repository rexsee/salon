<?php

namespace App\Http\Controllers\Staff;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $result = Product::all();
        return view('staff.product.index', compact('result'));
    }

    public function add(Request $request)
    {
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'name' => 'max:191|required',
                'is_active' => 'boolean',
                'price' => 'required',
                'description' => 'nullable',
                'collection' => 'nullable',
                'size' => 'nullable',
                'order' => 'nullable|integer',
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:5120'
            ]);

            $image = $request->file('image');
            $file_name = 'P' . time();
            $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
            $image->move('storage/product', $full_file_name);
            Image::make('storage/product/' . $full_file_name)->fit('800', '800')->save();
            Image::make('storage/product/' . $full_file_name)->save('storage/product/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
            $inputs['image_path'] = 'storage/product/' . $full_file_name;

            Product::create($inputs);

            flash('Record added')->success();
            return redirect()->route('staff.product');
        } else {
            $lastOrder = Product::orderBy('order','desc')->first();
            $lastOrder = empty($lastOrder) ? 1 : ($lastOrder->order + 1);
            return view('staff.product.add',compact('lastOrder'));
        }

    }

    public function edit($id, Request $request)
    {
        $record = Product::findOrFail($id);
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'name' => 'max:191|required',
                'is_active' => 'boolean',
                'price' => 'required',
                'description' => 'nullable',
                'collection' => 'nullable',
                'size' => 'nullable',
                'order' => 'nullable|integer',
                'image' => 'mimes:jpeg,jpg,png,gif|max:5120'
            ]);

            if (!empty($request->image)) {
                if (File::exists($record->image_path)) {
                    File::delete($record->image_path);
                }

                $image = $request->file('image');
                $file_name = 'P' . time();
                $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
                $image->move('storage/product', $full_file_name);
                Image::make('storage/product/' . $full_file_name)->fit('800', '800')->save();
                Image::make('storage/product/' . $full_file_name)->save('storage/product/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
                $inputs['image_path'] = 'storage/product/' . $full_file_name;
            }

            $record->update($inputs);

            flash('Record updated')->success();
            return redirect()->route('staff.product');
        } else {
            $lastOrder = $record->order;
            return view('staff.product.edit', compact('record','lastOrder'));
        }
    }

    public function delete($id)
    {
        $record = Product::findOrFail($id);

        if (File::exists($record->image_path)) {
            File::delete($record->image_path);
        }

        $record->delete();

        flash('Record deleted')->warning()->important();
        return redirect()->back();
    }
}
