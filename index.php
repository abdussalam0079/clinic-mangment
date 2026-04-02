<?php
/**
 * index.php — Task 1: Dashboard
 *
 * Demonstrates PHP variables (string, int, float, bool),
 * dynamic year calculation, and conditional clinic status.
 */

$pageTitle = 'Dashboard';
include 'includes/header.php';

/* ── Clinic Data Variables (Task 1) ──────────────────────── */
$clinicName        = "City Care Clinic";          // string
$clinicAddress     = "42 Health Avenue, Downtown"; // string
$clinicPhone       = "+1 (800) 555-0192";          // string
$clinicEmail       = "info@citycareclinic.com";    // string
$establishedYear   = 2008;                          // int
$currentYear       = (int) date('Y');               // int — dynamic
$yearsInService    = $currentYear - $establishedYear; // int — calculated
$totalDoctors      = 18;                            // int
$totalPatients     = 4750;                          // int
$consultationFee   = 75.00;                         // float
$emergencyFee      = 149.99;                        // float
$isAccredited      = true;                          // bool
$isOpen24Hours     = false;                         // bool

/* ── Clinic Hours & Open/Closed Logic ────────────────────── */
$currentHour    = (int) date('G');   // 0–23 (24-hour, no leading zero)
$currentDay     = date('N');         // 1 = Monday … 7 = Sunday
$openingHour    = 8;                 // 08:00
$closingHour    = 20;                // 20:00

// Weekend (Sat=6, Sun=7) closes at 17:00
if ($currentDay >= 6) {
    $closingHour = 17;
}

// Determine if currently open
$isClinicOpen = ($currentHour >= $openingHour && $currentHour < $closingHour);

// Human-readable schedule
$scheduleWeekday  = "Mon – Fri: 8:00 AM – 8:00 PM";
$scheduleWeekend  = "Sat – Sun: 8:00 AM – 5:00 PM";
?>

