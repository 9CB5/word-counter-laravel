<x-layout>
    <section class="flex flex-col gap-4">
        <div class="bg-white p-4 rounded-xl shadow-md hover:scale-[1.01]">
            <!-- url -->
            <h2 class="border-2 border-gray-100 break-all font-bold mb-4 p-4 rounded-xl text-center">
                {{ $website->url }}
            </h2>

            <!-- word count -->
            <aside class="flex flex-col items-center justify-center pb-4">
                <p class="text-6xl">{{ $website->total_word_count }}</p>
                <p>Word count</p>
            </aside>

            <!-- top 10 keywords -->
            <h2 class="bg-cyan-200 font-bold my-4 p-4 rounded-md text-xl">Top 10 Keywords</h2>

            <!-- keyword table header -->
            <aside class="bg-white border-2 border-gray-100 rounded-md">
                <div class="border-b-4 border-gray-100 flex font-bold p-4 text-left">
                    <p class="w-full">Keyword</p>
                    <p class="w-full">Frequency</p>
                    <p class="w-full">Density</p>
                </div>
            </aside>

            <!-- keyword table body -->
            @foreach($website->keywords as $item)
                <aside class="bg-white border-2 border-gray-100 rounded-md hover:bg-gray-100">
                    <div class="flex p-4 text-left">
                        <p class="break-all capitalize w-full">{{ $item->keyword }} </p>
                        <p class="w-full">{{ $item->pivot->frequency }}</p>
                        <p class="w-full">{{ $item->pivot->density }}%</p>
                    </div>
                </aside>
            @endforeach

            <!-- top 10 phrases -->
            <h2 class="bg-cyan-200 font-bold my-4 p-4 rounded-md text-xl">Top 10 Phrases</h2>

            <!-- phrases table header -->
            <aside class="bg-white border-2 border-gray-100 rounded-md">
                <div class="border-b-4 border-gray-100 flex font-bold p-4 text-left">
                    <p class="w-full">Phrase</p>
                    <p class="w-full">Frequency</p>
                    <p class="w-full">Density</p>
                </div>
            </aside>

            <!-- phrases table body -->
            @foreach($website->phrases as $item)
                <aside class="bg-white border-2 border-gray-100 rounded-md hover:bg-gray-100">
                    <div class="flex p-4 text-left">
                        <p class="break-all capitalize w-full">{{ $item->phrase }} </p>
                        <p class="w-full">{{ $item->pivot->frequency }}</p>
                        <p class="w-full">{{ $item->pivot->density }}%</p>
                    </div>
                </aside>
            @endforeach
        </div>
    </section>
</x-layout>