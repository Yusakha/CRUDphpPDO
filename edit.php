<?php
	require_once("koneksi.php");
	$country = $db->prepare("SELECT Code FROM country");
	$country->execute();
	$countrys = $country->fetchAll();
	$selectData = [];
	$selectID = $_GET['id'];
	if(isset($_GET['id']))
	{
	  $editID = $_GET["id"];
		$select= $db->prepare("SELECT * FROM city WHERE id =$editID");	//sql select query
	  $select->execute();
	  $selects=$select->fetch(PDO::FETCH_ASSOC);
		$selectData = $selects;
	}

if(isset($_POST['submit']))
{
	$Name = $_POST['Name'];
	$CountryCode = $_POST['CountryCode'];
	$District = $_POST['District'];
	$Population = $_POST['Population'];
	if(empty($Name)){
		echo "<script type='text/javascript'>alert('Nama Kota tidak boleh Kosong!');</script>";
	}
	elseif(empty($CountryCode)){
		echo "<script type='text/javascript'>alert('CountryCode tidak boleh Kosong!');</script>";
	}
	elseif(empty($District)){
		echo "<script type='text/javascript'>alert('District tidak boleh Kosong!');</script>";
	}
	elseif(empty($Population)){
		echo "<script type='text/javascript'>alert('District tidak boleh Kosong!');</script>";
	}
	elseif(!is_numeric($Population)){
		echo "<script type='text/javascript'>alert('Population harus Angka!');</script>";
	}
	else{
		try{
		  $select= $db->prepare("SELECT * FROM city WHERE ID=$selectID");
		  $select->execute();
		  $select->fetch();

			$data = $db->prepare("UPDATE city SET Name=:name, CountryCode=:countryCode, District=:district, Population=:population WHERE ID=:id");
			$data->execute([
				':name' => $Name,
				':countryCode' => $CountryCode,
				':district' => $District,
				':population' => $Population,
				':id' => $selectID
			]);
			echo "<script>
			alert('Data berhasil diubah');
			window.location.href='index.php';
			</script>";
		  }
			catch (\Exception $e) {
			  echo $e->getMessage;
			}
		}
	}
?>
<!DOCTYPE html>
	<head>
	    <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title>Edit Data Kota</title>
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
				<h1>Edit Data Kota</h1>
			</div>
		<div class="container">
			<form method="post">
				<div>
					<label for="Name">Nama Kota:</label>
					<input type="text" id="Name" value="<?php echo $selectData["Name"]; ?>" name="Name">
		      <label for="CountryCode">CountryCode:</label>
					<select type="text" id="CountryCode" name="CountryCode">
						<option disabled selected> CountryCode... </option>
						<?php
						    foreach($countrys as $row) {?>
										<option><?php echo $row["Code"]; ?></option>
								<?php
									}
						?>
					</select>
		      <label for="District">District:</label>
					<input type="text" id="District" value='<?php echo $selectData["District"]; ?>' name="District">
		      <label for="Population">Population:</label>
					<input type="text" id="Population" value="<?php echo $selectData["Population"]; ?>" name="Population">
				</div>
		    <div class="d-flex justify-content-between" style="margin-top:10px">
					<input name="submit" id="submit" type="submit" class="button green" value="Edit">
				</form>
		      <a href="./index.php" class="button red">Kembali</a>
		    </div>
			</div>
		</body>
</html>