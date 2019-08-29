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
                        <td class="text-center"><button class="btn btn-sm btn-primary getRecSppPst page-scroll" type="button" data-goto="#dataRecSpp" data-pstname="{{ $pst->nama_peserta }}" data-pstclass="{{ $kelas }}" data-pstcode="{{ $pst->kode_peserta }}"><i class="fas fa-file-invoice fa-2x"></i></button></td>
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
                    <button class="btn btn-primary pull-right sppPullSave"><i class="fas fa-save"></i>&ensp;Tambahkan</button>
                </div>
            </div>
        </div>
        <div class="box-body table-responsive no-padding bodyRecSppPst">
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
<script>
    // get record spp peserta
    $(document).ready(function() {
        $('.getRecSppPst').on('click', function() {
            let nama_peserta = $(this).data('pstname');
            let kelas_peserta = $(this).data('pstclass');
            let kode_peserta = $(this).data('pstcode');
            getRecordPstValue(nama_peserta, kelas_peserta, kode_peserta);
        });
        $('.page-scroll').on('click', function(e) {
            var addr = $(this).data('goto');
            var elmAddr = $(addr);
            $('html').animate({
                scrollTop: elmAddr.offset().top - 95
            }, 1250, 'easeInOutExpo');
            e.preventDefault();
        });
    });

    function getRecordPstValue(nama_peserta, kelas_peserta, kode_peserta) {
        $.ajax({
            type: 'GET',
            url: '/kelas/record/spp/' + kelas_peserta + '/' + kode_peserta,
            success: function(data) {
                $('#cclspp').addClass('displayHidden');
                $('#addspp').removeClass('displayHidden');
                $('#addSppForm').addClass('displayHidden');
                $('#postPstName').html('Record SPP ' + nama_peserta);
                $('#spp_kelas').val(kelas_peserta);
                $('#spp_peserta').val(kode_peserta);
                $('#spp_nama').val(nama_peserta);
                $('#dataRecSpp').removeAttr('hidden');
                $('.bodyRecSppPst').removeAttr('hidden');
                var showData = '';
                if (data) {
                    showData += data;
                } else {
                    showData += '<tr><td colspan="5" class="text-center alert-danger" style="font-weight: bold;">Tidak Ada Record SPP</td></tr>';
                }
                $('#dataValRecSpp').html(showData);
            }
        });
    }

    $(document).ready(function() {
        $('#addspp').on('click', function() {
            $(this).addClass('displayHidden');
            $('#cclspp').removeClass('displayHidden');
            $('#addSppForm').removeClass('displayHidden');
        });
        $('#cclspp').on('click', function() {
            $(this).addClass('displayHidden');
            $('#addspp').removeClass('displayHidden');
            $('#addSppForm').addClass('displayHidden');
        });
    });

    $('.sppPullSave').on('click', function() {
        let bulan = $("#spp_bulan option:selected").val();
        let kredit = $('#spp_kredit').val();
        let kelas = $('#spp_kelas').val();
        let peserta = $('#spp_peserta').val();
        let nama = $('#spp_nama').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: 'Yakin Menambahkan SPP ?',
            text: "",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, yakin!',
            cancelmButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: '/kelas/record/spp/push_record',
                    data: {
                        untuk_bulan: bulan,
                        kode_kelas: kelas,
                        kode_peserta: peserta
                    },
                    success: function(data) {
                        if (data[0] == 'true') {
                            Swal.fire(
                                data[1], '', 'success'
                            );
                            getRecordPstValue(nama, kelas, peserta);
                        } else {
                            Swal.fire(
                                data[1], '', 'error'
                            );
                        }
                    }
                });
            }
        })
    });

    function onClickFeeSpp(auth, kelas) {
        if (auth == '6') {
            Swal.fire({
                title: 'Ingin Ubah Biaya SPP?',
                text: '',
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ubah!',
                cancelmButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    window.location.href = '/pengaturan/class/' + kelas + '/edit#spp';
                }
            });
        } else {
            Swal.fire(
                'Biaya SPP Sudah Ditentukan Oleh Pengurus Ranting.', '', 'info'
            );
        }
    }
</script>



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