<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['noticia'])) {
    $noticia = $_POST['noticia'];
    $username = $_SESSION['username'];
    $noticiaFile = "usuarios/$username/$noticia";
    
    if (file_exists($noticiaFile)) {
        $likeFile = $noticiaFile . '_likes.txt';
        $likes = file_exists($likeFile) ? (int) file_get_contents($likeFile) : 0;
        $likes++;
        file_put_contents($likeFile, $likes);
    }
    header("Location: muro.php");
}
?>
