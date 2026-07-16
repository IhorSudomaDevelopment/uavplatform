@php use App\Models\Flight;use App\ValuesObject\Target;use App\ValuesObject\TargetStatus;use Illuminate\Support\Facades\DB; @endphp
<div x-data="{ copied: false }" class="space-y-4">
    <div id="reportText">
        <div>
            <b>Підсумки по польотах за {{ $from }} - {{ $to }}</b>
            <br>
            <br>
            200: {{ $personnel200 }}
            <br>
            300: {{ $personnel300 }}
            <br>
            Укриття (Знищено): {{ $coverDestroyed }}
            <br>
            Укриття (Уражено): {{ $coverAffected }}
            <br>
            Мінування ({{ $minedPoints }}): {{ $mined }}
            <br>
            Доставлено посилок: {{ $delivery }}
            <br>
            БПЛА: {{ $uavDestroyed }}
            <br>
            ЗПМ: {{ $zpm }}
            <br>
            Техніка:
            <br>
            <br>
            Втрачено дронів: {{ $droneLost }}
            <br>
            <br>
            Еквівалент у балах: {{ $points }}, Фактично балів: {{ $pointsFact }}
        </div>

        <br>

        <div>
            {{--            <pre>--}}
            {{--            {{ print_r($byPositions, true) }}--}}
            {{--            </pre>--}}

            @php
                $labels = [
                    'personnel200'   => '200',
                    'personnel300'   => '300',
                    'coverDestroyed' => 'Укриття знищено',
                    'coverAffected'  => 'Укриття уражено',
                    'zpm'            => 'ЗПМ',
                    'mined'          => 'Мінування',
                    'minedPoints'    => 'Мінування техніка',
                    'delivery'       => 'Доставка',
                    'uavDestroyed'   => 'БпЛА',
                    'droneLost'      => 'Втрачено БпЛА',
                ];

                $columns = array_keys(reset($byPositions));
            @endphp

            <table class="summary-table">
                <thead>
                <tr>
                    <th>Позиція</th>

                    @foreach($columns as $column)
                        <th>{{ $labels[$column] ?? $column }}</th>
                    @endforeach
                </tr>
                </thead>

                <tbody>
                @foreach($byPositions as $position => $values)
                    <tr>
                        <td>{{ $position }}</td>

                        @foreach($columns as $column)
                            <td>{{ $values[$column] }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <x-filament::button
            type="button"
            color="primary"
            style="margin-top: 8px"
            x-on:click="
                navigator.clipboard.writeText(
                    document.getElementById('reportText').innerText
                ).then(() => copied = true)
            "
        >
            Скопіювати
        </x-filament::button>
        <span x-show="copied" x-transition class="text-sm text-green-600">
            Скопійовано!
        </span>
    </div>

    <style>
        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 18px 10px;
            font-size: 14px;
        }

        .summary-table th {
            font-weight: 700;
            color: #fff;
            padding-bottom: 8px;
        }

        .summary-table td {
            padding: 4px 0;
            text-align: center;
        }

        .summary-table td:first-child,
        .summary-table th:first-child {
            text-align: left;
            padding-right: 30px;
            font-weight: 600;
        }
    </style>
</div>
