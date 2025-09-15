@if(!isset($products) || $products == null || count($products) == 0)
<div class="products-grid">
    <span>không có sản phẩm</span>
</div>
@else
@foreach ($products as $product)
<div class="col-md-4 col-xs-6">
    <div class="shop">
        <div class="shop-img">
            <img src="/storage/uploads/products/{{ $product->image }}" alt="">
        </div>
        <div class="shop-body">
            <h3>{{ $product->short_description }}</h3>
            <a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
</div>
@endforeach
@endif