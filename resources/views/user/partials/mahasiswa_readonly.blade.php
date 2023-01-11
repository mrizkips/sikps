<div class="mb-3 row">
    <label for="nim" class="col-sm-2 col-form-label">NIM</label>
    <div class="col-sm-10">
        <p id="nim" class="form-control-plaintext">{{ $mahasiswa->nim }}</p>
    </div>
</div>
<div class="mb-3 row">
    <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
    <div class="col-sm-10">
        <p id="jurusan" class="form-control-plaintext">{{ $mahasiswa->getJurusan() }}</p>
    </div>
</div>
