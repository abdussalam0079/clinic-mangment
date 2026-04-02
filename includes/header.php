<?php
/**
 * header.php — Shared navigation header
 * Included at the top of every page.
 *
 * Each page sets $pageTitle before including this file.
 */

// Default title if not set
$pageTitle = isset($pageTitle) ? htmlspecialchars($pageTitle) : 'City Care Clinic';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="City Care Clinic — Patient & Appointment Management System" />
  <title><?php echo $pageTitle; ?> | City Care Clinic</title>

  <!-- Google Fonts: Figtree + Poppins + Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="assets/style.css" />
</head>
<body>

<!-- ═══════════════════════════════════════════
     NAVIGATION BAR
════════════════════════════════════════════ -->
<nav class="navbar">
  <div class="container navbar-inner">

    <!-- Logo -->
    <a href="index.php" class="nav-logo">
      <!-- Medical cross / clinic SVG icon -->
      <svg class="nav-logo-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="40" height="40" rx="10" fill="#4f46e5"/>
        <rect x="17" y="9" width="6" height="22" rx="2" fill="white"/>
        <rect x="9" y="17" width="22" height="6" rx="2" fill="white"/>
      </svg>
      <div>
        <span class="nav-logo-text">City<span>Care</span></span>
        <span class="nav-logo-sub">Clinic Management System</span>
      </div>
    </a>

    <!-- Desktop Nav Links -->
    <ul class="nav-links" id="navLinks">

      <li>
        <a href="index.php">
          <!-- Home icon -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
          </svg>
          Dashboard
        </a>
      </li>

      <li>
        <a href="register.php">
          <!-- User plus icon -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>
          </svg>
          Register Patient
        </a>
      </li>

      <li>
        <a href="appointment.php">
          <!-- Calendar icon -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/>
            <line x1="3" y1="10" x2="21" y2="10"/>
          </svg>
          Book Appointment
        </a>
      </li>

      <li>
        <a href="schedule.php">
          <!-- Clock icon -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
          Doctor Schedule
        </a>
      </li>

      <li>
        <a href="report.php">
          <!-- File text icon -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
          </svg>
          Reports
        </a>
      </li>

      <li>
        <a href="step1.php">
          <!-- Clipboard icon -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
          </svg>
          Intake Form
        </a>
      </li>

    </ul>

    <!-- Mobile hamburger -->
    <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
      <span></span>
      <span></span>
      <span></span>
    </button>

  </div>
</nav>
<!-- end .navbar -->
