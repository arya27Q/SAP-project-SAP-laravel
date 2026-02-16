<?php
$server   = "sqldempo.southeastasia.cloudapp.azure.com,1433";
$username = "Adrob1";
$password = "C0ron@over0727";

try {
    echo "--- SEDANG LOGIN KE MASTER UNTUK MEMBUAT DATABASE BARU ---\n";
    
    // 1. Konek ke 'master' dulu (Database bawaan)
    $conn = new PDO(
        "sqlsrv:server=$server;Database=master;Encrypt=yes;TrustServerCertificate=1", 
        $username, 
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Login ke 'master' berhasil.\n";

    // 2. Perintah Buat Database
    echo "--- MENCOBA MEMBUAT DATABASE 'master_bp' ---\n";
    $sql = "IF NOT EXISTS (SELECT * FROM sys.databases WHERE name = 'master_bp')
            BEGIN
                CREATE DATABASE master_bp;
            END";
            
    $conn->exec($sql);
    echo "✅✅✅ SUKSES! Database 'master_bp' BERHASIL DIBUAT!\n";
    echo "Sekarang coba jalankan 'php artisan migrate' lagi di Laravel.\n";
    
} catch (PDOException $e) {
    echo "❌ GAGAL! Error: " . $e->getMessage() . "\n";
}
?>