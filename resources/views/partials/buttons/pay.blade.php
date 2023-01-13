<button type="button" class="btn btn-warning btn-xs mx-1" data-toggle="modal" data-target="#pay-{{ $id }}">
    <i class="fas fa-money-bill-wave"></i>
</button>

<div class="modal fade" id="pay-{{ $id }}" tabindex="-1" aria-labelledby="payLabel-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payLabel-{{ $id }}">Pelunasan Pengajuan</h5>
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
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin dengan aksi ini?')"><i class="fas fa-money-bill-wave"></i> Sudah Bayar</button>
                </div>
            </form>
        </div>
    </div>
</div>
