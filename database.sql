-- =========================================
-- Database Reservasi Tiket Bioskop
-- =========================================

CREATE DATABASE IF NOT EXISTS reservasi_bioskop;
USE reservasi_bioskop;

CREATE TABLE IF NOT EXISTS film (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    durasi INT NOT NULL COMMENT 'durasi dalam menit',
    harga INT NOT NULL,
    poster VARCHAR(255) NOT NULL,
    sinopsis TEXT NOT NULL,
    jadwal VARCHAR(255) NOT NULL COMMENT 'jam tayang dipisah koma'
);

INSERT INTO film (judul, genre, durasi, harga, poster, sinopsis, jadwal) VALUES
('Bumi Yang Hilang', 'Petualangan / Sci-Fi', 128, 45000,
 'https://picsum.photos/seed/bumi/400/600',
 'Sekelompok penjelajah menemukan portal menuju dunia paralel yang menyimpan rahasia kepunahan manusia. Mereka harus berpacu dengan waktu sebelum portal tertutup selamanya.',
 '12:00, 15:00, 18:00, 21:00'),

('Jejak Senja', 'Drama Romantis', 105, 40000,
 'https://picsum.photos/seed/senja/400/600',
 'Kisah cinta dua sahabat masa kecil yang dipertemukan kembali setelah 15 tahun berpisah, dan harus memilih antara masa lalu atau masa depan.',
 '13:00, 16:00, 19:00'),

('Malam Tanpa Bulan', 'Horor', 95, 42000,
 'https://picsum.photos/seed/malam/400/600',
 'Sebuah keluarga pindah ke rumah warisan yang menyimpan kutukan turun-temurun. Teror dimulai setiap kali bulan tak tampak di langit.',
 '14:00, 17:00, 20:00, 22:30'),

('Rasa Yang Tersisa', 'Komedi Keluarga', 110, 38000,
 'https://picsum.photos/seed/rasa/400/600',
 'Seorang chef muda kembali ke kampung halaman untuk menyelamatkan restoran keluarga yang hampir bangkrut, dengan cara-cara yang penuh kekacauan lucu.',
 '11:00, 14:30, 18:30'),

('Garis Waktu', 'Aksi / Thriller', 132, 48000,
 'https://picsum.photos/seed/garis/400/600',
 'Seorang mantan agen rahasia harus mencegah serangan besar yang akan mengubah garis waktu sejarah, dengan hanya 24 jam tersisa.',
 '12:30, 15:30, 18:00, 21:30'),

('Suara Dari Ruang Kosong', 'Misteri', 100, 40000,
 'https://picsum.photos/seed/suara/400/600',
 'Seorang detektif menyelidiki serangkaian kejadian aneh di gedung apartemen tua yang konon dihuni oleh penghuni yang tak pernah terlihat.',
 '13:30, 16:30, 19:30');
