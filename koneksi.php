<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jajal";
date_default_timezone_set("Asia/Bangkok");


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST['kode'])){
        $kode = $_POST['kode'];

        if($kode == "register"){

            $username          = $_POST['username'];
            $email          = $_POST['email'];
            $password       = $_POST['password'];
            $no_telp = $_POST['no_telp'];
            $no_wa = $_POST['no_wa'];
            $alamat = $_POST['alamat'];
            $create_at   = date("Y-m-d h:i:sa");

            $query = "SELECT id_pelanggan FROM pelanggan WHERE email= '$email'";
            $stmt = $conn->prepare($query); 
            $stmt->execute();
            // set the resulting array to associative
            $stmt->setFetchMode(PDO::FETCH_ASSOC); 
            $result = $stmt->fetchAll();

            if(count($result)==0){
                $query1 = "INSERT INTO pelanggan (username,email,password,no_telp,no_wa,alamat,create_at) VALUES ('$username','$email','$password','$no_telp','$no_wa','$alamat','$create_at')";
                $conn->exec($query1);
                $respon['status'] = 1;
                echo json_encode($respon);
            }else{
                $respon['status'] = 0;
                echo json_encode($respon);

            }            
        }else if($kode == "login"){
            $email  = $_POST['email'];
            $password = $_POST['password'];
            $query = "SELECT id_pelanggan,username,no_telp,no_wa,alamat FROM pelanggan WHERE password = '$password' AND email= '$email'";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            
            echo json_encode(array('respon'=>$result));
        }else if($kode== "beli_barang"){
            $id_pelanggan          = $_POST['id_pelanggan'];
            $toko          = $_POST['toko'];
            $barang       = $_POST['barang'];
            $tanggal_antar = $_POST['tanggal_antar'];
            $jam_antar = $_POST['jam_antar'];
            $lokasi_antar = $_POST['lokasi_antar'];
            $nama_penerima = $_POST['nama_penerima'];
            $create_at   = date("Y-m-d h:i:sa");
            $query1 = "INSERT INTO beli_makanan_barang (id_pelanggan,toko,barang,tanggal_antar,jam_antar,lokasi_antar,nama_penerima,create_at) VALUES ('$id_pelanggan','$toko','$barang','$tanggal_antar','$jam_antar','$lokasi_antar','$nama_penerima','$create_at')";
                $conn->exec($query1);
                $respon['status'] = 1;
                echo json_encode($respon);
        }else if($kode == "film"){
            $id_bioskop = $_POST['id_bioskop'];

            $query = "SELECT id_film,judul_film FROM film WHERE id_bioskop = '$id_bioskop' AND aktif= 'aktif'";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
        }else if($kode == "jam_tayang"){
             $id_film = $_POST['id_film'];

            $query = "SELECT jam_tayang FROM jam_tayang WHERE id_film = '$id_film'";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
        }else if($kode == "pesan_tiket"){
            $id_pelanggan  = $_POST['id_pelanggan'];
            $bioskop         = $_POST['bioskop'];
            $film       = $_POST['film'];
            $jam_tayang = $_POST['jam_tayang'];
            $jumlah = $_POST['jumlah'];
            $create_at   = date("Y-m-d h:i:sa");
            $query1 = "INSERT INTO beli_tiket (id_pelanggan,bioskop,film,jam_tayang,jumlah,create_at) VALUES ('$id_pelanggan','$bioskop','$film','$jam_tayang','$jumlah','$create_at')";
            $conn->exec($query1);
            $respon['status'] = 1;
            echo json_encode($respon);
        }
    }
}
    
catch(PDOException $e)
    {
    echo $query . "<br>" . $e->getMessage();
    }

$conn = null;
?> 



