<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="" crossorigin="anonymous">

    <title>Custom Roles and Permissions</title>
</head>

<body>
    @include('layouts.nav')
    @yield('content')

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity=""
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.logout-user').click(function() {
                $.ajax({
                    url: "{{ route('logout') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                })
            })
        })
    </script>
    @stack('script')

</body>

</html>
