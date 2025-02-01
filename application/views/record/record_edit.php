<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>SIMAWI - Edit Pendaftaran</title>
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
                        <h4 class="mt-4 head-font">Edit Pendaftaran</h4>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('/'); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('/record'); ?>">Riwayat Pasien</a></li>
                            <li class="breadcrumb-item active">Edit Pendaftaran</li>
                        </ol>                                           
						<!--Content Here-->
                        <hr>                                                       
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-8 pt-1">
                                                    <i class="fas fa-plus me-1"></i>
                                                    Edit Pendaftaran
                                                </div>                                    
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?php echo site_url('record/edit-post')?>" method="POST">
                                                <div class="form-group mb-2">
                                                    <label class="text-secondary fs-6" for="patient">Pasien</label>
                                                    <input name="id" type="hidden" value="<?php echo $record->ID;?>">
                                                    <select class="form-control" name="patient" required>
                                                        <option value="">Pilih Pasien</option>
                                                        <?php foreach ($patient as $item): ?>
                                                            <option <?php if($record->RecordNumber === $item['RecordNumber']) echo 'selected';?> value="<?php echo $item['RecordNumber'];?>"><?php echo $item['RecordNumber'].' '.$item['Name'];?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <label class="text-secondary fs-6" for="patient">Dokter</label>
                                                    <select class="form-control" name="doctor">
                                                        <option value="">Pilih Dokter</option>
                                                        <?php foreach ($doctor as $item): ?>
                                                            <option <?php if($record->ConsultationBy === $item['ID']) echo 'selected';?> value="<?php echo $item['ID'];?>"><?php echo $item['Name'];?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                              
                                                <button class="btn btn-primary mt-3">UPDATE</button>
                                            </form>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>  
                            
                        
                    
                    <div class="p-4"></div>
                </main>                
            </div>
        </div>

		<?php $this->load->view('component/footer', FALSE); ?>        
    </body>
</html>
