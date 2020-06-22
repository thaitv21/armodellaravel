<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: start;
            display: flex;
            justify-content: center;
            flex-direction: column;
            flex: 1;
        }

        .flex-start {
            align-items: flex-start;
            display: flex;
            justify-content: flex-start;
            margin-left: 20px;
        }

        .position-ref {
            position: relative;
        }

        .content {
            flex: 1;
            margin-right: 20px;
        }

        .title {
            font-size: 84px;
            text-decoration: none;
            color: #636b6f;
            margin-bottom: 20px;
        }

        .title:hover {
            color: #636b6f;
            text-decoration: none;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .btn-upload {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="flex-start position-ref full-height">
    <div class="content">
        <a class="title m-b-md" href="/">
            AR Models
        </a>

        <form method="post" action="/upload" enctype="multipart/form-data" class="flex-center">
            @csrf
            <div class="custom-file">
                <input name="model" type="file" class="custom-file-input">
                <label class="custom-file-label" for="customFile">Choose file</label>
                <input name="submit" type="submit" value="Upload" class="btn btn-primary btn-upload">
            </div>
        </form>
    </div>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function () {
            let fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
</div>
</body>
</html>
