<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Ecommerce Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 20px 30px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .back-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }

        .header-content {
            flex: 1;
        }

        .header h1 {
            font-size: 2.2em;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 5px;
        }

        .profile-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 600px;
            margin: 0 auto;
        }

        .avatar-section {
            text-align: center;
            margin-bottom: 25px;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            font-weight: bold;
            margin: 0 auto 15px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .user-name {
            font-size: 1.8em;
            font-weight: 700;
            margin-bottom: 5px;
            color: #333;
        }

        .user-role {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-admin { background: linear-gradient(135deg, #ff6b6b, #ee5a52); color: white; }
        .role-seller { background: linear-gradient(135deg, #4ecdc4, #44a08d); color: white; }
        .role-customer { background: linear-gradient(135deg, #45b7d1, #96c93d); color: white; }

        .profile-info {
            margin-top: 25px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        .profile-main {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .stats-grid {
            display: none;
        }

        .settings-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
        }

        .section-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .section-title {
            font-size: 1.4em;
            font-weight: 600;
            color: #333;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .activity-content {
            flex: 1;
        }

        .activity-text {
            color: #333;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .activity-time {
            color: #666;
            font-size: 12px;
        }

        .edit-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            padding: 12px 16px;
            border: 2px solid rgba(102, 126, 234, 0.1);
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #666;
            border: 2px solid rgba(0, 0, 0, 0.1);
        }

        .btn-secondary:hover {
            background: #e9ecef;
            color: #333;
        }

        .profile-main {
            display: none;
        }

        @media (max-width: 768px) {
            .edit-form {
                grid-template-columns: 1fr;
            }
        }

        .edit-mode {
            display: none;
        }

        .edit-mode.active {
            display: block;
        }

        .view-mode.editing {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <button class="back-btn" onclick="goBack()">
                ← Back
            </button>
            <div class="header-content">
                <h1>User Profile</h1>
                <p>Manage your account information and settings</p>
            </div>
        </div>

        <div class="profile-grid">
            <div class="profile-sidebar">
                <div class="profile-card">
                    <div class="avatar-section">
                        <div class="avatar" id="userAvatar">JS</div>
                        <div class="user-name" id="userName">John Smith</div>
                        <span class="user-role role-seller" id="userRole">Seller</span>
                    </div>
                    
                    <div class="profile-info view-mode">
                        <div class="info-item">
                            <div class="info-icon">📧</div>
                            <div class="info-content">
                                <div class="info-label">Email</div>
                                <div class="info-value" id="userEmail">john.smith@example.com</div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">📱</div>
                            <div class="info-content">
                                <div class="info-label">Phone</div>
                                <div class="info-value" id="userPhone">+1 (555) 123-4567</div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">🏪</div>
                            <div class="info-content">
                                <div class="info-label">Store Name</div>
                                <div class="info-value" id="userStore">Smith's Electronics</div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">📅</div>
                            <div class="info-content">
                                <div class="info-label">Member Since</div>
                                <div class="info-value" id="userJoined">March 15, 2024</div>
                            </div>
                        </div>
                    </div>

                    <div class="edit-mode" id="editMode">
                        <form class="edit-form" id="profileForm">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-input" id="editName" value="John Smith">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" id="editEmail" value="john.smith@example.com">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-input" id="editPhone" value="+1 (555) 123-4567">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Store Name</label>
                                <input type="text" class="form-input" id="editStore" value="Smith's Electronics">
                            </div>
                        </form>
                        
                        <div class="btn-group">
                            <button class="btn btn-primary" onclick="saveProfile()">Save Changes</button>
                            <button class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-main">


                <div class="settings-section">
                    <div class="section-header">
                        <div class="section-icon">⚙️</div>
                        <h3 class="section-title">Account Settings</h3>
                    </div>
                    
                    <div class="btn-group">
                        <button class="btn btn-primary" onclick="editProfile()">Edit Profile</button>
                        <button class="btn btn-secondary" onclick="changePassword()">Change Password</button>
                        <button class="btn btn-secondary" onclick="manageNotifications()">Notifications</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample user data - in real application, this would come from your PHP backend
        const userData = {
            id: 1,
            name: "John Smith",
            email: "john.smith@example.com",
            phone: "+1 (555) 123-4567",
            role: "seller",
            storeName: "Smith's Electronics",
            joinDate: "March 15, 2024"
        };

        // Initialize profile display
        function initializeProfile() {
            document.getElementById('userName').textContent = userData.name;
            document.getElementById('userEmail').textContent = userData.email;
            document.getElementById('userPhone').textContent = userData.phone;
            document.getElementById('userStore').textContent = userData.storeName;
            document.getElementById('userJoined').textContent = userData.joinDate;
            document.getElementById('userRole').textContent = userData.role.charAt(0).toUpperCase() + userData.role.slice(1);
            
            // Set avatar initials
            const initials = userData.name.split(' ').map(n => n[0]).join('');
            document.getElementById('userAvatar').textContent = initials;
            
            // Set role class
            const roleElement = document.getElementById('userRole');
            roleElement.className = `user-role role-${userData.role}`;
        }

        function editProfile() {
            document.querySelector('.view-mode').classList.add('editing');
            document.getElementById('editMode').classList.add('active');
            
            // Populate edit form
            document.getElementById('editName').value = userData.name;
            document.getElementById('editEmail').value = userData.email;
            document.getElementById('editPhone').value = userData.phone;
            document.getElementById('editStore').value = userData.storeName;
        }

        function saveProfile() {
            // Get updated values
            const updatedName = document.getElementById('editName').value;
            const updatedEmail = document.getElementById('editEmail').value;
            const updatedPhone = document.getElementById('editPhone').value;
            const updatedStore = document.getElementById('editStore').value;
            
            // Validate inputs
            if (!updatedName || !updatedEmail) {
                alert('Name and email are required fields');
                return;
            }
            
            // Update userData object
            userData.name = updatedName;
            userData.email = updatedEmail;
            userData.phone = updatedPhone;
            userData.storeName = updatedStore;
            
            // Update display
            initializeProfile();
            
            // Exit edit mode
            cancelEdit();
            
            // In real application, you would send this data to your PHP backend
            console.log('Profile updated:', userData);
            
            // Show success message
            showNotification('Profile updated successfully!', 'success');
        }

        function cancelEdit() {
            document.querySelector('.view-mode').classList.remove('editing');
            document.getElementById('editMode').classList.remove('active');
        }

        function changePassword() {
            // In real application, this would open a password change modal
            alert('Password change functionality would be implemented here');
        }

        function manageNotifications() {
            // In real application, this would open notification settings
            alert('Notification settings would be implemented here');
        }

        function goBack() {
            // In real application, this would navigate back to the previous page
            window.history.back();
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#28a745' : '#667eea'};
                color: white;
                padding: 15px 20px;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                z-index: 1000;
                font-weight: 600;
                transform: translateX(400px);
                transition: transform 0.3s ease;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(400px)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', initializeProfile);

        // Add some interactive animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stat-card, .profile-card, .activity-section, .settings-section');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
</body>
</html>