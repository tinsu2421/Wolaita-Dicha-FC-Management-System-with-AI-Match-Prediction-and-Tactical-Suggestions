# Wolaita Dicha FC - Project Summary (Brief)

---

## 📋 WHAT IS THIS PROJECT?

A **Football Club Management System** for Wolaita Dicha FC that helps manage players, matches, and predicts match outcomes using AI.

---

## 🎯 MAIN FEATURES (7 Modules)

### 1. **User Management**
Different types of users can login: Admin, Secretary, Coach, Medical Staff, Technical Director, Players, and Fans. Each has different permissions.

### 2. **Player Management**
Register new players, track their information (height, position, nationality), and manage their status (active/pending).

### 3. **Match Management**
Schedule upcoming matches and record results of past matches.

### 4. **AI Match Prediction**
Uses machine learning to predict if the team will Win, Draw, or Lose based on statistics.

### 5. **Dashboards**
Each user type has their own dashboard showing relevant information.

### 6. **Email System**
Sends emails for registration, password reset, and notifications.

### 7. **Security**
Protects user data with passwords, session management, and prevents hacking attempts.

---

## 📚 LIBRARIES (Tools Used)

### **PHP (Backend - Server Side)**

**1. PHPMailer**
- What: Email sending tool
- Why: To send registration emails and password resets
- Like: A post office that delivers emails automatically

**2. PDO (PHP Data Objects)**
- What: Database connection tool
- Why: To safely read/write data to MySQL database
- Like: A secure messenger between your code and database

### **JavaScript/CSS (Frontend - User Interface)**

**3. Bootstrap**
- What: Design framework
- Why: Makes the website look professional and work on mobile phones
- Like: Pre-made building blocks for beautiful websites

**4. jQuery**
- What: JavaScript helper library
- Why: Makes forms interactive and validates user input
- Like: A toolbox that makes coding easier

**5. DataTables**
- What: Table enhancement plugin
- Why: Makes tables sortable, searchable, and paginated
- Like: Excel features for web tables

**6. ApexCharts**
- What: Chart/graph library
- Why: Shows statistics as beautiful graphs on dashboards
- Like: Converting numbers into visual charts

**7. Bootstrap Icons**
- What: Icon library
- Why: Adds small icons (like trash, edit, user symbols)
- Like: Emoji for professional websites

### **Python (Machine Learning)**

**8. Flask**
- What: Python web framework
- Why: Creates a web page where you can get match predictions
- Like: A mini web server for the AI model

**9. Pandas**
- What: Data analysis library
- Why: Reads CSV files and organizes match data
- Like: Excel for Python

**10. Scikit-learn**
- What: Machine learning library
- Why: Trains the AI model to predict match outcomes
- Like: The brain that learns from past matches

**11. NumPy**
- What: Math library
- Why: Does fast calculations for the AI model
- Like: A super calculator

---

## 🔒 SECURITY FEATURES (10 Protections)

### 1. **Session Management**
- What: Remembers who is logged in
- How: Uses PHP sessions
- Like: A ticket that proves you're allowed inside

### 2. **Password Encryption**
- What: Hides passwords so hackers can't read them
- How: Uses SHA-1 hashing
- Like: Converting "password123" into "7c4a8d09ca3762af61e59520943dc26494f8941b"

### 3. **SQL Injection Prevention**
- What: Stops hackers from stealing database data
- How: Uses prepared statements
- Like: A security guard checking every database request

### 4. **Input Validation**
- What: Checks if user input is correct
- How: JavaScript (client) + PHP (server) validation
- Like: A spell-checker for forms

### 5. **XSS Prevention**
- What: Stops hackers from injecting malicious code
- How: Escapes HTML special characters
- Like: Removing dangerous ingredients from food

### 6. **CSRF Protection**
- What: Prevents fake form submissions
- How: Hidden tokens in forms
- Like: A secret handshake to verify requests

### 7. **File Upload Security**
- What: Only allows safe image uploads
- How: Checks file type and size
- Like: Airport security for files

### 8. **Login Attempt Tracking**
- What: Records all login attempts
- How: Logs IP address, device, time
- Like: Security camera footage

### 9. **Error Handling**
- What: Catches errors gracefully
- How: Try-catch blocks
- Like: A safety net that prevents crashes

### 10. **reCAPTCHA**
- What: "I'm not a robot" checkbox
- How: Google reCAPTCHA on registration
- Like: A bouncer that blocks bots

---

## 🖥️ SERVERS (4 Types)

