<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>SIMAWI - Data User</title>
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
                        <h4 class="mt-4 head-font">Tambah User</h4>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('/'); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('/user'); ?>">User</a></li>
                            <li class="breadcrumb-item active">Tambah User</li>
                        </ol>                                           
						<!--Content Here-->
                        <hr>

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-8 pt-1">
                                                <i class="fas fa-plus me-1"></i>
                                                Tambah User
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo site_url('user/create-post')?>" method="POST">
                                            <div class="form-group mb-2">
                                                <label class="text-secondary fs-6" for="name">Nama</label>
                                                <input value="<?= set_value('name'); ?>" required name="name" type="text" class="form-control" id="name" aria-describedby="name" placeholder="Isikan nama lengkap">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="text-secondary fs-6" for="email">Email</label>
                                                <input value="<?= set_value('email'); ?>" required name="email" type="email" class="form-control" id="email" aria-describedby="email" placeholder="Isikan email">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="text-secondary fs-6" for="password">Password Default</label>
                                                <input value="<?= set_value('password'); ?>" required name="password" type="text" class="form-control" id="password" aria-describedby="password" placeholder="Isikan password">
                                            </div>

                                            <?php if ($this->session->flashdata('errors')): ?>
                                                <div class="alert alert-danger fs-6">
                                                    <strong>Errors:</strong><br>
                                                    <?php echo $this->session->flashdata('errors'); ?>
                                                </div>
                                            <?php endif; ?>

                                            <button class="btn btn-primary mt-3">SIMPAN</button>
                                        </form>
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
