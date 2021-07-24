<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        * { font-family: DejaVu Sans, sans-serif;
            font-size:12px;}
        .center-blue {
            text-align: center;
            color: blue;
        }
    </style>
</head>
<body>
<div class="container">
<div>
    <p>Rok. Akademicki: {!! $current_academic_year !!}</p>
    <p>Nazwa koła/sekcji: {!! $club_name !!}</p>
    <p>Data złożenia planu działań: {!! $current_date !!}</p>
    <p>Opis planowanych działań: {!! $report_description !!}</p>
    <p>Osoba przygotowująca sprawozdanie: {!! $person_name !!}</p>
    <p>Przewodniczący koła {!! $chairman_name !!}</p>
    <p>Opiekun: {!! $supervisor_name !!}</p>
</div>
</div>
</body>
</html>
