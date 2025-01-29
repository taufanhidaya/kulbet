<?php
// Mulai sesi untuk notifikasi (opsional)
session_start();

// Masukkan file koneksi database
include 'koneksi.php'; // Sesuaikan dengan lokasi file koneksi Anda

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi apakah ID kegiatan ada di POST
    if (isset($_POST['id_kegiatan']) && !empty($_POST['id_kegiatan'])) {
        $id_kegiatan = intval($_POST['id_kegiatan']); // Hindari SQL Injection

        // Ambil data kegiatan untuk menghapus file media
        $querySelect = "SELECT media_kegiatan FROM kegiatan WHERE id_kegiatan = ?";
        $stmtSelect = $conn->prepare($querySelect);
        $stmtSelect->bind_param('i', $id_kegiatan);
        $stmtSelect->execute();
        $result = $stmtSelect->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $mediaFile = $row['media_kegiatan'];

            // Hapus file media jika ada
            $filePath = "../assets/media/" . $mediaFile;
            if (file_exists($filePath) && !is_dir($filePath)) {
                unlink($filePath);
            }

            // Hapus data dari database
            $queryDelete = "DELETE FROM kegiatan WHERE id_kegiatan = ?";
            $stmtDelete = $conn->prepare($queryDelete);
            $stmtDelete->bind_param('i', $id_kegiatan);

            if ($stmtDelete->execute()) {
                // Redirect dengan pesan sukses (opsional)
                $_SESSION['success_message'] = "Kegiatan berhasil dihapus.";
                header("Location: ../kegiatan");
                exit;
            } else {
                // Redirect dengan pesan error (opsional)
                $_SESSION['error_message'] = "Terjadi kesalahan saat menghapus data.";
                header("Location: ../kegiatan");
                exit;
            }
        } else {
            // Redirect jika data tidak ditemukan
            $_SESSION['error_message'] = "Data kegiatan tidak ditemukan.";
            header("Location: ../kegiatan");
            exit;
        }
    } else {
        // Redirect jika ID kegiatan tidak valid
        $_SESSION['error_message'] = "ID kegiatan tidak valid.";
        header("Location: ../kegiatan");
        exit;
    }
} else {
    // Redirect jika metode tidak valid
    $_SESSION['error_message'] = "Metode request tidak valid.";
    header("Location: ../kegiatan");
    exit;
}
?>
