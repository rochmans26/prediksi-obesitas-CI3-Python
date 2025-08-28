</main>
<div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1" aria-label="Bootstrap">
                <img src="<?= base_url('assets/img/obscu-logo.png') ?>" alt="logo" width="70px" />
            </a>
            <span class="mb-3 mb-md-0 text-body-secondary">© 2025 Obscu, Inc. by Nanda Marthatilaar</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-body-secondary" href="#" aria-label="Instagram"><svg class="bi" width="24"
                        height="24" aria-hidden="true">
                        <use xlink:href="#instagram"></use>
                    </svg></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#" aria-label="Facebook"><svg class="bi" width="24"
                        height="24">
                        <use xlink:href="#facebook"></use>
                    </svg></a></li>
        </ul>
    </footer>
</div>
<script src="<?= base_url('vendor/bs5/dist/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('vendor/bs5/js/color-modes.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('consultationForm');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Ambil nilai input
            const nama = document.getElementById('nama').value.trim();
            const email = document.getElementById('email').value.trim();
            const telp = document.getElementById('telp').value.trim();
            const sex = document.getElementById('sex').value;
            const age = document.getElementById('age').value.trim();

            // Validasi
            if (!nama) {
                showError('Nama lengkap harus diisi');
                return;
            }

            if (!email) {
                showError('Email harus diisi');
                return;
            }

            if (!isValidEmail(email)) {
                showError('Format email tidak valid');
                return;
            }

            if (!telp) {
                showError('Nomor telepon harus diisi');
                return;
            }

            if (!isValidPhone(telp)) {
                showError('Format nomor telepon tidak valid (minimal 10 digit angka)');
                return;
            }

            if (sex === "Pilih Salah Satu") {
                showError('Jenis kelamin harus dipilih');
                return;
            }

            if (!age) {
                showError('Umur harus diisi');
                return;
            }

            if (isNaN(age) || age < 1 || age > 120) {
                showError('Umur harus antara 1 sampai 120 tahun');
                return;
            }

            // Jika semua validasi terpenuhi
            Swal.fire({
                title: 'Konfirmasi Data',
                html: `
                <div style="text-align: left;">
                    <p><strong>Nama:</strong> ${nama}</p>
                    <p><strong>Email:</strong> ${email}</p>
                    <p><strong>No. Telp:</strong> ${telp}</p>
                    <p><strong>Jenis Kelamin:</strong> ${sex === "1" ? "Laki-laki" : "Perempuan"}</p>
                    <p><strong>Umur:</strong> ${age} tahun</p>
                </div>
            `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, data sudah benar',
                cancelButtonText: 'Periksa lagi'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika dikonfirmasi
                    form.submit();
                }
            });
        });

        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
                confirmButtonColor: '#3085d6'
            });
        }

        function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function isValidPhone(telp) {
            // Minimal 10 digit angka (boleh ada + di depan)
            const re = /^\+?\d{10,}$/;
            return re.test(telp);
        }
    });
</script>
</body>

</html>