<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="/">
                    <div class="sb-nav-link-icon"><i class="fas fa-fw fa-home"></i></div>
                    Dashboard
                </a>
                <?php if ($this->session->userdata('role') == 'Admin'): ?>
                <div class="sb-sidenav-menu-heading">Menu</div>
                <a class="nav-link" href="/user">
                    <div class="sb-nav-link-icon"><i class="fas fa-fw fa-user"></i></div>
                    Kelola User
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-right"></i></div>
                </a>                
                <a class="nav-link" href="/doctor">
                    <div class="sb-nav-link-icon"><i class="fas fa-fw fa-user-doctor"></i></div>
                    Kelola Dokter
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-right"></i></div>
                </a>                
                <a class="nav-link" href="/patient">
                    <div class="sb-nav-link-icon"><i class="fas fa-fw fa-bed"></i></div>
                    Kelola Pasien
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-right"></i></div>
                </a>                
                <div class="sb-sidenav-menu-heading">Rekam Medis</div>
                <a class="nav-link" href="/record">
                    <div class="sb-nav-link-icon"><i class="fas fa-fw fa-laptop-medical"></i></div>
                    Data Rekam Medis
                </a>
                <?php endif; ?>

                <?php if ($this->session->userdata('role') == 'Doctor'): ?>
                <div class="sb-sidenav-menu-heading">Rekam Medis</div>
                <a class="nav-link" href="/medical-record">
                    <div class="sb-nav-link-icon"><i class="fas fa-fw fa-laptop-medical"></i></div>
                    Data Rekam Medis
                </a>                            
                <?php endif; ?>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo $this->session->userdata('role'); ?>
        </div>
    </nav>
</div>