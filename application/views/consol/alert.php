<script>
    var id = "<?php echo $id; ?>";
    $(document).ready(function() {
        function fungsi(id) {
            swal({
                    title: "Ingin Langsung Pindahkan ke Zona Delivery?",
                    text: "Nomor CA ini hanya memiliki 1 picklist, pastikan item dan qty benar!",
                    icon: "warning",
                    buttons: ["Batal", "Pindahkan"],
                    dangerMode: true,
                })
                .then((willMove) => {
                    if (willMove) {
                        $.ajax({
                            url: url + 'package/movedeliver',
                            method: 'post',
                            data: {
                                ca: id
                            },
                            dataType: 'json',
                            success: function() {}
                        })
                        setTimeout(function() {
                            window.open(url + 'package/moved#search=' + id, '_self');
                        }, time);
                    } else {
                        window.open(url + "consol/add", "_self");
                    }
                });
        }

        fungsi(id);
    })
</script>