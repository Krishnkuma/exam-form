<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    {{-- Bootstrap CSS --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">

    <style>
        body {
            margin: 0;
        }

        .sidebar {
            width: 17%;
            background: #343a40;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding-top: 20px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .active {
            background: #ff5722;
        }

        .content {
            margin-left: 17%;
            /* Matches sidebar width */
            padding: 20px;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .btn-stylish {
            display: inline-block;
            padding: 12px 24px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            color: #fff;
            background: linear-gradient(45deg, #007bff, #00d4ff);
            border: none;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .btn-stylish:hover {
            background: linear-gradient(45deg, #0056b3, #008bb5);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
        }

        .btn-verify {
            background: linear-gradient(45deg, #28a745, #34d058);
            color: white;
        }

        .btn-verify:hover {
            background: linear-gradient(45deg, #218838, #2b8e3f);
        }

        .btn-unverify {
            background: linear-gradient(45deg, #dc3545, #e03e3e);
            color: white;
        }

        .btn-unverify:hover {
            background: linear-gradient(45deg, #c82333, #ba2d2d);
        }

        .table-container {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 1rem;
            margin-top: 1rem;
        }

        table.table {
            border-collapse: separate;
            border-spacing: 0;
        }

        table.table thead {
            background: #343a40;
            color: #fff;
        }

        table.table th, table.table td {
            vertical-align: middle;
            text-align: center;
        }

        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 1rem;
        }

        .pagination .page-link {
            border-radius: 50% !important;
            margin: 0 3px;
            color: #343a40;
        }

        .pagination .page-item.active .page-link {
            background-color: #ff5722;
            border-color: #ff5722;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <a href = ""> <h5 class="p-1 text-center h5 " style="color:#d6dde6">Admin Portal</h5></a>
        <a href ="">Exam Forms</a>
        {{-- <a href=" {{ route('logout') }} ">Logout</a>  --}}
    </div>

    {{-- <div class="content">
        <h2> @yield('title', 'Dashboard') </h2>
    </div> --}}

    <div class="content">
        @yield('content')
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>


    <script>
        var quill = new Quill('#description', {
            theme: 'snow',
            placeholder: 'Write your description here...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    ['link'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }]
                ]
            },
            height: 300
        });
    </script>

</body>

</html>
