<?php
    include "Client.php";
?>

<!DOCTYPE html>
	<html>
	<head>
		<title></title>
	</head>
	<body>

	<?php if ($_COOKIE['jwt']) { ?>
		<a href="?page=home">Home</a> | <a href="?page=tambah">Tambah Data</a> | <a href="?page=daftar-data">Data Server</a>
		| <a href="proses.php?aksi=logout" onclick="return confirm('Apakah Anda ingin Logout?')">Logout</a>
		<br/>
		<?php echo '<strong>'.$_COOKIE['nama'].' ('.$_COOKIE['id_pengguna'].')</strong>'; ?>
	<?php } else {?> <a href="?page=home">Home</a> | <a href="?page=login">Login</a> <?php } ?>
	<br/><br/>

		<fieldset>
		<?php if($_GET['page']=='login' and !isset($_COOKIE['jwt'])) { ?>
			<legend>Login</legend>
				<form name="form" method="POST" action="proses.php">
					<input type="hidden" name="aksi" value="login"/>
					<label>ID Pengguna</label>
					<input type="text" name="id_pengguna"/>
					<br/>
					<label>PIN</label>
					<input type="text" name="pin"/>
					<button type="submit" name="login">Login</button>
				</form>

			<?php } elseif($_GET['page']=='tambah' and isset($_COOKIE['jwt'])) { ?>
			<legend>Tambah Data</legend>
				<form name="form" method="POST" action="proses.php">
					<input type="hidden" name="aksi" value="tambah"/>
					<input type="hidden" name="jwt" value="<?=$_COOKIE['jwt']?>"/>
					<label>ID Barang</label>
					<input type="text" name="id_barang"/>
					<br/>
					<label>Nama Barang</label>
					<input type="text" name="nama_barang"/>
					<label>Stok Barang</label>
					<input type="text" name="stok_barang"/>
					<label>Harga Satuan</label>
					<input type="text" name="harga_satuan"/>
					<br/>
					<button type="submit" name="simpan">Simpan</button>
				</form>
		<?php } elseif ($_GET['page']=='ubah' and isset($_COOKIE['jwt'])) {
			$data = array("jwt"=>$_COOKIE['jwt'],
						"id_barang"=>$_GET['id_barang']);
			$r = $abc->tampil_data($data);
		?>
		<legend>Ubah Data</legend>
			<form name="form" method="post" action="proses.php">
				<input type="hidden" name="aksi" value="ubah"/>
				<input type="hidden" name="id_barang" value="<?=$r->id_barang?>" />
				<input type="hidden" name="jwt" value="<?=$_COOKIE['jwt']?>"/>
				<label>ID Barang</label>
				<input type="text" name="id_barang" value="<?=$r->id_barang?>" disabled>
				<br/>
				<label>Nama Barang</label>
				<input type="text" name="nama_barang" value="<?=$r->nama_barang?>">
				<br/>
				<label>Stok Barang</label>
				<input type="text" name="stok_barang" value="<?=$r->stok_barang?>">
				<br/>
				<label>Harga Satuan</label>
				<input type="text" name="harga_satuan" value="<?=$r->harga_satuan?>">
				<br/>
				<button type="submit" name="ubah">Ubah</button>
			</form>
		<?php unset($data,$r,$abc);
		}
		
		else if ($_GET['page']=='daftar-data' and isset($_COOKIE['jwt'])) {
		?>
		<legend>Daftar Data Server</legend>
			<table border="1">
			<tr><th width='5%'>No</th>
					<th width='10%'>ID Barang</th>
					<th width='45%'>Nama</th>
					<th width='15%'>Stok</th>
					<th width='15%'>Harga</th>
					<th width='5%' colspan="2">Aksi</th>
				</tr>
				<?php 	$no = 1;
					$data = $abc->tampil_semua_data($_COOKIE['jwt']);
					foreach ($data as $r) {
				?>	<tr><td><?=$no?></td>
						<td><?=$r->id_barang?></td>
						<td><?=$r->nama_barang?></td>
						<td><?=$r->stok_barang?></td>
						<td><?=$r->harga_satuan?></td>
						<td><a href="?page=ubah&id_barang=<?=$r->id_barang?>&jwt=<?=$_COOKIE['jwt']?>">Ubah</a></td>
						<td><a href="proses.php?aksi=hapus&id_barang=<?=$r->id_barang?>&jwt=<?=$_COOKIE['jwt']?>" onclick="return confirm('Apakah Anda ingin menghapus data ini?')">Hapus</a></td>
					</tr>
				<?php	$no++;
					}
					unset($no,$data,$r,$abc);
				?>
			</table>

		<?php } else { ?>
		<legend>Home</legend>
			Aplikasi sederhana ini menggunakan JWT dan RESTful dengan format data JSON (Javascript Object Notation).
		</fieldset>
		<?php } ?>
	</body>
</html>