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
                        <h4 class="mt-4 head-font">Data User</h4>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('/'); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">User</li>
                        </ol>                                           
						<!--Content Here-->
                        <hr>

                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8 pt-1">
                                        <i class="fas fa-table me-1"></i>
                                        Data User
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="<?php echo base_url('/user/create'); ?>" class="btn btn-success btn-sm"><i class="fas fa-fw fa-add"></i>User</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Tanggal Terdaftar</th>                                            
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Tanggal Terdaftar</th>                                            
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php if (!empty($user)): ?>
                                        <?php foreach ($user as $item): ?>
                                        <tr>
                                            <td><?php echo $item['Name']; ?></td>
                                            <td><?php echo $item['Email']; ?></td>
                                            <td><?php echo date('d M Y', strtotime($item['CreatedAt'])); ?></td>                                            
                                            <td>
                                                <a href="<?php echo base_url('/user/edit?id='); ?><?php echo $item['ID']; ?>" class="btn btn-sm btn-light"><i class="fas fa-fw fa-pencil"></i>Edit</a>
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
            function deleteConfirm(id) {
                Swal.fire({
                    title: "Hapus?",
                    text: "Data akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo base_url('/user/delete?id='); ?>"+id
                    }
                });
            }
        </script>
    </body>
</html>
