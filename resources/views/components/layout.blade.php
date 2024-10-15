<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>Word counter - Click intelligence</title>
    <meta name="author" content="Christian Barcelona">
    <meta name="description" content="Simple website word counter">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 bg-wave bg-no-repeat bg-cover min-h-screen">
    <!-- header -->
    <header class="bg-white flex gap-4 items-center justify-center p-4 shadow-md">
        <!-- branding -->
        <div class="flex flex-col justify-center items-center pb-4">
            <img alt="logo" src="{{asset('images/logo.svg')}}">
            <h1 class="font-bold text-2xl">Word counter</h1>
        </div>
    </header>

    <!-- main section -->
    <main class="min-h-screen">
        <div class="min-h-screen mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <!-- nav section -->
            <nav class="flex flex-wrap gap-4 items-center mb-4 rounded-md">
                <a
                    class="bg-cyan-200 px-4 py-2 rounded-md text-center text-gray-500 w-[6rem]"
                    href="/"
                >
                    &#43 Create
                </a>

                <a
                    class="bg-cyan-200 block px-4 py-2 rounded-md text-center text-gray-500 w-[6rem]"
                    href="/websites"
                >
                    &#x1F50E View
                </a>
            </nav>

            {{ $slot }}
        </div>
    </main>
</body>

</html>

<style>
    .bg-wave {
        background-image: url("{{ asset('/images/login-wave.svg') }}");
    }

    .bg-transparent {
        background-color: transparent;
    }
</style>