@php use App\Models\Drone; @endphp
    <!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Звіт по залишках</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Звіт по залишках</h2>

<p><strong>Позиція:</strong> {{ $position->title }}</p>

<table>

    <thead>
    <tr>
        <th>Назва</th>
        <th>Кількість</th>
        <th>Од.</th>
    </tr>
    </thead>

    <tbody>

    @foreach($leftovers as $leftover)
        <tr>
            <td>{{ $leftover->title }}</td>
            <td>{{ $leftover->quantity }}</td>
            <td>{{ $leftover->unit }}</td>
        </tr>
    @endforeach

    </tbody>

</table>

@php
    $drones = Drone::where('position_id', $position->id)->get();
@endphp

<p style="align-self: center; align-content: center; align-items: center"><strong>БОРТИ</strong></p>

@if(!empty($drones))
    <table>
        <thead>
        <tr>
            <th>Борт</th>
            <th>СН</th>
            <th>-</th>
        </tr>
        </thead>
        <tbody>
        @foreach($drones as $drone)
            <tr>
                <td>{{ $drone->type }}</td>
                <td>{{ $drone->serial_number }}</td>
                <td>{{ $drone->additional_info }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

<p><strong>Станом на:</strong> {{ now('Europe/Kyiv')->format('d-m-Y') }}</p>

</body>
</html>
