<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>laravel list app</title>
    @yield('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        label {
            @apply block uppercase text-slate-700 mb-2
        }
        input,textarea{
            @apply shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none
        }
        .btn{
            @apply border p-1 rounded-md bg-blue-100 border-blue-400 hover:bg-blue-300
        }
    </style>
</head>

<body class="container mx-auto my-10 max-w-lg bg-slate-50 border">
    <h1 class="text-gray-700 text-2xl mb-4 mx-3 mt-3">@yield('title')</h1>
    <div>
        @if (session()->has('success'))
            <div class="text-green-700">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>

</html>
