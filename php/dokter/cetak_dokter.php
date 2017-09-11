<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../koneksi.php'); 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query="SELECT * FROM dokter WHERE id='$id'";
    $result = mysql_query($query);
    $num=mysql_num_rows($result);
    $data1=mysql_result($result, $i,"id");
    $data2=mysql_result($result, $i,"nama");
    $data3=mysql_result($result, $i,"alamat");
    $data4=mysql_result($result, $i,"foto");
}else{
    die("pilih id terlebih dahulu..");
}
?>
<div class="content">
<center>
    <table border="2" cellspacing="2" align="center" bordercolordark="#FFFF00">
        <h2 align="center">DOK_LINE</h2>
        <h2 align="center">Jl bekasi raya</h2>
        <h2 align="center">Bekasi</h2>
        <p align="center">****************************************************</p>
        <tr>
             <td><img src='<?php echo base_url(); ?><?=$data4; ?>' width='80' height='50'></td>
              
        </tr>
        <tr bgcolor="#99a">
            <td align="center">ID DOKTER</td>
            <td align="left"><?=$data1; ?></td>
        </tr>
        <tr bgcolor="#99a">
            <td align="center">NAMA</td>
            <td align="left"><?=$data2; ?></td>
        </tr>
        <tr bgcolor="#99a">
            <td align="center">ALAMAT</td>
            <td align="left"><?=$data3; ?></td>
        </tr>

    </table>
</center>
</div>