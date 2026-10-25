# Aadhaar Enrolment Acknowledgement Slip Platform & V-UCL Integration

A comprehensive, production-ready web application and management platform for generating standardized Unique Identification Authority of India (UIDAI) Aadhaar enrolment and update acknowledgement slips. Built with high-fidelity client-side PDF rendering, multi-lingual support, SID (Enrolment Number) barcode generation, and robust backend integration architecture supporting legacy V-UCL (Aadhaar Update Client Lite) systems.

---

## 🚀 Key Features

### 1. Aadhaar Acknowledgement Slip Form & Generator
- **Precise A4 Print & PDF Layout**: Pixel-perfect layout adhering to official UIDAI acknowledgment slip specifications (dimensions, typography, borders, and spacing).
- **SID (Enrolment Number) Support & Barcode Generation**: Dynamic generation of 28-digit SID/Enrolment numbers with automated **PDF417 barcode encoding** using `bwip-js`.
- **Multi-Language Template Engine**: Full support for regional languages including Hindi (हिन्दी), Bengali (বাংলা), and Telugu (తెలుగు) with localized titles, consent sentences, and disclosures.
- **Smart Biometric & Age Mode Detection**: Automatic detection of resident age from Date of Birth (calculating 18+ adult hand fingerprint quality blocks vs. minor exemption notes).
- **Comprehensive Data Fields**:
  - Resident Name & Gender with Regional Scripting
  - Full Address (English & Regional Script) & Relationship/Care-Of details
  - Date of Birth with Birth Certificate statutory reference notes
  - Contact details (Mobile, Email) and Document proof checklist
  - Information Sharing Disclosure & Biometrics Captured summary
  - Registrar, Enrolment Agency, and Location ID (Latitude/Longitude)
  - Consent block with Head of Family (HoF) Name and UID mapping
  - Detailed **Cash Receipt** table with service breakdowns (New Enrolment, Mandatory Biometric Update, Demographic Update, Biometric Update) and 18% GST calculation.
  - Operator, Resident, and Receipt Signatures

### 2. Legacy V-UCL Classic PHP Integration
- Designed to integrate seamlessly with **V-UCL (Aadhaar Update Client Lite)** classic PHP backend environments.
- Supports legacy session handling, data synchronization, and client-server payload formatting for offline/online enrolment stations.

### 3. Managed Hosting Installer (`install.php`)
- Automated guided setup script for managed hosting environments.
- Performs automatic database connection validation, table schema creation, directory permission checks, and environment configuration.

### 4. Database Migrations & Management
- Structured SQL migration scripts and database initialization routines for managing resident enrolment logs, transaction receipts, audit trails, and operator credentials.

### 5. Authentication & Security
- Secure operator session management and role-based access control (RBAC).
- Protection against unauthorized data access during enrolment data entry and receipt generation.

### 6. Administration Panel
- Centralized management dashboard for operators and administrators.
- Monitor daily enrolment counts, search transaction records, verify receipt numbers, manage agency/registrar mappings, and audit operator activity.

---

## 📁 Project Structure

```text
├── index.html          # Main acknowledgement form UI & printable A4 stage layout
├── app.js              # Application controller, i18n, sample data, state sync, and PDF/barcode handlers
├── style.css           # Print & screen stylesheets optimized for A4 (210mm x 297mm)
├── assets/             # Government emblems, UIDAI logo, hand gesture diagrams, and sample portraits
│   ├── emblem.jpeg     # National Emblem of India placeholder
│   ├── aalogo.jpeg     # Aadhaar / UIDAI logo
│   ├── left-hand.png   # Left hand fingerprint quality template
│   ├── right-hand.png  # Right hand fingerprint quality template
│   └── photo_*.jpg     # Pre-loaded sample resident photos
└── vendor/             # Third-party client-side libraries
    ├── html2pdf.bundle.min.js # Html2pdf wrapper for client-side PDF export
    ├── bwip-js-min.js         # Barcode writer in JavaScript (PDF417 support)
    └── JsBarcode.all.min.js   # Linear barcode utilities
```

---

## 🛠️ Technology Stack

- **Frontend**: HTML5, CSS3, Vanilla JavaScript (ES6+), Grid & Flexbox layouts.
- **PDF Generation**: `html2pdf.js` (html2canvas + jsPDF).
- **Barcode Rendering**: `bwip-js` (PDF417 2D barcode generation).
- **Backend / Integration**: PHP (Legacy V-UCL integration & `install.php` installer scripts), SQL database migrations.

---

## 🚀 Getting Started

### Local Development / Frontend Preview
1. Clone or download the repository.
2. Serve the directory using any static web server (e.g., Live Server in VS Code, Python HTTP server, or PHP built-in server):
   ```bash
   php -S localhost:8000
   ```
3. Open `http://localhost:8000` in your browser.
4. Use the sidebar controls to fill in resident details, upload photos, switch languages, or click pre-loaded sample buttons (**Nahid sample**, **Isha sample**, **Baljeet sample**) for instant preview.
5. Click **Download PDF** to export a high-resolution Aadhaar Enrolment Acknowledgement slip.

### Managed Hosting Installation
1. Upload the project files to your PHP-enabled web hosting server.
2. Navigate to `http://yourdomain.com/install.php` to run the automated managed installer.
3. Configure your MySQL/MariaDB database credentials and complete the setup wizard.
4. Access the Admin Panel using your provisioned administrator credentials.

---

## 📄 License

This project is proprietary and confidential. Unauthorized copying, distribution, or modification is strictly prohibited.
