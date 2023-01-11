@if ($message = session()->get('success'))
    <x-adminlte-alert theme="success" title="Sukses" dismissable>
        {{ $message }}
    </x-adminlte-alert>
@endif
