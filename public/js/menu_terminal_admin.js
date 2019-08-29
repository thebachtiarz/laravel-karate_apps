
$('.buttonPost').on('click', function () {
    let query = $('.thisQuery').val();
    // console.log(query);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/nimda/auth/query',
        // dataType: 'json',
        data: { key: query },
        success: function (data) {
            $('#postValueAjax').html(data);
        }
    });
});