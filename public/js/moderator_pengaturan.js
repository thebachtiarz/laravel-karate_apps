
// get all access class
$(document).ready(function () {
	$('.hiddenReact').on('click', function () {
		var addr = $(this).attr('value');
		$('table').remove('tableDataJSON');
		$('.getHidden').attr('hidden', 'value');
		$('#' + addr).removeAttr("hidden");
		var dataNeed = $(this).data('ajaxjson');
		$.ajax({
			type: 'GET',
			url: '/ajaxgettable/' + dataNeed,
			success: function (data) {
				$('.thisDataJSON').html(data);
			}
		});
	});
	$('.page-scroll').on('click', function (e) {
		if ($(this).attr('href')) {
			var addr = $(this).attr('href');
		} else {
			var addr = '#' + $(this).data('goto');
		}
		var elmAddr = $(addr);
		$('html').animate({
			scrollTop: elmAddr.offset().top - 95
		}, 1250, 'easeInOutExpo');
		e.preventDefault();
	});
});

// save edit sweetalert
$('.saveButton').on('click', function (e) {
	e.preventDefault();
	var tipe = $(this).data('type');
	Swal.fire({
		title: 'Anda Yakin?',
		text: "Melakukan Perubahan " + tipe + "?",
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Iya, Yakin!',
		cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.value) {
			$(this).closest('form').submit();
		}
	})
});

// delete sweetalert
$(document).on("click", ".delete-req", function (e) {
	e.preventDefault();
	const href = $(this).attr('href');
	const type = $(this).attr('data-type');
	Swal.fire({
		title: 'Yakin Hapus ' + type + '?',
		text: "",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, hapus!',
		cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.value) {
			document.location.href = href;
			// result.preventDefault();
		}
	})
});

// return cash peserta sweetalert
$(document).on("click", ".returnCashPeserta", function (e) {
	e.preventDefault();
	let saldo = $(this).attr('data-saldo');
	Swal.fire({
		title: 'Yakin Kembalikan Semua Dana?',
		text: 'Total yang harus dikembalikan adalah Rp.' + saldo + ',-',
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, kembalikan!',
		cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.value) {
			$(this).closest('form').submit();
		}
	})
});

// add new pelatih or bendahara
$('.addNewResource').on('click', function (e) {
	e.preventDefault();
	let type = $(this).data('type');
	Swal.fire({
		title: 'Anda Yakin?',
		text: "Menambahkan " + type + " Baru?",
		type: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Iya, Yakin!',
		cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.value) {
			$(this).closest('form').submit();
		}
	})
});

// section show hidden toggle
$('.showToggle').on('click', function () {
	$('.addHiddenToggle').attr('hidden', 'value');
	let addr = $(this).data('goto');
	let dataNeed = $(this).data('need');
	let kodekelas = $(this).data('kodekelas');
	let send = $(this).data('send');
	$('#' + addr).removeAttr("hidden");
	// console.log(addr + dataNeed + kodekelas);
	$.ajax({
		type: 'GET',
		url: '/ajaxgettable/' + dataNeed,
		data: { kelas: kodekelas },
		dataType: 'json',
		success: function (data) {
			if (data[0] == 'true') {
				if (dataNeed == 'getdatapeserta') {
					var header = '<div class="table-responsive"><table class="table table-hover table-condensed"><thead class="bg-primary"><th>#</th><th>Nama Peserta</th><th>Tingkat</th><th>No Induk</th><th>Aksi</th></thead><tbody>';
				} else {
					var header = '<div class="table-responsive"><table class="table table-hover table-condensed"><thead class="bg-primary"><th>#</th><th>Nama</th><th>Akses Sejak</th><th>Aksi</th></thead><tbody>';
				}
				var showData = '';
				var footer = '</tbody></table></div>';
				var x;
				for (x = 0; x < data[1].length; x++) {
					if (dataNeed == 'getdatapeserta') {
						showData += '<tr><td> ' + (x + 1) + '</td><td>' + data[1][x].peserta + '</td><td>' + data[1][x].tingkat + '</td><td>' + data[1][x].induk + '</td><td><a href="/pengaturan/peserta/profile/' + data[1][x].kelas + '/' + data[1][x].kode + '" class="btn btn-sm btn-info">Profil</a>&ensp;<a href="/pengaturan/peserta/delete/' + data[1][x].kelas + '/' + data[1][x].kode + '" class="btn btn-sm btn-danger delete-req" data-type="Peserta">Hapus</a></td></tr>';
					} else {
						showData += '<tr><td> ' + (x + 1) + '</td><td>' + data[1][x].pelatih + '</td><td>' + data[1][x].tgl_akses + '</td><td><button class="btn btn-sm btn-danger dataHapus" value="' + data[1][x].kode + '">Hapus</button></td></tr>';
					}
				}
				$('#' + send).html(header + showData + footer);
				dataTingkatPeserta(kodekelas);
			} else {
				let message = `<div class="callout callout-danger"><p><i class="fas fa-info-circle"></i>&ensp;` + data[1] + `</p></div>`;
				$('#' + send).html(message);
			}
		}
	});
});

