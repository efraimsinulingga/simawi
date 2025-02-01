<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>SIMAWI - Data Riwayat Pasien</title>
		<meta name="description" content="" />
		<?php $this->load->view('component/head', FALSE); ?>
    </head>
    <body class="sb-nav-fixed">
		<?php $this->load->view('component/nav', FALSE); ?>
        <div id="layoutSidenav">
            <?php $this->load->view('component/sidebar', FALSE); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h4 class="mt-4 head-font">Data Riwayat Pasien</h4>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Riwayat Pasien</li>
                        </ol>                                           
						<!--Content Here-->
                        <hr>

                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-4 pt-1">
                                        <i class="fas fa-table me-1"></i>
                                        Data Riwayat Pasien
                                    </div>              
                                    <form method="GET" class="col-md-8 d-flex justify-content-end">
                                        <input value="<?php if(isset($_GET['q'])) echo $_GET['q'] ?>" class="form-control me-4" placeholder="Cari no medis/nama pasien" name="q"/>
                                        <input value="<?php if(isset($_GET['date'])) echo $_GET['date'] ?>" type="date" class="form-control me-4 w-50" placeholder="Tanggal Visit" name="date"/>
                                        <select name="is_done" class="form-control w-50">
                                            <option <?php if(isset($_GET['is_done']) && $_GET['is_done'] == '0') echo 'selected' ?> value="0">Belum Selesai</option>
                                            <option <?php if(isset($_GET['is_done']) && $_GET['is_done'] == '1') echo 'selected' ?> value="1">Selesai</option>
                                        </select>
                                        <button type="submit" method="GET" class="ms-4 btn btn-light"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </form>                    
                                </div>
                            </div>
                            <div class="card-body">
                            <?php if (!empty($user)): ?>
                                <table id="table">
                                    <thead>
                                        <tr>
                                            <th>No. Medis</th>
                                            <th>Nama Pasien</th>
                                            <th>Tgl. Lahir (Usia)</th>
                                            <th>Tanggal Daftar</th>
                                            <th>Didaftar oleh</th>                                            
                                            <th>Dokter</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No. Medis</th>
                                            <th>Nama Pasien</th>
                                            <th>Tgl. Lahir (Usia)</th>
                                            <th>Tanggal Daftar</th>
                                            <th>Didaftar oleh</th>                                            
                                            <th>Dokter</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    
                                        <?php foreach ($user as $item): ?>
                                        <tr>
                                            <td><?php echo $item['RecordNumber']; ?></td>
                                            <td><?php echo $item['PatientName']; ?></td>
                                            <td><?php echo date('d M Y', strtotime($item['PatientBirth'])); ?> (<?php echo (date('Y') - date('Y', strtotime($item['PatientBirth']))); ?>)</td>
                                            <td><?php echo date('d M Y', strtotime($item['DateVisit'])); ?></td>                                                                                        
                                            <td><?php echo $item['RegisteredName']; ?></td>                                            
                                            <td><?php echo $item['DoctorName']; ?></td>
                                            <td>
                                            <?php 
                                                if ($item['isDone'] == 0) {                                                  
                                                    echo '<span class="badge bg-danger">Belum Selesai</span>';
                                                } else {
                                                    echo '<span class="badge bg-success">Selesai</span>';
                                                }
                                                ?>
                                            </td>                                            
                                            <td>
                                                <?php if($item['isDone'] == 0):?>
                                                <a href="<?php echo base_url('/medical-record/diagnose?id='); ?><?php echo $item['ID']?>" class="btn btn-sm btn-light"><i class="fas fa-fw fa-pencil"></i>Periksa</a>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>                                    
                                    </tbody>
                                </table>
                                <?php else: ?>
                                    <p class="text-center fs-6 text-secondary">
                                        Tidak ada Data
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>                        
                    </div>   
                    
                    <div class="p-4"></div>
                </main>                
            </div>
        </div>

		<?php $this->load->view('component/footer', FALSE); ?>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script>
            window.addEventListener('DOMContentLoaded', event => { 
                const datatablesSimple = document.getElementById('table');
                if (datatablesSimple) {
                    new simpleDatatables.DataTable(datatablesSimple);
                }
            });
        </script>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <script>            
            function comingSoon() {
                Swal.fire({
                    title: "Oops",
                    text: "Sayangnya fitur ini belum bisa digunakan",
                    icon: "warning"
                });
            }
        </script>
    </body>
</html>
