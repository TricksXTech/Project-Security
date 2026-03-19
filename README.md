# 🛡️ Lightweight PHP WAF (Web Application Firewall)

A simple yet powerful security layer for PHP applications that detects and blocks common web attacks in real-time.

---

## 🚀 Features

### ✅ Protection Against

* SQL Injection attempts
* Cross-Site Scripting (XSS)
* Bad bots (curl, python, wget, etc.)
* Rate limiting / spam requests
* Session hijacking attempts

---

### 📊 Logging System

* Logs all detected attacks
* Stores attacker IP addresses
* Saves payload data for analysis

---

## ⚙️ Installation

### 1. Include Security Engine

Add this line at the **top of every PHP file**:

```php
require_once "security.php";
```

---

### 2. Add Client-Side Protection

Include the JavaScript file before closing `</body>` tag:

```html
<script src="security.js"></script>
```

---

### 3. Upload Required Files

Make sure these files are in your project:

```
/security.php
/security.js
/report.php (optional for client logging)
/.htaccess (recommended)
```

---

## 🧠 How It Works

* Scans all incoming requests (`GET`, `POST`, `REQUEST`)
* Uses pattern detection + scoring system
* Tracks user behavior (rate, headers, session)
* Automatically blocks suspicious users
* Logs attack details for monitoring

---

## 🔐 What Gets Blocked

| Attack Type    | Detection Method           |
| -------------- | -------------------------- |
| SQL Injection  | Regex pattern matching     |
| XSS            | Script & event detection   |
| Bots           | User-Agent filtering       |
| Spam Requests  | Rate limiting              |
| Session Hijack | IP + User-Agent validation |

---

## 📁 Logs

Logs are stored locally:

```
logs.txt
client_logs.txt
blocked.json
rate.json
```

---

## ⚠️ Limitations

* ❌ Not full DDoS protection (network-level attacks require external services)
* ❌ Can be bypassed by advanced attackers
* ❌ Basic pattern detection (needs continuous improvement)

---

## 🚀 Future Improvements

* AI-based scoring system
* Advanced behavior analysis
* Centralized threat intelligence API
* Admin dashboard (real-time monitoring)
* Telegram / Email alerts
* Redis-based rate limiting (high performance)

---

## 🧑‍💻 Use Case

Best suited for:

* Small to medium PHP applications
* Developers looking for quick security integration
* Projects needing basic protection without heavy setup

---

## 📌 Disclaimer

This tool improves application security but does **not guarantee complete protection** against all types of attacks. For enterprise-level security, consider combining with network-level solutions.

---

## ⭐ Contributing

Feel free to fork, improve, and submit pull requests.

---

## 📄 License

MIT License

---

## 💬 Author

Built by a developer exploring real-world web security systems 🚀
