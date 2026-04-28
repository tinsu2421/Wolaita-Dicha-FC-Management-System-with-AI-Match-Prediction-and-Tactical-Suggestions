# Free Deployment Guide - Wolaita Dicha FC Project

---

## 🚀 FREE HOSTING OPTIONS

Your project has 2 parts that need hosting:
1. **PHP Website** (Main application)
2. **Python ML Model** (Match prediction)

---

## ✅ RECOMMENDED: Split Deployment (Best Free Option)

### **Option 1: InfinityFree + PythonAnywhere**

#### **Part A: PHP Website on InfinityFree**

**InfinityFree Features:**
- ✅ Free PHP hosting
- ✅ Free MySQL database
- ✅ Free subdomain (yoursite.infinityfreeapp.com)
- ✅ 5GB storage
- ✅ Unlimited bandwidth
- ✅ cPanel access
- ✅ No ads

**Steps:**

1. **Sign Up**
   - Go to: https://www.infinityfree.net
   - Click "Sign Up Now"
   - Create account (use real email)

2. **Create Hosting Account**
   - Click "Create Account"
   - Choose subdomain: `wolaita-dicha.infinityfreeapp.com`
   - Or use your own domain (if you have one)

3. **Upload Files**
   - Login to cPanel
   - Go to "File Manager"
   - Navigate to `htdocs` folder
   - Upload all PHP files (except Python files)
   - Upload folders: Auth, Syadmin, Sec, Coach, Player, etc.

4. **Create Database**
   - In cPanel, go to "MySQL Databases"
   - Create new database: `wolaita_dichafcdb`
   - Create database user with password
   - Grant all privileges

5. **Import Database**
   - Go to phpMyAdmin
   - Select your database
   - Click "Import"
   - Upload `wolaita_dichafcdb.sql`
   - Click "Go"

6. **Update Configuration**
   - Edit `Configuration/ini.php`:
   ```php
   define('SERVERHOST', 'sql123.infinityfreeapp.com'); // Your DB host
   define('SERVERUNAME', 'epiz_12345678'); // Your DB username
   define('SERVERPASSWORD', 'your_password'); // Your DB password
   define('SERVERDB', 'epiz_12345678_wolaita'); // Your DB name
   ```

7. **Test Website**
   - Visit: `https://wolaita-dicha.infinityfreeapp.com`
   - Try login, registration, etc.

---

#### **Part B: Python ML Model on PythonAnywhere**

**PythonAnywhere Features:**
- ✅ Free Python hosting
- ✅ Flask support
- ✅ 512MB storage
- ✅ Free subdomain (yourname.pythonanywhere.com)

**Steps:**

1. **Sign Up**
   - Go to: https://www.pythonanywhere.com
   - Click "Start running Python online"
   - Create free account

2. **Upload Python Files**
   - Go to "Files" tab
   - Upload `main2.py`
   - Upload `templates/main2.html`
   - Upload CSV files: `wolaita_dicha_recent_match.csv`, `future_matches.csv`

3. **Install Libraries**
   - Go to "Consoles" tab
   - Start "Bash" console
   - Run:
   ```bash
   pip3 install --user flask pandas scikit-learn numpy
   ```

4. **Create Web App**
   - Go to "Web" tab
   - Click "Add a new web app"
   - Choose "Flask"
   - Python version: 3.10
   - Path: `/home/yourusername/main2.py`

5. **Configure WSGI**
   - Edit WSGI configuration file:
   ```python
   import sys
   path = '/home/yourusername'
   if path not in sys.path:
       sys.path.append(path)
   
   from main2 import app as application
   ```

6. **Reload Web App**
   - Click "Reload" button
   - Visit: `https://yourusername.pythonanywhere.com`

7. **Connect to Main Website**
   - In your PHP website, add link to prediction:
   ```html
   <a href="https://yourusername.pythonanywhere.com">Match Prediction</a>
   ```

---

## 🎯 ALTERNATIVE OPTIONS

### **Option 2: 000webhost (All-in-One, PHP Only)**

