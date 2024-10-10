{{-- extending the layout  --}}
<x-layout>
    <h1 class="title">
        Register a New Account
    </h1>

    <div class="mx-auto max-w-screen-sm card">
        <form action="{{route('register')}}" method="POST">
            {{-- security against csrf attacks  --}}
            @csrf

            {{-- username --}}
            <div class="mb-4">
                <label for="username">Username</label>
                <input type="text" name="userName" value="{{old('username')}}"
                    class="input @error('userName') ring-red-500  @enderror">
                {{-- outputing errors done by laravel behind the scenes  --}}
                @error('username')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- email --}}
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{old('email')}}" class="input @error('email') ring-red-500  @enderror">
                @error('email')
                <p class="error">
                    {{ $message }}
                </p>
            @enderror
            </div>
            {{-- password --}}
            <div class="mb-4">
                <label for="password">Password</label>
                <input type="text" name="password"  class="input @error('password') ring-red-500  @enderror">
                @error('password')
                <p class="error">
                    {{ $message }}
                </p>
            @enderror
            </div>
            {{-- password --}}
            <div class="mb-4">
                <label for="password_confirmation">Confirm Password</label>
                <input type="text" name="password_confirmation" class="input  @error('password') ring-red-500  @enderror">
            </div>

            <button type="submit" class="btn">
                Submit
            </button>
        </form>

    </div>
</x-layout>
