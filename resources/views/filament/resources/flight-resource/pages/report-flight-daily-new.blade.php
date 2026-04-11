@php
    use App\Models\Flight;
    use App\ValuesObject\Target;
    use App\ValuesObject\TargetStatus;

    $positions = $flights->groupBy('position');
    $count = $positions->count();

    if ($count > 1) {
        $r = $flights->groupBy(['position','date']);
    }
@endphp

<div x-data="{ copied: false }" class="space-y-4">

    <div id="reportText">

        @if($count > 1)

            @foreach($r as $key => $data)

                <br>
                <b style="font-size: 14pt">Позиція {{ $key }}</b>

                <div style="margin:8px;padding:4px">

                    @foreach($data as $date => $info)

                        <br>
                        <b style="font-size: 12pt">Дата: {{ $date }}</b>
                        <br>

                        @foreach($info as $flight)

                            <div style="margin-left:8px">

                                <br>
                                ~Виліт №{{ $flight->flight_number }}

                                <br>
                                Час: {{ $flight->time_start }} - {{ $flight->time_end }}

                                <br>
                                Ціль: Укриття

                                <br>
                                Координати: 37U CP 37Y XY 00000 00001

                                <br>
                                Статус: Знищено

                                <br>
                                БК:
                                @foreach($flight->getAmmunition() as $ammo)
                                    {{ $ammo['title'] }} - {{ $ammo['quantity'] }}шт
                                @endforeach

                                <br>

                            </div>

                        @endforeach
                    @endforeach
                </div>

            @endforeach


        @else

            <div style="font-size:12pt">

                Звіт про роботу

                <br>
                Дата:

                <br>
                Позиція: {{ $flights->first()->position }}

                <br>
                Екіпаж:

                <br>

            </div>

            @php
                $dates = $flights->groupBy('date');
                $withOneDate = $dates->count() === 1;
            @endphp


            @if($withOneDate)

                @foreach($flights as $flight)

                    <div style="margin:8px;padding:4px">

                        <b>~Виліт №{{ $flight->flight_number }}</b>

                        <br>
                        Час: {{ $flight->time_start }} - {{ $flight->time_end }}

                        <br>
                        Ціль: {{ $flight->target }}

                        <br>
                        Координати: 37U CP {{ $flight->coordinates }}

                        <br>
                        Статус: {{ $flight->status }}

                        <br>
                        БК:
                        @foreach($flight->getAmmunition() as $ammo)
                            {{ $ammo['title'] }} - {{ $ammo['quantity'] }}шт
                        @endforeach

                        <br>

                    </div>

                @endforeach

            @else

                @foreach($dates as $date => $resultDate)

                    <br>
                    <b style="font-size:12pt">Дата: {{ $date }}</b>
                    <br><br>

                    <div style="margin-left:8px">

                        @foreach($resultDate as $flightData)

                            <b>~Виліт №{{ $flightData->flight_number }}</b>

                            <br>
                            Час: {{ $flightData->time_start }} - {{ $flightData->time_end }}

                            <br>
                            Ціль: {{ $flightData->target }}

                            <br>
                            Координати: 37U CP {{ $flightData->coordinates }}

                            <br>
                            Статус: {{ $flightData->status }}

                            <br>
                            БК:
                            @foreach($flightData->getAmmunition() as $ammo)
                                {{ $ammo['title'] }} - {{ $ammo['quantity'] }}шт
                            @endforeach

                            <br><br>

                        @endforeach

                    </div>

                @endforeach

            @endif


            <br>

            <div>

                Кількість вильотів: {{ $flights->count() }}

                @php

                    $notAffected = $flights->count();
                    $ukryttya = 0;
                    $personnel = 0;
                    $personnel200 = 0;
                    $personnel300 = 0;
                    $bySignatures = 0;
                    $byCoords = 0;
                    $mining = 0;
                    $fire = 0;
                    $delivery = 0;
                    $technics = 0;
                    $technicType = '';
                    $ammunitionData = [];

                    foreach ($flights as $flight) {

                    foreach ($flight->getAmmunition() as $ammo) {
                    $ammunitionData[$ammo['title']] =
                    ($ammunitionData[$ammo['title']] ?? 0) + $ammo['quantity'];
                    }

                    if (
                    $flight->target === Target::SHELTER &&
                    ($flight->status === TargetStatus::AFFECTED ||
                    $flight->status === TargetStatus::DESTROYED)
                    ) {

                    $ukryttya++;
                    $notAffected--;

                    }

                    elseif (

                    ($flight->target === Target::PERSONNEL &&
                    (
                    str_starts_with($flight->status, TargetStatus::AFFECTED) ||
                    str_starts_with($flight->status, TargetStatus::DESTROYED)
                    ))

                    ||

                    ($flight->target === Target::SHELTER_WITH_PERSONNEL &&
                    str_starts_with($flight->status, TargetStatus::DESTROYED))

                    ) {

                    $personnel++;
                    $notAffected--;

                    preg_match_all('/(\d+)\s*-\s*(\d+)/',$flight->status,$matches,PREG_SET_ORDER);

                    foreach ($matches as $match) {

                    if ($match[2] == '200') $personnel200 += $match[1];
                    elseif ($match[2] == '300') $personnel300 += $match[1];

                    }

                    }

                    elseif ($flight->status === TargetStatus::AFFECTED_BY_SIGNATURES) {
                    $bySignatures++;
                    $notAffected--;
                    }

                    elseif ($flight->status === TargetStatus::AFFECTED_BY_COORDS) {
                    $byCoords++;
                    $notAffected--;
                    }

                    elseif ($flight->target === Target::MINING) {
                    $mining++;
                    $notAffected--;
                    }

                    elseif ($flight->target === Target::FIRE_FIGHTING) {
                    $fire++;
                    $notAffected--;
                    }

                    elseif ($flight->target === Target::DELIVERY) {
                    $delivery++;
                    $notAffected--;
                    }

                    elseif ($flight->target === Target::UAV) {
                    $technics++;
                    $technicType = Target::UAV;
                    $notAffected--;
                    }

                    elseif ($flight->target === Target::UAV_HUNT && $flight->status === TargetStatus::NOT_DETECTED) {
                        $notAffected--;
                    }

                    }

                @endphp


                <br>
                Укриття: {{ $ukryttya }}

                <br>
                Відпрацювали по сигнатурах: {{ $bySignatures }}

                <br>
                Відпрацювали по координатах: {{ $byCoords }}

                <br>
                Уражень ОС: {{ $personnel }}

                <br>
                200 - {{ $personnel200 }}

                <br>
                300 - {{ $personnel300 }}

                <br>
                Мінування: {{ $mining }}

                <br>
                Пожежогасіння: {{ $fire }}

                <br>
                Доставка: {{ $delivery }}

                <br>
                МТЗ (матеріально технічні засоби): 0

                <br>
                Техніка (тип техніки): {{ $technics }} ({{ $technicType }})

                <br>

                Витрати БК:

                @foreach($ammunitionData as $title => $quantity)

                    <br>
                    {{ $title }} - {{ $quantity }}шт

                @endforeach

                <br><br>

                Не Уражено: {{ $notAffected }}

            </div>

        @endif

    </div>

    <div class="flex items-center gap-3">

        <x-filament::button
            type="button"
            color="primary"
            style="margin-top:8px"
            x-on:click="
navigator.clipboard.writeText(
document.getElementById('reportText').innerText
).then(()=>copied=true)
"
        >

            Скопіювати

        </x-filament::button>

        <span x-show="copied" x-transition class="text-sm text-green-600">

Скопійовано!

</span>

    </div>

</div>
