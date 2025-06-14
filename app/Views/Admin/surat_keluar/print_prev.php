<?= $template; ?>
<script>
var str = document.body.innerHTML;
var detailDataSuratKeluar = <?= json_encode($detail_surat_keluar); ?>;


// console.log(detailDataSuratKeluar);

if (detailDataSuratKeluar != null && detailDataSuratKeluar.length > 0) {
    // add data nama_user to {}
    if (detailDataSuratKeluar.length > 1) {
        // add ul list angka 1. nama_user, 2. nama_user dst
        var list = '<ol>';
        for (var i = 0; i < detailDataSuratKeluar.length; i++) {
            list += '<li style="padding: 2px;">' + detailDataSuratKeluar[i].nama_user + '</li>';
        }
        list += '</ol>';
        var regex = new RegExp("{" + 'nama_penerima' + "}", "g");
        str = str.replace(regex, list);

    } else {
        var nama_user = detailDataSuratKeluar[0].nama_user;
        var regex = new RegExp("{" + 'nama_penerima' + "}", "g");
        str = str.replace(regex, nama_user);
    }
    var regex = new RegExp("{" + 'tempat_penerima' + "}", "g");
    str = str.replace(regex, 'Tempat');
}

// // Update isi body dengan hasil yang sudah diganti
document.body.innerHTML = str;

window.print();

// when print is done, close the window
window.onafterprint = function() {
    window.close();
}
</script>