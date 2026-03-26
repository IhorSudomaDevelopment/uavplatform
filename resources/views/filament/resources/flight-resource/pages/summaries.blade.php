@php use App\Models\Flight;use App\ValuesObject\Target;use App\ValuesObject\TargetStatus;use Illuminate\Support\Facades\DB; @endphp
<div x-data="{ copied: false }" class="space-y-4">
    <div id="reportText">
        <div>
            <b>Підсумки по польотах за {{ $from }} - {{ $to }}</b>
            <br>
            <br>
            200: {{ $status200 }}
            <br>
            300: {{ $status300 }}
            <br>
            Укриття (Знищено): {{ $coverDestroyed }}
            <br>
            Укриття (Уражено): {{ $coverHeat }}
            <br>
            БПЛА: {{ $uavDestroyed }}
            <br>
            Техніка:
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
