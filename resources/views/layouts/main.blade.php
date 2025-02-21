<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCATina</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    @include('layouts.partials.header')

    <div id="content">
        @yield('content')
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', 'a.ajax-link', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            $('#content').load(url + ' #content > *');
        });
    </script>
</body>

</html>