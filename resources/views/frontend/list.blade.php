@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-3">
            <form action="{{route('project.list')}}" method="post">
                @csrf
                <h3>Search</h3>
                <div class="form-group pb-3">
                    <input type="text" name="keyword" class="form-control" value="{{old('keyword',$keyword)}}" placeholder="Search">
                </div>
                <div class="pb-3">
                    <h3>Price</h3>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="price" value="price_0_500" {{isset($select_price) && $select_price == 'price_0_500' ? 'checked':''}}> 0 - 500
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="price" value="price_501_1500" {{isset($select_price) && $select_price == 'price_501_1500' ? 'checked':''}}> 501 - 1500
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="price" value="price_1501_3000" {{isset($select_price) && $select_price == 'price_1501_3000' ? 'checked':''}}> 1501 - 3000
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="price" value="price_3000_5000" {{isset($select_price) && $select_price == 'price_3000_5000' ? 'checked':''}}> 3001 - 5000
                        </label>
                    </div>
                </div>
                <div class="pb-3">
                    <h3>Category</h3>
                    @foreach($categories as $category)
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="category" value="{{$category->id}}" {{isset($select_category) && $select_category == $category->id ? 'checked':''}}> {{$category->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="pb-3">
                    <h3>Tags</h3>
                    @foreach($tags as $tag)
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="tags[]" value="{{$tag->id}}" {{isset($select_tags) && in_array($tag->id,$select_tags) ? 'checked':''}}> {{$tag->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                </div>
                <div class="form-group pb-3">
                    <a href="{{route('project.list')}}" class="btn btn-danger btn-block">Rest</a>
                </div>
            </form>
        </div>
        <div class="col-9">

            <div class="d-flex justify-content-center">
                {{$products->appends(request()->input())->links()}}
            </div>
        </div>
    </div>

@endsection