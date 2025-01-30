<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>SIMAWI - Data Pasien</title>
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
                        <h4 class="mt-4 head-font">Edit Pasien</h4>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href='/medical-record'>Riwayat Pasien</a></li>
                            <li class="breadcrumb-item active">Diagnosa</li>
                        </ol>                                           
						<!--Content Here-->
                        <hr>

                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8 pt-1">
                                        <i class="fas fa-plus me-1"></i>
                                        Diagnosa
                                    </div>                                    
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo site_url('medical-record/diagnose-post')?>" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><?php echo $user->PatientName;?></li>
                                            <li class="list-group-item"><?php echo date('d M Y', strtotime($user->PatientBirth)); ?> (<?php echo (date('Y') - date('Y', strtotime($user->PatientBirth))); ?>Tahun)</li>
                                            <li class="list-group-item"><?php echo $user->Symptoms;?></li>                                            
                                        </ul>                                               
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2">
                                                <input name="id" type="hidden" required value="<?php echo $user->ID;?>">
                                                <label class="text-secondary fs-6" for="icd">Kode ICD</label>
                                                <input required name="kode" type="text" class="form-control" id="icd" aria-describedby="icd" placeholder="Cari kode ICD">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="text-secondary fs-6" for="name">Nama </label>
                                                <input required name="name" type="text" class="form-control" id="name" aria-describedby="name" placeholder="Nama ICD">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="text-secondary fs-6" for="address">Diagnosa</label>
                                                <textarea name="diagnose" required class="form-control" placeholder="Isikan diagnosa" rows="3"></textarea>
                                            </div>
                                            

                                            <button class="btn btn-primary mt-3 float-end">SIMPAN</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>  
                    </div>
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
    </body>
</html>
