{{-- extending the layout  --}}
<x-layout>

    <h1 class="mb-6">Hello {{ auth()->user()->userName }} you have {{ $posts->total() }}</h1>

    {{-- Create Post Form --}}
    <div class="card mb-4">
        <h2 class="font-bold mb-4">
            Create a new post
        </h2>
        {{-- session message --}}
        @if (session('success'))
            <div class="mb-2">
                <x-flashMsg msg="{{ session('success') }}" />
            </div>
        @elseif(session('delete'))
            <div class="mb-2">
                <x-flashMsg msg="{{ session('delete') }}" />
            </div>
        @endif
        {{-- adding files  --}}
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Post Title --}}
            <div class="mb-4">
                <label for="title">Post Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="input @error('title') ring-red-500  @enderror">
                @error('title')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Post Body --}}
            <div class="mb-4">
                <label for="body">Post Content</label>
                <textarea name="body" rows="15" class="input @error('body') ring-red-500  @enderror">{{ old('body') }}</textarea>
                @error('body')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image">Cover photo</label>
                <input type="file" name="image" id="image">
                @error('image')
                <p class="error">{{ $image }}</p>
            @enderror
            </div>

            <button type="submit" class="btn mt-6">Submit</button>

        </form>
    </div>


    {{-- user post --}}

    <h2> Your latest post</h2>

    <div class="grid grid-cols-2 gap-6">
        @foreach ($posts as $post)
            {{-- since this is basically and object(associative array ) :propname="data" --}}
            <x-postCard :post="$post">
                {{-- Update  --}}
                <a href="{{ route('posts.edit', $post) }}"
                    class="bg-green-500 text-white px-2 py-1 text-xs rounded-md">Update</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                    @method('DELETE')
                    {{-- method spoofing --}}
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-2 py-1 text-xs rounded-md">delete</button>
                </form>
            </x-postCard>
        @endforeach
    </div>

    <div>
        {{-- basically since we pag we get this links meth from the posts that allows as to load more posts  --}}
        {{ $posts->links() }}
    </div>
</x-layout>
