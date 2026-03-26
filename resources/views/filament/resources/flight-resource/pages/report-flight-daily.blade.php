@php use App\Models\Flight;use App\ValuesObject\Target;use App\ValuesObject\TargetStatus; @endphp
<div x-data="{ copied: false }" class="space-y-4">
    <div id="reportText">
        <div>
            Звіт про роботу
            <br>
            Дата: <input class="js-date">
            <br>
            Позиція: <input class="js-position">
            <br>
            Екіпаж: <input class="js-crew">
            <br>
            Борт: № <input class="js-drone-serial">
            <br>
        </div>
        @foreach($flights as $flight)
            @php
                /*** @var Flight $flight */
            @endphp
            <div style="margin: 8px; padding: 4px">
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
                БК: @foreach($flight->getAmmunition() as $ammunition)
                    {{ $ammunition['title'] }} - {{ $ammunition['quantity'] }}шт
                @endforeach
                <br>
            </div>
        @endforeach
        <div>
            Кількість вильотів: {{ $flights->count() }}
            @php
                $notAffected = $flights->count();
                $ukryttya = 0;
                $personnel = 0;
                $result = [];
                $personnel200 = 0;
                $personnel300 = 0;
                $bySignatures = 0;
                $byCoords = 0;
                $mining = 0;
                $fire = 0;
                $delivery = 0;
                $ammunitionData = [];
                $technics = 0;
                $technicType = '';

                foreach ($flights as $flight) {
                    foreach ($flight->getAmmunition() as $ammunition) {
                        if (isset($ammunitionData[$ammunition['title']])) {
                            $ammunitionData[$ammunition['title']] += $ammunition['quantity'];
                        } else {
                            $ammunitionData[$ammunition['title']] = $ammunition['quantity'];
                        }
                    }
                    if ($flight->target === 'Укриття' &&
                    ($flight->status === TargetStatus::AFFECTED || $flight->status === TargetStatus::DESTROYED)
                    ) {
                        $ukryttya++;
                        $notAffected--;
                    } else if (($flight->target === Target::PERSONNEL &&
                    (str_starts_with($flight->status, TargetStatus::AFFECTED) || (str_starts_with($flight->status, TargetStatus::DESTROYED)))) ||
                    ($flight->target === Target::SHELTER_WITH_PERSONNEL && str_starts_with($flight->status, TargetStatus::DESTROYED))) {
                        $personnel++;
                        $notAffected--;
                        preg_match_all('/(\d+)\s*-\s*(\d+)/', $flight->status, $matches, PREG_SET_ORDER);
                        foreach ($matches as $match) {
                            $count          = $match[1];
                            $value          = $match[2];
                            $result[$value] = $count;
                        }
                        if (isset($result['200'])) {
                            $personnel200 += $result['200'];
                        }
                        if (isset($result['300'])) {
                            $personnel300 += $result['300'];
                        }
                    } else if ($flight->status === TargetStatus::AFFECTED_BY_SIGNATURES) {
                        $bySignatures++;
                        $notAffected--;
                    } else if ($flight->status === TargetStatus::AFFECTED_BY_COORDS) {
                        $byCoords++;
                        $notAffected--;
                    } else if ($flight->target === Target::MINING) {
                        $mining++;
                        $notAffected--;
                    } else if ($flight->target === Target::FIRE_FIGHTING) {
                        $fire++;
                        $notAffected--;
                    } else if ($flight->target === Target::DELIVERY) {
                        $delivery++;
                        $notAffected--;
                    } else if ($flight->target === Target::UAV) {
                        $technics++;
                        $technicType = Target::UAV;
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
            Техніка (тип техніки): {{ $technics }} {{ '('. $technicType . ')' }}
            <br>
            Витрати БК: @foreach($ammunitionData as $title => $quantity)
                <br>
                {{ $title }} - {{ $quantity . 'шт' }}
            @endforeach
            <br>
            <br>
            Не Уражено: {{ $notAffected }}
	</div>
</div>
<style>
	.js-date, .js-position, .js-crew, .js-drone-serial {
		margin-bottom:    5px;
		margin-top:       5px;
		background-color: #18181b;
		border:           2px solid #FFBF00;
		border-radius:    4px;
		outline:          none !important;
		outline-offset:   0;
		box-shadow:       none;
	}
	.js-date:hover, .js-position:hover, .js-crew:hover, .js-drone-serial:hover {
		background-color: #18181b;
		border:           2px solid #FFBF00;
		border-radius:    4px;
		outline:          none !important;
		outline-offset:   0;
		box-shadow:       none;
	}
	.js-date:active, .js-position:active, .js-crew:active, .js-drone-serial:active {
		background-color: #18181b;
		border:           2px solid #FFBF00;
		border-radius:    4px;
		outline:          none !important;
		outline-offset:   0;
		box-shadow:       none;
	}
	.js-date:focus, .js-position:focus, .js-crew:focus, .js-drone-serial:focus {
		background-color: #18181b;
		border:           2px solid #FFBF00;
		border-radius:    4px;
		outline:          none !important;
		outline-offset:   0;
		box-shadow:       none;
	}
</style>
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
</div>
