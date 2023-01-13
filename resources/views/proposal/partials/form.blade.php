<x-adminlte-input
    type="text"
    label="Judul*"
    name="judul"
    value="{!! old('judul', $proposal->judul ?? '') !!}"
    />

<x-adminlte-select
    label="Jenis*"
    name="jenis"
    >
    <option disabled @selected(!old('jenis', $proposal->jenis ?? ''))>Pilih Jenis Proposal</option>
    <option value="1" @selected(old('jenis', $proposal->jenis ?? '') === '1')>Kerja Praktek</option>
    <option value="2" @selected(old('jenis', $proposal->jenis ?? '') === '2')>Skripsi</option>
</x-adminlte-select>

<x-adminlte-input-file
    type="file"
    label="{{ isset($proposal) ? 'File Proposal' : 'File Proposal*' }}"
    name="file_proposal"
    legend="Upload"
    placeholder="Upload file proposal dengan format pdf"
    >
    <x-slot name="prependSlot">
        <div class="input-group-text">
            <i class="fas fa-file-pdf fa-sm"></i>
        </div>
    </x-slot>
</x-adminlte-input-file>

<x-adminlte-textarea
    label="Deskripsi*"
    name="deskripsi"
    placeholder="Deksripsi proposal..."
    rows="3"
    >
    {!! old('deskripsi', $proposal->deskripsi ?? '') !!}
</x-adminlte-textarea>

<x-adminlte-input
    type="text"
    label="Organisasi"
    name="organisasi"
    value="{!! old('organisasi', $proposal->organisasi ?? '') !!}"
    />
