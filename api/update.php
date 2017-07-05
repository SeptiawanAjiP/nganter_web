<?php
require 'db_config.php';


  $id  = $_POST["id"];
  $post = $_POST;

  $sql = "UPDATE items SET title = '".$post['title']."'

    ,description = '".$post['description']."' 

    WHERE id = '".$id."'";

  $result = $mysqli->query($sql);


  $sql = "SELECT b.id_order,p.username,b.create_at,b.toko,b.barang,b.lokasi_antar,b.nama_penerima FROM pelanggan p INNER JOIN beli_makanan_barang b WHERE b.id_pelanggan ='$id'"; 

  $result = $mysqli->query($sql);

  $data = $result->fetch_assoc();


echo json_encode($data);
?>