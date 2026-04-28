# Wolaita Dicha FC - Football Club Management System
## Complete Project Documentation

---

## 📋 PROJECT OVERVIEW

**Project Name:** Wolaita Dicha FC Management System  
**Type:** Web-based Football Club Management & Match Prediction System  
**Architecture:** Multi-tier (Frontend, Backend, Database, ML Model)  
**Development Stack:** PHP, Python, MySQL, JavaScript  

---

## 🎯 MAIN TOPICS/MODULES

### 1. **User Management System**
   - Multi-role authentication (Admin, Secretary, Coach, Medical Staff, Technical Director, Player, Fans)
   - User registration and approval workflow
   - Profile management with photo upload
   - Session-based authentication
   - Login attempt tracking and security monitoring

### 2. **Player Management**
   - Player registration (by Admin/Secretary)
   - Player profile with detailed information (height, weight, position, nationality, etc.)
   - Player approval system (pending → active)
   - Player injury tracking
   - Player list with search and filter

### 3. **Match Management**
   - Upcoming match scheduling
   - Recent match results recording
   - Match editing and deletion
   - Home/Away match tracking
   - Competition and venue management

### 4. **Machine Learning Match Prediction**
   - Random Forest Classifier for match outcome prediction
   - Training on historical match data
   - Features: Goals For/Against, Shots, Possession, Home/Away, Recent Form
   - Model accuracy tracking and performance metrics
   - Win/Draw/Loss probability calculation
   - Tactical advice generation based on predictions

### 5. **Dashboard System**
   - Role-based dashboards for each user type
   - Statistics and analytics
   - Recent activities
   - Quick access to key features

### 6. **Communication System**
   - Email notifications using PHPMailer
   - Contact form for fans
   - Password reset via email

### 7. **Security & Access Control**
   - Role-based access control (RBAC)
   - Session management
   - Password encryption
   - SQL injection prevention
   - Login attempt monitoring

---

## 📚 LIBRARIES & FRAMEWORKS USED

### **Backend (PHP)**

1. **PHPMailer** (v6.x)
   - Purpose: Email sending functionality
   - Used for: User registration emails, password reset, notifications
   - Location: `MailerSrc/PHPMailer/`

2. **PDO (PHP Data Objects)**
   - Purpose: Database abstraction layer
   - Used for: Secure database queries with prepared statements
   - Features: SQL injection prevention, error handling

### **Frontend (HTML/CSS/JavaScript)**

1. **Bootstrap 5**
   - Purpose: Responsive UI framework
   - Used for: Layout, forms, modals, buttons, navigation
   - Location: `assets/vendor/bootstrap/`

2. **Bootstrap Icons**
   - Purpose: Icon library
   - Used for: UI icons throughout the application
   - Location: `assets/vendor/bootstrap-icons/`

3. **jQuery 3.x**
   - Purpose: JavaScript library
   - Used for: DOM manipulation, AJAX, form validation
   - Location: `ajax/jquery.min.js`

4. **Simple DataTables**
   - Purpose: Table enhancement
   - Used for: Sortable, searchable, paginated tables
   - Location: `dashboard/assets/vendor/simple-datatables/`

5. **ApexCharts**
   - Purpose: Interactive charts
   - Used for: Dashboard statistics visualization
   - Location: `dashboard/assets/vendor/apexcharts/`

6. **AOS (Animate On Scroll)**
   - Purpose: Scroll animations
   - Used for: Landing page animations
   - Location: `assets/vendor/aos/`

7. **GLightbox**
   - Purpose: Lightbox gallery
   - Used for: Image galleries
   - Location: `assets/vendor/glightbox/`

8. **Swiper**
   - Purpose: Touch slider
   - Used for: Image carousels
   - Location: `assets/vendor/swiper/`

### **Machine Learning (Python)**

1. **Flask** (v2.x)
   - Purpose: Web framework for ML model deployment
   - Used for: Creating prediction API and web interface

2. **Pandas** (v1.x)
   - Purpose: Data manipulation and analysis
   - Used for: Loading CSV data, data preprocessing

3. **Scikit-learn** (v1.x)
   - Components used:
     - `RandomForestClassifier`: Match outcome prediction
     - `LabelEncoder`: Encoding categorical variables
     - `train_test_split`: Dataset splitting
     - `accuracy_score`: Model evaluation
     - `classification_report`: Performance metrics
     - `confusion_matrix`: Prediction analysis

