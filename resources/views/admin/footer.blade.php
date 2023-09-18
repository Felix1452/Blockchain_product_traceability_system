
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>

<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="/template/admin/dist/js/adminlte.min.js?v=3.2.0"></script>

<script src="/template/admin/js/main.js"></script>

<script>


    function btAnimationSaleroom(){
        const myTimeout = setTimeout(sendDataSaleroom, 500);
    }

    function sendDataSaleroom(){
        if (confirm('Bạn có chắc chắn thêm dữ liệu này vào hệ thống')) {
            const tencoso =  document.getElementById("tencoso").value;
            const madoanhnghiep =  document.getElementById("madoanhnghiep").value;
            const tenchucoso =  document.getElementById("tenchucoso").value;
            const tennguoidaidien =  document.getElementById("tennguoidaidien").value;
            const diachi =  document.getElementById("diachi").value;
            const sodienthoai =  document.getElementById("sodienthoai").value;
            const mota =  document.getElementById("mota").value;
            const thumb_saleroom =  document.getElementById("thumb").value;


            if(tencoso == "" || madoanhnghiep =="" || tenchucoso == "" || tennguoidaidien == null || diachi ==null || sodienthoai == null || mota == null || thumb_saleroom == null){
                alert("Vui lòng nhập đầy đủ thông tin!");
            }else {
                document.getElementById('submit').innerHTML = '<i class="fa fa-spinner fa-spin"></i> Save'
                const  button = document.getElementById('submit');
                button.disabled = true;
                $.ajax({
                    type: 'POST',
                    datatype: 'JSON',
                    data: { tencoso,madoanhnghiep,tenchucoso,tennguoidaidien,diachi,sodienthoai,mota,thumb_saleroom },
                    url: "/admin/salerooms/add",
                    success: function (result) {
                        if (result.error === false) {
                            alert(result.message);
                            location.reload();
                        } else {
                            alert(result.message);
                            document.getElementById('submit').innerHTML = 'Thêm Salesroom'
                            const  button = document.getElementById('submit');
                            button.disabled = false;
                            document.getElementById("tencoso").value = "";
                            document.getElementById("madoanhnghiep").value = "";
                            document.getElementById("tenchucoso").value = "";
                            document.getElementById("tennguoidaidien").value = "";
                            document.getElementById("diachi").value = "";
                            document.getElementById("sodienthoai").value = "";
                            document.getElementById("mota").value = "";
                            document.getElementById("thumb").value = "";
                            document.getElementById("upload").value = "";
                        }
                    }
                })
            }

        }else {

        }
    }

    function btAnimation(){
        const myTimeout = setTimeout(sendData, 500);
    }

    function sendData(){
        if (confirm('Bạn có chắc chắn thêm dữ liệu này vào hệ thống')) {
            const id_product =  document.getElementById("id_product").value;
            const quantity =  document.getElementById("quantity").value;
            const shelf_life =  document.getElementById("shelf_life").value;
            var saleroom =  $('#saleroom').val();

            const selected = document.querySelectorAll('#saleroom option:checked');
            const values = Array.from(selected).map(el => el.value);

            alert(JSON.stringify(values));

            // if(id_product == "" || quantity =="" || shelf_life == "" || saleroom == null){
            //     alert("Vui lòng nhập đầy đủ thông tin!");
            // }else {
            //     document.getElementById('submit').innerHTML = '<i class="fa fa-spinner fa-spin"></i> Save'
            //     const  button = document.getElementById('submit');
            //     button.disabled = true;
            //     $.ajax({
            //         type: 'POST',
            //         datatype: 'JSON',
            //         data: { id_product,quantity,shelf_life,saleroom },
            //         url: "/admin/blocks/add",
            //         success: function (result) {
            //             if (result.error === false) {
            //                 alert(result.message);
            //                 location.reload();
            //             } else {
            //                 alert('Thêm thành công');
            //                 document.getElementById('submit').innerHTML = 'Save'
            //                 const  button = document.getElementById('submit');
            //                 button.disabled = false;
            //                 document.getElementById('name').value = '';
            //                 document.getElementById('description').value = '';
            //                 document.getElementById('content').value = '';
            //             }
            //         }
            //     })
            // }

        }else {

        }
    }
</script>

@yield('footer')


