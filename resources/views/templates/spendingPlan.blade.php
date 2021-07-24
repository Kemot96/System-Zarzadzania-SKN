<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        * { font-family: DejaVu Sans, sans-serif;
            font-size:12px;}
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        thead {
            background-color: rgba(255, 232, 23, 0.77);
        }
    </style>
</head>
<body>
<div class="container">
<table>
    <thead>
    <tr>
        <td>L.p.</td>
        <td>Rodzaj</td>
        <td>Przedmiot</td>
        <td>Opis</td>
        <td>Ilość</td>
        <td>Wartość szacunkowa brutto PLN</td>
        <td>Termin (m-c)</td>
    </tr>
    </thead>
    <tbody>
    @foreach($report->orders as $order)
        <tr>
            <td></td>
            <td>{{$order->type}}</td>
            <td>{{$order->name}}</td>
            <td>{{$order->description}}</td>
            <td>{{$order->quantity}}</td>
            <td>{{$order->gross}}</td>
            <td>{{$order->term}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
</body>
</html>