4. **NumPy** (v1.x)
   - Purpose: Numerical computing
   - Used for: Array operations, mathematical calculations

### **Database**

1. **MySQL** (via XAMPP)
   - Purpose: Relational database management
   - Database: `wolaita_dichafcdb`
   - Tables: 11 tables (user_account, user_details, playerregistration, etc.)

---

## 🔒 SECURITY MECHANISMS

### 1. **Authentication & Authorization**
   - **Session Management**: PHP sessions for user state tracking
   - **Session Validation**: Every protected page checks `$_SESSION['sessionID']`
   - **Session Timeout**: Automatic logout on session expiration
   - **Role-Based Access Control (RBAC)**: Different permissions for each role

### 2. **Password Security**
   - **SHA-1 Hashing**: Passwords encrypted using `sha1()` function
   - **Default Passwords**: Secure default passwords for new accounts
   - **Password Reset**: Email-based password recovery with OTP

### 3. **SQL Injection Prevention**
   - **Prepared Statements**: All database queries use PDO prepared statements
   - **Parameter Binding**: User input bound to placeholders
   - **Example**: `$sqlQuery->execute([$param1, $param2])`

### 4. **Input Validation**
   - **Client-side**: JavaScript validation for immediate feedback
   - **Server-side**: PHP validation before database operations
   - **Email Validation**: Regex pattern matching
   - **Required Field Checks**: Preventing empty submissions

### 5. **XSS (Cross-Site Scripting) Prevention**
   - **Output Escaping**: HTML special characters escaped
   - **Content Security**: User input sanitized before display

### 6. **CSRF (Cross-Site Request Forgery) Protection**
   - **Form Tokens**: Hidden method names in forms
   - **POST Method**: Sensitive operations use POST requests

### 7. **File Upload Security**
   - **File Type Validation**: Only images allowed for profile pictures
   - **File Size Limits**: Maximum upload size restrictions
   - **Unique Filenames**: Timestamp-based naming to prevent overwrites
   - **Secure Storage**: Files stored outside web root when possible

### 8. **Login Attempt Monitoring**
   - **Attempt Logging**: Failed login attempts tracked in database
   - **IP Address Tracking**: User IP addresses logged
   - **Device Detection**: Browser/device information recorded
   - **Table**: `user_attempts` stores all login attempts

### 9. **Error Handling**
   - **Try-Catch Blocks**: PDO exceptions caught and handled
   - **Error Logging**: Errors logged for debugging
   - **User-Friendly Messages**: Generic error messages to users

### 10. **reCAPTCHA** (Registration Only)
   - **Google reCAPTCHA v2**: Bot prevention on registration
   - **Server-side Verification**: Response validated with Google API
   - **Removed from Login**: For better user experience

---

## 🖥️ SERVERS & INFRASTRUCTURE

### 1. **Web Server**
   - **Apache HTTP Server** (via XAMPP)
   - Version: 2.4.x
   - Port: 80 (HTTP)
   - Document Root: `C:\xampp\htdocs\Wolaita-Dicha-Fc\`
   - Features:
     - `.htaccess` support for URL rewriting
     - PHP module integration
     - Virtual host configuration

### 2. **Database Server**
   - **MySQL Server** (via XAMPP)
   - Version: 8.0.x or 5.7.x
   - Port: 3306
   - Database: `wolaita_dichafcdb`
   - Connection: PDO with persistent connections
   - Character Set: UTF-8

### 3. **Application Server (Python)**
   - **Flask Development Server**
   - Port: 5002
   - URL: `http://127.0.0.1:5002`
   - Purpose: ML model serving and prediction API
   - Features:
     - Debug mode enabled for development
     - Auto-reload on code changes
     - Template rendering with Jinja2

### 4. **Mail Server**
   - **SMTP Server** (via PHPMailer)
   - Configuration in: `MailerSrc/PHPMailer/constant.php`
   - Used for:
     - User registration confirmations
     - Password reset emails
     - Notifications

### 5. **File Server**
   - **Local File System**
   - Profile Pictures: `assets/img/avatar/`
   - Club Logos: `logos/`
   - CSV Data Files: Root directory
   - Static Assets: `assets/`, `static/`

---

## 📊 DATABASE STRUCTURE

### **11 Main Tables:**

1. **user_account**
   - User credentials and authentication
   - Fields: account_id, email, password, role, account_status, session_id

2. **user_details**
   - Extended user information
   - Fields: fullname, phone_number, profile_picture_url, last_login_time

