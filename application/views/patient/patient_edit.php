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
                            <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('/patient'); ?>">Pasien</a></li>
                            <li class="breadcrumb-item active">Edit Pasien</li>
                        </ol>                                           
						<!--Content Here-->
                        <hr>

                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8 pt-1">
                                        <i class="fas fa-plus me-1"></i>
                                        Edit Pasien
                                    </div>                                    
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo site_url('patient/edit-post')?>" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2">
                                                <input type="hidden" value="<?php echo $user->ID; ?>" name="id">
                                                <label class="text-secondary fs-6" for="rekam">Rekam Medis</label>
                                                <input required value="<?= set_value('rekam', $user->RecordNumber); ?>" name="rekam" type="text" class="form-control" id="rekam" aria-describedby="rekam" placeholder="Isikan no. Rekam Medis">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="text-secondary fs-6" for="name">Nama Lengkap</label>
                                                <input required value="<?= set_value('name', $user->Name); ?>" name="name" type="text" class="form-control" id="name" aria-describedby="name" placeholder="Isikan nama">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="text-secondary fs-6" for="birth">Tanggal Lahir</label>
                                                <input required value="<?= set_value('birth', $user->Birth); ?>" name="birth" type="date" class="form-control" id="birth" aria-describedby="birth" placeholder="Isikan tanggal lahir">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="text-secondary fs-6" for="nik">NIK</label>
                                                <input required value="<?= set_value('nik', $user->NIK); ?>" name="nik" type="number" minlength="16" maxlength="16" class="form-control" id="nik" aria-describedby="nik" placeholder="Isikan NIK">
                                            </div>                                                   
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2">
                                                <label class="text-secondary fs-6" for="phone">No. hp</label>
                                                <input required value="<?= set_value('phone', $user->Phone); ?>" name="phone" type="text" minlength="8" maxlength="14" class="form-control" id="phone" aria-describedby="phone" placeholder="Isikan No. Handphone">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="text-secondary fs-6" for="address">Alamat</label>
                                                <textarea name="address" required class="form-control" placeholder="Isikan data alamat" rows="3"><?= set_value('address', $user->Address); ?></textarea>
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="text-secondary fs-6" for="blood">Golongan Darah</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="blood" id="bloodTypeA" value="A" <?= ($user->BloodType == 'A' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="bloodTypeA">A</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="blood" id="bloodTypeB" value="B" <?= ($user->BloodType == 'B' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="bloodTypeB">B</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="blood" id="bloodTypeAB" value="AB" <?= ($user->BloodType == 'AB' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="bloodTypeAB">AB</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="blood" id="bloodTypeO" value="O" <?= ($user->BloodType == 'O' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="bloodTypeO">O</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="blood" id="bloodTypeRh" value="Rh" <?= ($user->BloodType == 'Rh' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="bloodTypeRh">Rh-</label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="text-secondary fs-6" for="height">Tinggi Badan (cm)</label>
                                                        <input required value="<?= set_value('height', $user->Height); ?>" name="height" type="number" minlength="2" maxlength="3" class="form-control" id="height" aria-describedby="height" placeholder="Isi tinggi badan">
                                                    </div> 
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="text-secondary fs-6" for="weight">Berat Badan (kg)</label>
                                                        <input required value="<?= set_value('weight', $user->Weight); ?>" name="weight" type="number" minlength="1" maxlength="3" class="form-control" id="weight" aria-describedby="weight" placeholder="Isi berat badan">
                                                    </div> 
                                                </div>
                                            </div>

                                            <?php if ($this->session->flashdata('errors')): ?>
                                                <div class="alert alert-danger fs-6">
                                                    <strong>Errors:</strong><br>
                                                    <?php echo $this->session->flashdata('errors'); ?>
                                                </div>
                                            <?php endif; ?>

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
