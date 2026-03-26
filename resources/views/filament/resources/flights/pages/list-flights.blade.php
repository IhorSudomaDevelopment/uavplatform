<x-filament::modal
    id="summaries-modal"
    :visible="$showSummariesModal"
>
    <x-slot name="heading">
        Підсумки
    </x-slot>

    @php
        $flights = \App\Models\Flight::whereBetween(
            'date',
            [$dateFrom, $dateTo]
        )->get();
    @endphp

    @include('filament.resources.flight-resource.pages.summaries', [
        'startDate' => $dateFrom, 'endDate' => $dateTo
    ])

</x-filament::modal>
