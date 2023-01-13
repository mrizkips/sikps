<button type="button" class="btn btn-danger btn-xs mx-1" data-toggle="modal" data-target="#reject-{{ $id }}">
    <i class="fas fa-ban"></i>
</button>

<div class="modal fade" id="reject-{{ $id }}" tabindex="-1" aria-labelledby="rejectLabel-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectLabel-{{ $id }}">Tolak Pengajuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ $route }}" method="post">
                <div class="modal-body">
                    @csrf

                    <x-adminlte-textarea
                        name="catatan"
                        placeholder="Tambahkan catatan bila diperlukan..." />

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin dengan aksi ini?')"><i class="fas fa-ban"></i> Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
