<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        * { font-family: DejaVu Sans, sans-serif;
            font-size:12px;}
        .center {
            font-weight: bold;
            text-align: center;
            margin-left: 2.5cm;
            margin-right: 2.5cm;
            margin-bottom: 0.5cm;
        }

        .right {
            text-align: right;
            margin-bottom: 1cm;
        }
    </style>
</head>
<body>
<div class="container">
<div>
    <div class="right">Elbląg, dn. {!! $current_date !!}</div>
    <div class="center">
        <p>Plany {{$club_name}}</p>
        <p>na rok {{$current_academic_year}}</p>
    </div>

    <div>{!! $report_description !!}</div>
</div>
</div>
</body>
</html>
