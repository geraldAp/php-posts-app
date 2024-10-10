<x-layout>
    <h1 class="mb-3 title">
     {{$user->userName}}'s Posts &#9830 {{$posts->total()}}
    </h1>

    <div class="grid grid-cols-2 gap-6">
        @foreach ($posts as $post)
            {{-- since this is basically and object(associative array ) :propname="data" --}}
            <x-postCard :post="$post" />
        @endforeach
    </div>

    <div>
        {{-- basically since we pag we get this links meth from the posts that allows as to load more posts  --}}
        {{ $posts->links() }}
    </div>
</x-layout>
