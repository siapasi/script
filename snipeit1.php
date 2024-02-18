<?php
// Konfigurasi API Snipe-IT
$apiUrl = 'https://redmine.com/api/v1/hardware?limit=4000&offset=0&sort=created_at&order=desc';
$apiKey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZWEzYWE4MzgwZWMxYjEzMTQ1YTM4MzEwNjY2YWZiNzcwZTU0YTM4MDliZTcyMjNhZjBlYTMwMTFkYmE1ZWI4ZjFkYmE1M2NhYzQ3YjUwZTciLCJpYXQiOjE3MDgyMjI2NjUuMzk1MTgsIm5iZiI6MTcwODIyMjY2NS4zOTUxODcsImV4cCI6Mjk3MDUyNjY2NS4xMDEwNzgsInN1YiI6IjEiLCJzY29wZXMiOltdfQ.lnd8h9IHURVC_-1OJqF-34QLbOlkL5NRbSCMhKNVomSNmi2GRIPHtRDanweApEGH2WoCX-cIxmcuKOGLmrbBHiHMM9rr7HeWB44SR94NjLCv6mIT9OpWPk71eJKOQ0P0yq8LiLazjV7l9eJNv4bRRCTRdoWbnvUK9areWk2QQcPHueuDPASvAXDS3LRiQANXzB3N1a-etKHsUXrDbB_VdW55ZtlD1skwyKHl1K2aF3G4BVnEc5Ryrvcjnn-qerofJGLIkNvW0UN6jtsKZwylVUwIt4Hd2Ep_FJDBmd0rf9PFIy3fB9RW4tRzBB-usjRMFoNTCUughK3NvWU5YMvYBVC5yNMu48HAsh034bEN-VlyWVZgfZerjWSVkpMPWytVsvypua9QbPN9g9QnMZPMRry1wPSttX6smx2g1R2r6VwGo_CM11dYrBzshUIc3rU-5crqucBzd1tvQ3z3iO22NOkbrgxyXA3nEMVL4mZf130Pe1Efkrc-Z7I_cKizxgoT0FcGPUWfSIUMFeGYwoasO3p0Yz0vls_C7Wl_NX8n4P3OjPTaqKG66_JfQ1IDBdI52aOtFst8gkifSGb8xekq8bM3lc8f41_Fn4Moq6mDeDtbOVPr8XqDqDbFWwjmYaNpDq9yCxkEvuautor4d9Ic2Z9NX5qUtuDjD8Xq8sdZERw
';

// Panggil fungsi untuk mendapatkan data aset dari API
$assets = getAssetsFromSnipeIT($apiUrl, $apiKey);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Aset</title>
    <!-- Sertakan pustaka CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.7.0/css/searchBuilder.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css">


<style>
    .dt-length, .dt-search {
  display: inline;
  border: 1px solid #ccc;
  padding: 10px;
  margin: 5px;
}
</style>




</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <?php
                // Tampilkan tabel HTML dengan data aset
                if (!empty($assets)) {
                    echo '<table id="assetTable" class="table table-striped table-bordered nowrap" style="width:100%">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Serial</th>';
                    echo '<th>Asset Tag</th>';
                    echo '<th>Model</th>';
                    echo '<th>Category</th>';
                    echo '<th>Location</th>';
                    echo '<th>Status</th>';
                    echo '<th>Purchase</th>';
                    echo '<th>Notes</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    foreach ($assets as $asset) {
                        echo '<tr>';
                        echo '<td>' . $asset['serial'] . '</td>';
                        echo '<td>' . $asset['asset_tag'] . '</td>';
                        echo '<td>' . ($asset['model']['name'] ?? '') . '</td>';
                        echo '<td>' . ($asset['category']['name'] ?? '') . '</td>';
                        echo '<td>' . ($asset['location']['name'] ?? '') . '</td>';
                        echo '<td>' . ($asset['status_label']['name'] ?? '') . '</td>';
                        echo '<td>' . ($asset['purchase_date']['formatted'] ?? '') . '</td>';
                        echo '<td>' . $asset['notes'] . '</td>';
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo "No assets found.";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Sertakan pustaka JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap4.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.7.0/js/dataTables.searchBuilder.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.7.0/js/searchBuilder.dataTables.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#assetTable').DataTable( {
                responsive: true,
                scrollX: true,
                dom: 'Qlfrtip',
                language: {
                    searchBuilder: {
                        conditions: {
                            category: {
                                '=': 'Category',
                            },
                            location: {
                                '=': 'Location',
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>





<?php
// Fungsi untuk mengambil data aset dari API Snipe-IT
function getAssetsFromSnipeIT($url, $apiKey) {
    // Konfigurasi header HTTP
    $header = [
        'http' => [
            'method' => 'GET',
            'header' => "Content-Type: application/json\r\n" .
                        "Authorization: Bearer $apiKey\r\n"
        ]
    ];

    // Buat konteks aliran
    $context = stream_context_create($header);

    // Ambil data dari API menggunakan file_get_contents
    $response = file_get_contents($url . 'hardware', false, $context);

    // Decode JSON response menjadi array
    $data = json_decode($response, true);

    // Kembalikan data
    return $data['rows'];
}
?>