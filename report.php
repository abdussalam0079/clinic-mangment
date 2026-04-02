<?php
/**
 * report.php — Task 5: Patient Report
 *
 * Demonstrates:
 * - strtoupper() on patient name
 * - preg_replace() to clean diagnosis text
 * - Medicines array → numbered list
 * - str_word_count() for word count
 * - Color-coded status badge
 * - Timestamp (date/time functions)
 */

$pageTitle = 'Patient Report';

/* ══════════════════════════════════════════════════════════
   SAMPLE PATIENT DATA
   (In production, this would come from a database or form)
   ══════════════════════════════════════════════════════════ */
$rawPatientName = "  john   michael   doe  ";   // messy spacing
$patientId      = "CCC-JOH-4821";
$patientAge     = 47;
$patientGender  = "Male";
$bloodType      = "O+";
$admissionDate  = "2025-09-14";
$wardNo         = "Ward 3-B";

/* ── Status options: Stable | Critical | Recovering | Discharged ── */
$patientStatus = "Recovering";

/* ── Raw diagnosis text (contains extra spaces, special chars) ── */
$rawDiagnosis = "  Patient   presents   with   hypertension!!   and   mild   
                  tachycardia???   Blood   pressure   readings   were   elevated 
                  at   145/92   mmHg.   Recommend   lifestyle   modifications   
                  and   pharmacological   intervention.  ";

/* ── Medicines array ─────────────────────────────────────── */
$medicines = [
    "Amlodipine 5mg — Once daily (morning)",
    "Atorvastatin 20mg — Once daily (night)",
    "Metoprolol 25mg — Twice daily",
    "Aspirin 81mg — Once daily (with food)",
    "Lisinopril 10mg — Once daily",
];

/* ── Doctor's notes (raw) ────────────────────────────────── */
$rawNotes = "  Patient   is   responding   well   to   treatment.   
              Follow-up   required   in   two   weeks.   
              Monitor   blood   pressure   daily.   
              Avoid   high-sodium   diet   and   strenuous   activity.  ";

/* ══════════════════════════════════════════════════════════
   STRING PROCESSING (Task 5 Requirements)
   ══════════════════════════════════════════════════════════ */

// 1. Convert patient name to UPPERCASE using strtoupper()
$patientNameUpper = strtoupper(trim($rawPatientName));
// Also create a title-case version for display
$patientNameDisplay = ucwords(strtolower(trim($rawPatientName)));

// 2. Clean diagnosis text using preg_replace():
//    a) Remove multiple spaces/newlines → single space
//    b) Remove repeated punctuation (!! → !, ??? → ?)
//    c) Trim leading/trailing whitespace
$cleanDiagnosis = preg_replace('/\s+/', ' ', $rawDiagnosis);         // collapse whitespace
$cleanDiagnosis = preg_replace('/[!]{2,}/', '!', $cleanDiagnosis);   // multiple ! → single
$cleanDiagnosis = preg_replace('/[?]{2,}/', '.', $cleanDiagnosis);   // multiple ? → period
$cleanDiagnosis = trim($cleanDiagnosis);

// 3. Clean doctor's notes similarly
$cleanNotes = preg_replace('/\s+/', ' ', $rawNotes);
$cleanNotes = trim($cleanNotes);

// 4. Word count using str_word_count()
$diagnosisWordCount = str_word_count($cleanDiagnosis);
$notesWordCount     = str_word_count($cleanNotes);

// 5. Timestamp
$reportGeneratedAt = date('l, F j, Y \a\t g:i:s A');
$reportTimestamp   = date('Y-m-d H:i:s');

/* ── Status badge color mapping ──────────────────────────── */
$statusConfig = [
    'Stable'     => ['badge' => 'badge-success', 'color' => '#166534', 'bg' => '#dcfce7'],
    'Critical'   => ['badge' => 'badge-error',   'color' => '#991b1b', 'bg' => '#fee2e2'],
    'Recovering' => ['badge' => 'badge-warning',  'color' => '#92400e', 'bg' => '#fef3c7'],
    'Discharged' => ['badge' => 'badge-neutral',  'color' => '#374151', 'bg' => '#f3f4f6'],
];

$statusInfo = $statusConfig[$patientStatus] ?? $statusConfig['Stable'];

include 'includes/header.php';
?>

