<?php
require_once("koneksi.php");
$perPage = 10;
$nowPage = $_GET["halaman"];
$page = isset($nowPage) ? (int)$nowPage : 1;
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

$data = $db->prepare("SELECT * FROM city LIMIT $start, $perPage");
$data->execute();
$result = $data->fetchAll();

$totalData = $db->prepare("SELECT * FROM city");
$totalData->execute();
$total = $totalData->rowCount();
$pages = ceil($total/$perPage);
if(isset($_REQUEST['delete_id']))
{
  $deleteID = $_GET["delete_id"];
  $select= $db->prepare("SELECT * FROM city WHERE id =$deleteID");
  $select->execute();
  $selects=$select->fetch(PDO::FETCH_ASSOC);

  $delete= $db->prepare("DELETE FROM city WHERE id =$deleteID");
  $delete->execute();
  $deletes=$delete->fetch(PDO::FETCH_ASSOC);
  header("Location:index.php");}
?>
<!DOCTYPE html>
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Data Kota</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div style="color:#f8f9fa;">
      <div class="flex between" style="margin-top:20px; margin-left:20px; margin-right:20px;">
        <p>Nama : Yoga Firdaus Pratikha<br>NIM :  192410102084</p>
        <p>Kelas : PWEB E<br>Prodi : Teknologi Informasi</p>
      </div>
      <div style="text-align: center;">
        <h1>Data Kota</h1>
      </div>
      <div class="flex" style="margin-top:20px">
        <a href='add.php' class="button green center">Tambah Data</a>
      </div>
      </form>
      <div class="container">
        <table class="center">
          <thead>
            <tr>
              <th style="width:55px">ID</th>
              <th style="width:320px">Nama</th>
              <th style="width:75px">Negara</th>
              <th style="width:230px">Kawasan</th>
              <th style="width:120px">Populasi</th>
              <th style="width:140px">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              if(!empty($result)) {
                foreach($result as $row) {
              ?>
                <tr>
                  <td><?php echo $row["ID"]; ?></td>
                  <td><?php echo $row["Name"]; ?></td>
                  <td><?php echo $row["CountryCode"]; ?></td>
                  <td><?php echo $row["District"]; ?></td>
                  <td><?php echo $row["Population"]; ?></td>
                  <td>
                    <a href='edit.php?id=<?php echo $row['ID']; ?>' class="button yellow">Edit</a>
                    <a onclick="return confirm('Hapus data <?php echo $row['Name'];?> dengan ID <?php echo $row['ID']; ?>?')" href='?delete_id=<?php echo $row['ID']; ?>' class="button red">Delete</a>
                  </td>
                </tr>
              <?php
                }
              }
            ?>
          </tbody>
        </table><div style="margin-top:20px">
          <a href="?halaman=1" class="button green nomor"><<</a>
        <?php
        $x = 0;
        $y = 0;
        if($page<=5){
          $x = 1;
          $y = $x+10;
        }
        else {
          $x = $page-4;
          $y = $x+10;
          if($x>=$pages-10){
            $x = $pages-10;
            $y = $pages;
          }
        }
        for($x; $x<=$y; $x++){
          ?>
          <a href="?halaman=<?php echo $x; ?>" class="button red nomor"><?php echo $x;?></a>
        <?php
        }
      ?><a href="?halaman=<?php echo $pages; ?>" class="button green nomor">>></a></div>
      </div>
    </div>
  </body>
</html>