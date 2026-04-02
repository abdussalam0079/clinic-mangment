<?php
/**
 * appointment.php — Task 3: Book Appointment
 *
 * Self-submitting form (action="appointment.php").
 * Validates: name ≥ 3 chars, date not in past, reason ≤ 200 chars.
 * Shows ALL errors together, retains form values on error.
 * On success → shows styled success card.
 */

$pageTitle = 'Book Appointment';

/* ── Default values (retain after errors) ────────────────── */
$name      = '';
$apptDate  = '';
$time      = '';
$doctor    = '';
$reason    = '';
$apptType  = '';

$errors    = [];
$submitted = false;

/* ── Handle POST submission ──────────────────────────────── */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect & sanitize inputs
    $name     = trim($_POST['name']       ?? '');
    $apptDate = trim($_POST['appt_date']  ?? '');
    $time     = trim($_POST['appt_time']  ?? '');
    $doctor   = trim($_POST['doctor']     ?? '');
    $reason   = trim($_POST['reason']     ?? '');
    $apptType = trim($_POST['appt_type']  ?? '');

    /* ── Validation rules ──────────────────────────────── */

    // 1. Name: required, minimum 3 characters
    if ($name === '') {
        $errors[] = "Patient name is required.";
    } elseif (strlen($name) < 3) {
        $errors[] = "Patient name must be at least 3 characters long.";
    }

    // 2. Date: required and must not be in the past
    if ($apptDate === '') {
        $errors[] = "Appointment date is required.";
    } else {
        $selectedDate = new DateTime($apptDate);
        $todayMidnight = new DateTime(date('Y-m-d'));
        if ($selectedDate < $todayMidnight) {
            $errors[] = "Appointment date cannot be in the past. Please select today or a future date.";
        }
    }

    // 3. Time: required
    if ($time === '') {
        $errors[] = "Appointment time is required.";
    }

    // 4. Doctor: required
    if ($doctor === '') {
        $errors[] = "Please select a doctor.";
    }

    // 5. Appointment type: required
    if ($apptType === '') {
        $errors[] = "Please select an appointment type.";
    }

    // 6. Reason: required, max 200 characters
    if ($reason === '') {
        $errors[] = "Reason for visit is required.";
    } elseif (strlen($reason) > 200) {
        $errors[] = "Reason for visit must not exceed 200 characters (currently " . strlen($reason) . ").";
    }

    // All validations passed → mark success
    if (empty($errors)) {
        $submitted = true;

        // Generate confirmation number
        $confirmationNo = 'APT-' . strtoupper(substr(md5(uniqid()), 0, 8));
        $submittedAt    = date('l, F j, Y \a\t g:i A');
    }
}

include 'includes/header.php';

/* ── Available doctors list ──────────────────────────────── */
$doctors = [
    "Dr. Sarah Mitchell (Cardiology)",
    "Dr. James Okonkwo (General Practice)",
    "Dr. Priya Sharma (Paediatrics)",
    "Dr. Liam Torres (Orthopaedics)",
    "Dr. Amara Hassan (Neurology)",
    "Dr. David Chen (Dermatology)",
];

/* ── Available time slots ────────────────────────────────── */
$timeSlots = [
    "08:00 AM", "08:30 AM", "09:00 AM", "09:30 AM",
    "10:00 AM", "10:30 AM", "11:00 AM", "11:30 AM",
    "12:00 PM", "01:00 PM", "01:30 PM", "02:00 PM",
    "02:30 PM", "03:00 PM", "03:30 PM", "04:00 PM",
    "04:30 PM", "05:00 PM",
];
?>