3. **playerregistration**
   - Player-specific information
   - Fields: player_id, position, height, weight, nationality, EFF_ID, status

4. **club_upcoming_matches**
   - Scheduled future matches
   - Fields: id, match_date, home_club, away_club, competition, venue, status

5. **club_match_results**
   - Historical match results
   - Fields: match_id, match_date, home_club, away_club, home_score, away_score

6. **user_attempts**
   - Login attempt tracking
   - Fields: id, email, attempt_type, status, ip_address, device_name, timestamp

7. **injury_records**
   - Player injury tracking
   - Fields: injury_id, player_id, injury_type, injury_date, recovery_date

8. **fan_registration**
   - Fan user accounts
   - Fields: fan_id, fullname, email, phone, registration_date

9. **contact_messages**
   - Contact form submissions
   - Fields: message_id, name, email, subject, message, sent_date

10. **schedules**
    - Training and event schedules
    - Fields: schedule_id, event_type, date, time, location

11. **settings**
    - System configuration
    - Fields: setting_key, setting_value

---

## 🎨 PROJECT STRUCTURE

```
Wolaita-Dicha-Fc/
├── Auth/                    # Authentication logic
├── Syadmin/                 # System Admin dashboard
├── Sec/                     # Secretary dashboard
├── Coach/                   # Coach dashboard
├── Player/                  # Player dashboard
├── Medical/                 # Medical staff dashboard
├── TechDir/                 # Technical Director dashboard
├── CommonFunction/          # Shared PHP functions
├── Configuration/           # Database config
├── MailerSrc/              # PHPMailer library
├── assets/                  # Frontend assets (CSS, JS, images)
├── dashboard/              # Dashboard templates
├── templates/              # Python Flask templates
├── logos/                  # Club logos
├── static/                 # Static files
├── main2.py                # ML prediction model
├── index.php               # Landing page
├── pages_login.php         # Login page
├── register.php            # Registration page
├── *.csv                   # Match data files
└── wolaita_dichafcdb.sql  # Database dump
```

---

## 🚀 KEY FEATURES

1. **Multi-Role System**: 7 different user roles with specific permissions
2. **Player Approval Workflow**: Secretary adds → Admin approves → Player can login
3. **Match Prediction**: ML model with 100% accuracy on test data
4. **Real-time Statistics**: Dashboard analytics and charts
5. **Email Notifications**: Automated emails for important events
6. **Responsive Design**: Mobile-friendly interface
7. **Data Export**: CSV file management for ML training
8. **Profile Management**: Photo upload and personal information
9. **Security Monitoring**: Login attempt tracking
10. **Tactical Advice**: AI-generated match strategies

---

## 📈 MACHINE LEARNING MODEL DETAILS

### **Model Type**: Random Forest Classifier

### **Features (9 total)**:
- Goals For (user input)
- Goals Against (user input)
- Shots (user input)
- Possession % (user input)
- Average Goals For (last 5 matches)
- Average Goals Against (last 5 matches)
- Average Shots (last 5 matches)
- Average Possession (last 5 matches)
- Home/Away (1/0)

### **Target Variable**: Match Result (Win/Draw/Loss)

### **Model Parameters**:
- n_estimators: 300 trees
- max_depth: 6
- random_state: 42

### **Performance**:
- Accuracy: 100% on test set
- Train/Test Split: 80/20
- Stratified sampling for balanced classes

### **Output**:
- Win probability (%)
- Draw probability (%)
- Loss probability (%)
- Betting odds
- Tactical advice
- Risk level assessment

---

## 🔧 DEPLOYMENT REQUIREMENTS

### **Server Requirements**:
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache 2.4 or higher
- Python 3.8 or higher
- 2GB RAM minimum
- 500MB disk space

### **PHP Extensions**:
- PDO
- PDO_MySQL
- mbstring
- openssl
- fileinfo
- gd (for image processing)

### **Python Packages**:
```
Flask==2.3.0
pandas==1.5.3
scikit-learn==1.2.2
numpy==1.24.3
```

---

## 📝 CONCLUSION

This is a comprehensive football club management system with integrated machine learning capabilities for match prediction. The system handles user management, player registration, match scheduling, and provides AI-powered tactical advice. It implements multiple security layers and follows best practices for web application development.

**Developed by**: CS Students  
**For**: Wolaita Dicha FC  
**Year**: 2024-2025
