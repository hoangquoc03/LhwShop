@if($favoriteProducts->count())
    @foreach($favoriteProducts as $product)
        <div class="d-flex align-items-center mb-2" data-id="{{ $product->id }}">
            <img src="{{ asset('storage/uploads/products/' . basename($product->image)) }}" 
                 class="mr-2 rounded" 
                 alt="{{ $product->product_name }}" 
                 style="width:40px;height:40px;object-fit:cover;">
            <div>
                <p class="mb-0 small">{{ $product->product_name }}</p>
                <span class="text-danger small">{{ number_format($product->list_price,0,',','.') }}₫</span>
            </div>
        </div>
    @endforeach
@else
    <p class="text-muted">Chưa có sản phẩm yêu thích nào.</p>
@endif
