<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>SIMAWI - Dashboard</title>
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
                        <h4 class="mt-4 head-font">Dashboard</h4>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>                                           
						<!--Content Here-->
                        <hr>
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="card bg-light text-white mb-4">
                                    <div class="card-body text-dark"><?php echo $patient_total;?> Total Pasien</div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card bg-light text-white mb-4">
                                    <div class="card-body text-dark"><?php echo $patient_total_month;?>  Pasien Terdaftar (<?php echo date('M Y')?>)</div>
                                </div>
                            </div>                           
                        </div>                        

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pasien
                            </div>
                            <div class="card-body">
                            <table id="table">
                                    <thead>
                                        <tr>
                                            <th>No. Rekam Medis</th>
                                            <th>Nama</th>
                                            <th>Tanggal Lahir (Usia)</th>
                                            <th>No. Hp</th>
                                            <th>Tanggal Daftar</th>                                            
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No. Rekam Medis</th>
                                            <th>Nama</th>
                                            <th>Tanggal Lahir (Usia)</th>
                                            <th>No. Hp</th>          
                                            <th>Tanggal Daftar</th>                                                                              
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php if (!empty($user)): ?>
                                        <?php foreach ($user as $item): ?>
                                        <tr>
                                            <td><?php echo $item['RecordNumber']; ?></td>
                                            <td><?php echo $item['Name']; ?></td>
                                            <td><?php echo date('d M Y', strtotime($item['Birth'])); ?> (<?php echo (date('Y') - date('Y', strtotime($item['Birth']))); ?>)</td>
                                            <td><?php echo $item['Phone']; ?></td>
                                            <td><?php echo date('d M Y', strtotime($item['CreatedAt'])); ?></td>
                                            <td>
                                                <a href="/patient/edit?id=<?php echo $item['ID']; ?>" class="btn btn-sm btn-light"><i class="fas fa-fw fa-pencil"></i>Edit</a>
                                                <button type="button" onClick="deleteConfirm(<?php echo $item['ID']; ?>)" class="btn btn-sm btn-danger ms-2"><i class="fas fa-fw fa-trash"></i>Delete</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak ada Data</td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h4 class="m-0 head-font">5 ICD-10 Teratas</h4>
                            <p class="text-secondary">Berdasarkan klasifikasi ICD-10 RS Ngurah</p>
                        </div>                

                        <div class="overflow-auto">
                            <div class="case-scroll">
                                <?php foreach ($most_cases as $item): ?>
                                <div class="case float-start text-end">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="head-font m-0"><?php echo $item['total']?></h2>
                                            <p class="fs-6 text-secondary m-0"><?php echo $item['ICD10Code']?></p>
                                            <p class="fs-6 text-secondary m-0"><?php echo $item['ICD10Name']?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>                                
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
    </body>
</html>
