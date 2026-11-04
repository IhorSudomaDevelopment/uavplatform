
@php
    use App\Models\Flight;

    $flights = Flight::where('position', $record->position)
        ->where('shift', $record->date)
        ->get();

    $report = "Звіт про роботу\n";
    $report .= "Дата: {$record->date}\n";
    $report .= "Позиція: {$record->position}\n";
    $report .= "Екіпаж: {$record->crew}\n\n";

    foreach ($flights as $flight) {
        $report .= "Виліт №{$flight->flight_number}\n";
        $report .= "Час: {$flight->time_start} - {$flight->time_end}\n";
        $report .= "Ціль: {$flight->target}\n";
        $report .= "Координати: {$flight->coordinates}\n";

        $status = is_array($flight->status)
            ? implode(', ', $flight->status)
            : ($flight->status ?? '');

        $report .= "Статус: {$status}\n";
        $report .= "БК:\n";

        $ammunition = $flight->ammunition;

        if (is_string($ammunition)) {
            $ammunition = json_decode($ammunition, true) ?? [];
        }

        foreach (($ammunition ?? []) as $ammo) {
            $title = $ammo['title'] ?? '';
            $quantity = $ammo['quantity'] ?? 0;

            $report .= "{$title} - {$quantity} шт\n";
        }

        $report .= "\n";
    }

    $report .= "Кількість вильотів: {$flights->count()}\n\n";

    $report .= "Укриття:\n";
    $report .= "- знищено - 0\n";
    $report .= "- ушкоджено - 0\n\n";

    $report .= "Наземна споруда:\n";
    $report .= "- знищено - 0\n";
    $report .= "- ушкоджено - 2\n\n";

    $report .= "Бліндаж:\n";
    $report .= "- знищено - 0\n";
    $report .= "- ушкоджено - 0\n\n";

    $report .= "Відпрацювали по сигнатурах: 0\n";
    $report .= "Відпрацювали по координатах: 0\n\n";

    $report .= "Уражень ОС:\n";
    $report .= "200 - 0\n";
    $report .= "300 - 0\n";
    $report .= "ЗПМ - 0\n\n";

    $report .= "Мінування: 0\n";
    $report .= "Гасіння пожеж: 0\n";
    $report .= "Доставка: 0\n";
    $report .= "Логістична місія: 0\n";
    $report .= "Перегін борта: 0\n";
    $report .= "Евакуаційна місія: 0\n";
    $report .= "МТЗ (матеріально технічні засоби): 0\n";
    $report .= "Техніка (тип техніки): 0\n";
    $report .= "БпЛА: 0\n";
    $report .= "Хант: 0\n\n";

    $report .= "Не заміновано: 0\n";
    $report .= "Не доставлено: 0\n";
    $report .= "Не ушкоджено: 0\n";
    $report .= "Не виконано: 0\n\n";

    $report .= "Витрати БК:\n";
@endphp

<div
    x-data="{
        copied: false,
        async copyText() {
            try {
                await navigator.clipboard.writeText(
                    this.$refs.editor.value
                );

                this.copied = true;

                setTimeout(() => {
                    this.copied = false;
                }, 2000);
            } catch (error) {
                this.$refs.editor.select();
                document.execCommand('copy');
                this.copied = true;
            }
        }
    }"
    class="space-y-3"
>
    <div class="flex items-center justify-between gap-3">
        <x-filament::button
            type="button"
            icon="heroicon-o-clipboard-document"
            x-on:click="copyText()"
        >
            Скопіювати текст
        </x-filament::button>
    </div>

    <textarea
        x-ref="editor"
        spellcheck="false"
        wrap="soft"
        class="report-textarea"
    >{{ $report }}</textarea>

    <div
        x-show="copied"
        x-cloak
        class="text-sm font-medium text-success-600"
    >
        Текст скопійовано!
    </div>
</div>

<style>
    .report-textarea {
        display: block;
        width: 100%;
        height: 65vh;
        min-height: 350px;
        resize: vertical;
        padding: 16px;
        border: 1px solid #64748b;
        border-radius: 8px;
        background: #fff;
        color: #111827;
        font-family: Consolas, "Courier New", monospace;
        font-size: 14px;
        line-height: 1.6;
        white-space: pre-wrap;
        tab-size: 4;
        outline: none;
    }

    .report-textarea:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 1px #0ea5e9;
    }

    [x-cloak] {
        display: none !important;
    }
</style>
