<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../koneksi.php');


    $query="SELECT * FROM pasien JOIN login ON pasien.id=login.user WHERE login.status=1 ORDER BY id";
    $result = mysql_query($query);
    $num=mysql_num_rows($result);
    $data1=mysql_result($result, $i,"id");
    $data2=mysql_result($result, $i,"nama");
    $data3=mysql_result($result, $i,"alamat");
    $data4=mysql_result($result, $i,"foto");

?>
<style type="text/css">
td{
    padding:3px;
}
</style>
<div class="content">
<center>
    <table id="tbl" border="2" cellspacing="2" align="center" bordercolordark="#FFFF00" style="border-collapse: collapse; ">
        <h2 align="center">DOK_LINE</h2>
        <h2 align="center">Jl bekasi raya</h2>
        <h2 align="center">Bekasi</h2>
        <p align="center">****************************************************</p>
        <tr bgcolor="#0033FF">
            <td align="right">
                <font face="Arial, Helvetica, sans-serif">No</font>
            </td>
            <td align="center">
                <font face="Arial, Helvetica, sans-serif">ID Pasien</font>
            </td>
            <td align="center">
                <font face="Arial, Helvetica, sans-serif">NAMA</font>
            </td>
            <td align="center">
                <font face="Arial, Helvetica, sans-serif">Alamat</font>
            </td>
        </tr>
        <?php 
        $i=0;
        while ($i<$num) {
            $data1=mysql_result($result, $i,"id");
            $data2=mysql_result($result, $i,"nama");
            $data3=mysql_result($result, $i,"alamat");
        
         ?>
         <tr>
             <td><font><?php echo $i+1; ?></font></td>
             <td><font><?php echo $data1; ?></font></td>
             <td><font><?php echo $data2; ?></font></td>
             <td><font><?php echo $data3; ?></font></td>
         </tr>
         <?php $i++; } ?>
        
    </table>
    </center>



    
</div>