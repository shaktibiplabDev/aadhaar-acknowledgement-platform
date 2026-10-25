# V-UCL Laravel & Enrolment Management Platform

A high-performance, enterprise-grade web application and management platform built for UIDAI Aadhaar Enrolment Agencies, Operators, Distributors, and Retailers. It combines a robust Laravel backend with legacy PHP bridging, an automated managed hosting installer (`install.php`), advanced SID (Enrolment Number) cell tracking, multi-role access control, and client-side high-fidelity Aadhaar acknowledgement slip generation.

---

## 🌟 Key Features

### 1. Multi-Role Admin / Operator / Distributor / Retailer Panel
- **Role-Based Access Control (RBAC)**: Hierarchical access structure catering to:
  - **Administrator**: Complete system configuration, registrar/agency mappings, global audit logs, pricing rules, and operator commission management.
  - **Distributor**: Regional network management, retailer onboarding, wallet top-ups, and transaction volume reporting.
  - **Retailer / Enrolment Center**: Counter-level cash collection, service request logging, and daily reconciliation.
  - **Operator**: Biometric enrolment data entry, demographic updates, and acknowledgement slip generation.
- **Wallet & Commission System**: Automated ledger tracking for distributors and retailers with instant settlement and balance alerts.

### 2. Aadhaar Acknowledgement Slip Form & PDF Engine
- **UIDAI-Compliant A4 Layout**: Pixel-perfect layout adhering to official Unique Identification Authority of India (UIDAI) acknowledgment slip specifications (margins, typography, borders, and structured sections).
- **SID (Enrolment Number) Barcode Generation**: Dynamic generation of 28-digit SID/Enrolment numbers with automated **PDF417 2D barcode encoding** using `bwip-js`.
- **Multi-Language Template Engine**: Localized support for regional languages including Hindi (हिन्दी), Bengali (বাংলা), and Telugu (తెలుగు) with dynamic consent sentences and statutory disclosures.
- **Smart Age & Biometric Mode Detection**: Automatic detection of resident age from Date of Birth (calculating adult vs. minor biometric exemption rules).
- **Comprehensive Receipt Ledger**: Detailed cash receipt breakdown covering New Enrolments, Mandatory Biometric Updates, Demographic Updates, and statutory 18% GST calculation.

### 3. SID Cell Tracking & Lifecycle Management
- **Enrolment Tracking**: End-to-end tracking of Enrolment IDs (SIDs) across stages: `Registered`, `QC Verified`, `Synced to UIDAI`, `Generated`, and `Rejected/On Hold`.
- **Audit Trails**: Detailed event logging for every enrolment packet update, operator action, and verification check.

### 4. Managed Hosting Installer (`install.php`)
- **Automated Setup Wizard**: Guided installation script designed for cPanel, shared hosting, and VPS environments.
- **Automated Checks**: Validates PHP version, required extensions (`PDO`, `Mbstring`, `OpenSSL`, `JSON`), directory permissions (`storage`, `bootstrap/cache`), and database connectivity before running table migrations and seeders.

### 5. Legacy PHP Bridging
- **V-UCL Compatibility Layer**: Seamless integration bridge between modern Laravel architectural standards and legacy **V-UCL (Aadhaar Update Client Lite)** backend sync scripts and packet XML formatters.

---

## 📁 Project Structure

```text
├── app/                      # Laravel application source code (Controllers, Models, Middleware)
│   ├── Http/Controllers/     # Multi-role dashboard & API controllers
│   ├── Models/               # Enrolment, User, Wallet, and Transaction models
│   └── Services/             # V-UCL bridging & PDF/Barcode generation services
├── database/                 # Migrations, factories, and database seeders
├── public/                   # Public web root
│   ├── index.html            # Client-side acknowledgement form UI & printable A4 stage layout
│   ├── app.js                # Frontend controller, i18n, state sync, and PDF/barcode handlers
│   ├── style.css             # Print & screen stylesheets optimized for A4 (210mm x 297mm)
│   ├── install.php           # Managed hosting automated installer script
│   └── assets/               # Government emblems, UIDAI logo, hand gesture diagrams, and portraits
├── resources/                # Blade views and frontend assets
├── routes/                   # Web and API route definitions
└── vendor/                   # Composer dependencies & third-party libraries (bwip-js, html2pdf, etc.)
```

---

## 🛠️ Technology Stack

- **Backend**: PHP 8.1+, Laravel Framework, MySQL / MariaDB.
- **Frontend**: HTML5, CSS3, Vanilla JavaScript (ES6+), Blade templates.
- **PDF & Barcode**: `html2pdf.js` (html2canvas + jsPDF), `bwip-js` (PDF417 2D barcodes).
- **Hosting & Deployment**: Managed installer (`install.php`), Composer, Apache / Nginx.

---

## 🚀 Installation & Setup

### Method A: Managed Hosting Automated Installer (`install.php`)
1. Upload the project archive to your web server public directory.
2. Navigate in your browser to:
   ```text
   http://yourdomain.com/install.php
   ```
3. Follow the interactive setup wizard to configure database credentials, generate application keys, and create the initial administrator account.

### Method B: Manual Developer Setup (Local Environment)
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/shaktibiplabDev/aadhaar-acknowledgement-platform.git
   cd aadhaar-acknowledgement-platform
   ```
2. **Install Dependencies**:
   ```bash
   composer install
   ```
3. **Configure Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Configure Database**:
   Update your database settings in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=v_ucl_laravel
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```
5. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate --seed
   ```
6. **Start Development Server**:
   ```bash
   php artisan serve
   ```
   Access the application at `http://localhost:8000`.

---

## ⚙️ Configuration

Key configuration options in `.env`:
- `APP_NAME`: Platform name (default: V-UCL Enrolment Platform)
- `VUCL_AGENCY_CODE`: Registered UIDAI Enrolment Agency Code
- `VUCL_REGISTRAR_CODE`: UIDAI Registrar ID
- `VUCL_SYNC_MODE`: Operational mode (`offline` or `online` V-UCL bridge sync)

---

## 🔌 API Integration

The platform provides RESTful API endpoints for external V-UCL client applications and remote stations to synchronize enrolments, check packet status, and manage wallets.

### Authentication
Authenticate requests by passing a Bearer Token in the authorization header:
```http
Authorization: Bearer <your_api_token>
```

### Endpoints

#### 1. Submit Enrolment / Acknowledgment Packet
- **URL**: `/api/v1/enrolments`
- **Method**: `POST`
- **Payload**:
  ```json
  {
    "sid": "1234123451234567890123456789",
    "resident_name": "Rajesh Kumar",
    "gender": "M",
    "dob": "1990-05-15",
    "mobile": "9876543210",
    "operator_id": "OP1002",
    "enrolment_type": "new"
  }
  ```

#### 2. Check Enrolment Status (SID Tracking)
- **URL**: `/api/v1/enrolments/{sid}/status`
- **Method**: `GET`
- **Response**:
  ```json
  {
    "sid": "1234123451234567890123456789",
    "status": "QC_VERIFIED",
    "updated_at": "2026-10-25T10:30:00Z"
  }
  ```

---

## 📄 License

This project is proprietary and confidential. Unauthorized copying, distribution, or modification is strictly prohibited.
