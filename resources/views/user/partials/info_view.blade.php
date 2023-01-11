@if ($user)
    <div class="row">
        <span class="col-lg-3">Username</span>
        <span class="col">{{ $user->username }}</span>
    </div>
    <div class="row">
        <span class="col-lg-3">Jenis Kelamin</span>
        <span class="col">{{ $user->getJk() ?? '-' }}</span>
    </div>
    <div class="row">
        <span class="col-lg-3">Email</span>
        <span class="col">{{ $user->email ?? '-' }}</span>
    </div>
    <div class="row">
        <span class="col-lg-3">No. Hp</span>
        <span class="col">{{ $user->no_hp ?? '-' }}</span>
    </div>
@else
    <span>-</span>
@endif
