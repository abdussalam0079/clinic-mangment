<?php
/**
 * step3.php — Task 6: Multi-Step Intake Form — Step 3
 *
 * - Displays full summary of steps 1 & 2
 * - Calculates BMI and classification
 * - On confirm → destroys session, shows success message,
 *   generates random reference number
 */

session_start();

// Guard: must have completed both steps
if (empty($_SESSION['step1']) || empty($_SESSION['step2'])) {
    header('Location: step1.php');
    exit;
}

$pageTitle = 'Intake Form — Review & Submit';

/* ── Pull session data ───────────────────────────────────── */
$s1 = $_SESSION['step1'];
$s2 = $_SESSION['step2'];

/* ── BMI Calculation ─────────────────────────────────────── */
$heightM  = (float)$s2['height'] / 100;  // convert cm → metres
$weightKg = (float)$s2['weight'];

// BMI = weight (kg) / height² (m²)
$bmi      = ($heightM > 0) ? round($weightKg / ($heightM * $heightM), 1) : 0;

// BMI classification
if ($bmi < 18.5) {
    $bmiClass    = 'Underweight';
    $bmiBadge    = 'badge-info';
    $bmiBarClass = 'underweight';
    $bmiBarWidth = min(($bmi / 18.5) * 30, 30);   // 0–30% of bar
    $bmiNote     = 'Consider a balanced diet and nutritional guidance.';
} elseif ($bmi < 25.0) {
    $bmiClass    = 'Normal weight';
    $bmiBadge    = 'badge-success';
    $bmiBarClass = 'normal';
    $bmiBarWidth = 30 + (($bmi - 18.5) / 6.5) * 25; // 30–55%
    $bmiNote     = 'Great! Maintain a healthy lifestyle.';
} elseif ($bmi < 30.0) {
    $bmiClass    = 'Overweight';
    $bmiBadge    = 'badge-warning';
    $bmiBarClass = 'overweight';
    $bmiBarWidth = 55 + (($bmi - 25) / 5) * 20; // 55–75%
    $bmiNote     = 'Consider dietary adjustments and regular exercise.';
} else {
    $bmiClass    = 'Obese';
    $bmiBadge    = 'badge-error';
    $bmiBarClass = 'obese';
    $bmiBarWidth = min(75 + (($bmi - 30) / 10) * 25, 100); // 75–100%
    $bmiNote     = 'Please consult with a doctor for a management plan.';
}

/* ── Handle final confirmation (POST) ────────────────────── */
$confirmed   = false;
$referenceNo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {

    // Generate random reference number BEFORE destroying session
    $referenceNo = 'INT-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 10));
    $submittedAt = date('l, F j, Y \a\t g:i A');

    // Destroy the session (clear all intake data)
    session_unset();
    session_destroy();

    $confirmed = true;
}

include 'includes/header.php';
?>

