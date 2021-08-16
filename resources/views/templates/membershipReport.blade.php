<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        * { font-family: DejaVu Sans, sans-serif;
            font-size:15px;}
        .center-blue {
            font-weight: bold;
            text-align: center;
            color: #526ce0;
            margin-left: 2.5cm;
            margin-right: 2.5cm;
        }
        @page {
            margin-left: 2.5cm;
            margin-right: 3cm;
        }

    </style>
</head>
<body>
<div class="container">
    <div>Lista członków <b>Koła Naukowego {{$club_name}}</b> w roku akademickim {{$academicYear->name}}:</div>

    <div>
        @if($chairman_name)
            <div>1.	{{$chairman_name}} (przewodniczący)</div>
            @foreach($club_members as $club_member)
                <div>
                    {{$loop->index+2}}. {{$club_member->user->name}}
                </div>
            @endforeach
        @else
            @foreach($club_members as $club_member)
                <div>
                    {{$loop->index+1}}. {{$club_member->user->name}}
                </div>
            @endforeach
        @endif
    </div>
    <div>Opiekunem <b>Koła Naukowego {{$club_name}}</b> jest {{$supervisor_name}}.</div>
</div>
</body>
</html>