### 1. **Apache Web Server**
- What: Serves PHP web pages
- Port: 80 (http://localhost)
- Like: A waiter delivering web pages to browsers

### 2. **MySQL Database Server**
- What: Stores all data (users, players, matches)
- Port: 3306
- Like: A filing cabinet for all information

### 3. **Flask Python Server**
- What: Runs the AI prediction model
- Port: 5002 (http://localhost:5002)
- Like: A fortune teller for match outcomes

### 4. **SMTP Mail Server**
- What: Sends emails
- Used by: PHPMailer
- Like: A postal service for digital mail

---

## 🗄️ DATABASE (11 Tables)

Think of the database as a filing cabinet with 11 drawers:

1. **user_account** - Login credentials (email, password, role)
2. **user_details** - Personal info (name, phone, photo)
3. **playerregistration** - Player details (position, height, nationality)
4. **club_upcoming_matches** - Future matches scheduled
5. **club_match_results** - Past match scores
6. **user_attempts** - Login history (who tried to login when)
7. **injury_records** - Player injuries
8. **fan_registration** - Fan accounts
9. **contact_messages** - Messages from contact form
10. **schedules** - Training schedules
11. **settings** - System configuration

---

## 🤖 MACHINE LEARNING MODEL

### **What it does:**
Predicts if Wolaita Dicha will Win, Draw, or Lose a match.

### **How it works:**
1. **Learns from history**: Studies 92 past matches
2. **Looks at 9 factors**:
   - Goals scored/conceded (what you expect)
   - Shots taken
   - Ball possession %
   - Recent form (last 5 matches average)
   - Home or Away game
3. **Makes prediction**: Gives Win/Draw/Loss probabilities
4. **Gives advice**: Suggests tactics (attack, defend, etc.)

### **Accuracy:**
100% on test data (19 matches)

### **Example Output:**
- Win: 65%
- Draw: 25%
- Loss: 10%
- Advice: "High pressing and aggressive attacking style"

---

## 👥 USER ROLES (7 Types)

1. **Admin** - Full control, approves users
2. **Secretary** - Adds players and matches
3. **Coach** - Views players and schedules
4. **Medical Staff** - Manages injuries
5. **Technical Director** - Approves players
6. **Player** - Views own profile and matches
7. **Fan** - Views public information

---

## 🔄 HOW IT WORKS (Simple Flow)

### **For Users:**
1. Register → Admin approves → Login → Use dashboard

### **For Players:**
1. Secretary adds player → Admin approves → Player can login

### **For Match Prediction:**
1. Enter match details → AI analyzes → Get prediction + advice

### **For Matches:**
1. Secretary schedules match → Match happens → Secretary records result

---

## 💻 TECHNOLOGY STACK (Simple Terms)

**Frontend (What users see):**
- HTML/CSS - Structure and design
- JavaScript/jQuery - Interactive features
- Bootstrap - Beautiful responsive design

**Backend (Behind the scenes):**
- PHP - Server-side logic
- MySQL - Data storage
- Python/Flask - AI predictions

**Security:**
- Sessions - Remember logged-in users
- Encryption - Hide passwords
- Validation - Check user input

---

## 📊 PROJECT SIZE

- **Files**: 100+ PHP files, 1 Python file
- **Database**: 11 tables
- **Users**: 7 different roles
- **Features**: 20+ major features
- **Lines of Code**: ~15,000+ lines

---

## 🎓 LEARNING OUTCOMES

This project demonstrates:
1. **Full-stack development** (Frontend + Backend + Database)
2. **Machine Learning integration** (AI predictions)
3. **Security best practices** (Authentication, encryption)
4. **Role-based access control** (Different permissions)
5. **Email automation** (PHPMailer)
6. **Data visualization** (Charts and graphs)
7. **Responsive design** (Mobile-friendly)
8. **File handling** (Image uploads)
9. **API development** (Flask REST API)
10. **Database design** (Normalized tables)

---

## 🚀 QUICK START

1. **Install XAMPP** (Apache + MySQL + PHP)
2. **Import database** (wolaita_dichafcdb.sql)
3. **Start Apache & MySQL**
4. **Open browser**: http://localhost/Wolaita-Dicha-Fc
5. **For predictions**: Run `python main2.py` → http://localhost:5002

---

## 📝 SUMMARY IN ONE SENTENCE

**A complete football club management website with user accounts, player management, match scheduling, and AI-powered match predictions, built with PHP, MySQL, and Python.**

---

**Developed by**: CS Students  
**For**: Wolaita Dicha FC  
**Purpose**: Final Year Project / Capstone Project
