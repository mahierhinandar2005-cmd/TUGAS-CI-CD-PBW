<?php
session_start();

// LOGIN DUMMY
if (isset($_POST['login'])) {
    if ($_POST['user'] == 'admin' && $_POST['pass'] == '123') {
        $_SESSION['login'] = true;
        $_SESSION['user'] = 'admin';
    }
}

// LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// CEK LOGIN
if (!isset($_SESSION['login'])) {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Login - Gadget Kecee</title>
        <style>
            *{margin:0;padding:0;box-sizing:border-box;}
            body{font-family:"Inter","Segoe UI",Arial,sans-serif;background:#0f172a;min-height:100vh;display:flex;justify-content:center;align-items:center;}
            .login-box{background:white;border-radius:24px;display:flex;max-width:1000px;width:100%;overflow:hidden;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);}
            .login-left{background:linear-gradient(135deg,#1e3c72,#2a5298);padding:60px;text-align:center;color:white;width:50%;}
            .login-left .phone-icon{font-size:80px;margin-bottom:20px;}
            .login-left h1{font-size:32px;margin-bottom:10px;}
            .login-right{padding:60px;width:50%;}
            .login-right h2{font-size:28px;color:#0f172a;margin-bottom:10px;}
            .login-right p{color:#64748b;margin-bottom:30px;}
            .form-group{margin-bottom:20px;}
            .form-group label{display:block;margin-bottom:8px;font-weight:600;color:#334155;}
            .form-group input{width:100%;padding:14px;border:1px solid #e2e8f0;border-radius:12px;font-size:14px;}
            .form-group input:focus{outline:none;border-color:#1e3c72;box-shadow:0 0 0 3px rgba(30,60,114,0.1);}
            .btn-login{width:100%;padding:14px;background:#1e3c72;color:white;border:none;border-radius:12px;font-size:16px;font-weight:600;cursor:pointer;}
            .btn-login:hover{background:#2a5298;}
        </style>
    </head>
    <body>
        <div class="login-box">
            <div class="login-left">
                <div class="phone-icon">📱</div>
                <h1>GADGET KECEE</h1>
                <p>Toko Handphone & Gadget</p>
            </div>
            <div class="login-right">
                <h2>Login</h2>
                <p>Masuk ke dashboard administrator</p>
                <form method="POST">
                    <div class="form-group"><label>Username</label><input type="text" name="user" placeholder="admin" required></div>
                    <div class="form-group"><label>Password</label><input type="password" name="pass" placeholder="123" required></div>
                    <button type="submit" name="login" class="btn-login">Login</button>
                </form>
                <div style="margin-top:30px;text-align:center;font-size:12px;color:#94a3b8;">Demo: admin / 123</div>
            </div>
        </div>
    </body>
    </html>
    ';
    exit();
}

$conn = mysqli_connect('localhost', 'root', '', 'gadgetkecee');
if (!$conn) die("Koneksi database gagal");

// PROSES CRUD
if(isset($_POST['tambah_petugas'])){
    mysqli_query($conn,"INSERT INTO petugas (nama_petugas, hp_petugas, alamat_petugas) VALUES ('".$_POST['nama_petugas']."','".$_POST['hp_petugas']."','".$_POST['alamat_petugas']."')");
    header("Location: ?page=petugas"); exit();
}
if(isset($_POST['edit_petugas'])){
    mysqli_query($conn,"UPDATE petugas SET nama_petugas='".$_POST['nama_petugas']."', hp_petugas='".$_POST['hp_petugas']."', alamat_petugas='".$_POST['alamat_petugas']."' WHERE id_petugas=".(int)$_POST['id_petugas']);
    header("Location: ?page=petugas"); exit();
}
if(isset($_GET['hapus_petugas'])){
    mysqli_query($conn,"DELETE FROM petugas WHERE id_petugas=".(int)$_GET['hapus_petugas']);
    header("Location: ?page=petugas"); exit();
}
if(isset($_POST['tambah_barang'])){
    mysqli_query($conn,"INSERT INTO barang (nama_barang, imei, harga) VALUES ('".$_POST['nama_barang']."','".$_POST['imei']."',".(float)$_POST['harga'].")");
    header("Location: ?page=barang"); exit();
}
if(isset($_POST['edit_barang'])){
    mysqli_query($conn,"UPDATE barang SET nama_barang='".$_POST['nama_barang']."', imei='".$_POST['imei']."', harga=".(float)$_POST['harga']." WHERE id_barang=".(int)$_POST['id_barang']);
    header("Location: ?page=barang"); exit();
}
if(isset($_GET['hapus_barang'])){
    mysqli_query($conn,"DELETE FROM barang WHERE id_barang=".(int)$_GET['hapus_barang']);
    header("Location: ?page=barang"); exit();
}
if(isset($_POST['tambah_pelanggan'])){
    mysqli_query($conn,"INSERT INTO pelanggan (nama_pelanggan, no_telepon, alamat) VALUES ('".$_POST['nama_pelanggan']."','".$_POST['no_telepon']."','".$_POST['alamat']."')");
    header("Location: ?page=pelanggan"); exit();
}
if(isset($_POST['edit_pelanggan'])){
    mysqli_query($conn,"UPDATE pelanggan SET nama_pelanggan='".$_POST['nama_pelanggan']."', no_telepon='".$_POST['no_telepon']."', alamat='".$_POST['alamat']."' WHERE id_pelanggan=".(int)$_POST['id_pelanggan']);
    header("Location: ?page=pelanggan"); exit();
}
if(isset($_GET['hapus_pelanggan'])){
    mysqli_query($conn,"DELETE FROM pelanggan WHERE id_pelanggan=".(int)$_GET['hapus_pelanggan']);
    header("Location: ?page=pelanggan"); exit();
}
if(isset($_POST['simpan_pelanggan'])){
    $_SESSION['selected_pelanggan']=(int)$_POST['simpan_pelanggan'];
    header("Location: ?page=tambah_transaksi"); exit();
}
if(isset($_POST['simpan_petugas'])){
    $_SESSION['selected_petugas']=(int)$_POST['simpan_petugas'];
    header("Location: ?page=tambah_transaksi"); exit();
}
if(isset($_POST['add_to_cart_ajax'])){
    $item=['id_barang'=>(int)$_POST['id_barang'],'nama_barang'=>$_POST['nama_barang'],'imei'=>$_POST['imei'],'harga'=>(float)$_POST['harga'],'jumlah'=>(int)$_POST['jumlah']];
    if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];
    $f=false; foreach($_SESSION['cart'] as $k=>$v) if($v['id_barang']==$item['id_barang']){$_SESSION['cart'][$k]['jumlah']+=$item['jumlah'];$f=true;break;}
    if(!$f) $_SESSION['cart'][]=$item;
    header("Location: ?page=tambah_transaksi"); exit();
}
if(isset($_GET['remove_from_cart'])){
    unset($_SESSION['cart'][(int)$_GET['remove_from_cart']]);
    $_SESSION['cart']=array_values($_SESSION['cart']);
    header("Location: ?page=tambah_transaksi"); exit();
}
if(isset($_POST['proses_transaksi'])){
    $no_nota=(int)$_POST['no_nota']; $tanggal=$_POST['tanggal']; $id_pelanggan=(int)$_POST['id_pelanggan']; $id_petugas=(int)$_POST['id_petugas']; $total=0;
    foreach($_SESSION['cart'] as $item) $total+=$item['harga']*$item['jumlah'];
    mysqli_query($conn,"INSERT INTO nota (no_nota, tanggal, total, id_petugas, id_pelanggan) VALUES ($no_nota, '$tanggal', $total, $id_petugas, $id_pelanggan)");
    foreach($_SESSION['cart'] as $item) mysqli_query($conn,"INSERT INTO detail_nota (no_nota, id_barang, harga, jumlah, subtotal) VALUES ($no_nota, ".$item['id_barang'].", ".$item['harga'].", ".$item['jumlah'].", ".($item['harga']*$item['jumlah']).")");
    unset($_SESSION['cart'],$_SESSION['selected_pelanggan'],$_SESSION['selected_petugas']);
    header("Location: ?page=cetak_nota&id=$no_nota"); exit();
}
if(isset($_POST['update_transaksi_multi'])){
    $no_nota=(int)$_POST['no_nota']; $tanggal=$_POST['tanggal']; $id_pelanggan=(int)$_POST['id_pelanggan']; $id_petugas=(int)$_POST['id_petugas']; $cart_data=json_decode($_POST['cart_data'],true);
    $total=0; foreach($cart_data as $item) $total+=$item['harga']*$item['jumlah'];
    mysqli_query($conn,"UPDATE nota SET tanggal='$tanggal', id_pelanggan=$id_pelanggan, id_petugas=$id_petugas, total=$total WHERE no_nota=$no_nota");
    mysqli_query($conn,"DELETE FROM detail_nota WHERE no_nota=$no_nota");
    foreach($cart_data as $item) mysqli_query($conn,"INSERT INTO detail_nota (no_nota, id_barang, harga, jumlah, subtotal) VALUES ($no_nota, ".$item['id_barang'].", ".$item['harga'].", ".$item['jumlah'].", ".($item['harga']*$item['jumlah']).")");
    header("Location: ?page=detail_transaksi&id=$no_nota"); exit();
}
if(isset($_GET['hapus_transaksi'])){
    $id=(int)$_GET['hapus_transaksi'];
    mysqli_query($conn,"DELETE FROM detail_nota WHERE no_nota=$id");
    mysqli_query($conn,"DELETE FROM nota WHERE no_nota=$id");
    header("Location: ?page=transaksi"); exit();
}

$total_barang = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM barang"))['total'];
$total_pelanggan = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM pelanggan"))['total'];
$total_petugas = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM petugas"))['total'];
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM nota"))['total'];
$total_pemasukan = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(total) as total FROM nota"))['total'] ?? 0;
$saldo_akhir = $total_pemasukan;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gadget Kecee - Sistem Penjualan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f8fafc; }
        
        .app { max-width: 1440px; margin: 0 auto; background: #f8fafc; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { position: fixed; left: 0; top: 0; width: 260px; height: 100vh; background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); color: white; z-index: 1000; }
        .sidebar-header { padding: 28px 24px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header h1 { font-size: 22px; font-weight: 700; }
        .sidebar-header p { font-size: 12px; opacity: 0.6; margin-top: 4px; }
        .sidebar-nav { padding: 24px 16px; }
        .sidebar-nav a { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #cbd5e1; text-decoration: none; border-radius: 12px; margin-bottom: 4px; transition: all 0.2s; font-size: 14px; font-weight: 500; }
        .sidebar-nav a:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-nav a.active { background: #2a5298; color: white; }
        .sidebar-nav .logout { margin-top: 40px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; color: #f87171; }
        .sidebar-nav .logout:hover { background: rgba(248,113,113,0.1); color: #f87171; }
        
        /* Main Content */
        .main { margin-left: 260px; padding: 32px 40px; }
        
        /* Header */
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .page-header h2 { font-size: 28px; font-weight: 700; color: #0f172a; }
        .user-badge { display: flex; align-items: center; gap: 12px; background: white; padding: 8px 20px; border-radius: 40px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .user-badge span { color: #334155; font-weight: 500; }
        
        /* Stat Cards */
        .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 32px; }
        .stat-card { background: white; border-radius: 20px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; transition: all 0.2s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .stat-card .icon { font-size: 32px; margin-bottom: 12px; }
        .stat-card .label { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 8px; }
        .stat-card .value { font-size: 32px; font-weight: 700; color: #0f172a; }
        
        /* Cashflow Cards */
        .cashflow-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px; }
        .cash-card { background: linear-gradient(135deg, #1e3c72, #2a5298); border-radius: 20px; padding: 28px; color: white; }
        .cash-card .label { font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; margin-bottom: 12px; }
        .cash-card .value { font-size: 36px; font-weight: 700; }
        .cash-card.income { background: linear-gradient(135deg, #059669, #10b981); }
        .cash-card.balance { background: linear-gradient(135deg, #7c3aed, #8b5cf6); }
        
        /* Welcome Card */
        .welcome-card { background: linear-gradient(135deg, #1e3c72, #2a5298); border-radius: 24px; padding: 48px; color: white; text-align: center; margin-bottom: 32px; }
        .welcome-card .icon { font-size: 64px; margin-bottom: 16px; }
        .welcome-card h2 { font-size: 28px; margin-bottom: 12px; }
        .welcome-card p { opacity: 0.9; }
        
        /* Tables */
        .data-table { width: 100%; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border-collapse: collapse; }
        .data-table th { padding: 16px; text-align: left; background: #f8fafc; font-weight: 600; color: #475569; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; }
        .data-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; color: #334155; font-size: 14px; }
        .data-table tr:hover { background: #f8fafc; }
        
        /* Buttons */
        .btn { display: inline-block; padding: 8px 16px; border-radius: 10px; text-decoration: none; font-size: 13px; font-weight: 500; margin: 2px; cursor: pointer; border: none; transition: all 0.2s; }
        .btn-primary { background: #1e3c72; color: white; }
        .btn-primary:hover { background: #2a5298; }
        .btn-success { background: #10b981; color: white; }
        .btn-success:hover { background: #059669; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-warning { background: #f59e0b; color: white; }
        .btn-warning:hover { background: #d97706; }
        .btn-info { background: #06b6d4; color: white; }
        .btn-info:hover { background: #0891b2; }
        .btn-outline { background: white; border: 1px solid #e2e8f0; color: #475569; }
        .btn-outline:hover { background: #f1f5f9; }
        
        .action-buttons { margin-bottom: 24px; display: flex; gap: 12px; flex-wrap: wrap; }
        
        /* Forms */
        .form-card { background: white; border-radius: 20px; padding: 32px; max-width: 600px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #334155; font-size: 14px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; transition: all 0.2s; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #1e3c72; box-shadow: 0 0 0 3px rgba(30,60,114,0.1); }
        
        /* Cart */
        .cart-table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        .cart-table th, .cart-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .cart-table th { background: #f8fafc; font-weight: 600; color: #475569; }
        .total-display { text-align: right; font-size: 18px; font-weight: 700; margin-top: 16px; padding-top: 16px; border-top: 2px solid #e2e8f0; color: #0f172a; }
        
        /* Filter */
        .filter-bar { background: white; padding: 20px; border-radius: 16px; margin-bottom: 24px; display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap; border: 1px solid #e2e8f0; }
        .filter-group { display: flex; flex-direction: column; gap: 6px; }
        .filter-group label { font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; }
        .filter-group input, .filter-group select { padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 14px; }
        
        /* Nota */
        .nota-wrapper { background: #e2e8f0; padding: 24px; display: flex; justify-content: center; border-radius: 16px; }
        .nota { max-width: 360px; background: white; padding: 20px; border-radius: 8px; font-family: 'Courier New', monospace; font-size: 11px; border: 1px solid #cbd5e1; }
        .nota-header { text-align: center; border-bottom: 2px dashed #000; padding-bottom: 10px; margin-bottom: 10px; }
        .nota-header h2 { font-size: 14px; margin: 0; }
        .nota-header p { font-size: 9px; margin: 2px 0; }
        .nota-info { border-bottom: 1px dashed #000; padding-bottom: 10px; margin-bottom: 10px; }
        .nota-info table { width: 100%; }
        .nota-info td { padding: 2px; font-size: 10px; }
        .nota-items { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .nota-items th, .nota-items td { border: 1px solid #000; padding: 5px; font-size: 9px; }
        .nota-total { text-align: right; font-weight: bold; margin-top: 10px; padding-top: 8px; border-top: 1px dashed #000; }
        .nota-footer { margin-top: 15px; border-top: 1px dashed #000; padding-top: 10px; font-size: 8px; }
        .ttd { display: flex; justify-content: space-between; margin-top: 20px; }
        
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main { margin-left: 0; padding: 20px; }
            .stats-row, .cashflow-row { grid-template-columns: 1fr; }
        }
        
        @media print { body * { visibility: hidden; } .nota, .nota * { visibility: visible; } .nota { position: absolute; top: 0; left: 0; width: 100%; margin: 0; } .action-buttons, .sidebar, .main > *:not(.nota-wrapper) { display: none; } }
    </style>
</head>
<body>
<div class="app">
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h1>📱 Gadget</h1>
            <h1 style="margin-top: -4px;">Kecee</h1>
            <p>Handphone Store</p>
        </div>
        <div class="sidebar-nav">
            <a href="?page=home" class="<?= ($_GET['page'] ?? 'home') == 'home' ? 'active' : '' ?>">🏠 Beranda</a>
            <a href="?page=dashboard" class="<?= ($_GET['page'] ?? '') == 'dashboard' ? 'active' : '' ?>">📊 Dashboard</a>
            <a href="?page=cashflow" class="<?= ($_GET['page'] ?? '') == 'cashflow' ? 'active' : '' ?>">💰 Cashflow</a>
            <a href="?page=barang" class="<?= ($_GET['page'] ?? '') == 'barang' ? 'active' : '' ?>">📱 Data Barang</a>
            <a href="?page=pelanggan" class="<?= ($_GET['page'] ?? '') == 'pelanggan' ? 'active' : '' ?>">👥 Data Pelanggan</a>
            <a href="?page=petugas" class="<?= ($_GET['page'] ?? '') == 'petugas' ? 'active' : '' ?>">👨‍💼 Data Petugas</a>
            <a href="?page=transaksi" class="<?= ($_GET['page'] ?? '') == 'transaksi' ? 'active' : '' ?>">🧾 Data Transaksi</a>
            <a href="?logout=1" class="logout">🚪 Logout</a>
        </div>
    </div>
    
    <!-- MAIN CONTENT -->
    <div class="main">
        <div class="page-header">
            <h2>
                <?php 
                    $page_title = $_GET['page'] ?? 'home';
                    echo match($page_title) {
                        'home' => 'Beranda',
                        'dashboard' => 'Dashboard',
                        'cashflow' => 'Cashflow',
                        'barang' => 'Manajemen Barang',
                        'pelanggan' => 'Manajemen Pelanggan',
                        'petugas' => 'Manajemen Petugas',
                        'transaksi' => 'Manajemen Transaksi',
                        'tambah_transaksi' => 'Tambah Transaksi',
                        default => 'Dashboard'
                    };
                ?>
            </h2>
            <div class="user-badge">
                <span>👋 <?= isset($_SESSION['user']) ? $_SESSION['user'] : 'Admin' ?></span>
            </div>
        </div>
        
        <?php
        $page = $_GET['page'] ?? 'home';
        
        // HOME
        if ($page == 'home') {
            echo '
            <div class="welcome-card">
                <div class="icon">📱</div>
                <h2>Selamat Datang di GADGET KECEE</h2>
                <p>Sistem Penjualan Handphone &amp; Gadget Terpercaya</p>
                <p style="margin-top:16px; font-size:14px;">Jl. Raya Kodau Gg. H. Porod RT.005/RW.003<br>Jatimekar Jatiasih Bekasi</p>
                <p style="margin-top:8px;">📞 Call / Wa : 0896 5900 9400</p>
                <div style="margin-top:24px;">
                    <a href="?page=tambah_transaksi" class="btn btn-success" style="padding:12px 28px;">➕ Mulai Transaksi Baru</a>
                </div>
            </div>
            <div class="stats-row">
                <div class="stat-card"><div class="icon">📱</div><div class="label">Total Barang</div><div class="value">'.$total_barang.'</div></div>
                <div class="stat-card"><div class="icon">👥</div><div class="label">Total Pelanggan</div><div class="value">'.$total_pelanggan.'</div></div>
                <div class="stat-card"><div class="icon">👨‍💼</div><div class="label">Total Petugas</div><div class="value">'.$total_petugas.'</div></div>
                <div class="stat-card"><div class="icon">🧾</div><div class="label">Total Transaksi</div><div class="value">'.$total_transaksi.'</div></div>
            </div>';
            
            $recent = mysqli_query($conn, "SELECT n.*, p.nama_pelanggan FROM nota n JOIN pelanggan p ON n.id_pelanggan = p.id_pelanggan ORDER BY n.no_nota DESC LIMIT 5");
            echo '<h3 style="margin-bottom:16px; font-size:18px; color:#0f172a;">Transaksi Terbaru</h3>
            <table class="data-table">
                <thead><tr><th>No Nota</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th><th>Aksi</th></tr></thead>
                <tbody>';
            while($r=mysqli_fetch_assoc($recent)) echo '<tr>
                    <td>'.$r['no_nota'].'</a></td>
                    <td>'.date('d-m-Y',strtotime($r['tanggal'])).'</a></td>
                    <td>'.htmlspecialchars($r['nama_pelanggan']).'</a></td>
                    <td>Rp '.number_format($r['total'],0,',','.').'</a></td>
                    <td><a href="?page=detail_transaksi&id='.$r['no_nota'].'" class="btn btn-info">Detail</a> <a href="?page=cetak_nota&id='.$r['no_nota'].'" class="btn btn-primary">Cetak</a></a></td>
                </tr>';
            echo '</tbody></table>';
        }
        
        // DASHBOARD
        elseif ($page == 'dashboard') {
            echo '
            <div class="stats-row">
                <div class="stat-card"><div class="icon">📱</div><div class="label">Total Barang</div><div class="value">'.$total_barang.'</div></div>
                <div class="stat-card"><div class="icon">👥</div><div class="label">Total Pelanggan</div><div class="value">'.$total_pelanggan.'</div></div>
                <div class="stat-card"><div class="icon">👨‍💼</div><div class="label">Total Petugas</div><div class="value">'.$total_petugas.'</div></div>
                <div class="stat-card"><div class="icon">🧾</div><div class="label">Total Transaksi</div><div class="value">'.$total_transaksi.'</div></div>
            </div>
            <div class="cashflow-row">
                <div class="cash-card"><div class="label">Total Pemasukan</div><div class="value">Rp '.number_format($total_pemasukan,0,',','.').'</div></div>
                <div class="cash-card income"><div class="label">Omzet Bulan Ini</div><div class="value">Rp '.number_format($total_pemasukan,0,',','.').'</div></div>
                <div class="cash-card balance"><div class="label">Saldo Akhir</div><div class="value">Rp '.number_format($saldo_akhir,0,',','.').'</div></div>
            </div>';
            
            $recent = mysqli_query($conn, "SELECT n.*, p.nama_pelanggan FROM nota n JOIN pelanggan p ON n.id_pelanggan = p.id_pelanggan ORDER BY n.no_nota DESC LIMIT 10");
            echo '<h3 style="margin-bottom:16px;">Transaksi Terbaru</h3>
            <table class="data-table">
                <thead><tr><th>No Nota</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th><th>Aksi</th></tr></thead>
                <tbody>';
            while($r=mysqli_fetch_assoc($recent)) echo '<tr>
                    <td>'.$r['no_nota'].'</a></td>
                    <td>'.date('d-m-Y',strtotime($r['tanggal'])).'</a></td>
                    <td>'.htmlspecialchars($r['nama_pelanggan']).'</a></td>
                    <td>Rp '.number_format($r['total'],0,',','.').'</a></td>
                    <td><a href="?page=detail_transaksi&id='.$r['no_nota'].'" class="btn btn-info">Detail</a> <a href="?page=cetak_nota&id='.$r['no_nota'].'" class="btn btn-primary">Cetak</a></a></td>
                </tr>';
            echo '</tbody></table>';
        }
        
        // CASHFLOW
        elseif ($page == 'cashflow') {
            $bulan = $_GET['bulan'] ?? date('Y-m');
            $tahun = explode('-', $bulan)[0];
            $bulan_angka = explode('-', $bulan)[1];
            $nama_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            $transaksi_bulan = mysqli_query($conn, "SELECT n.*, p.nama_pelanggan, pg.nama_petugas FROM nota n JOIN pelanggan p ON n.id_pelanggan = p.id_pelanggan JOIN petugas pg ON n.id_petugas = pg.id_petugas WHERE YEAR(n.tanggal)=$tahun AND MONTH(n.tanggal)=$bulan_angka ORDER BY n.tanggal DESC");
            $total_bulan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM nota WHERE YEAR(tanggal)=$tahun AND MONTH(tanggal)=$bulan_angka"))['total'] ?? 0;
            
            echo '
            <div class="cashflow-row">
                <div class="cash-card"><div class="label">Pemasukan ' . $nama_bulan[(int)$bulan_angka] . ' ' . $tahun . '</div><div class="value">Rp '.number_format($total_bulan,0,',','.').'</div></div>
                <div class="cash-card income"><div class="label">Pengeluaran</div><div class="value">Rp 0</div></div>
                <div class="cash-card balance"><div class="label">Saldo</div><div class="value">Rp '.number_format($total_bulan,0,',','.').'</div></div>
            </div>
            <div class="filter-bar">
                <div class="filter-group"><label>Filter Bulan</label><input type="month" id="filter_bulan" value="'.$bulan.'" onchange="window.location.href=\'?page=cashflow&bulan=\'+this.value"></div>
            </div>
            <table class="data-table">
                <thead><tr><th>Tanggal</th><th>No Nota</th><th>Pelanggan</th><th>Petugas</th><th>Total</th><th>Aksi</th></tr></thead>
                <tbody>';
            if(mysqli_num_rows($transaksi_bulan) > 0) {
                while($r=mysqli_fetch_assoc($transaksi_bulan)) echo '<tr>
                        <td>'.date('d-m-Y',strtotime($r['tanggal'])).'</a></td>
                        <td>'.$r['no_nota'].'</a></td>
                        <td>'.htmlspecialchars($r['nama_pelanggan']).'</a></td>
                        <td>'.htmlspecialchars($r['nama_petugas']).'</a></td>
                        <td>Rp '.number_format($r['total'],0,',','.').'</a></td>
                        <td><a href="?page=detail_transaksi&id='.$r['no_nota'].'" class="btn btn-info">Detail</a> <a href="?page=cetak_nota&id='.$r['no_nota'].'" class="btn btn-primary">Cetak</a></a></td>
                    </tr>';
            } else {
                echo '<tr><td colspan="6" style="text-align:center;">Tidak ada transaksi pada bulan ini</a></td></tr>';
            }
            echo '</tbody></table>';
        }
        
        // BARANG
        elseif ($page == 'barang') {
            if(isset($_GET['edit'])){
                $d=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM barang WHERE id_barang=".(int)$_GET['edit']));
                echo '
                <div class="form-card">
                    <form method="POST">
                        <input type="hidden" name="id_barang" value="'.$d['id_barang'].'">
                        <div class="form-group"><label>Nama Barang</label><input type="text" name="nama_barang" value="'.htmlspecialchars($d['nama_barang']).'" required></div>
                        <div class="form-group"><label>IMEI</label><input type="text" name="imei" value="'.htmlspecialchars($d['imei']).'"></div>
                        <div class="form-group"><label>Harga</label><input type="number" name="harga" value="'.$d['harga'].'" required></div>
                        <button type="submit" name="edit_barang" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="?page=barang" class="btn btn-outline">Batal</a>
                    </form>
                </div>';
            } elseif(isset($_GET['tambah'])){
                echo '
                <div class="form-card">
                    <form method="POST">
                        <div class="form-group"><label>Nama Barang</label><input type="text" name="nama_barang" required></div>
                        <div class="form-group"><label>IMEI</label><input type="text" name="imei"></div>
                        <div class="form-group"><label>Harga</label><input type="number" name="harga" required></div>
                        <button type="submit" name="tambah_barang" class="btn btn-success">Simpan</button>
                        <a href="?page=barang" class="btn btn-outline">Batal</a>
                    </form>
                </div>';
            } else {
                $data = mysqli_query($conn, "SELECT * FROM barang ORDER BY id_barang DESC");
                echo '<div class="action-buttons"><a href="?page=barang&tambah=1" class="btn btn-success">+ Tambah Barang</a></div>
                <table class="data-table">
                    <thead><tr><th>ID</th><th>Nama Barang</th><th>IMEI</th><th>Harga</th><th>Aksi</th></tr></thead>
                    <tbody>';
                while($r=mysqli_fetch_assoc($data)) echo '<tr>
                        <td>'.$r['id_barang'].'</a></td>
                        <td>'.htmlspecialchars($r['nama_barang']).'</a></td>
                        <td>'.($r['imei']?:'-').'</a></td>
                        <td>Rp '.number_format($r['harga'],0,',','.').'</a></td>
                        <td><a href="?page=barang&edit='.$r['id_barang'].'" class="btn btn-warning">Edit</a> <a href="?hapus_barang='.$r['id_barang'].'" class="btn btn-danger" onclick="return confirm(\'Yakin hapus?\')">Hapus</a></a></td>
                    </tr>';
                echo '</tbody><tr>';
            }
        }
        
        // PELANGGAN
        elseif ($page == 'pelanggan') {
            if(isset($_GET['edit'])){
                $d=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM pelanggan WHERE id_pelanggan=".(int)$_GET['edit']));
                echo '
                <div class="form-card">
                    <form method="POST">
                        <input type="hidden" name="id_pelanggan" value="'.$d['id_pelanggan'].'">
                        <div class="form-group"><label>Nama Pelanggan</label><input type="text" name="nama_pelanggan" value="'.htmlspecialchars($d['nama_pelanggan']).'" required></div>
                        <div class="form-group"><label>No Telepon</label><input type="text" name="no_telepon" value="'.htmlspecialchars($d['no_telepon']).'"></div>
                        <div class="form-group"><label>Alamat</label><textarea name="alamat" rows="3">'.htmlspecialchars($d['alamat']).'</textarea></div>
                        <button type="submit" name="edit_pelanggan" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="?page=pelanggan" class="btn btn-outline">Batal</a>
                    </form>
                </div>';
            } elseif(isset($_GET['tambah'])){
                echo '
                <div class="form-card">
                    <form method="POST">
                        <div class="form-group"><label>Nama Pelanggan</label><input type="text" name="nama_pelanggan" required></div>
                        <div class="form-group"><label>No Telepon</label><input type="text" name="no_telepon"></div>
                        <div class="form-group"><label>Alamat</label><textarea name="alamat" rows="3"></textarea></div>
                        <button type="submit" name="tambah_pelanggan" class="btn btn-success">Simpan</button>
                        <a href="?page=pelanggan" class="btn btn-outline">Batal</a>
                    </form>
                </div>';
            } else {
                $data = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
                echo '<div class="action-buttons"><a href="?page=pelanggan&tambah=1" class="btn btn-success">+ Tambah Pelanggan</a></div>
                <table class="data-table">
                    <thead><tr><th>ID</th><th>Nama Pelanggan</th><th>No Telepon</th><th>Alamat</th><th>Aksi</th></tr></thead>
                    <tbody>';
                while($r=mysqli_fetch_assoc($data)) echo '<tr>
                        <td>'.$r['id_pelanggan'].'</a></td>
                        <td>'.htmlspecialchars($r['nama_pelanggan']).'</a></td>
                        <td>'.($r['no_telepon']?:'-').'</a></td>
                        <td>'.($r['alamat']?:'-').'</a></td>
                        <td><a href="?page=pelanggan&edit='.$r['id_pelanggan'].'" class="btn btn-warning">Edit</a> <a href="?hapus_pelanggan='.$r['id_pelanggan'].'" class="btn btn-danger" onclick="return confirm(\'Yakin hapus?\')">Hapus</a></a></td>
                    </tr>';
                echo '</tbody></table>';
            }
        }
        
        // PETUGAS
        elseif ($page == 'petugas') {
            if(isset($_GET['edit'])){
                $d=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM petugas WHERE id_petugas=".(int)$_GET['edit']));
                echo '
                <div class="form-card">
                    <form method="POST">
                        <input type="hidden" name="id_petugas" value="'.$d['id_petugas'].'">
                        <div class="form-group"><label>Nama Petugas</label><input type="text" name="nama_petugas" value="'.htmlspecialchars($d['nama_petugas']).'" required></div>
                        <div class="form-group"><label>No HP</label><input type="text" name="hp_petugas" value="'.htmlspecialchars($d['hp_petugas']).'"></div>
                        <div class="form-group"><label>Alamat</label><textarea name="alamat_petugas" rows="3">'.htmlspecialchars($d['alamat_petugas']).'</textarea></div>
                        <button type="submit" name="edit_petugas" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="?page=petugas" class="btn btn-outline">Batal</a>
                    </form>
                </div>';
            } elseif(isset($_GET['tambah'])){
                echo '
                <div class="form-card">
                    <form method="POST">
                        <div class="form-group"><label>Nama Petugas</label><input type="text" name="nama_petugas" required></div>
                        <div class="form-group"><label>No HP</label><input type="text" name="hp_petugas"></div>
                        <div class="form-group"><label>Alamat</label><textarea name="alamat_petugas" rows="3"></textarea></div>
                        <button type="submit" name="tambah_petugas" class="btn btn-success">Simpan</button>
                        <a href="?page=petugas" class="btn btn-outline">Batal</a>
                    </form>
                </div>';
            } else {
                $data = mysqli_query($conn, "SELECT * FROM petugas ORDER BY id_petugas DESC");
                echo '<div class="action-buttons"><a href="?page=petugas&tambah=1" class="btn btn-success">+ Tambah Petugas</a></div>
                <table class="data-table">
                    <thead><tr><th>ID</th><th>Nama Petugas</th><th>No HP</th><th>Alamat</th><th>Aksi</th></tr></thead>
                    <tbody>';
                while($r=mysqli_fetch_assoc($data)) echo '<tr>
                        <td>'.$r['id_petugas'].'</a></td>
                        <td>'.htmlspecialchars($r['nama_petugas']).'</a></td>
                        <td>'.($r['hp_petugas']?:'-').'</a></td>
                        <td>'.($r['alamat_petugas']?:'-').'</a></td>
                        <td><a href="?page=petugas&edit='.$r['id_petugas'].'" class="btn btn-warning">Edit</a> <a href="?hapus_petugas='.$r['id_petugas'].'" class="btn btn-danger" onclick="return confirm(\'Yakin hapus?\')">Hapus</a></a></td>
                    </tr>';
                echo '</tbody><tr>';
            }
        }
        
        // TRANSAKSI
        elseif ($page == 'transaksi') {
            $data = mysqli_query($conn, "SELECT n.*, p.nama_pelanggan, pg.nama_petugas FROM nota n JOIN pelanggan p ON n.id_pelanggan = p.id_pelanggan JOIN petugas pg ON n.id_petugas = pg.id_petugas ORDER BY n.no_nota DESC");
            echo '<div class="action-buttons"><a href="?page=tambah_transaksi" class="btn btn-success">+ Transaksi Baru</a></div>
            <table class="data-table">
                <thead><tr><th>No Nota</th><th>Tanggal</th><th>Pelanggan</th><th>Petugas</th><th>Total</th><th>Aksi</th></tr></thead>
                <tbody>';
            while($r=mysqli_fetch_assoc($data)) echo '<tr>
                    <td>'.$r['no_nota'].'</a></td>
                    <td>'.date('d-m-Y',strtotime($r['tanggal'])).'</a></td>
                    <td>'.htmlspecialchars($r['nama_pelanggan']).'</a></td>
                    <td>'.htmlspecialchars($r['nama_petugas']).'</a></td>
                    <td>Rp '.number_format($r['total'],0,',','.').'</a></td>
                    <td>
                        <a href="?page=detail_transaksi&id='.$r['no_nota'].'" class="btn btn-info">Detail</a>
                        <a href="?page=edit_transaksi&id='.$r['no_nota'].'" class="btn btn-warning">Edit</a>
                        <a href="?page=cetak_nota&id='.$r['no_nota'].'" class="btn btn-primary">Cetak</a>
                        <a href="?hapus_transaksi='.$r['no_nota'].'" class="btn btn-danger" onclick="return confirm(\'Yakin hapus?\')">Hapus</a>
                    </a></td>
                </tr>';
            echo '</tbody></table>';
        }
        
        // TAMBAH TRANSAKSI
        elseif ($page == 'tambah_transaksi') {
            $barang = mysqli_query($conn, "SELECT * FROM barang");
            $pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
            $petugas = mysqli_query($conn, "SELECT * FROM petugas");
            $last = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(no_nota) as max FROM nota"));
            $no_nota = ($last['max'] ?? 0) + 1;
            
            $total_cart = 0;
            if(isset($_SESSION['cart'])) foreach($_SESSION['cart'] as $item) $total_cart += $item['harga'] * $item['jumlah'];
            
            echo '
            <div class="form-card" style="max-width:100%;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px;">
                    <div><label>No Nota</label><input type="text" id="no_nota" value="'.$no_nota.'" readonly style="background:#f8fafc;"></div>
                    <div><label>Tanggal</label><input type="date" id="tanggal_transaksi" value="'.date('Y-m-d').'"></div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:32px;">
                    <div><label>Pelanggan</label><select id="select_pelanggan" style="width:100%; padding:12px;">';
                        while($p=mysqli_fetch_assoc($pelanggan)) echo '<option value="'.$p['id_pelanggan'].'" '.(isset($_SESSION['selected_pelanggan']) && $_SESSION['selected_pelanggan']==$p['id_pelanggan']?'selected':'').'>'.htmlspecialchars($p['nama_pelanggan']).'</option>';
            echo '      </select></div>
                    <div><label>Petugas</label><select id="select_petugas" style="width:100%; padding:12px;">';
                        while($p=mysqli_fetch_assoc($petugas)) echo '<option value="'.$p['id_petugas'].'" '.(isset($_SESSION['selected_petugas']) && $_SESSION['selected_petugas']==$p['id_petugas']?'selected':'').'>'.htmlspecialchars($p['nama_petugas']).'</option>';
            echo '      </select></div>
                </div>
                <hr style="margin:20px 0; border-color:#e2e8f0;">
                <h3 style="margin-bottom:16px;">🛒 Daftar Belanja</h3>
                <div style="display:flex; gap:12px; margin-bottom:20px;">
                    <select id="barang_select" style="flex:2; padding:12px; border:1px solid #e2e8f0; border-radius:12px;">
                        <option value="">-- Pilih Barang --</option>';
                        while($b=mysqli_fetch_assoc($barang)) echo '<option value="'.$b['id_barang'].'" data-nama="'.htmlspecialchars($b['nama_barang']).'" data-harga="'.$b['harga'].'" data-imei="'.htmlspecialchars($b['imei']).'">'.htmlspecialchars($b['nama_barang']).' - Rp '.number_format($b['harga'],0,',','.').'</option>';
            echo '</select>
                    <input type="number" id="jumlah_barang" value="1" min="1" style="flex:1; padding:12px; border:1px solid #e2e8f0; border-radius:12px;">
                    <button type="button" class="btn btn-primary" onclick="tambahKeKeranjang()" style="padding:0 24px;">Tambah</button>
                </div>
                <table class="cart-table">
                    <thead><tr><th>Nama Barang</th><th>IMEI</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th></tr></thead>
                    <tbody id="cart_body">';
            if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
                $idx=0;
                foreach($_SESSION['cart'] as $item){
                    $subtotal=$item['harga']*$item['jumlah'];
                    echo '<tr>
                            <td>'.htmlspecialchars($item['nama_barang']).'</a></td>
                            <td>'.htmlspecialchars($item['imei']??'-').'</a></td>
                            <td>Rp '.number_format($item['harga'],0,',','.').'</a></td>
                            <td>'.$item['jumlah'].'</a></td>
                            <td>Rp '.number_format($subtotal,0,',','.').'</a></td>
                            <td><a href="?remove_from_cart='.$idx.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus?\')">Hapus</a></a></td>
                          </tr>';
                    $idx++;
                }
            } else { echo '<tr><td colspan="6" style="text-align:center;">Keranjang kosong</a></td></tr>'; }
            echo '</tbody></table>
                <div class="total-display">Total: Rp <span id="total_cart">'.number_format($total_cart,0,',','.').'</span></div>
                <div style="margin-top:24px;"><button type="button" class="btn btn-success" style="width:100%; padding:14px; font-size:16px;" onclick="prosesTransaksi()">Proses Transaksi</button></div>
            </div>
            <script>
            function tambahKeKeranjang(){
                let s=document.getElementById("barang_select");
                if(!s.value){alert("Pilih barang!");return;}
                let f=document.createElement("form");f.method="POST";
                f.innerHTML="<input type=\"hidden\" name=\"add_to_cart_ajax\" value=\"1\"><input type=\"hidden\" name=\"id_barang\" value=\""+s.value+"\"><input type=\"hidden\" name=\"nama_barang\" value=\""+s.options[s.selectedIndex].getAttribute("data-nama")+"\"><input type=\"hidden\" name=\"harga\" value=\""+s.options[s.selectedIndex].getAttribute("data-harga")+"\"><input type=\"hidden\" name=\"imei\" value=\""+s.options[s.selectedIndex].getAttribute("data-imei")+"\"><input type=\"hidden\" name=\"jumlah\" value=\""+document.getElementById("jumlah_barang").value+"\">";
                document.body.appendChild(f);f.submit();
            }
            function prosesTransaksi(){
                let p=document.getElementById("select_pelanggan").value, t=document.getElementById("select_petugas").value;
                if(!p){alert("Pilih pelanggan!");return;}
                if(!t){alert("Pilih petugas!");return;}
                let rows=document.getElementById("cart_body").rows;
                if(rows.length===0||(rows.length===1&&rows[0].cells[0].innerText==="Keranjang kosong")){alert("Keranjang kosong!");return;}
                if(confirm("Proses transaksi?")){
                    let f=document.createElement("form");f.method="POST";
                    f.innerHTML="<input type=\"hidden\" name=\"proses_transaksi\" value=\"1\"><input type=\"hidden\" name=\"no_nota\" value=\""+document.getElementById("no_nota").value+"\"><input type=\"hidden\" name=\"tanggal\" value=\""+document.getElementById("tanggal_transaksi").value+"\"><input type=\"hidden\" name=\"id_pelanggan\" value=\""+p+"\"><input type=\"hidden\" name=\"id_petugas\" value=\""+t+"\">";
                    document.body.appendChild(f);f.submit();
                }
            }
            document.getElementById("select_pelanggan").onchange=function(){
                let f=document.createElement("form");f.method="POST";
                f.innerHTML="<input type=\"hidden\" name=\"simpan_pelanggan\" value=\""+this.value+"\">";
                document.body.appendChild(f);f.submit();
            };
            document.getElementById("select_petugas").onchange=function(){
                let f=document.createElement("form");f.method="POST";
                f.innerHTML="<input type=\"hidden\" name=\"simpan_petugas\" value=\""+this.value+"\">";
                document.body.appendChild(f);f.submit();
            };
            </script>';
        }
        
        // ==================== EDIT TRANSAKSI ====================
elseif ($page == 'edit_transaksi') {
    $id=(int)$_GET['id'];
    $nota=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM nota WHERE no_nota=$id"));
    $pelanggan=mysqli_query($conn,"SELECT * FROM pelanggan");
    $petugas=mysqli_query($conn,"SELECT * FROM petugas");
    $barang=mysqli_query($conn,"SELECT * FROM barang");
    
    $dq=mysqli_query($conn,"SELECT dn.*, b.nama_barang, b.imei FROM detail_nota dn JOIN barang b ON dn.id_barang = b.id_barang WHERE dn.no_nota=$id");
    $edit_cart=[]; while($r=mysqli_fetch_assoc($dq)) $edit_cart[]=['id_barang'=>$r['id_barang'],'nama_barang'=>$r['nama_barang'],'imei'=>$r['imei'],'harga'=>(float)$r['harga'],'jumlah'=>(int)$r['jumlah']];
    $total_edit=0; foreach($edit_cart as $item) $total_edit+=$item['harga']*$item['jumlah'];
    
    echo '
    <div class="form-card" style="max-width:100%;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px;">
            <div><label>No Nota</label><input type="text" value="'.$id.'" readonly style="background:#f8fafc;"></div>
            <div><label>Tanggal</label><input type="date" id="edit_tanggal" value="'.$nota['tanggal'].'"></div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:32px;">
            <div><label>Pelanggan</label><select id="edit_pelanggan" style="width:100%; padding:12px;">';
                while($p=mysqli_fetch_assoc($pelanggan)) echo '<option value="'.$p['id_pelanggan'].'" '.($p['id_pelanggan']==$nota['id_pelanggan']?'selected':'').'>'.htmlspecialchars($p['nama_pelanggan']).'</option>';
    echo '      </select></div>
            <div><label>Petugas</label><select id="edit_petugas" style="width:100%; padding:12px;">';
                while($p=mysqli_fetch_assoc($petugas)) echo '<option value="'.$p['id_petugas'].'" '.($p['id_petugas']==$nota['id_petugas']?'selected':'').'>'.htmlspecialchars($p['nama_petugas']).'</option>';
    echo '      </select></div>
        </div>
        <hr style="margin:20px 0;">
        <h3>Daftar Belanja</h3>
        <div style="display:flex; gap:12px; margin-bottom:20px;">
            <select id="barang_tambah" style="flex:2; padding:12px; border:1px solid #e2e8f0; border-radius:12px;">
                <option value="">-- Tambah Barang --</option>';
                while($b=mysqli_fetch_assoc($barang)) echo '<option value="'.$b['id_barang'].'" data-nama="'.htmlspecialchars($b['nama_barang']).'" data-harga="'.$b['harga'].'" data-imei="'.htmlspecialchars($b['imei']).'">'.htmlspecialchars($b['nama_barang']).' - Rp '.number_format($b['harga'],0,',','.').'</option>';
    echo '</select>
            <input type="number" id="jumlah_tambah" value="1" min="1" style="flex:1; padding:12px; border:1px solid #e2e8f0; border-radius:12px;">
            <button type="button" class="btn btn-primary" onclick="tambahItemEdit()" style="padding:0 24px;">Tambah</button>
        </div>
        <table class="cart-table">
            <thead><tr><th>Nama Barang</th><th>IMEI</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th></tr></thead>
            <tbody id="edit_cart_body">';
    foreach($edit_cart as $idx=>$item){
        $sub=$item['harga']*$item['jumlah'];
        echo '<tr id="row_'.$idx.'">
                 <td>'.htmlspecialchars($item['nama_barang']).'</td>
                 <td>'.htmlspecialchars($item['imei']?:'-').'</td>
                 <td>Rp '.number_format($item['harga'],0,',','.').'</td>
                 <td><input type="number" class="edit_jml" value="'.$item['jumlah'].'" min="1" style="width:70px; padding:8px; border:1px solid #e2e8f0; border-radius:8px;" onchange="updateJumlahEdit('.$idx.')"></td>
                 <td class="sub_'.$idx.'">Rp '.number_format($sub,0,',','.').'</td>
                 <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusItemEdit('.$idx.')">Hapus</button></td>
               </tr>';
    }
    echo '</tbody>
        </table>
        <div class="total-display">Total: Rp <span id="edit_total">'.number_format($total_edit,0,',','.').'</span></div>
        <div style="margin-top:24px;"><button type="button" class="btn btn-success" style="width:100%; padding:14px; font-size:16px;" onclick="simpanEdit()">Simpan Perubahan</button></div>
    </div>
    <script>
    let editCart = ' . json_encode($edit_cart) . ';
    function updateJumlahEdit(idx){
        let jml = parseInt(document.querySelector("#row_"+idx+" .edit_jml").value);
        editCart[idx].jumlah = jml;
        let sub = editCart[idx].harga * jml;
        document.querySelector(".sub_"+idx).innerHTML = "Rp " + sub.toLocaleString("id-ID");
        let total = 0;
        for(let i=0;i<editCart.length;i++) total += editCart[i].harga * editCart[i].jumlah;
        document.getElementById("edit_total").innerHTML = total.toLocaleString("id-ID");
    }
    function tambahItemEdit(){
        let s = document.getElementById("barang_tambah");
        if(!s.value){ alert("Pilih barang!"); return; }
        let id = s.value;
        let nama = s.options[s.selectedIndex].getAttribute("data-nama");
        let harga = parseFloat(s.options[s.selectedIndex].getAttribute("data-harga"));
        let imei = s.options[s.selectedIndex].getAttribute("data-imei");
        let jumlah = parseInt(document.getElementById("jumlah_tambah").value);
        let existing = -1;
        for(let i=0;i<editCart.length;i++) if(editCart[i].id_barang == id){ existing = i; break; }
        if(existing >= 0){
            editCart[existing].jumlah += jumlah;
            updateJumlahEdit(existing);
        } else {
            editCart.push({id_barang:id, nama_barang:nama, imei:imei, harga:harga, jumlah:jumlah});
            refreshEditTable();
        }
    }
    function hapusItemEdit(idx){
        if(confirm("Hapus item?")){ editCart.splice(idx,1); refreshEditTable(); }
    }
    function refreshEditTable(){
        let tbody = document.getElementById("edit_cart_body");
        tbody.innerHTML = "";
        if(editCart.length === 0){
            tbody.innerHTML = "<tr><td colspan=\'6\' style=\'text-align:center;\'>Keranjang kosong</td></tr>";
            document.getElementById("edit_total").innerHTML = "0";
            return;
        }
        for(let i=0;i<editCart.length;i++){
            let item = editCart[i];
            let sub = item.harga * item.jumlah;
            let row = tbody.insertRow();
            row.id = "row_"+i;
            row.innerHTML = "<td>"+item.nama_barang+"</td>"+
                "<td>"+(item.imei||"-")+"</td>"+
                "<td>Rp "+item.harga.toLocaleString("id-ID")+"</td>"+
                "<td><input type=\"number\" class=\"edit_jml\" value=\""+item.jumlah+"\" min=\"1\" style=\"width:70px; padding:8px; border:1px solid #e2e8f0; border-radius:8px;\" onchange=\"updateJumlahEdit("+i+")\"></td>"+
                "<td class=\"sub_"+i+"\">Rp "+sub.toLocaleString("id-ID")+"</td>"+
                "<td><button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"hapusItemEdit("+i+")\">Hapus</button></td>";
        }
        let total = 0;
        for(let i=0;i<editCart.length;i++) total += editCart[i].harga * editCart[i].jumlah;
        document.getElementById("edit_total").innerHTML = total.toLocaleString("id-ID");
    }
    function simpanEdit(){
        let tgl = document.getElementById("edit_tanggal").value;
        let plg = document.getElementById("edit_pelanggan").value;
        let ptg = document.getElementById("edit_petugas").value;
        if(editCart.length === 0){ alert("Keranjang kosong!"); return; }
        if(confirm("Simpan perubahan?")){
            let f = document.createElement("form");
            f.method = "POST";
            f.innerHTML = "<input type=\"hidden\" name=\"update_transaksi_multi\" value=\"1\">"+
                "<input type=\"hidden\" name=\"no_nota\" value=\"'.$id.'\">"+
                "<input type=\"hidden\" name=\"tanggal\" value=\""+tgl+"\">"+
                "<input type=\"hidden\" name=\"id_pelanggan\" value=\""+plg+"\">"+
                "<input type=\"hidden\" name=\"id_petugas\" value=\""+ptg+"\">"+
                "<input type=\"hidden\" name=\"cart_data\" value=\'" + JSON.stringify(editCart) + "\'>";
            document.body.appendChild(f);
            f.submit();
        }
    }
    </script>';
}
   // ==================== DETAIL TRANSAKSI ====================
elseif ($page == 'detail_transaksi') {
    $id = (int)$_GET['id'];
    
    $query_nota = "SELECT n.*, p.nama_pelanggan, p.no_telepon, p.alamat, pg.nama_petugas 
                   FROM nota n 
                   JOIN pelanggan p ON n.id_pelanggan = p.id_pelanggan 
                   JOIN petugas pg ON n.id_petugas = pg.id_petugas 
                   WHERE n.no_nota = $id";
    $nota = mysqli_fetch_assoc(mysqli_query($conn, $query_nota));
    
    if(!$nota){
        echo '<div style="text-align:center; padding:60px; background:white; border-radius:20px;">
                <div style="font-size:48px; margin-bottom:16px;">📭</div>
                <h3 style="color:#475569;">Transaksi tidak ditemukan</h3>
                <a href="?page=transaksi" class="btn btn-primary" style="margin-top:16px;">Kembali ke Daftar Transaksi</a>
              </div>';
    } else {
        $detail_query = "SELECT dn.*, b.nama_barang, b.imei 
                         FROM detail_nota dn 
                         JOIN barang b ON dn.id_barang = b.id_barang 
                         WHERE dn.no_nota = $id";
        $detail = mysqli_query($conn, $detail_query);
        
        echo '
        <div style="margin-bottom:24px; display:flex; gap:12px; flex-wrap:wrap;">
            <a href="?page=cetak_nota&id='.$id.'" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:8px;">🖨️ Cetak Nota</a>
            <a href="?page=edit_transaksi&id='.$id.'" class="btn btn-warning" style="display:inline-flex; align-items:center; gap:8px;">✏️ Edit Transaksi</a>
            <a href="?hapus_transaksi='.$id.'" class="btn btn-danger" onclick="return confirm(\'Yakin hapus transaksi ini?\')" style="display:inline-flex; align-items:center; gap:8px;">🗑️ Hapus Transaksi</a>
            <a href="?page=transaksi" class="btn btn-outline" style="display:inline-flex; align-items:center; gap:8px;">← Kembali ke Daftar</a>
        </div>
        
        <div style="background:white; border-radius:20px; border:1px solid #e2e8f0; overflow:hidden; margin-bottom:24px;">
            <div style="padding:20px 24px; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                <h3 style="margin:0; font-size:18px; color:#0f172a;">Informasi Nota</h3>
            </div>
            <div style="padding:24px;">
                <table style="width:100%; border-collapse:collapse;">
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        <td style="padding:12px 8px; width:140px; font-weight:600; color:#475569;">No Nota</td>
                        <td style="padding:12px 8px; color:#0f172a;">: ' . $nota['no_nota'] . '</td>
                        <td style="padding:12px 8px; width:140px; font-weight:600; color:#475569;">Tanggal</td>
                        <td style="padding:12px 8px; color:#0f172a;">: ' . date('d-m-Y', strtotime($nota['tanggal'])) . '</td>
                    </tr>
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        <td style="padding:12px 8px; font-weight:600; color:#475569;">Pelanggan</td>
                        <td style="padding:12px 8px; color:#0f172a;">: ' . htmlspecialchars($nota['nama_pelanggan']) . '</td>
                        <td style="padding:12px 8px; font-weight:600; color:#475569;">No Telepon</td>
                        <td style="padding:12px 8px; color:#0f172a;">: ' . ($nota['no_telepon'] ?: '-') . '</td>
                    </tr>
                    <tr>
                        <td style="padding:12px 8px; font-weight:600; color:#475569;">Alamat</td>
                        <td style="padding:12px 8px; color:#0f172a;">: ' . ($nota['alamat'] ?: '-') . '</td>
                        <td style="padding:12px 8px; font-weight:600; color:#475569;">Petugas</td>
                        <td style="padding:12px 8px; color:#0f172a;">: ' . htmlspecialchars($nota['nama_petugas']) . '</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div style="background:white; border-radius:20px; border:1px solid #e2e8f0; overflow:hidden;">
            <div style="padding:20px 24px; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                <h3 style="margin:0; font-size:18px; color:#0f172a;">Detail Barang</h3>
            </div>
            <div style="padding:0;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                            <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:13px;">Nama Barang</th>
                            <th style="padding:14px 16px; text-align:left; font-weight:600; color:#475569; font-size:13px;">IMEI</th>
                            <th style="padding:14px 16px; text-align:right; font-weight:600; color:#475569; font-size:13px;">Harga</th>
                            <th style="padding:14px 16px; text-align:center; font-weight:600; color:#475569; font-size:13px;">Jumlah</th>
                            <th style="padding:14px 16px; text-align:right; font-weight:600; color:#475569; font-size:13px;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        if(mysqli_num_rows($detail) > 0){
            while($d = mysqli_fetch_assoc($detail)){
                echo '<tr style="border-bottom:1px solid #f1f5f9;">
                        <td style="padding:14px 16px; color:#334155;">' . htmlspecialchars($d['nama_barang']) . '</td>
                        <td style="padding:14px 16px; color:#334155; font-family:monospace;">' . ($d['imei'] ?: '-') . '</td>
                        <td style="padding:14px 16px; text-align:right; color:#334155;">Rp ' . number_format($d['harga'],0,',','.') . '</td>
                        <td style="padding:14px 16px; text-align:center; color:#334155;">' . $d['jumlah'] . '</td>
                        <td style="padding:14px 16px; text-align:right; color:#334155;">Rp ' . number_format($d['subtotal'],0,',','.') . '</td>
                      </tr>';
            }
        } else {
            echo '<tr><td colspan="5" style="padding:40px; text-align:center; color:#64748b;">Tidak ada detail barang</td></tr>';
        }
        
        echo '      </tbody>
                    <tfoot>
                        <tr style="background:#f8fafc; border-top:2px solid #e2e8f0;">
                            <td colspan="4" style="padding:14px 16px; text-align:right; font-weight:700; color:#0f172a;">Total</td>
                            <td style="padding:14px 16px; text-align:right; font-weight:700; color:#1e3c72; font-size:16px;">Rp ' . number_format($nota['total'],0,',','.') . '</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>';
    }
}
        // CETAK NOTA
        elseif ($page == 'cetak_nota') {
            $id=(int)$_GET['id'];
            $nota=mysqli_fetch_assoc(mysqli_query($conn,"SELECT n.*, p.nama_pelanggan, p.no_telepon, p.alamat, pg.nama_petugas FROM nota n JOIN pelanggan p ON n.id_pelanggan = p.id_pelanggan JOIN petugas pg ON n.id_petugas = pg.id_petugas WHERE n.no_nota=$id"));
            $detail=mysqli_query($conn,"SELECT dn.*, b.nama_barang, b.imei FROM detail_nota dn JOIN barang b ON dn.id_barang = b.id_barang WHERE dn.no_nota=$id");
            
            echo '
            <div class="action-buttons">
                <button onclick="window.print()" class="btn btn-primary">Cetak Nota</button>
                <a href="?page=detail_transaksi&id='.$id.'" class="btn btn-outline">Kembali</a>
                <a href="?page=transaksi" class="btn btn-outline">Daftar Transaksi</a>
            </div>
            <div class="nota-wrapper">
                <div class="nota">
                    <div class="nota-header">
                        <h2>GADGET KECEE</h2>
                        <p>Bergaransi Terjamin dan Terpercaya</p>
                        <p>Jln. Raya Kodau Gg. H. Porod RT.005/RW.003</p>
                        <p>Jatimekar Jatiasih Bekasi</p>
                        <p>(Sebrang Pegadaian Kodau)</p>
                        <p>Call / Wa : 0896 5900 9400</p>
                    </div>
                    <div class="nota-info">
                        <table>
                            <tr><td width="80">No. Nota</a></td><td>: '.$nota['no_nota'].'</a></td></tr>
                            <tr><td>Atas Nama</a></td><td>: '.htmlspecialchars($nota['nama_pelanggan']).'</a></td></tr>
                            <tr><td>Tanggal</a></td><td>: '.date('d-m-Y',strtotime($nota['tanggal'])).'</a></td></tr>
                            <tr><td>No. HP</a></td><td>: '.($nota['no_telepon']?:'-').'</a></td></tr>
                            <tr><td>Petugas</a></td><td>: '.htmlspecialchars($nota['nama_petugas']).'</a></table></tr>
                        </table>
                    </div>
                    <table class="nota-items">
                        <thead><tr><th>Banyak</th><th>Keterangan</th><th>Imei</th><th>Harga</th></tr></thead>
                        <tbody>';
            while($d=mysqli_fetch_assoc($detail)) echo '<tr>
                                <td>'.$d['jumlah'].'</a></td>
                                <td>'.htmlspecialchars($d['nama_barang']).'</a></td>
                                <td>'.($d['imei']?:'-').'</a></td>
                                <td align="right">'.number_format($d['harga'],0,',','.').'</a></td>
                              </tr>';
            echo '</tbody>
                        </table>
                        <div class="nota-total">Total : Rp '.number_format($nota['total'],0,',','.').'</div>
                        <div class="nota-footer">
                            <p><strong>PERHATIAN:</strong></p>
                            <p>✓ Barang yang sudah dibeli tidak bisa dikembalikan</p>
                            <p>✓ Barang Sudah Diperiksa Dengan Baik</p>
                            <p>✓ Barang Diterima Dalam Keadaan Baik</p>
                            <p>✓ Akad Dilakukan Secara Baik Antara Konsumen Dan Seller</p>
                            <p><strong>Syarat dan Ketentuan Garansi</strong></p>
                            <p>✓ Segel Tidak Rusak</p>
                            <p>✓ Nota Masih Atas Nama Buyer</p>
                            <p>✓ Tidak Upgrade IOS + Tanpa Konfirmasi Ke Seller</p>
                            <p>✓ Tidak Lecet / Baret, Jatuh Ke Air / Kesalahan Pengguna</p>
                            <p>✓ Proses Klaim Garansi 2-7 Hari</p>
                            <p>✓ Garansi Hanya Berlaku Tuker Unit</p>
                        </div>
                        <div class="ttd">
                            <div>Penerima,<br><br><br>(__________________)</div>
                            <div>Hormat Kami,<br><br><br>(__________________)</div>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>
</body>
</html>