<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>generate qrcode form</title>
</head>
<body>

<h2>Generate QR Code</h2>
<form action="<?php echo base_url('index.php/generate_qrcode'); ?>" method="post" enctype="multipart/form-data">
    <label for="data">Data to encode:</label>
    <input type="text" name="data" id="data" required>
    
    <label for="use_logo">Use logo:</label>
    <input type="checkbox" name="use_logo" id="use_logo">
    
    <input type="submit" value="Generate QR Code">
</form>

</body>
</html>