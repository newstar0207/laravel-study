<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    {{-- <h1>hello world!</h1> --}}
    <div style="text-align: center">
        <button wire:click='increment'>+</button>
        <h1>{{ $count}}</h1>
        <button wire:click='decrement'>-</button>
        <br>
        <div>
            <input type="text" wire:model.lazy="name"><br>
            <span>{{ $name }}</span>
        </div>
    </div>
</div>
{{-- div 밖에 무조건 하나만 있어야함 --}}