<div class="page-wrapper">
<div class="container">

  <!-- Page header -->
  <div class="page-header fade-in">
    <div class="page-header-badge">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      Task 5
    </div>
    <h1 class="page-title">Patient Health Report</h1>
    <p class="page-subtitle">Generated on <?php echo htmlspecialchars($reportGeneratedAt); ?></p>
  </div>

  <!-- Report card -->
  <div class="card fade-in anim-delay-1" style="max-width:780px; margin:0 auto;">

    <!-- Report header: name + status -->
    <div class="d-flex flex-between align-center flex-wrap gap-3" style="margin-bottom:24px;">
      <div>
        <!-- Name displayed in UPPERCASE (Task 5) -->
        <h2 class="page-title" style="font-size:1.6rem; margin-bottom:4px;">
          <?php echo htmlspecialchars($patientNameUpper); ?>
        </h2>
        <div class="text-muted text-sm">Patient ID: <strong><?php echo htmlspecialchars($patientId); ?></strong></div>
      </div>
      <!-- Color-coded status badge (Task 5) -->
      <span
        class="badge <?php echo htmlspecialchars($statusInfo['badge']); ?>"
        style="font-size:0.82rem; padding:6px 16px; border-radius:999px;"
      >
        <svg width="8" height="8" viewBox="0 0 8 8" fill="currentColor" style="margin-right:4px;"><circle cx="4" cy="4" r="4"/></svg>
        <?php echo htmlspecialchars($patientStatus); ?>
      </span>
    </div>

    <div class="card-divider"></div>

    <!-- Patient demographics -->
    <h3 class="card-title" style="margin-bottom:14px;">Patient Details</h3>
    <div class="info-grid">
      <div class="info-item">
        <div class="info-item-label">Full Name (Original)</div>
        <div class="info-item-value"><?php echo htmlspecialchars($patientNameDisplay); ?></div>
      </div>
      <div class="info-item">
        <div class="info-item-label">Name (UPPERCASE)</div>
        <div class="info-item-value" style="color:var(--primary); font-family:'Figtree',sans-serif;">
          <?php echo htmlspecialchars($patientNameUpper); ?>
        </div>
      </div>
      <div class="info-item">
        <div class="info-item-label">Age / Gender</div>
        <div class="info-item-value"><?php echo $patientAge; ?> years / <?php echo htmlspecialchars($patientGender); ?></div>
      </div>
      <div class="info-item">
        <div class="info-item-label">Blood Type</div>
        <div class="info-item-value">
          <span class="badge badge-error"><?php echo htmlspecialchars($bloodType); ?></span>
        </div>
      </div>
      <div class="info-item">
        <div class="info-item-label">Admission Date</div>
        <div class="info-item-value"><?php echo htmlspecialchars(date('F j, Y', strtotime($admissionDate))); ?></div>
      </div>
      <div class="info-item">
        <div class="info-item-label">Ward</div>
        <div class="info-item-value"><?php echo htmlspecialchars($wardNo); ?></div>
      </div>
    </div>

    <div class="card-divider"></div>

    <!-- Diagnosis section (cleaned with regex) -->
    <div style="margin-bottom:20px;">
      <div class="d-flex flex-between align-center flex-wrap gap-2 mb-2">
        <h3 class="card-title" style="margin-bottom:0;">Diagnosis</h3>
        <span class="badge badge-neutral">
          <?php echo $diagnosisWordCount; ?> words
        </span>
      </div>

      <!-- Show before/after to demonstrate regex (Task 5) -->
      <div class="alert alert-info" style="margin-bottom:12px; font-size:0.8rem;">
        <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <div class="alert-content">
          <div class="alert-title">Task 5: preg_replace() Applied</div>
          Multiple spaces collapsed to single space, repeated punctuation normalised.
          Word count calculated using str_word_count().
        </div>
      </div>

      <div style="background:#f8f9ff; border:1px solid var(--border); border-radius:var(--radius-sm); padding:16px; font-size:0.9rem; line-height:1.7; color:var(--text);">
        <?php echo htmlspecialchars($cleanDiagnosis); ?>
      </div>
    </div>

    <div class="card-divider"></div>

    <!-- Medicines — numbered list (Task 5) -->
    <div style="margin-bottom:20px;">
      <div class="d-flex flex-between align-center flex-wrap gap-2 mb-3">
        <h3 class="card-title" style="margin-bottom:0;">Prescribed Medicines</h3>
        <span class="badge badge-primary"><?php echo count($medicines); ?> items</span>
      </div>

      <ul class="medicine-list">
        <?php foreach ($medicines as $index => $medicine): ?>
          <li>
            <span class="medicine-num"><?php echo $index + 1; ?></span>
            <?php echo htmlspecialchars($medicine); ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="card-divider"></div>

    <!-- Doctor's Notes (also cleaned with regex) -->
    <div style="margin-bottom:20px;">
      <div class="d-flex flex-between align-center flex-wrap gap-2 mb-2">
        <h3 class="card-title" style="margin-bottom:0;">Doctor's Notes</h3>
        <span class="badge badge-neutral"><?php echo $notesWordCount; ?> words</span>
      </div>
      <div style="background:#f8f9ff; border:1px solid var(--border); border-radius:var(--radius-sm); padding:16px; font-size:0.9rem; line-height:1.7; color:var(--text);">
        <?php echo htmlspecialchars($cleanNotes); ?>
      </div>
    </div>

    <div class="card-divider"></div>

    <!-- Report metadata -->
    <div class="info-grid" style="margin-bottom:24px;">
      <div class="info-item">
        <div class="info-item-label">Report Generated</div>
        <div class="info-item-value" style="font-size:0.82rem;"><?php echo htmlspecialchars($reportGeneratedAt); ?></div>
      </div>
      <div class="info-item">
        <div class="info-item-label">System Timestamp</div>
        <div class="info-item-value" style="font-size:0.82rem; font-family:monospace;"><?php echo htmlspecialchars($reportTimestamp); ?></div>
      </div>
      <div class="info-item">
        <div class="info-item-label">Diagnosis Word Count</div>
        <div class="info-item-value"><?php echo $diagnosisWordCount; ?> words</div>
      </div>
      <div class="info-item">
        <div class="info-item-label">Medicines Prescribed</div>
        <div class="info-item-value"><?php echo count($medicines); ?></div>
      </div>
    </div>

    <!-- Actions -->
    <div class="d-flex gap-3 flex-wrap">
      <button id="printPage" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
          <polyline points="6 9 6 2 18 2 18 9"/>
          <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
          <rect x="6" y="14" width="12" height="8"/>
        </svg>
        Print Report
      </button>
      <a href="appointment.php" class="btn btn-outline">Book Follow-up</a>
      <a href="index.php" class="btn btn-ghost">← Dashboard</a>
    </div>

  </div><!-- end card -->

</div>
</div>

<?php include 'includes/footer.php'; ?>