<div class="page-wrapper">
<div class="container">

  <!-- Page header -->
  <div class="page-header fade-in">
    <div class="page-header-badge">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
      Task 6 — Multi-Step Form
    </div>
    <h1 class="page-title">Patient Intake Form</h1>
    <p class="page-subtitle">Review your information before final submission.</p>
  </div>

  <div style="max-width:680px; margin:0 auto;">

    <?php if ($confirmed): ?>
      <!-- ═══ SUCCESS STATE ═══ -->
      <div class="card fade-in">
        <div class="success-card">
          <div class="success-icon" style="width:72px;height:72px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="34" height="34">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
          </div>
          <h2 class="page-title" style="font-size:1.6rem;">Intake Form Submitted!</h2>
          <p class="text-muted mt-2" style="max-width:400px; margin:8px auto 0;">
            Your intake form has been successfully submitted. Our team will review it before your appointment.
          </p>
        </div>

        <!-- Reference number -->
        <div class="ref-box">
          <div class="ref-label">Intake Reference Number</div>
          <div class="ref-number" id="refNumber"><?php echo htmlspecialchars($referenceNo); ?></div>
          <div class="text-muted text-sm mt-2">Submitted on <?php echo htmlspecialchars($submittedAt); ?></div>
        </div>

        <div class="alert alert-success" style="margin-top:16px;">
          <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          <div class="alert-content">
            Your session data has been securely cleared. Please keep your reference number for follow-up.
          </div>
        </div>

        <div class="card-divider"></div>

        <div class="d-flex gap-3 flex-wrap">
          <a href="appointment.php" class="btn btn-primary">Book Appointment</a>
          <a href="index.php" class="btn btn-ghost">← Dashboard</a>
          <button id="copyRef" class="btn btn-ghost">Copy Reference #</button>
        </div>
      </div>

    <?php else: ?>

      <!-- ═══ REVIEW STATE ═══ -->

      <!-- Step progress -->
      <div class="step-progress fade-in anim-delay-1">
        <div class="step-wrapper step-item done">
          <div class="step-circle done">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <div class="step-label">Personal Info</div>
        </div>
        <div class="step-line done"></div>
        <div class="step-wrapper step-item done">
          <div class="step-circle done">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <div class="step-label">Medical Info</div>
        </div>
        <div class="step-line done"></div>
        <div class="step-wrapper step-item active">
          <div class="step-circle active">3</div>
          <div class="step-label">Review</div>
        </div>
      </div>

      <!-- Personal info summary card -->
      <div class="card fade-in anim-delay-2" style="margin-bottom:20px;">
        <div class="d-flex flex-between align-center mb-4">
          <div class="card-title" style="margin-bottom:0;">Personal Information</div>
          <a href="step1.php" class="btn btn-sm btn-outline">Edit</a>
        </div>
        <div class="info-grid">
          <div class="info-item">
            <div class="info-item-label">Full Name</div>
            <div class="info-item-value">
              <?php echo htmlspecialchars($s1['first_name'] . ' ' . $s1['last_name']); ?>
            </div>
          </div>
          <div class="info-item">
            <div class="info-item-label">Date of Birth</div>
            <div class="info-item-value">
              <?php echo htmlspecialchars(date('F j, Y', strtotime($s1['dob']))); ?>
            </div>
          </div>
          <div class="info-item">
            <div class="info-item-label">Gender</div>
            <div class="info-item-value"><?php echo htmlspecialchars($s1['gender']); ?></div>
          </div>
          <div class="info-item">
            <div class="info-item-label">Phone</div>
            <div class="info-item-value"><?php echo htmlspecialchars($s1['phone']); ?></div>
          </div>
          <?php if (!empty($s1['email'])): ?>
          <div class="info-item">
            <div class="info-item-label">Email</div>
            <div class="info-item-value"><?php echo htmlspecialchars($s1['email']); ?></div>
          </div>
          <?php endif; ?>
          <?php if (!empty($s1['address'])): ?>
          <div class="info-item" style="grid-column: 1/-1;">
            <div class="info-item-label">Address</div>
            <div class="info-item-value"><?php echo htmlspecialchars($s1['address']); ?></div>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Medical info summary card -->
      <div class="card fade-in anim-delay-3" style="margin-bottom:20px;">
        <div class="d-flex flex-between align-center mb-4">
          <div class="card-title" style="margin-bottom:0;">Medical Information</div>
          <a href="step2.php" class="btn btn-sm btn-outline">Edit</a>
        </div>
        <div class="info-grid">
          <div class="info-item">
            <div class="info-item-label">Height</div>
            <div class="info-item-value"><?php echo htmlspecialchars($s2['height']); ?> cm</div>
          </div>
          <div class="info-item">
            <div class="info-item-label">Weight</div>
            <div class="info-item-value"><?php echo htmlspecialchars($s2['weight']); ?> kg</div>
          </div>
          <div class="info-item">
            <div class="info-item-label">Allergies</div>
            <div class="info-item-value">
              <?php echo htmlspecialchars(!empty($s2['allergies']) ? $s2['allergies'] : 'None reported'); ?>
            </div>
          </div>
          <div class="info-item">
            <div class="info-item-label">Smoking</div>
            <div class="info-item-value"><?php echo htmlspecialchars($s2['smoking']); ?></div>
          </div>
          <div class="info-item">
            <div class="info-item-label">Alcohol Use</div>
            <div class="info-item-value"><?php echo htmlspecialchars($s2['alcohol']); ?></div>
          </div>
          <?php if (!empty($s2['conditions'])): ?>
          <div class="info-item" style="grid-column:1/-1;">
            <div class="info-item-label">Pre-existing Conditions</div>
            <div class="info-item-value" style="display:flex; gap:6px; flex-wrap:wrap; margin-top:4px;">
              <?php foreach ($s2['conditions'] as $cond): ?>
                <span class="badge badge-warning"><?php echo htmlspecialchars($cond); ?></span>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>
          <?php if (!empty($s2['current_meds'])): ?>
          <div class="info-item" style="grid-column:1/-1;">
            <div class="info-item-label">Current Medications</div>
            <div class="info-item-value"><?php echo htmlspecialchars($s2['current_meds']); ?></div>
          </div>
          <?php endif; ?>
          <?php if (!empty($s2['surgeries'])): ?>
          <div class="info-item" style="grid-column:1/-1;">
            <div class="info-item-label">Past Surgeries / Hospitalizations</div>
            <div class="info-item-value"><?php echo htmlspecialchars($s2['surgeries']); ?></div>
          </div>
          <?php endif; ?>
        </div>

        <!-- BMI card (Task 6 requirement) -->
        <div class="card-divider"></div>
        <h3 class="card-title" style="margin-bottom:14px; font-size:0.95rem;">Body Mass Index (BMI)</h3>

        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:8px;">
          <div>
            <span style="font-family:'Figtree',sans-serif; font-size:2rem; font-weight:800; color:var(--text);">
              <?php echo $bmi; ?>
            </span>
            <span class="text-muted text-sm" style="margin-left:6px;">kg/m²</span>
          </div>
          <span class="badge <?php echo $bmiBadge; ?>" style="font-size:0.82rem; padding:6px 14px;">
            <?php echo htmlspecialchars($bmiClass); ?>
          </span>
        </div>

        <!-- BMI visual bar -->
        <div class="bmi-meter">
          <div
            class="bmi-fill <?php echo $bmiBarClass; ?>"
            data-width="<?php echo round($bmiBarWidth); ?>"
            style="width: 0%;"
          ></div>
        </div>

        <div class="d-flex flex-between" style="font-size:0.7rem; color:var(--muted); margin-top:4px;">
          <span>Underweight &lt;18.5</span>
          <span>Normal 18.5–24.9</span>
          <span>Overweight 25–29.9</span>
          <span>Obese ≥30</span>
        </div>

        <div class="alert alert-info" style="margin-top:14px; padding:10px 14px;">
          <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <div class="alert-content" style="font-size:0.82rem;">
            <?php echo htmlspecialchars($bmiNote); ?>
          </div>
        </div>

        <div style="font-size:0.75rem; color:var(--muted); margin-top:8px;">
          BMI Formula: weight (<?php echo htmlspecialchars($s2['weight']); ?> kg) ÷ height²
          (<?php echo $heightM; ?> m)² = <strong><?php echo $bmi; ?></strong>
        </div>

      </div><!-- end medical card -->

      <!-- Confirm submission form -->
      <div class="card fade-in anim-delay-4">
        <div class="card-title">Ready to Submit?</div>
        <div class="card-subtitle">
          Please review all information above. Once submitted, your session data will be cleared.
        </div>

        <div class="alert alert-warning" style="margin-bottom:20px;">
          <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/>
            <line x1="12" y1="17" x2="12.01" y2="17"/>
          </svg>
          <div class="alert-content">
            By clicking <strong>Confirm & Submit</strong>, you confirm that all information provided is accurate and complete.
          </div>
        </div>

        <form action="step3.php" method="POST">
          <input type="hidden" name="confirm" value="1" />
          <div class="d-flex flex-between align-center flex-wrap gap-3">
            <a href="step2.php" class="btn btn-ghost btn-lg">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                <polyline points="15 18 9 12 15 6"/>
              </svg>
              Back to Step 2
            </a>
            <button type="submit" class="btn btn-primary btn-lg">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
              Confirm &amp; Submit
            </button>
          </div>
        </form>

      </div><!-- end confirm card -->

    <?php endif; ?>

  </div>

</div>
</div>

<?php include 'includes/footer.php'; ?>
