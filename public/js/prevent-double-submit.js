// Cegah double-submit: sekali form disubmit, tombol submit-nya langsung
// dinonaktifkan supaya klik kedua (atau double-click) tidak mengirim ulang.
// Berlaku otomatis untuk semua <form> di halaman, tidak perlu setup tambahan per form.
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            if (form.dataset.sedangDikirim === 'true') {
                return;
            }
            form.dataset.sedangDikirim = 'true';

            form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (tombol) {
                tombol.disabled = true;
                if (tombol.tagName === 'BUTTON') {
                    tombol.dataset.teksAsli = tombol.innerHTML;
                    tombol.innerHTML = 'Memproses...';
                }
            });
        });
    });
});
