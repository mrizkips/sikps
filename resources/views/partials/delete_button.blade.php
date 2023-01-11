<form action="{{ $route }}" method="post" class="d-inline-block">
    @csrf
    @method('delete')

    <button type="submit" class="btn btn-danger btn-xs mx-1" title="Hapus" onclick="confirm('Apakah Anda yakin dengan aksi ini?')">
        <i class="far fa-trash-alt"></i>
    </button>
</form>
