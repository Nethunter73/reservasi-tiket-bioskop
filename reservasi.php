<?php
require 'includes/koneksi.php';
include 'includes/header.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $koneksi->prepare("SELECT * FROM film WHERE id = :id");
$stmt->execute(['id' => $id]);
$film = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$film) {
    echo '<div class="container my-5"><div class="alert alert-danger text-center">
            Film tidak ditemukan. <a href="index.php" class="alert-link">Kembali ke Beranda</a>
          </div></div>';
    include 'includes/footer.php';
    exit;
}

// Ubah string jadwal "12:00, 15:00, 18:00" jadi array
$jadwalList = array_map('trim', explode(',', $film['jadwal']));
?>

<section class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
            <li class="breadcrumb-item"><a href="detail.php?id=<?php echo $film['id']; ?>"><?php echo htmlspecialchars($film['judul']); ?></a></li>
            <li class="breadcrumb-item active">Reservasi Tiket</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-1"><i class="fa-solid fa-ticket me-2 text-danger"></i>Form Reservasi Tiket</h3>
                    <p class="text-muted mb-4">Lengkapi data berikut untuk memesan tiket <strong><?php echo htmlspecialchars($film['judul']); ?></strong>.</p>

                    <form action="konfirmasi.php" method="POST">
                        <input type="hidden" name="film_id" value="<?php echo $film['id']; ?>">
                        <input type="hidden" name="harga" id="harga" value="<?php echo $film['harga']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Pemesan</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="tel" name="telepon" class="form-control" placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Film</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($film['judul']); ?>" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jadwal Tayang</label>
                                <select name="jadwal" id="jadwal" class="form-select" required>
                                    <option value="">-- Pilih Jam Tayang --</option>
                                    <?php foreach ($jadwalList as $jam): ?>
                                        <option value="<?php echo htmlspecialchars($jam); ?>"><?php echo htmlspecialchars($jam); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jumlah Tiket</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control"
                                       value="1" min="1" max="10" required>
                            </div>
                        </div>

                        <div class="alert alert-light border d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Total Pembayaran:</span>
                            <span class="fs-5 fw-bold text-danger" id="totalTampil">
                                Rp <?php echo number_format($film['harga'], 0, ',', '.'); ?>
                            </span>
                        </div>

                        <button type="submit" class="btn btn-danger btn-lg w-100 mt-2">
                            <i class="fa-solid fa-check me-1"></i>Konfirmasi Pemesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Hitung total pembayaran secara otomatis (live) saat jumlah tiket berubah
    const hargaSatuan = <?php echo (int) $film['harga']; ?>;
    const inputJumlah = document.getElementById('jumlah');
    const totalTampil = document.getElementById('totalTampil');

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    inputJumlah.addEventListener('input', function () {
        let jumlah = parseInt(this.value) || 0;
        let total = jumlah * hargaSatuan;
        totalTampil.textContent = formatRupiah(total);
    });
</script>

<?php include 'includes/footer.php'; ?>
