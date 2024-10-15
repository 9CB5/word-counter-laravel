<x-layout>
    <form
        method="POST" action="/websites"
        class="bg-white p-4 flex flex-col gap-4 rounded-lg"
    >
        @csrf

        <!-- form instructions -->
        <h2 class="pb-12 text-xl">To begin, enter up to 5 URL's below</h2>

        <!-- url inputs -->
        @for ($i = 0; $i < 5; $i++)
            <!-- accepts valid url OR blank input -->
            <input
                aria-label="url-{{ $i + 1 }}"
                class="border border-gray-100 p-2 rounded-lg w-full"
                name="{{ $i }}"
                pattern="https?://.*"
                placeholder="Enter full URL..."
                type="url"
            />
        @endfor

        <!-- submit button -->
        <input
            aria-label="Submit URLs"
            class="bg-indigo-400 p-4 rounded-lg text-white cursor-pointer mt-12"
            type="submit"
            value="Submit"
        />
    </form>
</x-layout>