# Venus Cars – Web-Based Car Sales Application

This is the official repository for **Venus Cars**, a web-based car trading platform developed as part of the *Proyek Berbasis Pembelajaran (PBL)* course in the Informatics Engineering Study Program, Department of Informatics Engineering, Politeknik Negeri Batam.

## 🎥 Demo & Presentation Videos

- 📽️ **AAS Presentation**: [Watch on YouTube](https://youtu.be/YTQ31TIfkBg?si=6taJc82NuBjANB4v)  
- 📽️ **ATS Presentation**: [Watch on YouTube](https://youtu.be/ewwh3TE3lyk?si=Nefud2H52_xEkf5q)  
- 🎞️ **Product Demonstration**: [Watch on YouTube](https://youtu.be/90eOflVbOpo?si=5Cwjt-RvVxRrgb8U)  
- 📺 **All Features Explained!**: [Watch on YouTube](https://youtu.be/Dq1YVKdbofI?si=FOPYtZSYKDsSh1U-)

---

## 📁 Documentation

- 📂 **AAS Documents**: [Open Google Drive Folder](https://drive.google.com/drive/folders/1kdFlhHaBG9p1BQb1ac9227wTVZM8qhNw?usp=sharing)  
- 📂 **ATS Documents**: [Open Google Drive Folder](https://drive.google.com/drive/folders/1uMICl7Z-YArTyE_wBuG7Snr23ZVJ4xrV?usp=sharing)

---

## 🚘 About the Project

Venus Cars is an online platform that allows users to browse, filter, and purchase cars with various payment methods such as cash or credit. The system includes two main user roles: **Seller (Dealer)** and **Buyer (Customer)**, each with their own dashboard and functionality.

---

## 👥 Project Developers

This application was developed by the following students from Politeknik Negeri Batam:

- **Meiske Priskilla Sahertian** – Project Leader / 3312401001  
- **Marsha Olivia** – 3312401006  
- **Neli Fauziyah** – 3312401007 
- **Fitri Nabila** – 3312401012  

Supervised by: *Yeni Rokhayati, S.Si., M.Sc*

---

## ✅ Key Features

- 🔐 User registration & login (buyers & sellers)
- 🚗 Car browsing with filters and search
- 📄 Car detail view with image gallery & technical specifications
- 🧮 Purchase simulation (credit or cash) with adjustable DP and tenor
- 📤 Purchase submission form (requires login)
- 📊 Seller dashboard with product, order, and payment management
- 📥 Invoice generation and digital download
- 📈 Sales analytics and reporting for dealers

---

## 📋 Functional Requirements (Summary)

| Code  | Feature Name             | Actor     | Description                                                       |
|-------|--------------------------|-----------|-------------------------------------------------------------------|
| FR-1  | Register                 | Seller    | Seller can register a new account                                 |
| FR-2  | Login                    | Seller    | Seller can log in to manage products and orders                   |
| FR-5  | Manage Products          | Seller    | Add, update, delete, and view car products                        |
| FR-7  | View Incoming Orders     | Seller    | See and filter customer orders                                    |
| FR-10 | Verify Payment           | Seller    | Confirm buyer payments (cash or down payment)                     |
| FR-14 | View Dashboard           | Seller    | Filter sales data by date                                         |
| FR-15 | Sales Analytics          | Seller    | View performance charts and stats                                 |
| FR-17 | View Cars                | Buyer     | Browse all available and unavailable cars                         |
| FR-18 | Search & Filter Cars     | Buyer     | Filter by brand, category, year, price                            |
| FR-20 | Payment Simulation       | Buyer     | Simulate installment or cash payments                             |
| FR-28 | Submit Purchase          | Buyer     | Submit purchase request (credit or cash)                          |
| FR-30 | Make Payment             | Buyer     | Perform payments: down payment, cash, or installments             |
| FR-31 | Download Invoice         | Buyer     | Download purchase invoice in digital format                       |

> 📌 *For full functional requirement list, refer to the `https://drive.google.com/drive/folders/1kdFlhHaBG9p1BQb1ac9227wTVZM8qhNw?usp=sharing`.*

---

## ⚙️ Installation Guide

Follow these steps to run the project locally:

### 1. Clone the Repository

```bash
git clone https://github.com/godlovesmei/venus-cars.git
cd venus-cars
```

### 2. Install Dependencies

```bash
composer install
npm install && npm run dev
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` to match your local database configuration.

### 4. Run Database Migration

```bash
php artisan migrate
```

> Alternatively, you can manually import the provided `db_vcars.sql` file into your MySQL database (see the previous Google Drive AAS Documents link).

### 5. Run the Server

```bash
php artisan serve
```

Then access the app at:  
[http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🛡️ Non-Functional Requirements

- Codebase must be well-structured and maintainable (NFR-1)
- User interface must be user-friendly and intuitive (NFR-2 & NFR-3)
- App must be responsive on desktop, tablet, and mobile devices (NFR-4)

---

## 📄 License

This project is created solely for academic use as part of the PBL course.  
All rights reserved © 2025 by the Venus Cars team.
