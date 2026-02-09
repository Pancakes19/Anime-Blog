# 📝 Quinton’s Blog Website

A full-stack **PHP blog application** featuring secure user authentication, an admin dashboard, and dynamic content publishing.  
Built with clean PHP architecture, centralized session handling, and real-world hosting considerations.

---

## 🚀 Features

### 👤 Authentication & Authorization
- User signup and signin
- Secure password hashing using `password_hash()` and `password_verify()`
- Session-based authentication
- Admin role detection
- Proper logout with full session destruction
  
### 🛠 Admin Dashboard
- Add, edit, and delete blog posts
- Manage users
- Manage categories
- Upload and display user avatars
- Protected admin-only routes

### 📖 Blog Functionality
- View all blog posts
- Filter posts by category
- Individual post pages
- Dynamic content fetched from MySQL

### 🔐 Security
- Prepared statements (SQL injection protection)
- Session regeneration on login
- Centralized session bootstrap
- Role-based access control

---

## 🧰 Tech Stack
- **Frontend:** HTML5, CSS3, JavaScript  
- **Backend:** PHP (Procedural, MySQLi)  
- **Database:** MySQL  
- **Hosting:** InfinityFree  
- **Version Control:** Git & GitHub  

---

## 📁 Project Structure
