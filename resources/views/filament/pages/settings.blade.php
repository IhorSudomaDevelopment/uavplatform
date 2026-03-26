<x-filament::page>
    @if(isRoleNavigator() || auth()->user()->isPremium())
        <div class="flex gap-2 p-2">
            <div class="flex">Позиція за замовчуванням</div>
            <div class="flex border-2 border-gray-900 rounded-md" style="border: 2px solid">
                {{ getDefaultPosition() }}
            </div>
        </div>
    @endif
</x-filament::page>
