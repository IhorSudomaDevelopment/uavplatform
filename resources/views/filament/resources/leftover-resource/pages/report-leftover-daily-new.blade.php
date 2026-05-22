@php

@endphp

<div x-data="{ copied: false }" class="space-y-4">

    <div id="reportText">
        <h4>Залишки БК, АКБ, бортів, палива та провізії на позиції "" станом на {{ now('Europe/Kyiv')->format('Y-m-d') }}</h4>
        <br>
        @foreach($leftovers as $leftover)
            {{ $leftover->title }} - {{ $leftover->quantity }}{{ $leftover->unit }}
            <br>
        @endforeach
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
