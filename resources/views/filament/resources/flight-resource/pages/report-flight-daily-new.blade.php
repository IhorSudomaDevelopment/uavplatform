@php
    use App\Models\Flight;
    use App\ValuesObject\Target;
    use App\ValuesObject\TargetStatus;

    $positions = $flights->groupBy('position');
    $count = $positions->count();

    if ($count > 1) {
        $r = $flights->groupBy(['position','date']);
    }

    /*** @var Flight $flight */
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
                                Ціль: {{ $flight->target }}

                                <br>
                                Координати: {{ $flight->coordinates }}

                                <br>
                                Статус: {{ implode(', ', $flight->status) }}

                                <br>
                                БК:
                                @if(is_array($flight->ammunition))
                                    @foreach($flight->ammunition as $ammo)
                                        {{ $ammo['title'] }} - {{ $ammo['quantity'] }}шт
                                        <br>
                                    @endforeach
                                @else
                                    @foreach(json_decode($flight->ammunition) as $ammo)
                                        {{ $ammo->title }} - {{ $ammo->quantity }}шт
                                    @endforeach
                                @endif


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
                        Координати: {{ $flight->coordinates }}

                        <br>
                        Статус: {{ implode(', ', $flight->status) }}

                        <br>
                        БК:
                        @if(!is_array($flight->ammunition))
                            @foreach(json_decode($flight->ammunition, TRUE, 512, JSON_THROW_ON_ERROR) as $ammo)
                                {{ $ammo['title'] }} - {{ $ammo['quantity'] }}шт
                            @endforeach
                        @else
                            @foreach($flight->ammunition as $ammo)
                                {{ $ammo['title'] }} - {{ $ammo['quantity'] }}шт
                            @endforeach
                        @endif


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
                            Координати: {{ $flightData->coordinates }}

                            <br>
                            Статус: {{ implode(', ', $flightData->status) }}

                            <br>
                            БК:
                            @foreach($flightData->ammunition as $ammo)
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

                    $personnel200 = 0;
                    $personnel300 = 0;
                    $bySignatures = 0;
                    $byCoords = 0;
                    $mining = 0;
                    $fire = 0;
                    $delivery = 0;
                    $technics = 0;
                    $technicType = '';
                    $hunt = 0;
                    $evacuationMission = 0;
                    $crossingBarge = 0;
                    $searchMission = 0;
                    $ammunitionData = [];

                    foreach ($flights as $flight) {
                        $personnel200 += $flight->personnel_200;
                        $personnel300 += $flight->personnel_300;

                    foreach ($flight->ammunition as $ammo) {
                        if (isset($ammo['title'])) {
                            $ammunitionData[$ammo['title']] =
                            ($ammunitionData[$ammo['title']] ?? 0) + (int)$ammo['quantity'];
                        }
                    }
                    if ($flight->target === Target::CROSSING_BARGE) {
                        $crossingBarge++;
                        $notAffected--;
                    } else if ($flight->target === Target::SEARCH_MISSION) {
                        $searchMission++;
                        $notAffected--;
                    } else if ($flight->target === Target::UAV_EVACUATION) {
                        $evacuationMission++;
                        $notAffected--;
                    } else if ($flight->target === Target::UAV_HUNT) {
                        $hunt++;
                        $notAffected--;
                    } else if ($flight->target === Target::SHELTER) {
                        foreach ($flight->status as $status) {
                            if (str_contains($status, TargetStatus::AFFECTED) || str_contains($status, TargetStatus::DESTROYED)) {
                                $ukryttya++;
                                $notAffected--;
                            }
                        }
                    } else if ($flight->target === Target::DELIVERY) {
                        $delivery++;
                        $notAffected--;
                    } else if ($flight->target === Target::MINING) {
                        $mining++;
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
                Перегін борта: {{ $crossingBarge }}

                <br>
                Евакуація борта: {{ $evacuationMission }}

                <br>
                МТЗ (матеріально технічні засоби): 0

                <br>
                Техніка (тип техніки): {{ $technics }} ({{ $technicType }})

                <br>
                Хант: {{ $hunt }}

                <br>
                Пошукова міссія: {{ $searchMission }}

                <br>
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
