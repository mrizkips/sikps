<form action="{{ $route }}" method="post" class="d-inline-block">
    @csrf

    <button type="submit" class="btn btn-danger btn-xs mx-1" title="Print Form Bimbingan" onclick="return confirm('Apakah Anda yakin dengan aksi ini, aksi ini hanya bisa dilakukan sekali dan tidak dapat dibatalkan?')">
        <i class="fas fa-print"></i>
    </button>
</form>
