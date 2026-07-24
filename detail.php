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
?>

<section class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($film['judul']); ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-md-4">
            <img src="<?php echo htmlspecialchars($film['poster']); ?>"
                 class="img-fluid rounded shadow-sm" alt="Poster <?php echo htmlspecialchars($film['judul']); ?>">
        </div>
        <div class="col-md-8">
            <h1 class="fw-bold"><?php echo htmlspecialchars($film['judul']); ?></h1>
            <span class="badge bg-secondary mb-3"><?php echo htmlspecialchars($film['genre']); ?></span>

            <ul class="list-unstyled mb-3">
                <li class="mb-2"><i class="fa-regular fa-clock me-2 text-danger"></i>Durasi: <?php echo $film['durasi']; ?> menit</li>
                <li class="mb-2"><i class="fa-solid fa-tag me-2 text-danger"></i>Harga: Rp <?php echo number_format($film['harga'], 0, ',', '.'); ?> / tiket</li>
                <li class="mb-2"><i class="fa-regular fa-calendar me-2 text-danger"></i>Jadwal Tayang: <?php echo htmlspecialchars($film['jadwal']); ?></li>
            </ul>

            <h5 class="fw-bold">Sinopsis</h5>
            <p class="text-muted"><?php echo nl2br(htmlspecialchars($film['sinopsis'])); ?></p>

            <a href="reservasi.php?id=<?php echo $film['id']; ?>" class="btn btn-danger btn-lg mt-3">
                <i class="fa-solid fa-ticket me-1"></i>Pesan Tiket Sekarang
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
