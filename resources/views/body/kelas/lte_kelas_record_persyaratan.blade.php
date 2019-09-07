@extends('layouts.masterlte')

@section('header')
<!-- DataTables -->
<link rel="stylesheet" href="{{ online_asset() }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>Record Persyaratan</h1>
    {!! createBreadcrumbByArrayOfCode(['kelas', $kelas]) !!}
    <div style="padding-top: 10px;"></div>
    @if((auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer') || (auth()->user()->status == 'instructor'))<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_peserta"><i class="fas fa-plus"></i>&ensp;Tambah Peserta</a>@endif
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-condensed dataTable" id="example2" role="grid">
                        <thead class="bg-primary">
                            <tr role="row">
                                <th class="text-center">No</th>
                                <th class="text-center sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">Nama</th>
                                <th class="text-center sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Tingkatan</th>
                                <th class="text-center sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="20%">Kelengkapan</th>
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
                                <td class="text-center"><a href="{{ route('kelas.record.persyaratan').'?key='.$kelas.'&pst='.$pst->kode_peserta }}" class="btn btn-sm btn-primary" type="button"><i class="fas fa-file-invoice fa-2x"></i></a></td>
                            </tr>
                            @php $no++ @endphp
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@include('body.modal_form.lte_modal_based_auth')

@endsection

@section('footer')

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