<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\ClassStudy;

class StudentController extends Controller
{
    public function index(){
        $users = User::select([
            'users.id',
            'phone',
            'birthday',
            'address',
            'age',
            'gender',
            'first_name',
            'last_name'
        ])
        ->with('roles', 'activations')
        ->orderBy('users.id', 'asc')
        ->paginate();
        return view('admin.users.index', compact('users'));
    }
    public function edit(Request $request, $id)
    {
        $student = User::find($id);
        if ($student) {
            // foreach($student->classStudies()->get() as $class) {
            //     dd($class->getOriginal('id'));
            // }
            return view('admin.users.edit', compact('student'));
        }

        return redirect(route('product.index'))
        ->with('msg', 'Product is not exitsting!');
    }

    // public function update(ProductRequest $request, $id)
    // {
    //     $msg = 'Product is not exitsting!';
    //     $product = Product::find($id);
    //     if ($product) {
    //         $product->name = $request->input('name');
    //         $product->slug = \Str::slug($product->name);
    //         $product->category_id = $request->input('category_id');
    //         $product->quantity = $request->input('quantity');
    //         $product->price = $request->input('price');
    //         $product->description = $request->input('description');
    //         $product->save();
    //         $msg = 'Update product is success!';
    //     }

    //     try {
    //         $photo = $request->file('photo');
    //         $path = Storage::putFile('images', $photo);

    //         $image = Image::create(['name'=>$path]);
    //         $product->images()->attach($image->id);
    //     } catch (\Throwable $t) {
    //         dd($t);
    //     }

    //     return redirect(route('product.index'))
    //     ->with('msg', $msg);
    // }
}