<div class="page-wrapper">
<div class="container">

  <!-- Hero banner with live status -->
  <div class="hero-banner fade-in">
    <div class="hero-title">Welcome to <?php echo htmlspecialchars($clinicName); ?></div>
    <div class="hero-subtitle">
      Compassionate, modern healthcare since <?php echo $establishedYear; ?>.
      Serving the community for <strong><?php echo $yearsInService; ?> years</strong> with
      <?php echo $totalDoctors; ?> dedicated physicians.
    </div>

    <!-- Live open/closed badge -->
    <?php if ($isClinicOpen): ?>
      <div class="hero-status">
        <span class="dot dot-green"></span>
        Clinic is <strong>OPEN</strong> right now &mdash; Walk-ins welcome!
      </div>
    <?php else: ?>
      <div class="hero-status">
        <span class="dot dot-red"></span>
        Clinic is currently <strong>CLOSED</strong> &mdash; We open at <?php echo $openingHour; ?>:00 AM
      </div>
    <?php endif; ?>
  </div>

  <!-- Stats row -->
  <div class="stat-grid">

    <div class="stat-card fade-in anim-delay-1">
      <div class="stat-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
          <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
      </div>
      <div class="stat-info">
        <div class="stat-value"><?php echo number_format($totalPatients); ?>+</div>
        <div class="stat-label">Registered Patients</div>
      </div>
    </div>

    <div class="stat-card fade-in anim-delay-2">
      <div class="stat-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="8" r="4"/><path d="M12 2v2M12 14v8M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
        </svg>
      </div>
      <div class="stat-info">
        <div class="stat-value"><?php echo $totalDoctors; ?></div>
        <div class="stat-label">Specialist Doctors</div>
      </div>
    </div>

    <div class="stat-card fade-in anim-delay-3">
      <div class="stat-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="1" x2="12" y2="23"/>
          <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
        </svg>
      </div>
      <div class="stat-info">
        <div class="stat-value">$<?php echo number_format($consultationFee, 2); ?></div>
        <div class="stat-label">Consultation Fee</div>
      </div>
    </div>

    <div class="stat-card fade-in anim-delay-4">
      <div class="stat-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
      </div>
      <div class="stat-info">
        <div class="stat-value"><?php echo $yearsInService; ?> yrs</div>
        <div class="stat-label">Years of Service</div>
      </div>
    </div>

  </div><!-- end stat-grid -->

  <!-- Two-column: clinic info card + quick links -->
  <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; align-items:start;" class="responsive-two-col">

    <!-- Clinic info card -->
    <div class="card fade-in anim-delay-2">
      <div class="card-title">Clinic Information</div>
      <div class="card-subtitle">Current operating details</div>

      <div class="info-grid" style="grid-template-columns:1fr;">

        <div class="info-item">
          <div class="info-item-label">Address</div>
          <div class="info-item-value"><?php echo htmlspecialchars($clinicAddress); ?></div>
        </div>

        <div class="info-item">
          <div class="info-item-label">Phone</div>
          <div class="info-item-value"><?php echo htmlspecialchars($clinicPhone); ?></div>
        </div>

        <div class="info-item">
          <div class="info-item-label">Email</div>
          <div class="info-item-value"><?php echo htmlspecialchars($clinicEmail); ?></div>
        </div>

        <div class="info-item">
          <div class="info-item-label">Operating Hours</div>
          <div class="info-item-value" style="font-size:0.85rem; line-height:1.8;">
            <?php echo htmlspecialchars($scheduleWeekday); ?><br>
            <?php echo htmlspecialchars($scheduleWeekend); ?>
          </div>
        </div>

        <div class="info-item">
          <div class="info-item-label">Emergency Fee</div>
          <div class="info-item-value">$<?php echo number_format($emergencyFee, 2); ?></div>
        </div>

        <div class="info-item">
          <div class="info-item-label">Accreditation Status</div>
          <div class="info-item-value">
            <?php if ($isAccredited): ?>
              <span class="badge badge-success">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Fully Accredited
              </span>
            <?php else: ?>
              <span class="badge badge-error">Not Accredited</span>
            <?php endif; ?>
          </div>
        </div>

        <div class="info-item">
          <div class="info-item-label">24-Hour Service</div>
          <div class="info-item-value">
            <?php echo $isOpen24Hours
              ? '<span class="badge badge-success">Available</span>'
              : '<span class="badge badge-neutral">Not Available</span>'; ?>
          </div>
        </div>

      </div><!-- end info-grid -->

    </div><!-- end clinic info card -->

    <!-- Quick access links -->
    <div class="fade-in anim-delay-3">
      <div class="page-header">
        <div class="page-header-badge">Quick Access</div>
        <h2 class="page-title" style="font-size:1.3rem;">Navigate the System</h2>
      </div>

      <div class="quick-grid">

        <a href="register.php" class="quick-card">
          <div class="quick-card-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>
            </svg>
          </div>
          <div class="quick-card-title">Register Patient</div>
          <div class="quick-card-desc">Add new patient records</div>
        </a>

        <a href="appointment.php" class="quick-card">
          <div class="quick-card-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </div>
          <div class="quick-card-title">Book Appointment</div>
          <div class="quick-card-desc">Schedule a clinic visit</div>
        </a>

        <a href="schedule.php" class="quick-card">
          <div class="quick-card-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
          </div>
          <div class="quick-card-title">Doctor Schedule</div>
          <div class="quick-card-desc">View available doctors</div>
        </a>

        <a href="report.php" class="quick-card">
          <div class="quick-card-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
              <line x1="16" y1="13" x2="8" y2="13"/>
              <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
          </div>
          <div class="quick-card-title">Patient Report</div>
          <div class="quick-card-desc">Generate health reports</div>
        </a>

        <a href="step1.php" class="quick-card">
          <div class="quick-card-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
              <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
            </svg>
          </div>
          <div class="quick-card-title">Intake Form</div>
          <div class="quick-card-desc">Multi-step patient intake</div>
        </a>

      </div><!-- end quick-grid -->
    </div>

  </div><!-- end two-col -->

</div><!-- end container -->
</div><!-- end page-wrapper -->

<style>
  @media (max-width: 768px) {
    .responsive-two-col { grid-template-columns: 1fr !important; }
  }
</style>

<?php include 'includes/footer.php'; ?>
