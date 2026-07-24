<?php
require 'includes/koneksi.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<div class="container my-5"><div class="alert alert-danger text-center">
            Tidak ada data reservasi. <a href="index.php" class="alert-link">Kembali ke Beranda</a>
          </div></div>';
    include 'includes/footer.php';
    exit;
}

// Ambil & bersihkan data dari form reservasi
$filmId  = (int) $_POST['film_id'];
$nama    = htmlspecialchars($_POST['nama']);
$telepon = htmlspecialchars($_POST['telepon']);
$email   = htmlspecialchars($_POST['email']);
$jadwal  = htmlspecialchars($_POST['jadwal']);
$jumlah  = (int) $_POST['jumlah'];
$harga   = (int) $_POST['harga'];

$total = $jumlah * $harga;

// Ambil data film untuk ditampilkan di struk
$stmt = $koneksi->prepare("SELECT * FROM film WHERE id = :id");
$stmt->execute(['id' => $filmId]);
$film = $stmt->fetch(PDO::FETCH_ASSOC);

$kodeBooking = 'CNK-' . strtoupper(substr(uniqid(), -6));
?>

<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center mb-4">
                <i class="fa-solid fa-circle-check text-success" style="font-size: 3.5rem;"></i>
                <h3 class="fw-bold mt-2">Reservasi Berhasil!</h3>
                <p class="text-muted">Terima kasih, berikut ringkasan pemesanan tiket Anda.</p>
            </div>

            <div class="card shadow-sm struk-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <h5 class="fw-bold mb-0"><i class="fa-solid fa-film me-2"></i>CinemaKu</h5>
                        <span class="badge bg-dark">#<?php echo $kodeBooking; ?></span>
                    </div>

                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Nama Pemesan</td>
                            <td class="fw-semibold text-end"><?php echo $nama; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nomor Telepon</td>
                            <td class="fw-semibold text-end"><?php echo $telepon; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td class="fw-semibold text-end"><?php echo $email; ?></td>
                        </tr>
                        <tr><td colspan="2"><hr></td></tr>
                        <tr>
                            <td class="text-muted">Judul Film</td>
                            <td class="fw-semibold text-end"><?php echo htmlspecialchars($film['judul']); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jadwal Tayang</td>
                            <td class="fw-semibold text-end"><?php echo $jadwal; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jumlah Tiket</td>
                            <td class="fw-semibold text-end"><?php echo $jumlah; ?> tiket</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Harga / Tiket</td>
                            <td class="fw-semibold text-end">Rp <?php echo number_format($harga, 0, ',', '.'); ?></td>
                        </tr>
                        <tr><td colspan="2"><hr></td></tr>
                        <tr>
                            <td class="fw-bold fs-5">Total Pembayaran</td>
                            <td class="fw-bold fs-5 text-end text-danger">Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-outline-dark">
                    <i class="fa-solid fa-house me-1"></i>Kembali ke Beranda
                </a>
                <button onclick="window.print()" class="btn btn-danger ms-2">
                    <i class="fa-solid fa-print me-1"></i>Cetak Struk
                </button>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
