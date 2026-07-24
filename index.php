<?php
require 'includes/koneksi.php';
include 'includes/header.php';

// Ambil kata kunci pencarian jika ada
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

if ($keyword !== '') {
    $stmt = $koneksi->prepare("SELECT * FROM film WHERE judul LIKE :keyword ORDER BY judul ASC");
    $stmt->execute(['keyword' => '%' . $keyword . '%']);
} else {
    $stmt = $koneksi->query("SELECT * FROM film ORDER BY judul ASC");
}
$daftarFilm = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- HERO SECTION -->
<section class="hero-section text-white text-center d-flex align-items-center">
    <div class="container">
        <h1 class="display-4 fw-bold"><i class="fa-solid fa-clapperboard me-2"></i>CinemaKu</h1>
        <p class="lead">
            Pesan tiket bioskop favoritmu kapan saja, di mana saja — tanpa perlu mengantre panjang di lokasi.
        </p>

        <!-- FORM PENCARIAN -->
        <form action="index.php" method="GET" class="search-form mx-auto mt-4">
            <div class="input-group input-group-lg">
                <input type="text" name="keyword" class="form-control"
                       placeholder="Cari judul film..." value="<?php echo htmlspecialchars($keyword); ?>">
                <button class="btn btn-danger" type="submit">
                    <i class="fa-solid fa-magnifying-glass me-1"></i>Cari
                </button>
            </div>
        </form>
    </div>
</section>

<!-- DAFTAR FILM -->
<section id="daftar-film" class="container my-5">
    <h2 class="fw-bold mb-4 text-center">
        <?php echo $keyword !== '' ? 'Hasil Pencarian: "' . htmlspecialchars($keyword) . '"' : 'Film Sedang Tayang'; ?>
    </h2>

    <?php if (count($daftarFilm) === 0): ?>
        <div class="alert alert-warning text-center">
            <i class="fa-solid fa-circle-exclamation me-1"></i>
            Film dengan judul "<?php echo htmlspecialchars($keyword); ?>" tidak ditemukan.
            <a href="index.php" class="alert-link">Lihat semua film</a>.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($daftarFilm as $film): ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm film-card">
                        <img src="<?php echo htmlspecialchars($film['poster']); ?>"
                             class="card-img-top" alt="Poster <?php echo htmlspecialchars($film['judul']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($film['judul']); ?></h5>
                            <p class="card-text mb-1">
                                <span class="badge bg-secondary"><?php echo htmlspecialchars($film['genre']); ?></span>
                            </p>
                            <p class="card-text small text-muted mb-1">
                                <i class="fa-regular fa-clock me-1"></i><?php echo $film['durasi']; ?> menit
                            </p>
                            <p class="card-text fw-bold text-danger mb-3">
                                Rp <?php echo number_format($film['harga'], 0, ',', '.'); ?> / tiket
                            </p>
                            <a href="detail.php?id=<?php echo $film['id']; ?>" class="btn btn-outline-dark mt-auto">
                                <i class="fa-solid fa-eye me-1"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
