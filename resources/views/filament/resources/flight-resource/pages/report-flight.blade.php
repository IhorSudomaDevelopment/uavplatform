<div x-data="{ copied: false }" class="space-y-4">
	<div id="reportText">
		<div>
			~Виліт №{{ $record->flight_number }}
			<br>
			Час: {{ $record->time_start }} - {{ $record->time_end }}
			<br>
			Ціль: {{ $record->target }}
			<br>
			Координати: {{ $record->coordinates }}
			<br>
			Статус: {{ $record->status }}
			<br>
			БК:
			@foreach($record->getAmmunition() as $ammunitionData)
				{{ $ammunitionData['title'] }} - {{ $ammunitionData['quantity'] . 'шт' }}
			@endforeach
            @if($record->is_drone_lost)
                <br>
                Коментар: Втрата борта, {{ $record->drone_lost_reason ?? '-' }}
            @endif
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
</div>
