<x-pdf-layout>
    <x-slot:title>
        Form Bimbingan
    </x-slot:title>

    @push('css')
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-weight: 500;
            font-size: 14px;
        }

        .kop {
            font-family: Arial, Helvetica, sans-serif;
            border-bottom: 6px #000000 ridge;
        }

        .stmik-kop {
            margin-bottom: 0;
            font-size: 26px;
            letter-spacing: -2px;
            font-weight: 700;
        }

        .stmik-kop-small {
            font-weight: 700;
            font-size: 11px;
        }

        .stmik-address {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-size: 9px;
            font-weight: 700;
            text-align: right;
        }

        .table-header {
            border: 6px #000000 ridge;
            padding: 14px 6px;
            font-size: 20px;
        }

        .table-identity {
            line-height: 1.75rem;
        }

        .table-bimbingan td {
            border: 1px solid #000000;
            padding: 8px;
            height: 18px;
        }
    </style>
    @endpush

    <table class="table">
        <tr>
            <td width="125px">
                <img src="{{ Vite::asset('resources/images/logo-stmik-grayscale.png') }}" alt="STMIK Bandung" width="125px" class="img-responsive">
            </td>
            <td>
                <table class="table mb-0">
                    <tr class="kop">
                        <td>
                            <p class="stmik-kop mb-0 ms-2">STMIK BANDUNG</p>
                            <p class="stmik-kop-small mb-0 ms-2">SEKOLAH TINGGI MANAJEMEN INFORMATIKA & KOMPUTER BANDUNG</p>
                        </td>
                        <td>
                            <address class="stmik-address mb-2">
                                Jl. Cikutra No. 113 A<br>
                                Bandung - 40124<br>
                                (022) 7207777,<br>
                                085722157777<br>
                                www.stmik-bandung.ac.id
                            </address>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="container-fluid px-5">
                    <table class="table mt-3">
                        <tr>
                            <td class="table-header text-center">
                                F.AKA-03-08-20
                            </td>
                            <td class="table-header text-center">
                                FORM BIMBINGAN {{ str($kpSkripsi->getJenis())->upper() }}
                            </td>
                        </tr>
                    </table>
                    <table class="table table-identity px-2">
                        <tr>
                            <td width="130">NIM</td>
                            <td>:</td>
                            <td>{{ $kpSkripsi->mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $kpSkripsi->mahasiswa->nama }}</td>
                        </tr>
                        <tr>
                            <td>No. Telp/ Handphone</td>
                            <td>:</td>
                            <td>{{ $kpSkripsi->mahasiswa->user->no_hp ?? '...............................................................' }}</td>
                        </tr>
                        <tr>
                            <td>Jurusan/ Prog. Studi</td>
                            <td>:</td>
                            <td>{{ $kpSkripsi->mahasiswa->getJurusan() }}</td>
                        </tr>
                        <tr>
                            <td>Judul {{ $kpSkripsi->getJenis() }}</td>
                            <td>:</td>
                            <td>{{ $kpSkripsi->proposal->judul }}</td>
                        </tr>
                        <tr>
                            <td>Pembimbing</td>
                            <td>:</td>
                            <td>{{ $kpSkripsi->dosen->nama }}</td>
                        </tr>
                    </table>
                    <table class="table table-bimbingan">
                        <tr class="text-center align-middle">
                            <td width="22px">No.</td>
                            <td>Tanggal</td>
                            <td>Catatan / Komentar Pembimbing</td>
                            <td>Tanda Tangan<br>Pembimbing</td>
                        </tr>
                        @for ($i = 0; $i < 12; $i++)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endfor
                    </table>
                    <p><small>Nb : Jika form ini hilang akan dikenakan denda Rp 100.000</small></p>
                    <p><small>Form ini dicetak pada tanggal {{ $kpSkripsi->form_bimbingan_last_printed_at }}</small></p>
                </div>
            </td>
        </tr>
    </table>
</x-pdf-layout>
