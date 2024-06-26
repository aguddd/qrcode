<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h2>List of Generated QR Codes</h2>
<style>
    .qr-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .qr-item {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
        width: 200px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .qr-item img {
        width: 100px;
        height: auto;
    }
    .qr-item .data {
        margin-top: 10px;
        font-size: 14px;
        color: #333;
    }
    .qr-item .use-logo {
        margin-top: 5px;
        font-size: 12px;
        color: #555;
    }
    .qr-item .download {
        margin-top: 10px;
        display: inline-block;
        padding: 5px 10px;
        background-color: #007BFF;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }
    .qr-item .download:hover {
        background-color: #0056b3;
    }
</style>
<div class="qr-grid">
    <?php foreach ($qrcodes as $qrcode) : ?>
    <div class="qr-item">
        <img src="<?php echo base_url('uploads/qrcodes/'.$qrcode['qr_image']); ?>" alt="QR Code">
        <div class="data"><?php echo $qrcode['data']; ?></div>
        <div class="use-logo"><?php echo $qrcode['use_logo'] ? 'With Logo' : 'Without Logo'; ?></div>
        <a href="<?php echo base_url('index.php/QrController/download/'.$qrcode['qr_image']); ?>" class="download">Download</a>
    </div>
    <?php endforeach; ?>
</div>
<!-- <br><a href="<?php echo base_url(); ?>">Generate Another QR Code</a> -->
<br><a href="<?php echo base_url('index.php/generate_qrcode_form'); ?>">Generate Another QR Code</a>


</body>
</html>