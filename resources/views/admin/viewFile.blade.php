<!DOCTYPE html>
<html>
<head>
    <title>View file</title>
    <style>
        iframe{
            position: fixed;
            background: #000;
            border: none;
            top: 0; right: 0;
            bottom: 0; left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
<iframe src="{{asset('public/media/' . $item->file_name)}}" style="width:100%;" frameborder="0"></iframe>
</body>
</html>

