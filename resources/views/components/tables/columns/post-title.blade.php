<div class="flex items-center gap-2" x-data="{
    show: false
}" @mouseenter="show = true" @mouseleave="show = false">

    <span class="fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white">
        {{ $getState() }}
    </span>

    @if($action = $getAction())
        <div x-show="show" x-transition.duration.400ms>
            <x-filament::link
                icon="heroicon-o-pencil-square"
                wire:click="mountTableAction('{{ $action->getName() }}', '{{ $recordKey }}')"
            />
        </div>
    @endif

</div>
