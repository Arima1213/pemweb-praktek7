<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <title>program crud</title>
  </head>
  <body style="height: 100vh; ">
    <?php
      // Koneksi ke database
      $conn = mysqli_connect("localhost", "root", "", "db_pegawai");
      if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
      }
      
      // Menampilkan data pegawai dari tabel "pegawai"
      $sql = "SELECT p.id_pegawai  , p.nama , p.alamat , CONCAT('Rp. ', FORMAT(p.gaji, 0)) as \"gaji\", d.id_departemen  , d.nama_departemen , j.nama_jabatan 
              FROM pegawai p 
              JOIN pegawai_departemen pd ON p.id_pegawai  = pd.id_pegawai 
              join departemen d on pd.id_departemen = d.id_departemen  
              join pegawai_jabatan pj on p.id_pegawai = pj.id_pegawai 
              join jabatan j on pj.id_jabatan = j.id_jabatan 
              order by p.id_pegawai";

      $result = mysqli_query($conn, $sql);
    ?>

    <div id="formkuUbah"
         class="row text-white" 
         style="height: 100vh; 
                width: 100vw; 
                display : none; 
                z-index : 99;
                position : fixed; 
                background-color: rgba(0, 0, 0, 0.75);
                justify-content: center;
                align-items: center;
    ">
      <div class="col-3 mx-auto" >
        <form method="post" action="ubah.php" class="needs-validation" novalidate>
          <div style="display: flex; justify-content: flex-end;">
            <button type="button" class="btn-close btn-close-white" aria-label="Close" style="position : relative; margin-bottom : -43px;"></button>
          </div>
          <h5 class="text-center mb-3">Ubah Data</h5>
          <div class="mb-3">
            <label class="form-label">Nama Pegawai</label>
            <input id="validationCustom01" type="text" name="nama_pegawai" class="form-control" aria-describedby="passwordHelpBlock" required>
            <div class="invalid-feedback">
              Harap masukkan nama pegawai.
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea id="validationCustom02" class="form-control" name="alamat" aria-label="With textarea" aria-describedby="alamatHelpBlock" required></textarea>
            <div class="invalid-feedback">
              Harap masukkan alamat pegawai.
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Departemen</label>
            <select id="validationCustom03" class="form-select" name="departemen" aria-label="Pilih Departemen" required>
              <option selected disabled>Pilih Departemen</option>
              <option value="1">Departemen IT</option>
              <option value="2">Departemen Keuangan</option>
              <option value="3">Departemen Pemasaran</option>
              <option value="4">Departemen Produksi</option>
              <option value="5">Departemen Sumber Daya Manusia</option>
              <option value="6">Departemen Pengembangan Bisnis</option>
              <option value="7">Departemen Riset dan Pengembangan</option>
              <option value="8">Departemen Logistik</option>
              <option value="9">Departemen Pelayanan Pelanggan</option>
              <option value="10">Departemen Teknik</option>
            </select>
            <div class="invalid-feedback">
              Harap pilih departemen.
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <select class="form-select" id="validationCustom04" name="jabatan" aria-label="Pilih Jabatan" required>
              <option selected disabled>Pilih Jabatan</option>
              <option value="1">Manajer</option>
              <option value="2">Supervisor</option>
              <option value="3">Staf Administrasi</option>
              <option value="4">Staf Keuangan</option>
              <option value="5">Staf Marketing</option>
              <option value="6">Staf Produksi</option>
              <option value="7">Staf SDM</option>
              <option value="8">Staf Pengembangan Bisnis</option>
              <option value="9">Staf Riset dan Pengembangan</option>
              <option value="10">Staf Teknik</option>
            </select>
            <div class="invalid-feedback">
              Harap pilih jabatan.
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Nominal Gaji</label>
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input id="validationCustom05" type="text" name="nominal_gaji" class="form-control" aria-label="Amount (to the nearest Rupiah)" required>
              <input id="id_pegawai" type="hidden" name="id_pegawai" value="">
              <div class="invalid-feedback">
                Harap masukkan nominal gaji.
              </div>
            </div>
          </div>
          
          <div class="d-grid col-5 mx-auto">
            <button type="submit" name="simpan" class="btn btn-primary justify-content-center save-button" >Simpan</button>
          </div>
        </form>
      </div>
    </div> 
    
    <div class="px-5" style="background-color: #212529;height: 100%;width: 100%; ">
      <div class="row">
        <h1 class="text-center text-white my-3 h1">PROGRAM CRUD DATA PEGAWAI</h1>
        <div class="col-12">
          <div class="row my-1 mt-4 justify-content-between">
            <div class="col-2 justify-content-end">
              <button class="btn btn-primary show-form-simpan" >
                <svg xmlns="http://www.w3.org/2000/svg" 
                    height="24px" 
                    viewBox="0 0 24 24" 
                    width="24px" 
                    fill="#FFFFFF">
                  <path d="M0 0h24v24H0z" 
                        fill="none"/>
                  <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>Tambah Pegawai
              </button>
            </div>
            <div class="col-4">
              <input type="text" class="form-control" placeholder="Cari Nama" aria-label="Username" aria-describedby="basic-addon1" id="search-bar" onkeypress="search()">
            </div>
          </div>
        </div>
        <div class="col-12">
            <?php
              // Koneksi ke database
              $conn = mysqli_connect("localhost", "root", "", "db_pegawai");
              if (!$conn) {
                die("Koneksi gagal: " . mysqli_connect_error());
              }
              // Memeriksa apakah ada data yang ditemukan
              if (mysqli_num_rows($result) > 0) {    
                echo "<div id=\"tabelku\" class=\"table-responsive\">
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
                          echo "Tidak ada data pegawai."; 
                        }
                        if($conn){
                          mysqli_close($conn);
                        }
            ?>
        </div>
        <div id="formkuSimpan"
        class="row text-white" 
        style="height: 100vh; 
                width: 100vw; 
                display : none; 
                z-index : 99;
                position : fixed; 
                background-color: rgba(0, 0, 0, 0.75);
                justify-content: center;
                align-items: center;
        ">
          <div class="col-3 mx-auto" >
            <form method="post" action="simpan.php" class="needs-validation" novalidate>
              <div style="display: flex; justify-content: flex-end;">
                <button type="button" class="btn-close btn-close-white" aria-label="Close" style="position : relative; margin-bottom : -43px;"></button>
              </div>
              <h5 class="text-center mb-3">Tambah Data</h5>
              <div class="mb-3">
                <label class="form-label">Nama Pegawai</label>
                <input id="validationCustom01" type="text" name="nama_pegawai" class="form-control" aria-describedby="passwordHelpBlock" required>
                <div class="invalid-feedback">
                  Harap masukkan nama pegawai.
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea id="validationCustom02" class="form-control" name="alamat" aria-label="With textarea" aria-describedby="alamatHelpBlock" required></textarea>
                <div class="invalid-feedback">
                  Harap masukkan alamat pegawai.
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Departemen</label>
                <select id="validationCustom03" class="form-select" name="departemen" aria-label="Pilih Departemen" required>
                  <option selected disabled>Pilih Departemen</option>
                  <option value="1">Departemen IT</option>
                  <option value="2">Departemen Keuangan</option>
                  <option value="3">Departemen Pemasaran</option>
                  <option value="4">Departemen Produksi</option>
                  <option value="5">Departemen Sumber Daya Manusia</option>
                  <option value="6">Departemen Pengembangan Bisnis</option>
                  <option value="7">Departemen Riset dan Pengembangan</option>
                  <option value="8">Departemen Logistik</option>
                  <option value="9">Departemen Pelayanan Pelanggan</option>
                  <option value="10">Departemen Teknik</option>
                </select>
                <div class="invalid-feedback">
                  Harap pilih departemen.
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <select class="form-select" id="validationCustom04" name="jabatan" aria-label="Pilih Jabatan" required>
                  <option selected disabled>Pilih Jabatan</option>
                  <option value="1">Manajer</option>
                  <option value="2">Supervisor</option>
                  <option value="3">Staf Administrasi</option>
                  <option value="4">Staf Keuangan</option>
                  <option value="5">Staf Marketing</option>
                  <option value="6">Staf Produksi</option>
                  <option value="7">Staf SDM</option>
                  <option value="8">Staf Pengembangan Bisnis</option>
                  <option value="9">Staf Riset dan Pengembangan</option>
                  <option value="10">Staf Teknik</option>
                </select>
                <div class="invalid-feedback">
                  Harap pilih jabatan.
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Nominal Gaji</label>
                <div class="input-group">
                  <span class="input-group-text">Rp</span>
                  <input id="validationCustom05" type="text" name="nominal_gaji" class="form-control" aria-label="Amount (to the nearest Rupiah)" required>
                  <div class="invalid-feedback">
                    Harap masukkan nominal gaji.
                  </div>
                </div>
              </div>
              
              <div class="d-grid col-5 mx-auto">
                <button type="submit" name="simpan" class="btn btn-primary justify-content-center save-button" >Tambah</button>
              </div>
            </form>
          </div>
        </div> 
    </div>
  </div> 

    <script>
      var showUbahFormButtons = document.querySelectorAll(".show-form-ubah");
      var showSimpanFormButtons = document.querySelectorAll(".show-form-simpan");
      var hideFormButtons = document.querySelectorAll(".btn-close");
      var saveButton = document.querySelectorAll(".save-button");
      var deleteButtons = document.querySelectorAll(".delete-button");
      var myFormUbah = document.getElementById("formkuUbah");
      var myFormSimpan = document.getElementById("formkuSimpan");
      var tableku = document.getElementById("tabelku");

      showUbahFormButtons.forEach(function(button) {
        button.addEventListener("click", function() {
          myFormUbah.style.display = "flex";
          // Ambil nilai data-id
          const idPegawai = button.getAttribute('data-id');
          // Set value dari input hidden dengan nilai id pegawai
          const inputId = document.querySelector('#id_pegawai');
          inputId.value = idPegawai;
          
          console.log(inputId.value)
        });
      });

      showSimpanFormButtons.forEach(function(button) {
        button.addEventListener("click", function() {
          myFormSimpan.style.display = "flex";
        });
      });

      hideFormButtons.forEach(function(button) {
        button.addEventListener("click", function() {
          myFormUbah.style.display = "none";
          myFormSimpan.style.display = "none";
        });
      });
      
      saveButton.forEach(function(button) {
        button.addEventListener("click", function() {
          myForm.style.display = "none";
        });
      });

      function search() {
      const searchValue = document.getElementById("search-bar").value;
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tabelku").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "search.php?q=" + searchValue, true);
      xmlhttp.send();
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  </body>
</html>