**Features:**
- ✅ Free PHP + MySQL hosting
- ✅ 300MB storage
- ✅ 3GB bandwidth
- ✅ Free subdomain
- ❌ No Python support (ML model won't work)

**Best for:** If you want to deploy only the PHP website without ML predictions

**Steps:**
1. Sign up: https://www.000webhost.com
2. Create website
3. Upload files via File Manager
4. Import database via phpMyAdmin
5. Update configuration

---

### **Option 3: Heroku (Requires Credit Card)**

**Features:**
- ✅ PHP support (with buildpack)
- ✅ Python support
- ✅ PostgreSQL database (not MySQL)
- ⚠️ Requires credit card (but free tier available)
- ⚠️ Sleeps after 30 min inactivity

**Note:** Heroku removed free tier in 2022, now requires payment method

---

### **Option 4: Render.com (Modern Alternative)**

**Features:**
- ✅ Free tier available
- ✅ Python support
- ✅ PostgreSQL database
- ❌ No PHP support (need to convert to Python/Node.js)

**Best for:** If you want to rewrite the project in Python (Django/Flask)

---

## 📝 STEP-BY-STEP: InfinityFree Setup (Detailed)

### **1. Prepare Your Files**

Before uploading, make these changes:

**A. Update Database Configuration**
```php
// Configuration/ini.php
define('SERVERHOST', 'sql123.infinityfreeapp.com');
define('SERVERUNAME', 'epiz_12345678');
define('SERVERPASSWORD', 'your_db_password');
define('SERVERDB', 'epiz_12345678_wolaita');
```

**B. Update File Paths**
- Change absolute paths to relative paths
- Example: `C:\xampp\htdocs\` → `./`

**C. Remove Local References**
- Remove `localhost` references
- Update to your new domain

### **2. Upload Process**

**Method 1: File Manager (Recommended)**
1. Login to cPanel
2. Open File Manager
3. Go to `htdocs` folder
4. Click "Upload"
5. Select all files and folders
6. Wait for upload to complete

**Method 2: FTP (Faster for large files)**
1. Download FileZilla: https://filezilla-project.org
2. Get FTP credentials from InfinityFree
3. Connect via FTP
4. Upload all files to `htdocs`

### **3. Database Setup**

**A. Create Database**
```
Database Name: epiz_12345678_wolaita
Database User: epiz_12345678
Password: (create strong password)
```

**B. Import SQL File**
1. Open phpMyAdmin
2. Select database
3. Click "Import" tab
4. Choose `wolaita_dichafcdb.sql`
5. Click "Go"
6. Wait for import (may take 2-5 minutes)

**C. Verify Tables**
- Check if all 11 tables are created
- Verify data is imported

### **4. Test Everything**

**Test Checklist:**
- [ ] Homepage loads
- [ ] Login works
- [ ] Registration works
- [ ] Dashboard displays
- [ ] Player list shows
- [ ] Match list shows
- [ ] Profile picture upload works
- [ ] Email sending works (if configured)

---

## 🔧 COMMON ISSUES & FIXES

### **Issue 1: Database Connection Failed**

**Error:** "Database Connection Failed"

**Fix:**
```php
// Check Configuration/ini.php
// Use exact credentials from InfinityFree
define('SERVERHOST', 'sql123.infinityfreeapp.com'); // Not localhost!
```

### **Issue 2: File Upload Not Working**

**Error:** "Failed to upload file"

**Fix:**
```php
// Check folder permissions
// In cPanel File Manager, right-click folder
// Set permissions to 755 or 777
```

### **Issue 3: Email Not Sending**

**Error:** "Could not send email"

**Fix:**
- InfinityFree blocks some email functions
- Use external SMTP (Gmail, SendGrid)
- Update PHPMailer configuration

### **Issue 4: Session Not Working**

**Error:** "Session timeout"

**Fix:**
```php
// Add at top of each page
session_start();
// Check session path is writable
```

### **Issue 5: CSS/JS Not Loading**

**Error:** Broken layout

**Fix:**
```html
<!-- Use relative paths -->
<link href="assets/css/style.css" rel="stylesheet">
<!-- Not: /assets/css/style.css -->
```

---

## 📧 EMAIL CONFIGURATION (Free SMTP)

### **Option 1: Gmail SMTP**

```php
// MailerSrc/PHPMailer/constant.php
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'your-email@gmail.com');
define('MAIL_PASSWORD', 'your-app-password'); // Not regular password!
define('MAIL_ENCRYPTION', 'tls');
```

**Get Gmail App Password:**
1. Go to Google Account settings
2. Security → 2-Step Verification
3. App passwords
4. Generate password for "Mail"

### **Option 2: SendGrid (Better for production)**

- Sign up: https://sendgrid.com (Free 100 emails/day)
- Get API key
- Use SendGrid SMTP settings

---

## 🐍 PYTHON ML MODEL DEPLOYMENT

### **PythonAnywhere Detailed Setup**

**1. File Structure**
```
/home/yourusername/
├── main2.py
├── templates/
│   └── main2.html
├── wolaita_dicha_recent_match.csv
└── future_matches.csv
```

**2. Update CSV Paths in main2.py**
```python
# Change from:
RECENT_CSV = "wolaita_dicha_recent_match.csv"

