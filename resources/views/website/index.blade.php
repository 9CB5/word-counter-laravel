<x-layout>
    <section class="flex flex-col gap-4">
        <!-- loop through every website -->
        @foreach ($websites as $website)
            <div class="bg-white break-all p-4 rounded-xl shadow-md hover:scale-[1.01]">
                <!-- url -->
                <h2 class="border-2 border-gray-100 font-bold mb-4 p-4 rounded-xl text-center">
                    {{ $website->url }}
                </h2>

                <!-- word count section -->
                <aside class="flex flex-col items-center justify-center pb-4">
                    <p class="text-6xl">{{ $website->total_word_count }}</p>
                    <p>Word count</p>
                </aside>

                <!-- website show link -->
                <a
                    href="/websites/{{ $website->id }}"
                    class="border-2 cursor-pointer border-gray-100 flex justify-between p-4 rounded-xl hover:bg-gray-200"
                >
                    <p class="">See more</p>
                </a>
            </div>
        @endforeach

        <!-- pagination -->
        <div class="pb-24">
            {{ $websites->links() }}
        </div>
    </section>
</x-layout>