// get tingkat peserta
function dataTingkatPeserta(kode_kelas) {
	// $.ajaxSetup({
	// 	headers: {
	// 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 	}
	// });
	$.ajax({
		type: 'GET',
		url: '/ajaxgettable/getdatatingkatpeserta',
		data: { kelas: kode_kelas },
		success: function (data) {
			if (data[0] == 'true') {
				var header = '<div class="table-responsive"><table class="table table-hover table-condensed"><thead class="bg-primary"><th>#</th><th>Nama Peserta</th><th>Tingkat</th><th>Aksi</th></thead><tbody>';
				var showData = '';
				var footer = '</tbody></table></div>';
				var x;
				for (x = 0; x < data[1].length; x++) {
					showData += '<tr><td> ' + (x + 1) + '</td><td>' + data[1][x].peserta + '</td><td>' + data[1][x].tingkat + '</td><td><button class="btn btn-sm btn-info text-bold" data-open="formreportbook" data-peserta="' + data[1][x].kode + '" data-kelas="' + data[1][x].kelas + '">Buka Buku Rapor</button></td></tr>';
				}
				$('#thisDataTingkatPeserta').html(header + showData + footer);
			} else {
				let message = `<div class="callout callout-danger"><p><i class="fas fa-info-circle"></i>&ensp;` + data[1] + `</p></div>`;
				$('#thisDataTingkatPeserta').html(message);
			}
		}
	});
}

// get new pelatih
$('#getNamaPelatih').on('keyup', function () {
	const keyName = $(this).val();
	if (keyName.length >= 3) {
		var dataNeed = $(this).data('ajaxjson');
		const header = '<div class="table-responsive"><table class="table table-hover table-condensed"><thead class="bg-primary"><th>#</th><th>Nama</th><th>Email</th><th>Aksi</th></thead><tbody>';
		const footer = '</tbody></table></div>';
		$.ajax({
			type: 'GET',
			url: '/ajaxgettable/' + dataNeed,
			data: { key: keyName },
			dataType: 'json',
			success: function (data) {
				var showData = '';
				var z;
				for (z = 0; z < data.length; z++) {
					showData += '<tr><td> ' + (z + 1) + '</td><td>' + data[z].name + '</td><td>' + data[z].email + '</td><td><button class="btn btn-sm btn-primary pilihPelatih" value="' + data[z].email + '">Pilih</button></td></tr >';
				}
				$('#getNamaPelatihData').html(header + showData + footer);
				$('.pilihPelatih').on('click', function () {
					let newPelatihEmail = $(this).val();
					$('#getNamaPelatih').val(newPelatihEmail);
				});
			}
		});
	}
});

// get peserta kelas for otentification
$('.searchPeserta').on('keyup click', function () {
	const srcKelas = $(this).data('kelas');
	const srcPeserta = $(this).val();
	// console.log(srcKelas + '/' + srcPeserta);
	if (srcPeserta.length >= 3) {
		var dataNeed = $(this).data('need');
		var header = '<div class="table-responsive"><table class="table table-hover table-condensed"><thead class="bg-primary"><th>#</th><th>Nama Peserta</th><th>Tingkat</th><th>No Induk</th><th>Aksi</th></thead><tbody>';
		var showData = '';
		var footer = '</tbody></table></div>';
		$.ajax({
			type: 'GET',
			url: '/ajaxgettable/' + dataNeed + '/' + srcKelas + '/' + srcPeserta,
			dataType: 'json',
			success: function (data) {
				var z;
				for (z = 0; z < data.length; z++) {
					showData += '<tr><td> ' + (z + 1) + '</td><td>' + data[z].nama_peserta + '</td><td>Kyu ' + data[z].tingkat + '</td><td>' + data[z].noinduk + '</td><td><button class="btn btn-sm btn-primary pilihPeserta" data-code="' + data[z].kode_peserta + '" data-nama="' + data[z].nama_peserta + '">Pilih</button></td></tr>';
				}
				$('#resultPesertaKelas').html(header + showData + footer);
				$('.pilihPeserta').on('click', function () {
					$('#getSelectedPeserta').removeAttr('hidden');
					$('#nama_ditemukan').val($(this).data('nama'));
					$('#code_ditemukan').val($(this).data('code'));
				});
			}
		});
	}
});

// auto select id after redirect
$(function () {
	var hash = window.location.hash;
	if (hash.length > 0) {
		$('a[role="tab"]').parent().removeClass('active');//remove the default active tab
		$('li').removeClass('active');
		$('.tab-pane').removeClass('active');
		$('a[href="' + hash + '"]').parent().addClass('active');
		$('div' + hash).addClass('active');
	}
});

