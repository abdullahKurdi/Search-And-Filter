<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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

    }
    public function edit($id){

        $categories = Category::all();
        $tags = Tag::all();
        $product =Product::whereId($id)->first();
        return view('frontend.edit',compact('categories','tags','product'));
    }
    public function update(Request $request , $id){

    }
    public function destroy($id){

    }
}