<div class="page-wrapper">
<div class="container">

  <!-- Page header -->
  <div class="page-header fade-in">
    <div class="page-header-badge">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      Task 3
    </div>
    <h1 class="page-title">Book an Appointment</h1>
    <p class="page-subtitle">Schedule your visit with one of our specialists.</p>
  </div>

  <div style="max-width:680px; margin:0 auto;">

    <?php if ($submitted): ?>
      <!-- ═══ SUCCESS STATE ═══ -->
      <div class="card fade-in">
        <div class="success-card">
          <div class="success-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
          </div>
          <h2 class="page-title" style="font-size:1.5rem;">Appointment Confirmed!</h2>
          <p class="text-muted mt-2">Your appointment has been successfully booked.</p>
        </div>

        <div class="ref-box">
          <div class="ref-label">Confirmation Number</div>
          <div class="ref-number" id="refNumber"><?php echo htmlspecialchars($confirmationNo); ?></div>
          <div class="text-muted text-sm mt-2"><?php echo htmlspecialchars($submittedAt); ?></div>
        </div>

        <div class="card-divider"></div>

        <div class="info-grid">
          <div class="info-item">
            <div class="info-item-label">Patient Name</div>
            <div class="info-item-value"><?php echo htmlspecialchars($name); ?></div>
          </div>
          <div class="info-item">
            <div class="info-item-label">Date</div>
            <div class="info-item-value"><?php echo htmlspecialchars(date('F j, Y', strtotime($apptDate))); ?></div>
          </div>
          <div class="info-item">
            <div class="info-item-label">Time</div>
            <div class="info-item-value"><?php echo htmlspecialchars($time); ?></div>
          </div>
          <div class="info-item">
            <div class="info-item-label">Doctor</div>
            <div class="info-item-value"><?php echo htmlspecialchars($doctor); ?></div>
          </div>
          <div class="info-item">
            <div class="info-item-label">Type</div>
            <div class="info-item-value">
              <span class="badge badge-primary"><?php echo htmlspecialchars($apptType); ?></span>
            </div>
          </div>
          <div class="info-item" style="grid-column: 1 / -1;">
            <div class="info-item-label">Reason for Visit</div>
            <div class="info-item-value"><?php echo htmlspecialchars($reason); ?></div>
          </div>
        </div>

        <div class="card-divider"></div>

        <div class="d-flex gap-3 flex-wrap">
          <a href="appointment.php" class="btn btn-primary">Book Another</a>
          <button id="printPage" class="btn btn-ghost">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
              <polyline points="6 9 6 2 18 2 18 9"/>
              <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
              <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Print
          </button>
          <button id="copyRef" class="btn btn-ghost">Copy #</button>
        </div>
      </div>

    <?php else: ?>
      <!-- ═══ FORM STATE ═══ -->

      <!-- Show ALL errors together (Task 3 requirement) -->
      <?php if (!empty($errors)): ?>
        <div class="alert alert-error fade-in" role="alert">
          <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <div class="alert-content">
            <div class="alert-title">Please fix the following errors:</div>
            <ul>
              <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endif; ?>

      <!-- Appointment form — self-submitting -->
      <div class="card fade-in">

        <div class="card-title">Appointment Details</div>
        <div class="card-subtitle">All fields marked <span style="color:var(--error)">*</span> are required.</div>

        <form action="appointment.php" method="POST" novalidate>

          <!-- Patient name -->
          <div class="form-group">
            <label class="form-label" for="name">
              Patient Name <span class="required">*</span>
            </label>
            <input
              type="text"
              id="name"
              name="name"
              class="form-control <?php echo (!empty($errors) && (strlen($name) < 3 || $name === '')) ? 'is-invalid' : ''; ?>"
              placeholder="Enter full patient name"
              value="<?php echo htmlspecialchars($name); ?>"
              minlength="3"
              maxlength="100"
            />
            <?php if (!empty($errors) && strlen($name) < 3): ?>
              <div class="field-error">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Minimum 3 characters required.
              </div>
            <?php endif; ?>
          </div>

          <!-- Date + Time -->
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="appointment_date">
                Appointment Date <span class="required">*</span>
              </label>
              <input
                type="date"
                id="appointment_date"
                name="appt_date"
                class="form-control <?php echo (!empty($errors) && $apptDate === '') ? 'is-invalid' : ''; ?>"
                value="<?php echo htmlspecialchars($apptDate); ?>"
                min="<?php echo date('Y-m-d'); ?>"
              />
            </div>
            <div class="form-group">
              <label class="form-label" for="appt_time">
                Preferred Time <span class="required">*</span>
              </label>
              <select
                id="appt_time"
                name="appt_time"
                class="form-control <?php echo (!empty($errors) && $time === '') ? 'is-invalid' : ''; ?>"
              >
                <option value="">— Select Time —</option>
                <?php foreach ($timeSlots as $slot): ?>
                  <option value="<?php echo htmlspecialchars($slot); ?>"
                    <?php echo ($time === $slot) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($slot); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Doctor + Type -->
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="doctor">
                Select Doctor <span class="required">*</span>
              </label>
              <select
                id="doctor"
                name="doctor"
                class="form-control <?php echo (!empty($errors) && $doctor === '') ? 'is-invalid' : ''; ?>"
              >
                <option value="">— Choose a doctor —</option>
                <?php foreach ($doctors as $doc): ?>
                  <option value="<?php echo htmlspecialchars($doc); ?>"
                    <?php echo ($doctor === $doc) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($doc); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label" for="appt_type">
                Appointment Type <span class="required">*</span>
              </label>
              <select
                id="appt_type"
                name="appt_type"
                class="form-control <?php echo (!empty($errors) && $apptType === '') ? 'is-invalid' : ''; ?>"
              >
                <option value="">— Select Type —</option>
                <?php
                $types = ["General Consultation", "Follow-up Visit", "Emergency", "Specialist Referral", "Routine Check-up", "Lab / Test Results"];
                foreach ($types as $t): ?>
                  <option value="<?php echo htmlspecialchars($t); ?>"
                    <?php echo ($apptType === $t) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($t); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Reason (max 200 chars) -->
          <div class="form-group">
            <label class="form-label" for="reason">
              Reason for Visit <span class="required">*</span>
            </label>
            <textarea
              id="reason"
              name="reason"
              class="form-control <?php echo (!empty($errors) && ($reason === '' || strlen($reason) > 200)) ? 'is-invalid' : ''; ?>"
              placeholder="Briefly describe your symptoms or reason for the visit…"
              rows="4"
              data-maxlength="200"
              data-counter="reasonCounter"
              maxlength="200"
            ><?php echo htmlspecialchars($reason); ?></textarea>
            <div class="form-hint" id="reasonCounter">200 characters remaining</div>
          </div>

          <!-- Submit -->
          <div class="card-divider"></div>
          <div class="d-flex gap-3 flex-wrap">
            <button type="submit" class="btn btn-primary btn-lg">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
              Confirm Appointment
            </button>
            <a href="index.php" class="btn btn-ghost btn-lg">Cancel</a>
          </div>

        </form>

      </div><!-- end card -->

    <?php endif; ?>

  </div><!-- end max-width wrapper -->

</div>
</div>

<?php include 'includes/footer.php'; ?>
