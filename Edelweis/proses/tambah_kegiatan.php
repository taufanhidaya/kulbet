<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kegiatan = mysqli_real_escape_string($conn, $_POST['nama_kegiatan']);
    $tanggal_kegiatan_input = $_POST['tanggal_kegiatan'];
    $divisi = mysqli_real_escape_string($conn, $_POST['divisi']);
    $no_anggota = mysqli_real_escape_string($conn, $_POST['no_anggota']);
    $deskripsi_kegiatan = mysqli_real_escape_string($conn, $_POST['deskripsi_kegiatan']);
    $instagram_url = mysqli_real_escape_string($conn, $_POST['instagram_url']);
    $tiktok_url = mysqli_real_escape_string($conn, $_POST['tiktok_url']);
    $youtube_url = mysqli_real_escape_string($conn, $_POST['youtube_url']);
    $facebook_url = mysqli_real_escape_string($conn, $_POST['facebook_url']);
    $twitter_url = mysqli_real_escape_string($conn, $_POST['twitter_url']);

    // Validasi tanggal
    try {
        $tanggal_kegiatan = (new DateTime($tanggal_kegiatan_input))->format('Y-m-d');
    } catch (Exception $e) {
        echo "Format tanggal tidak valid. Gunakan format YYYY-MM-DD.";
        exit();
    }

    // Validasi divisi
    $allowed_divisi = ['KSDA', 'RAFTING', 'CLIMBING', 'MONTAIN'];
    if (!in_array($divisi, $allowed_divisi)) {
        echo "Divisi tidak valid. Pilih salah satu dari: " . implode(", ", $allowed_divisi);
        exit();
    }

    // Validasi no_anggota
    $check_no_anggota = "SELECT no_anggota FROM pengurus WHERE no_anggota = '$no_anggota'";
    $result = mysqli_query($conn, $check_no_anggota);
    if (mysqli_num_rows($result) == 0) {
        echo "No Anggota tidak valid. Pastikan data anggota sudah terdaftar.";
        exit();
    }

    $target_dir = "../assets/media/";
    $media_kegiatan = isset($_FILES['media_kegiatan']['name']) ? basename($_FILES['media_kegiatan']['name']) : '';
    $unique_file_name = uniqid() . "_" . $media_kegiatan;
    $target_file = $target_dir . $unique_file_name;

    $uploadOk = 1;

    if (!empty($_FILES['media_kegiatan']['tmp_name'])) {
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];

        if (!in_array($fileType, $allowed_types)) {
            echo "Hanya file gambar atau video yang diperbolehkan.";
            $uploadOk = 0;
        }

        if ($_FILES["media_kegiatan"]["size"] > 52428800) {
            echo "Ukuran file terlalu besar (maksimum 50MB).";
            $uploadOk = 0;
        }

        if ($uploadOk === 1) {
            if (move_uploaded_file($_FILES["media_kegiatan"]["tmp_name"], $target_file)) {
                $sql = "
                    INSERT INTO kegiatan (
                        nama_kegiatan, 
                        tanggal_kegiatan, 
                        divisi, 
                        no_anggota, 
                        deskripsi_kegiatan, 
                        media_kegiatan, 
                        instagram_url, 
                        tiktok_url, 
                        youtube_url, 
                        facebook_url, 
                        twitter_url
                    ) VALUES (
                        '$nama_kegiatan', 
                        '$tanggal_kegiatan', 
                        '$divisi', 
                        '$no_anggota', 
                        '$deskripsi_kegiatan', 
                        '$unique_file_name', 
                        '$instagram_url', 
                        '$tiktok_url', 
                        '$youtube_url', 
                        '$facebook_url', 
                        '$twitter_url'
                    )
                ";

                if (mysqli_query($conn, $sql)) {
                    header("Location: ../kegiatan");
                    exit();
                } else {
                    echo "Query Error: " . mysqli_error($conn);
                }
            } else {
                echo "Terjadi kesalahan saat mengupload file.";
            }
        }
    } else {
        echo "File media tidak ditemukan.";
    }

    mysqli_close($conn);
} else {
    echo "Akses tidak diizinkan.";
}
?>