# To:
RECENT_CSV = "/home/yourusername/wolaita_dicha_recent_match.csv"
```

**3. Install Requirements**
```bash
pip3 install --user flask==2.3.0
pip3 install --user pandas==1.5.3
pip3 install --user scikit-learn==1.2.2
pip3 install --user numpy==1.24.3
```

**4. Test Locally First**
```bash
python3 main2.py
# Visit: https://yourusername.pythonanywhere.com
```

---

## 💰 COST COMPARISON

| Service | PHP | Python | Database | Storage | Cost |
|---------|-----|--------|----------|---------|------|
| InfinityFree | ✅ | ❌ | MySQL | 5GB | FREE |
| PythonAnywhere | ❌ | ✅ | ❌ | 512MB | FREE |
| 000webhost | ✅ | ❌ | MySQL | 300MB | FREE |
| Heroku | ✅ | ✅ | PostgreSQL | 512MB | $5-7/mo |
| Render | ❌ | ✅ | PostgreSQL | 512MB | FREE |

**Recommended Combo:** InfinityFree + PythonAnywhere = **100% FREE**

---

## 🎓 BEST PRACTICES

### **Before Deployment:**

1. **Backup Everything**
   - Export database
   - Zip all files
   - Save locally

2. **Test Locally**
   - Fix all errors
   - Test all features
   - Check mobile responsiveness

3. **Security Check**
   - Change default passwords
   - Update reCAPTCHA keys
   - Remove debug code

4. **Optimize**
   - Compress images
   - Minify CSS/JS
   - Remove unused files

### **After Deployment:**

1. **Monitor**
   - Check error logs
   - Test all features
   - Monitor uptime

2. **Update**
   - Keep software updated
   - Fix bugs promptly
   - Add new features

3. **Backup**
   - Regular database backups
   - Download files weekly
   - Keep version history

---

## 📱 CUSTOM DOMAIN (Optional)

### **Free Domain Options:**

1. **Freenom** (Free .tk, .ml, .ga domains)
   - Website: https://www.freenom.com
   - Free for 12 months
   - Can renew for free

2. **Use Subdomain**
   - yoursite.infinityfreeapp.com (Free)
   - yourname.pythonanywhere.com (Free)

### **Connect Custom Domain:**

1. Buy domain (or use free from Freenom)
2. In InfinityFree, go to "Addon Domains"
3. Add your domain
4. Update DNS nameservers:
   ```
   ns1.byet.org
   ns2.byet.org
   ```
5. Wait 24-48 hours for propagation

---

## 🔒 SSL CERTIFICATE (HTTPS)

**InfinityFree:**
- Free SSL included
- Auto-enabled for all sites
- No configuration needed

**PythonAnywhere:**
- Free SSL for .pythonanywhere.com subdomain
- Custom domain SSL requires paid plan

---

## 📊 MONITORING & ANALYTICS

### **Free Tools:**

1. **Google Analytics**
   - Track visitors
   - See user behavior
   - Free forever

2. **UptimeRobot**
   - Monitor uptime
   - Get alerts if site goes down
   - Free for 50 monitors

3. **Google Search Console**
   - SEO monitoring
   - Index your site
   - Free

---

## 🎯 QUICK START CHECKLIST

- [ ] Sign up for InfinityFree
- [ ] Create hosting account
- [ ] Upload PHP files
- [ ] Create MySQL database
- [ ] Import SQL file
- [ ] Update configuration
- [ ] Test website
- [ ] Sign up for PythonAnywhere
- [ ] Upload Python files
- [ ] Install libraries
- [ ] Create Flask app
- [ ] Test ML predictions
- [ ] Link both sites together
- [ ] Test everything end-to-end
- [ ] Share your live URL!

---

## 🆘 SUPPORT & HELP

**InfinityFree Support:**
- Forum: https://forum.infinityfree.net
- Knowledge Base: https://infinityfree.net/support

**PythonAnywhere Support:**
- Forum: https://www.pythonanywhere.com/forums
- Help: https://help.pythonanywhere.com

**General Help:**
- Stack Overflow
- YouTube tutorials
- GitHub issues

---

## 🎉 FINAL NOTES

**Your Live URLs will be:**
- Main Website: `https://wolaita-dicha.infinityfreeapp.com`
- ML Predictions: `https://yourusername.pythonanywhere.com`

**Total Cost:** $0.00 (100% FREE!)

**Limitations:**
- InfinityFree: Some PHP functions restricted, daily hits limit
- PythonAnywhere: CPU seconds limit, sleeps after inactivity

**For Production (Paid):**
- Consider: Hostinger ($2/mo), Namecheap ($3/mo), DigitalOcean ($5/mo)
- Better performance, support, and reliability

---

**Good luck with your deployment! 🚀**

If you need help, feel free to ask!
