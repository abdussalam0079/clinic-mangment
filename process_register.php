<?php
/**
 * process_register.php — Task 2: Process Patient Registration
 *
 * Receives POST data from register.php.
 * Sanitizes inputs, calculates age, assigns age category,
 * and displays a styled confirmation card.
 */

$pageTitle = 'Registration Confirmation';

/* ── Only allow POST requests ─────────────────────────────── */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

/* ── Sanitize & collect inputs ───────────────────────────── */
// trim() strips whitespace; htmlspecialchars() prevents XSS on output
$fullName       = trim($_POST['full_name']       ?? '');
$dob            = trim($_POST['dob']             ?? '');
$gender         = trim($_POST['gender']          ?? '');
$bloodType      = trim($_POST['blood_type']      ?? '');
$phone          = trim($_POST['phone']           ?? '');
$email          = trim($_POST['email']           ?? '');
$address        = trim($_POST['address']         ?? '');
$emergencyName  = trim($_POST['emergency_name']  ?? '');
$emergencyPhone = trim($_POST['emergency_phone'] ?? '');
$notes          = trim($_POST['notes']           ?? '');

/* ── Server-side validation ──────────────────────────────── */
$errors = [];

if ($fullName === '') {
    $errors[] = "Full name is required.";
} elseif (strlen($fullName) < 2) {
    $errors[] = "Full name must be at least 2 characters.";
}

if ($dob === '') {
    $errors[] = "Date of birth is required.";
} else {
    $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
    $today   = new DateTime();
    if (!$dobDate || $dobDate > $today) {
        $errors[] = "Please enter a valid date of birth (not in the future).";
    }
}

if ($gender === '') {
    $errors[] = "Gender selection is required.";
}

if ($phone === '') {
    $errors[] = "Phone number is required.";
} elseif (!preg_match('/^[\d\s\+\-\(\)]{7,20}$/', $phone)) {
    $errors[] = "Please enter a valid phone number.";
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}

/* ── If errors → redirect back (store in session) ────────── */
if (!empty($errors)) {
    // Use query string to pass error back (no session needed for this simple flow)
    session_start();
    $_SESSION['reg_errors'] = $errors;
    $_SESSION['reg_old']    = $_POST; // retain old values
    header('Location: register.php');
    exit;
}

/* ── Age calculation ─────────────────────────────────────── */
$dobObj    = new DateTime($dob);
$today     = new DateTime();
$ageInterval = $today->diff($dobObj);
$age       = $ageInterval->y; // years only

/* ── Age category logic ──────────────────────────────────── */
if ($age < 13) {
    $ageCategory      = "Child";
    $categoryBadge    = "badge-info";
    $categoryNote     = "Paediatric care recommended.";
} elseif ($age < 18) {
    $ageCategory      = "Teenager";
    $categoryBadge    = "badge-primary";
    $categoryNote     = "Adolescent health programs available.";
} elseif ($age < 60) {
    $ageCategory      = "Adult";
    $categoryBadge    = "badge-success";
    $categoryNote     = "Standard adult care applies.";
} else {
    $ageCategory      = "Senior";
    $categoryBadge    = "badge-warning";
    $categoryNote     = "Senior wellness program recommended.";
}

/* ── Generate patient ID ─────────────────────────────────── */
$patientId = 'CCC-' . strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $fullName), 0, 3)) . '-' . rand(1000, 9999);

/* ── Registration timestamp ──────────────────────────────── */
$registeredAt = date('l, F j, Y \a\t g:i A');

include 'includes/header.php';
?>

