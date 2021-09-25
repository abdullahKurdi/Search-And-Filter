<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index(Request $request){

        $keyword = $request->has('keyword') ? $request->get('keyword'):null;
        $select_price = $request->has('price') ? $request->get('price'):null;
        $select_category = $request->has('category') ? $request->get('category'):null;
        $select_tags = $request->has('tags') ? $request->get('tags'):[];

        //dd($request->all());

        $categories = Category::all();
        $tags = Tag::all();

        $products = Product::with(['category','tags']);

        if($keyword != null){
            $products = $products->search($keyword);
        }

        if($select_price != null){
            $products = $products->when($select_price , function ($q) use ($select_price){
                if($select_price == 'price_0_500'){
                    $q -> whereBetween('price',[0,500]);
                }elseif ($select_price == 'price_501_1500'){
                    $q -> whereBetween('price',[501,1500]);
                }elseif ($select_price == 'price_1501_3000'){
                    $q -> whereBetween('price',[1501,3000]);
                }elseif ($select_price == 'price_3000_5000'){
                    $q -> whereBetween('price',[3000,5000]);
                }
            });
        }

        if($select_category != null){
            $products = $products->whereCategoryId($select_category);
        }

        if(is_array($select_tags) && !empty($select_tags)){
            $products = $products->whereHas('tags',function ($q) use ($select_tags){
               $q->whereIn('product_tag.tag_id',$select_tags);
            });
        }

        $products = $products->orderByDesc('id');
        $products = $products->paginate(9);

        return view('frontend.index',compact('products' , 'categories' , 'tags' , 'keyword' , 'select_price', 'select_category' , 'select_tags'));
    }

    public function list(Request $request){

        $keyword = $request->has('keyword') ? $request->get('keyword'):null;
        $select_price = $request->has('price') ? $request->get('price'):null;
        $select_category = $request->has('category') ? $request->get('category'):null;
        $select_tags = $request->has('tags') ? $request->get('tags'):[];

        //dd($request->all());

        $categories = Category::all();
        $tags = Tag::all();

        $products = Product::with(['category','tags']);

        if($keyword != null){
            $products = $products->search($keyword);
        }

        if($select_price != null){
            $products = $products->when($select_price , function ($q) use ($select_price){
                if($select_price == 'price_0_500'){
                    $q -> whereBetween('price',[0,500]);
                }elseif ($select_price == 'price_501_1500'){
                    $q -> whereBetween('price',[501,1500]);
                }elseif ($select_price == 'price_1501_3000'){
                    $q -> whereBetween('price',[1501,3000]);
                }elseif ($select_price == 'price_3000_5000'){
                    $q -> whereBetween('price',[3000,5000]);
                }
            });
        }

        if($select_category != null){
            $products = $products->whereCategoryId($select_category);
        }

        if(is_array($select_tags) && !empty($select_tags)){
            $products = $products->whereHas('tags',function ($q) use ($select_tags){
                $q->whereIn('product_tag.tag_id',$select_tags);
            });
        }

        $products = $products->orderByDesc('id');
        $products = $products->paginate(9);

        return view('frontend.list',compact('products' , 'categories' , 'tags' , 'keyword' , 'select_price', 'select_category' , 'select_tags'));
    }

    public function create(){

        $categories = Category::all();
        $tags = Tag::all();
        return view('frontend.create',compact('categories','tags'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'          => 'required',
            'description'   =>'required',
            'price'         =>'required|numeric',
            'category_id'   =>'required',
            'tags'          =>'required',
            'image'         =>'required'
        ]);
        //var_dump($request->all());
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $product = Product::create([
            'name'          =>$request->name,
            'description'   =>$request->description,
            'price'         =>$request->price,
            'category_id'   =>$request->category_id,
            'image'         =>$request->image,
        ]);

        $product->tags()->attach($request->tags);

        return redirect()->route('project.create')->with([
            'message'=>'Product Added Successfully',
            'alert-type'=>'success'
        ]);
    }

    public function edit($id){

        $categories = Category::all();
        $tags = Tag::all();
        $product =Product::whereId($id)->first();
        return view('frontend.edit',compact('categories','tags','product'));
    }

    public function update(Request $request , $id){
        $validator = Validator::make($request->all(),[
            'name'          => 'required',
            'description'   =>'required',
            'price'         =>'required|numeric',
            'category_id'   =>'required',
            'tags'          =>'required',
            'image'         =>'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = Product::whereId($id)->first();

        $data['name']           =$request->name;
        $data['description']    =$request->description;
        $data['price']          =$request->price;
        $data['category_id']    =$request->category_id;
        $data['image']          =$request->image;

        $product->update($data);
        $product->tags()->sync($request->tags);

        return redirect()->route('project.list')->with([
            'message'=>'Product Updated Successfully',
            'alert-type'=>'success'
        ]);
    }

    public function destroy($id){
        $product = Product::whereId($id)->first();
        if($product){
            $product->delete();
            return redirect()->route('project.list')->with([
                'message'=>'Product Deleted Successfully',
                'alert-type'=>'success'
            ]);
        }
    }
}
