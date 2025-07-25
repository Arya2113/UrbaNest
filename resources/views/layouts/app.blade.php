<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UrbaNest - @yield('title', 'Welcome')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/favicon.png"  sizes="32x32" type="image/png">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        secondary: '#111827',
                        lightgray: '#f3f4f6',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">

    @include('partials.navbar')

     
    <div class="">
        @yield('content')
    </div>

    @yield('scripts')

</body>
</html>