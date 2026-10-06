@php
    use Illuminate\Support\Str;
    use App\Models\ShopProductPost;

    $post = ShopProductPost::select('id', 'post_image', 'post_title', 'post_content')->find($post_id ?? null);

    if (!$post) {
        return;
    }
@endphp

<img src="{{ Str::startsWith($post->post_image, ['http://', 'https://'])
    ? $post->post_image
    : asset('storage/uploads/products/' . $post->post_image) }}"
    alt="{{ $post->post_title }}" class="w-100" style="height:100vh; object-fit:cover;">

<style>
    .post-image-wrapper {
        width: 100vw;
        margin-left: calc(-50vw + 50%);
        overflow: hidden;
    }

    .post-image-full {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }
</style>
