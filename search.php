<?php
    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "db_pegawai");
    if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
    }

    // get the search query
    $searchValue = $_GET["q"];

    // construct the SQL query
    $sqlSearch = "SELECT p.id_pegawai  , p.nama , p.alamat , CONCAT('Rp. ', FORMAT(p.gaji, 0)) as \"gaji\", d.id_departemen  , d.nama_departemen , j.nama_jabatan 
                FROM pegawai p 
                JOIN pegawai_departemen pd ON p.id_pegawai  = pd.id_pegawai 
                join departemen d on pd.id_departemen = d.id_departemen  
                join pegawai_jabatan pj on p.id_pegawai = pj.id_pegawai 
                join jabatan j on pj.id_jabatan = j.id_jabatan 
                where p.nama LIKE '%$searchValue%'
                order by p.id_pegawai
                ";

    $result = mysqli_query($conn, $sqlSearch);

    // check if any data is found
    if (mysqli_num_rows($result) > 0) {
        echo "<div class=\"table-responsive\">
            <table class=\"table table-dark table-striped table-hover\">
                <thead>
                <tr>
                    <th style=\"white-space: nowrap;\">ID Pegawai</th>
                    <th style=\"white-space: nowrap;\">Nama Pegawai</th>
                    <th style=\"white-space: nowrap;\">Alamat Pegawai</th>
                    <th style=\"white-space: nowrap;\">Nama Departemen</th>
                    <th style=\"white-space: nowrap;\">jabatan</th>
                    <th style=\"white-space: nowrap;\">gaji</th>
                    <th style=\"white-space: nowrap;\">Hapus</th>
                    <th style=\"white-space: nowrap;\">Edit</th>
                </tr>
                </thead>
                <tbody class=\"overflow-scroll\">";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                <td>" . $row["id_pegawai"] . "</td>
                <td>" . $row["nama"] . "</td>
                <td>" . $row["alamat"] . "</td>
                <td>" . $row["nama_departemen"] . "</td>
                <td>" . $row["nama_jabatan"] . "</td>
                <td>" . $row["gaji"] . "</td>
                <td>
                    <form method=\"post\" action=\"hapus.php\">
                    <input type=\"hidden\" name=\"id_pegawai\" value='" . $row['id_pegawai'] . "'>
                    <button type=\"submit\" class=\"btn delete-button\" data-id='" . $row['id_pegawai'] . "'>
                        <svg xmlns=\"http://www.w3.org/2000/svg\" 
                            height=\"24px\" 
                            viewBox=\"0 0 24 24\" 
                            =\"24px\" fill=\"#dc3545\">
                        <path d=\"M0 0h24v24H0z\" 
                                fill=\"none\"/>
                        <path d=\"M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z\"/>
                        </svg>
                    </button>
                    </form>
                </td>
                <td>
                    <button type=\"submit\" class=\"btn show-form-ubah\" data-id='" . $row['id_pegawai'] . "'>
                    <svg xmlns=\"http://www.w3.org/2000/svg\" 
                            height=\"24px\" 
                            viewBox=\"0 0 24 24\" 
                            width=\"24px\" 
                            fill=\"#ffc107\">
                        <path d=\"M0 0h24v24H0z\" 
                            fill=\"none\"/>
                        <path d=\"M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z\"/>
                    </svg>
                    </button>
                </td>
                </tr>";
            } 
            echo "</tbody></table></div>"; 
            } else { 
                echo "<div class=\"table-responsive\">
                <table class=\"table table-dark table-striped table-hover\">
                    <thead>
                    <tr>
                        <th style=\"white-space: nowrap;\">ID Pegawai</th>
                        <th style=\"white-space: nowrap;\">Nama Pegawai</th>
                        <th style=\"white-space: nowrap;\">Alamat Pegawai</th>
                        <th style=\"white-space: nowrap;\">Nama Departemen</th>
                        <th style=\"white-space: nowrap;\">jabatan</th>
                        <th style=\"white-space: nowrap;\">gaji</th>
                        <th style=\"white-space: nowrap;\">Hapus</th>
                        <th style=\"white-space: nowrap;\">Edit</th>
                    </tr>
                    </thead>
                    <tbody class=\"overflow-scroll\">
                    <td class=\"text-center\" colspan=\"8\">Tidak Ada Data Yang Cocok</td>
                    
                    "; 

                echo "</tbody></table></div>"; 
            }
            if($conn){
                mysqli_close($conn);
            }
?>