<div class="page-wrapper">
<div class="container">

  <!-- Success confirmation card -->
  <div class="card fade-in" style="max-width:720px; margin:0 auto;">

    <!-- Success icon + heading -->
    <div class="success-card" style="padding-bottom:24px; padding-top:24px;">
      <div class="success-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
      <h2 class="page-title" style="font-size:1.5rem;">Patient Registered Successfully!</h2>
      <p class="text-muted mt-2">The patient record has been created. Please save the Patient ID below.</p>
    </div>

    <!-- Patient ID box -->
    <div class="ref-box">
      <div class="ref-label">Patient ID</div>
      <div class="ref-number" id="refNumber"><?php echo htmlspecialchars($patientId); ?></div>
      <div class="text-muted text-sm mt-2">Registered on <?php echo htmlspecialchars($registeredAt); ?></div>
    </div>

    <div class="card-divider"></div>

    <!-- Patient details grid -->
    <h3 class="card-title" style="margin-bottom:16px;">Registration Details</h3>

    <div class="info-grid">

      <div class="info-item">
        <div class="info-item-label">Full Name</div>
        <div class="info-item-value"><?php echo htmlspecialchars($fullName); ?></div>
      </div>

      <div class="info-item">
        <div class="info-item-label">Date of Birth</div>
        <div class="info-item-value">
          <?php echo htmlspecialchars(date('F j, Y', strtotime($dob))); ?>
        </div>
      </div>

      <div class="info-item">
        <div class="info-item-label">Age</div>
        <div class="info-item-value"><?php echo $age; ?> years old</div>
      </div>

      <div class="info-item">
        <div class="info-item-label">Age Category</div>
        <div class="info-item-value">
          <span class="badge <?php echo htmlspecialchars($categoryBadge); ?>">
            <?php echo htmlspecialchars($ageCategory); ?>
          </span>
          <div class="text-sm text-muted mt-1"><?php echo htmlspecialchars($categoryNote); ?></div>
        </div>
      </div>

      <div class="info-item">
        <div class="info-item-label">Gender</div>
        <div class="info-item-value"><?php echo htmlspecialchars($gender); ?></div>
      </div>

      <?php if ($bloodType !== ''): ?>
      <div class="info-item">
        <div class="info-item-label">Blood Type</div>
        <div class="info-item-value">
          <span class="badge badge-error"><?php echo htmlspecialchars($bloodType); ?></span>
        </div>
      </div>
      <?php endif; ?>

      <div class="info-item">
        <div class="info-item-label">Phone</div>
        <div class="info-item-value"><?php echo htmlspecialchars($phone); ?></div>
      </div>

      <?php if ($email !== ''): ?>
      <div class="info-item">
        <div class="info-item-label">Email</div>
        <div class="info-item-value"><?php echo htmlspecialchars($email); ?></div>
      </div>
      <?php endif; ?>

      <?php if ($address !== ''): ?>
      <div class="info-item" style="grid-column: 1 / -1;">
        <div class="info-item-label">Address</div>
        <div class="info-item-value"><?php echo htmlspecialchars($address); ?></div>
      </div>
      <?php endif; ?>

    </div><!-- end info-grid -->

    <?php if ($emergencyName !== '' || $emergencyPhone !== ''): ?>
    <div class="card-divider"></div>
    <h3 class="card-title" style="margin-bottom:12px; font-size:0.95rem;">Emergency Contact</h3>
    <div class="info-grid">
      <?php if ($emergencyName !== ''): ?>
      <div class="info-item">
        <div class="info-item-label">Name</div>
        <div class="info-item-value"><?php echo htmlspecialchars($emergencyName); ?></div>
      </div>
      <?php endif; ?>
      <?php if ($emergencyPhone !== ''): ?>
      <div class="info-item">
        <div class="info-item-label">Phone</div>
        <div class="info-item-value"><?php echo htmlspecialchars($emergencyPhone); ?></div>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($notes !== ''): ?>
    <div class="card-divider"></div>
    <h3 class="card-title" style="margin-bottom:8px; font-size:0.95rem;">Additional Notes</h3>
    <p style="font-size:0.875rem; color:var(--muted); line-height:1.6;">
      <?php echo nl2br(htmlspecialchars($notes)); ?>
    </p>
    <?php endif; ?>

    <div class="card-divider"></div>

    <!-- Action buttons -->
    <div class="d-flex gap-3 flex-wrap">
      <a href="appointment.php" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        Book Appointment
      </a>
      <a href="register.php" class="btn btn-outline">Register Another</a>
      <button id="printPage" class="btn btn-ghost">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
          <polyline points="6 9 6 2 18 2 18 9"/>
          <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
          <rect x="6" y="14" width="12" height="8"/>
        </svg>
        Print Record
      </button>
      <button id="copyRef" class="btn btn-ghost">Copy ID</button>
    </div>

  </div><!-- end card -->

</div>
</div>

<?php include 'includes/footer.php'; ?>
