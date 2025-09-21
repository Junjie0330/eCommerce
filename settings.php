<?php
// Database configuration
$host = "localhost";
$user = "root"; 
$pass = "";     
$db   = "ecommerce";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

$success = false;
$error = "";
$shop = null;

// Get shop info
$id = 1;
$sql = "SELECT * FROM shop_settings WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$shop = $result->fetch_assoc();

// If no record exists, create default
if (!$shop) {
    $insert_sql = "INSERT INTO shop_settings (shop_name, contact_info, policies, payment_methods, logo, banner) VALUES (?, '', '', '', NULL, NULL)";
    $insert_stmt = $conn->prepare($insert_sql);
    $default_name = "My Shop";
    $insert_stmt->bind_param("s", $default_name);
    
    if ($insert_stmt->execute()) {
        $id = $conn->insert_id;
        // Get the newly created record
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $shop = $result->fetch_assoc();
    }
    $insert_stmt->close();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $shop_name = trim($_POST["shop_name"]);
        $contact_info = trim($_POST["contact_info"]);
        $policies = trim($_POST["policies"]);
        $payment_methods = trim($_POST["payment_methods"]);
        
        $logo = $shop["logo"];
        $banner = $shop["banner"];

        // Create uploads directory
        $upload_dir = "uploads/";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Handle logo upload
        if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $file_type = $_FILES["logo"]["type"];
            
            if (in_array($file_type, $allowed_types) && $_FILES["logo"]["size"] <= 5000000) { // 5MB limit
                $file_extension = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
                $new_filename = "logo_" . time() . "." . $file_extension;
                $upload_path = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $upload_path)) {
                    // Delete old logo
                    if ($shop["logo"] && file_exists($shop["logo"])) {
                        unlink($shop["logo"]);
                    }
                    $logo = $upload_path;
                }
            }
        }

        // Handle banner upload
        if (isset($_FILES["banner"]) && $_FILES["banner"]["error"] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $file_type = $_FILES["banner"]["type"];
            
            if (in_array($file_type, $allowed_types) && $_FILES["banner"]["size"] <= 5000000) { // 5MB limit
                $file_extension = pathinfo($_FILES["banner"]["name"], PATHINFO_EXTENSION);
                $new_filename = "banner_" . time() . "." . $file_extension;
                $upload_path = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES["banner"]["tmp_name"], $upload_path)) {
                    // Delete old banner
                    if ($shop["banner"] && file_exists($shop["banner"])) {
                        unlink($shop["banner"]);
                    }
                    $banner = $upload_path;
                }
            }
        }

        // Update database
        $update_sql = "UPDATE shop_settings SET shop_name = ?, contact_info = ?, policies = ?, payment_methods = ?, logo = ?, banner = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssssi", $shop_name, $contact_info, $policies, $payment_methods, $logo, $banner, $id);
        
        if ($update_stmt->execute()) {
            $success = true;
            // Refresh shop data
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $shop = $result->fetch_assoc();
        } else {
            $error = "Failed to update shop settings.";
        }
        $update_stmt->close();
        
    } catch (Exception $e) {
        $error = "An error occurred: " . $e->getMessage();
    }
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shop Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: white;
            padding: 30px;
            border-bottom: 1px solid #e5e7eb;
        }

        .header h1 {
            color: #1f2937;
            font-size: 28px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header h1::before {
            content: "🏪";
            font-size: 32px;
        }

        .header p {
            color: #6b7280;
            margin-top: 8px;
            font-size: 16px;
        }

        .message {
            padding: 16px;
            text-align: center;
            font-weight: 500;
            margin: 0;
        }

        .success-message {
            background: #10b981;
            color: white;
        }

        .error-message {
            background: #ef4444;
            color: white;
        }

        .form-container {
            padding: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input[type="text"],
        .form-group textarea {
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.2s;
            background: #f9fafb;
            font-family: inherit;
        }

        .form-group input[type="text"]:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .file-upload-container {
            position: relative;
            background: #f9fafb;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.2s;
            cursor: pointer;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .file-upload-container:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .file-upload-container input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            top: 0;
            left: 0;
        }

        .upload-text {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }

        .upload-icon {
            font-size: 24px;
            margin-bottom: 8px;
            display: block;
        }

        .current-image, .image-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 16px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            object-fit: contain;
        }

        .image-preview {
            display: none;
        }

        .image-preview.show {
            display: block;
        }

        .button-container {
            display: flex;
            gap: 16px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            padding: 14px 32px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: inherit;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 2px solid #e5e7eb;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .container {
                margin: 10px;
            }
            
            .header,
            .form-container {
                padding: 20px;
            }
            
            .button-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Edit Shop Profile</h1>
            <p>Manage and update your shop's information and appearance</p>
        </div>

        <?php if ($success): ?>
            <div class="message success-message">
                ✅ Shop profile updated successfully!
            </div>
        <?php elseif ($error): ?>
            <div class="message error-message">
                ❌ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="shop_name">Shop Name</label>
                        <input type="text" id="shop_name" name="shop_name" 
                               value="<?php echo htmlspecialchars($shop['shop_name'] ?? ''); ?>" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="payment_methods">Payment Methods</label>
                        <input type="text" id="payment_methods" name="payment_methods" 
                               value="<?php echo htmlspecialchars($shop['payment_methods'] ?? ''); ?>" 
                               placeholder="e.g. Credit Card, PayPal, Bank Transfer">
                    </div>

                    <div class="form-group">
                        <label>Shop Logo</label>
                        <div class="file-upload-container">
                            <span class="upload-icon">📷</span>
                            <div class="upload-text">
                                <strong>Click to upload logo</strong><br>
                                PNG, JPG up to 5MB
                            </div>
                            <input type="file" name="logo" accept="image/*" onchange="previewImage(event, 'logoPreview')">
                        </div>
                        <?php if (!empty($shop['logo']) && file_exists($shop['logo'])): ?>
                            <img src="<?php echo htmlspecialchars($shop['logo']); ?>" class="current-image" alt="Current Logo">
                        <?php endif; ?>
                        <img id="logoPreview" class="image-preview" alt="Logo Preview">
                    </div>

                    <div class="form-group">
                        <label>Shop Banner</label>
                        <div class="file-upload-container">
                            <span class="upload-icon">🖼️</span>
                            <div class="upload-text">
                                <strong>Click to upload banner</strong><br>
                                PNG, JPG up to 5MB
                            </div>
                            <input type="file" name="banner" accept="image/*" onchange="previewImage(event, 'bannerPreview')">
                        </div>
                        <?php if (!empty($shop['banner']) && file_exists($shop['banner'])): ?>
                            <img src="<?php echo htmlspecialchars($shop['banner']); ?>" class="current-image" alt="Current Banner">
                        <?php endif; ?>
                        <img id="bannerPreview" class="image-preview" alt="Banner Preview">
                    </div>

                    <div class="form-group full-width">
                        <label for="contact_info">Contact Information</label>
                        <textarea id="contact_info" name="contact_info" rows="3" 
                                  placeholder="Enter your contact details, address, phone number, email, etc."><?php echo htmlspecialchars($shop['contact_info'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label for="policies">Shop Policies</label>
                        <textarea id="policies" name="policies" rows="4" 
                                  placeholder="Enter your shop policies, return policy, shipping info, etc."><?php echo htmlspecialchars($shop['policies'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="button-container">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                        ← Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        💾 Update Shop Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event, previewId) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.add('show');
                }
                reader.readAsDataURL(file);
            }
        }

        // Auto-hide messages after 5 seconds
        setTimeout(() => {
            const messages = document.querySelectorAll('.message');
            messages.forEach(message => {
                message.style.transition = 'opacity 0.5s';
                message.style.opacity = '0';
                setTimeout(() => {
                    message.style.display = 'none';
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>