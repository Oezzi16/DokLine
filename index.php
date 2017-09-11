<?php 
include "php/koneksi.php";
error_reporting(0); 
session_start();
?>
<!DOCTYPE>
<head>
	<title>Dok_Line</title>
	<link rel="icon" href="<?php echo base_url(); ?>dl.ico">
	<link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/dropdown-menu.css">
    <link rel="stylesheet" type="text/css" href="css/galeri.css">
    <style type="text/css">
        #login{
            float: right;
            background: #ed4536;
            height: 42px;
            border-top-left-radius: 11px;
            border-bottom-left-radius: 11px;
            box-shadow: 0 7px #d83527;
        }
        #login:hover{
            background: #C0392B;
            
        }
        #login a{
            color: #ede863;
        }
    </style>
	
</head>
<body bgcolor="#34495e">
<div class="wrap">
    <div class="header">
            
    </div>
 
           <ul id="navigation" class="nav-main">
            <li><a href="<?php echo base_url(); ?>">Beranda</a></li>
            <li class="list"><a href="#">Profile</a>
                <ul class="nav-sub">
                    <li><a href="<?php echo base_url(); ?>index.php?page=profil">Profile Dokline</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?page=contact">Kontak</a></li>
                    
                </ul>
            </li>
            <li><a href="<?php echo base_url(); ?>index.php?page=gallery">Galeri</a></li>
            <li><a href="<?php echo base_url(); ?>index.php?page=about">Tentang</a></li>
            <li><a href="<?php echo base_url(); ?>index.php?page=sk">S & K</a></li>
            <li><a href="<?php echo base_url(); ?>index.php?page=artikel">Artikel Kesehatan</a></li>
            
            <?php if ($_SESSION['nama'] && $_SESSION['role']==1) {  
                $query="SELECT * FROM `login` WHERE `role`=3 AND `status`=0";
                $sql=mysql_query($query);
                $num=mysql_num_rows($sql);
            ?>
            <li class="list"><a href="#">Data Dokter</a>
                <ul class="nav-sub">
                    <li><a href="<?php echo base_url(); ?>index.php?page=tampil_dokter">Data Dokter</a></li>
                    <li><a href='<?php echo base_url(); ?>index.php?page=tambah_dokter'>Tambah</a></li>
                    
                                       
                    
                </ul>
            </li>
            <li class="list"><a href="#">Data Pasien (<?=$num ?>)</a>
                <ul class="nav-sub">
                    <li><a href="<?php echo base_url(); ?>index.php?page=tampil_pasien">Data Pasien (<?=$num ?>)</a></li>
                                       
                    
                </ul>
            </li>
            <?php
            // jika yg login dokter
            }elseif ($_SESSION['nama'] && $_SESSION['role']==2) { ?>
            <li class="list"><a href="#">Data Dokter</a>
                <ul class="nav-sub">
                    <li><a href="<?php echo base_url(); ?>index.php?page=tampil_dokter">Data Dokter</a></li>                                      
                    
                </ul>
            </li>
            <li class="list"><a href="#">Data Pasien</a>
                <ul class="nav-sub">
                    <li><a href="<?php echo base_url(); ?>index.php?page=tampil_pasien">Data Pasien</a></li>
                                       
                    
                </ul>
            </li>
            <?php
            }elseif ($_SESSION['nama'] && $_SESSION['role']==3) { ?>
                <li class="list"><a href="#">Data Dokter</a>
                <ul class="nav-sub">
                    <li><a href="<?php echo base_url(); ?>index.php?page=tampil_dokter">Data Dokter</a></li>                                      
                    
                </ul>
            </li>
            
            <?php }else{ ?>
            <li class="list"><a href="#">Data Dokter</a>
                <ul class="nav-sub">
                    <li><a href="<?php echo base_url(); ?>index.php?page=tampil_dokter">Data Dokter</a></li>
                                                          
                    
                </ul>
            </li>

            <?php } ?>
            <?php 
            if ($_SESSION['nama'] && $_SESSION['role']==3) {
                $qnama="SELECT nama FROM pasien WHERE id='$_SESSION[nama]'";
                $sqlnama=mysql_query($qnama);
                $row=mysql_fetch_array($sqlnama);
                $nama=$row['nama']; ?>
                <li class='list' id='login'><a href='#'>Haloo ... <?=$nama ?></a>
                        <ul class='nav-sub'>
                            <li><a href='<?php echo base_url();?>index.php?page=account_pasien'>My Account</a></li>
                            <li><a href='<?php echo base_url();?>index.php?page=logout'>Logout</a></li>
                        </ul>
                      </li> <?php
            }else if ($_SESSION['nama'] && $_SESSION['role']==2) {
                $qnama="SELECT nama FROM dokter WHERE id='$_SESSION[nama]'";
                $sqlnama=mysql_query($qnama);
                $row=mysql_fetch_array($sqlnama);
                $nama=$row['nama']; ?>
                <li class='list' id='login'><a href='#'>Haloo ... <?=$nama ?></a>
                        <ul class='nav-sub'>
                            <li><a href='<?php echo base_url();?>index.php?page=account_dokter'>My Account</a></li>
                            <li><a href='<?php echo base_url();?>index.php?page=logout'>Logout</a></li>
                        </ul>
                      </li> <?php
            }else if ($_SESSION['nama'] && $_SESSION['role']==1) { ?>

                <li class='list' id='login'><a href='#'>Haloo ... <?=$_SESSION['nama']?></a>
                        <ul class='nav-sub'>
                            <li><a href='<?php echo base_url();?>index.php?page=account_admin'>My Account</a></li>
                            <li><a href='<?php echo base_url();?>index.php?page=logout'>Logout</a></li>
                        </ul>
                      </li>
                <?php
            }else{ ?>
                <li id='login'><a href='<?php echo base_url();?>index.php?page=login'>Login</a></li>
                <?php             
            }
            ?>

        </ul>

    

    <div class="main">
    <?php 

    $page=(isset($_GET['page']))? $_GET['page'] : "main";
    switch ($page) {
        case 'home': include "php/home.php"; break;
        case 'database': include "php/tampil.php"; break;
        case 'contact': include "php/contact.php"; break;
        case 'gallery': include "php/gallery.php"; break;
        case 'profil': include "php/profil.php"; break;
        case 'about': include "php/aboutme.php"; break;
        case 'sk': include "php/sk.php"; break;
        case 'artikel': include "php/artikel.php"; break;
        case 'logout': include "php/logout.php"; break;
        case 'login': include "php/login.php"; break;
        case 'forgot': include "php/forgot.php"; break;
        case 'register': include "php/register.php"; break;
        case 'printdok': include "php/dokter/cetak_dokter.php"; break;
        case 'printall_dokter': include "php/dokter/cetak.php"; break;
        case 'printallpdf_dokter': include "php/dokter/printpdf_dokter.php"; break;
        case 'petunjuk': include "php/petunjuk.php"; break;
        case 'tampil_dokter': include "php/dokter/tampil_dokter.php"; break;
        case 'tambah_dokter': include "php/dokter/tambah_dokter.php"; break;
        case 'edit_dokter': include "php/dokter/edit_dokter.php"; break;
        case 'foto_dokter': include "php/dokter/foto_dokter.php"; break;
        case 'account_dokter': include "php/dokter/account_dokter.php"; break;

        case 'tampil_pasien': include "php/pasien/tampil_pasien.php"; break;
        case 'edit_pasien': include "php/dokter/edit_pasien.php"; break;
        case 'foto_pasien': include "php/pasien/foto_pasien.php"; break;
        case 'printpas': include "php/pasien/cetak_pasien.php"; break;
        case 'printall_pasien': include "php/pasien/cetak_all.php"; break;
        case 'printallpdf_pasien': include "php/pasien/printpdf_pasien.php"; break;

        case 'tambah_artikel': include "php/tambah_artikel.php"; break;
        case 'detail_artikel': include "php/detail_artikel.php"; break;
        case 'edit_artikel': include "php/edit_artikel.php"; break;

        case 'account_pasien': include "php/pasien/account_pasien.php"; break;
        case 'account_admin': include "php/admin/account_admin.php"; break;
        
        case 'main':     
        default: include 'php/home.php'; break;
    }

    ?>
        
 
 
        <div class="clear"></div>
 
    </div>
 
    <div class="footer">
        <center><p>Copyright &copy; <?php echo date('Y'); ?> Dok_Line All Right Reserved | Created By Oezzi16, Visit on <b><i><a style="text-decoration: none; color: #8ee29f;" target="_blank" href="http://oezzi16.esy.es">Oezzi16.esy.es</a></i></b></p></center>
    </div>
 
</div>

</body>
<script src="ckeditor/ckeditor.js"></script>
<script language="javascript">
CKEDITOR.replace('isiku', {
extraPlugins: 'magicline',
allowedContent: true
});
</script>