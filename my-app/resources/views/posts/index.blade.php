{{-- extending the layout  --}}
<x-layout>
    {{-- shows for only authorized users  --}}
    <h1 class="text-2xl font-bold  mb-4">
        Latest Posts
    </h1>



    <div class="grid grid-cols-2 gap-6">
        @foreach ($posts as $post)
         <x-postCard :post="$post"/>
        @endforeach
    </div>


    <div>
        {{-- basically since we pag we get this links meth from the posts that allows as to load more posts  --}}
        {{ $posts->links() }}
    </div>
</x-layout>
