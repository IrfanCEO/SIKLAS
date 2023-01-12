<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title></title>
</head>
<body>
    <div class="container">
        <div class="row">
            <?php
            $cluster1 = array();
            $query1 = mysqli_query($koneksi, "SELECT cluster.nilai_cluster AS nilai FROM siswa JOIN cluster ON siswa.kode_siswa = cluster.kode_siswa JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan JOIN thajaran_smt ON siswa.kode_siswa = thajaran_smt.kode_siswa WHERE cluster.jenis_cluster = 'Berprestasi'");
            while ($baris= mysqli_fetch_array($query1)) {
                $cluster1[] = $baris['nilai'];
            }
            $cluster2 = array();
            $query2 = mysqli_query($koneksi, "SELECT cluster.nilai_cluster AS nilai FROM siswa JOIN cluster ON siswa.kode_siswa = cluster.kode_siswa JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan JOIN thajaran_smt ON siswa.kode_siswa = thajaran_smt.kode_siswa WHERE cluster.jenis_cluster = 'Cukup Berprestasi'");
            while ($baris= mysqli_fetch_array($query2)) {
                $cluster2[] = $baris['nilai'];
            }
            $cluster3 = array();
            $query3 = mysqli_query($koneksi, "SELECT cluster.nilai_cluster AS nilai FROM siswa JOIN cluster ON siswa.kode_siswa = cluster.kode_siswa JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan JOIN thajaran_smt ON siswa.kode_siswa = thajaran_smt.kode_siswa WHERE cluster.jenis_cluster = 'Tidak Berprestasi'");
            while ($baris= mysqli_fetch_array($query3)) {
                $cluster3[] = $baris['nilai'];
            }
            $json_C1 = json_encode($cluster1);
            $json_C2 = json_encode($cluster2);
            $json_C3 = json_encode($cluster3);
            ?>
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <canvas id="1"></canvas>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                var json_C1 = jQuery.parseJSON( '<?= $json_C1; ?> ' );
                var json_C2 = jQuery.parseJSON( '<?= $json_C2; ?> ' );
                var json_C3 = jQuery.parseJSON( '<?= $json_C3; ?> ' );
                var plotData1 = [];
                var plotData2 = [];
                var plotData3 = [];
                var rand = 0;
                for (var i=0; i < Object.keys(json_C1).length; i++) {
                    rand = Math.floor(Math.random() * 10) + 1;
                    plotData1.push({'x': json_C1[i], 'y': rand});
                }
                for (var i=0; i < Object.keys(json_C2).length; i++) {
                    rand = Math.floor(Math.random() * 10) + 1;
                    plotData2.push({'x': json_C2[i], 'y': rand});
                }
                for (var i=0; i < Object.keys(json_C3).length; i++) {
                    rand = Math.floor(Math.random() * 10) + 1;
                    plotData3.push({'x': json_C3[i], 'y': rand});
                }

                const ctx = document.getElementById('1');
                const data = {
                    datasets: [{
                        label: 'Berprestasi',
                        data: plotData1,
                        backgroundColor: 'rgb(84, 180, 53)'
                    }, {
                        label: 'Cukup Berprestasi',
                        data: plotData2,
                        backgroundColor: 'rgb(60, 121, 245)'                        
                    }, {
                        label: 'Tidak Berprestasi',
                        data: plotData3,
                        backgroundColor: 'rgb(255, 99, 132)'                        
                    }],
                };

                new Chart(ctx, {
                    type: 'scatter',
                    data: data,
                    options: {
                        scales: {
                            x: {
                                type: 'linear',
                                position: 'bottom'
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>
<script src="js/bootstrap.js"></script>

<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
<script src="js/styles.js"></script>
<script src="js/jquery.dataTables.js"></script>

</body>
</html>