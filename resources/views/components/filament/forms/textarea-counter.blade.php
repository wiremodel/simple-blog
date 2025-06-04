@props(['label'])

<div class="textarea-counter" x-data="{
        length: 0,
        maxLength: 255,
        get counter() {
            return this.maxLength - this.length
        },
        get color() {
            return this.counter < 0 ? 'danger' : 'primary'
        }
    }"
>
    <div class="flex items-center gap-x-3 justify-between mb-2">
        <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
            <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                {{ $label }}
                <sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>
            </span>
        </label>
        <span x-cloak :class="`text-sm font-medium text-${color}-600`" x-text="counter"></span>
    </div>

    {{ $slot }}

</div>
