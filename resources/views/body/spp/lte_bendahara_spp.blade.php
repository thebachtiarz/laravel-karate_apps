@extends('layouts.masterlte')

@section('header')
<link rel="stylesheet" href="{{ online_asset() }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
    .displayHidden {
        display: none;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<section class="content-header">
    <h1>Pembayaran SPP</h1>
    {!! createBreadcrumbByArrayOfCode(['SPP', $kelas]) !!}
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover table-condensed dataTable" id="example2" role="grid">
                <thead class="bg-primary">
                    <tr role="row">
                        <th class="text-center">No</th>
                        <th class="text-center sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">Nama</th>
                        <th class="text-center sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Tingkatan</th>
                        <th class="text-center sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="20%">Tambah SPP</th>
                    </tr>
                </thead>
                <tbody>
                    @if($peserta)
                    @php $no = 1 @endphp
                    @foreach($peserta as $pst)
                    <tr>
                        <td class="text-center">{{ $no }}</td>
                        <td class="text-left">{{ $pst->nama_peserta }}</td>
                        <td class="text-left">{{ 'Kyu '. $pst->tingkat .' / '. get_belt_by_kyu($pst->tingkat) }}</td>
                        <td class="text-center"><button data-goto="#dataRecSpp" class="btn btn-sm btn-primary getRecSppPst page-scroll" type="button" data-pstname="{{ $pst->nama_peserta }}" data-pstclass="{{ $kelas }}" data-pstcode="{{ $pst->kode_peserta }}"><i class="fas fa-file-invoice fa-2x"></i></button></td>
                    </tr>
                    @php $no++ @endphp
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="box box-success" id="dataRecSpp" hidden>
        <div class="box-header with-border">
            <h3 class="box-title" id="postPstName"></h3>
            <div class="box-tools">
                <button class="btn btn-success" id="addspp" data-hide="addspp"><i class="fas fa-plus"></i>&ensp;Tambah SPP</button>
                <button class="btn btn-warning displayHidden" id="cclspp" data-hide="cclspp"><i class="fas fa-times"></i>&ensp;Batal</button>
            </div>
        </div>
        <div class="box-header with-border displayHidden" id="addSppForm">
            <div class="row">
                <div class="col-sm-4" style="padding-bottom: 5px;">
                    <select id="spp_bulan" class="form-control">
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <option value="{{ $i }}" {{ ((int)date('m') == $i) ? 'selected' : '' }}>{{ getMonth($i) }}</option>
                        <?php endfor ?>
                    </select>
                </div>
                <div class="col-sm-4" style="padding-bottom: 5px;">
                    <input type="text" class="form-control" value="Rp. {{ mycurrency(getSppFeeClassByCode($kelas)) }}" @if(auth()->user()->status == 'moderator') onclick="onClickFeeSpp('{{ convStatUserToIndex(auth()->user()->status) }}', '{{ $kelas }}')" @else onclick="onClickFeeSpp('{{ convStatUserToIndex(auth()->user()->status) }}', '{{ $kelas }}')" @endif readonly>
                </div>
                <div class="col-sm-4" style="padding-bottom: 5px;">
                    <input type="hidden" id="spp_kelas" value="" readonly hidden>
                    <input type="hidden" id="spp_peserta" value="" readonly hidden>
                    <input type="hidden" id="spp_nama" value="" readonly hidden>
                    <button class="btn btn-primary pull-right" id="sppPullSave"><i class="fas fa-save"></i>&ensp;Tambahkan</button>
                </div>
            </div>
        </div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover table-condensed">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Waktu</th>
                        <th class="text-center">Kredit</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Penanggung Jawab</th>
                    </tr>
                </thead>
                <tbody id="dataValRecSpp"></tbody>
            </table>
        </div>
    </div>
</section>

@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="{{ asset('js/moderator_spp_management.js') }}"></script>
<script src="{{ online_asset() }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ online_asset() }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(function() {
        $('#example2').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false
        })
    })
</script>
@endsection