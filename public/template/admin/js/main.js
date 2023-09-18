$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function getProductValue(){
    const id_product = document.getElementById("id_product").value;
    $.ajax({
        type: 'POST',
        datatype: 'JSON',
        data: { id_product },
        url: "/admin/billreceiveds/getProductValue",
        success: function (result) {
            if (result.error === false) {
                alert(result.message);
            } else {
                document.getElementById('idNCC').innerHTML = result.madoanhnghiep;
                document.getElementById('nameNCC').innerHTML = result.tencoso;
                document.getElementById('nameNV').innerHTML = result.tenchunhatrong;
                document.getElementById('idNV').innerHTML = result.mavungtrong;
                document.getElementById('img_product').src = result.thumb;

            }
        }
    })
}

function removeRow(id, url) {
    if (confirm('Xóa vĩnh viễn! Vui lòng xác nhận ?')) {
        $.ajax({
            type: 'DELETE',
            datatype: 'JSON',
            data: { id },
            url: url,
            success: function (result) {
                if (result.error === false) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert('Xóa lỗi vui lòng thử lại');
                }
            }
        })
    }
}


/*Upload File */
$('#upload').change(function () {
    const form = new FormData();
    form.append('file', $(this)[0].files[0]);

    $.ajax({
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'JSON',
        data: form,
        url: '/admin/upload/services',
        success: function (results) {
            if (results.error === false) {
                $('#image_show').html('<a href="' + results.url + '" target="_blank">' +
                    '<img src="' + results.url + '" style="border-radius: 5%; max-width: 30vmax; max-height: 30vmax""></a>');

                $('#thumb').val(results.url);
            } else {
                alert('Upload File Lỗi');
            }
        }
    });
});

