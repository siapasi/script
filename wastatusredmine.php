<?php
$token = "M-JV@79vwPE"; // Ganti dengan token WhatsApp Anda
$target = "6287712@g.us"; // Ganti dengan nomor tujuan WhatsApp Anda

// Koneksi ke database MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "re";


// Buat koneksi
$connect = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($connect->connect_error) {
    die("Koneksi gagal: " . $connect->connect_error);
}

// Daftar assigne yang ingin ditampilkan
$assigneList = array('Oka IT', 'Visarah Armelia', 'Hendrik Tatang GA', 'Resepsionis JSM', 'Ahmad Deni', 'Fragil Jatmiko', 'Mursyid (^ ^_)', 'Dedi Wahyudi');

// Inisialisasi array untuk menyimpan jumlah tiket berdasarkan assigne
$assigneCount = array();

// Loop melalui setiap assigne
foreach ($assigneList as $assigne) {
    // Query untuk mengambil jumlah tiket berdasarkan assigne dengan status tertentu
    $sql_count_assigne = "SELECT COUNT(*) AS jumlah FROM issues WHERE YEAR(create_at) = 2024 AND assigne = '$assigne' AND status IN ('New', 'Open', 'In Progress', 'Pending', 'Feedback')";
    $result_count_assigne = $connect->query($sql_count_assigne);

    // Memproses hasil query
    if ($result_count_assigne->num_rows > 0) {
        $row = $result_count_assigne->fetch_assoc();
        $jumlahTiket = $row["jumlah"];

        // Menambahkan jumlah tiket ke dalam array
        $assigneCount[$assigne] = $jumlahTiket;
    } else {
        // Jika tidak ada tiket untuk assigne tertentu
        $assigneCount[$assigne] = 0;
    }
}

// Mengurutkan array berdasarkan jumlah tiket (terbanyak ke terendah)
arsort($assigneCount);

// Membuat pesan WhatsApp

$message = "Yuk bersih-bersih tiket Redmine yang belum Resolved:\n";
foreach ($assigneCount as $assigne => $jumlahTiket) {
    $message .= "- $assigne - $jumlahTiket tiket\n";
}

// Daftar status yang ingin ditampilkan
$statusList = array('New', 'Open', 'In Progress', 'Pending', 'Feedback');

// Loop melalui setiap status
foreach ($statusList as $status) {
    // Query untuk mengambil data jumlah status dalam grup
    $sql_count_status = "SELECT COUNT(*) AS jumlah FROM issues WHERE status = '$status' AND assigne IN ('" . implode("', '", $assigneList) . "') AND YEAR(create_at) = 2024";
    $result_count_status = $connect->query($sql_count_status);

    // Output data jumlah status dalam grup
    if ($result_count_status->num_rows > 0) {
        $row = $result_count_status->fetch_assoc();
        $jumlahStatus = $row["jumlah"];
        $message .= "\nStatus: " . $status . " - Jumlah: " . $jumlahStatus . "\n";

        // Query untuk menampilkan data lengkap dari masing-masing status dengan assigne yang sesuai
        $sql_status_data = "SELECT issue_id, subject, assigne FROM issues WHERE status = '$status' AND assigne IN ('" . implode("', '", $assigneList) . "') AND YEAR(create_at) = 2024 ORDER BY create_at DESC";
        $result_status_data = $connect->query($sql_status_data);

        // Output data lengkap dari masing-masing status
        if ($result_status_data->num_rows > 0) {
            while ($data_row = $result_status_data->fetch_assoc()) {
                $message .= "- " . $data_row["issue_id"] . " : " . $data_row["subject"] . " - " . $data_row["assigne"] . "\n";
            }
        } else {
            $message .= "Tidak ada data untuk status " . $status . "\n";
        }
    } else {
        $message .= "Tidak ada tiket dengan status " . $status . "\n";
    }
}


// Kirim notifikasi WhatsApp
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.fonnte.com/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
        'target' => $target,
        'message' => $message,
    ),
    CURLOPT_HTTPHEADER => array(
        "Authorization: $token"
    ),
));

$response = curl_exec($curl);
curl_close($curl);

echo $response;

// Tutup koneksi
$connect->close();
?>
