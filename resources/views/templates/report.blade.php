<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        .center-blue {
            text-align: center;
            color: blue;
        }
    </style>
</head>
<body>
<div class="center-blue">
    Sprawozdanie z działalności Koła Naukowego {{$club_name}}
    Państwowej Wyższej Szkoły Zawodowej w Elblągu
    w roku akademickim {{$current_academic_year}}
</div>
<div>
    <p>{!! nl2br(e($description)) !!}</p>
</div>
<div>
<p>W roku akademickim {{$current_academic_year}} w ramach Koła realizowane były następujące zadania:</p>
</div>

<div>
    <p>{!! nl2br(e($report_description)) !!}</p>
</div>

<div>Lista członków <b>Koła Naukowego {{$club_name}}</b> w roku akademickim {{$current_academic_year}}:</div>

<div>
    <div>1.	{{$chairman_name}} (przewodniczący)</div>
    @foreach($club_members as $club_member)
        <div>
            {{$loop->index+2}}. {{$club_member->user->name}}
        </div>
    @endforeach
</div>

<div>Opiekunem <b>Koła Naukowego {{$club_name}}</b> jest {{$supervisor_name}}.</div>

</body>
</html>
