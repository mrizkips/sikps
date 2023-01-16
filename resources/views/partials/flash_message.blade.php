@if ($message = session()->get('success'))
    <x-adminlte-alert theme="success" title="Sukses" dismissable>
        {{ $message }}
    </x-adminlte-alert>
@elseif ($message = session()->get('fail'))
    <x-adminlte-alert theme="danger" title="Gagal" dismissable>
        {{ $message }}
    </x-adminlte-alert>
@endif
