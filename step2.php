<?php
/**
 * step2.php — Task 6: Multi-Step Intake Form — Step 2
 *
 * Collects medical information (height, weight, conditions, etc.)
 * - Back button preserves step2 values from session
 * - On success, stores step2 data in session and goes to step3.php
 */

session_start();

// Guard: must have completed step 1 first
if (empty($_SESSION['step1'])) {
    header('Location: step1.php');
    exit;
}

$pageTitle = 'Intake Form — Step 2';

/* ── Pre-fill from session if coming back from step3 ─────── */
$height      = isset($_SESSION['step2']['height'])      ? $_SESSION['step2']['height']      : '';
$weight      = isset($_SESSION['step2']['weight'])      ? $_SESSION['step2']['weight']      : '';
$allergies   = isset($_SESSION['step2']['allergies'])   ? $_SESSION['step2']['allergies']   : '';
$conditions  = isset($_SESSION['step2']['conditions'])  ? $_SESSION['step2']['conditions']  : [];
$currentMeds = isset($_SESSION['step2']['current_meds'])? $_SESSION['step2']['current_meds']: '';
$smoking     = isset($_SESSION['step2']['smoking'])     ? $_SESSION['step2']['smoking']     : '';
$alcohol     = isset($_SESSION['step2']['alcohol'])     ? $_SESSION['step2']['alcohol']     : '';
$surgeries   = isset($_SESSION['step2']['surgeries'])   ? $_SESSION['step2']['surgeries']   : '';

$errors = [];

/* ── Handle POST ─────────────────────────────────────────── */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $height      = trim($_POST['height']       ?? '');
    $weight      = trim($_POST['weight']       ?? '');
    $allergies   = trim($_POST['allergies']    ?? '');
    $conditions  = isset($_POST['conditions']) && is_array($_POST['conditions'])
                     ? $_POST['conditions'] : [];
    $currentMeds = trim($_POST['current_meds'] ?? '');
    $smoking     = trim($_POST['smoking']      ?? '');
    $alcohol     = trim($_POST['alcohol']      ?? '');
    $surgeries   = trim($_POST['surgeries']    ?? '');

    // Validate height: required, numeric, sensible range (50–250 cm)
    if ($height === '') {
        $errors[] = "Height is required.";
    } elseif (!is_numeric($height) || $height < 50 || $height > 250) {
        $errors[] = "Please enter a valid height in centimetres (50–250 cm).";
    }

    // Validate weight: required, numeric, sensible range (1–300 kg)
    if ($weight === '') {
        $errors[] = "Weight is required.";
    } elseif (!is_numeric($weight) || $weight < 1 || $weight > 300) {
        $errors[] = "Please enter a valid weight in kilograms (1–300 kg).";
    }

    if ($smoking === '') $errors[] = "Smoking status is required.";
    if ($alcohol === '') $errors[] = "Alcohol use information is required.";

    if (empty($errors)) {
        // Save step 2 data to session
        $_SESSION['step2'] = [
            'height'       => $height,
            'weight'       => $weight,
            'allergies'    => $allergies,
            'conditions'   => $conditions,
            'current_meds' => $currentMeds,
            'smoking'      => $smoking,
            'alcohol'      => $alcohol,
            'surgeries'    => $surgeries,
        ];

        header('Location: step3.php');
        exit;
    }
}

/* ── Checkbox options for medical conditions ─────────────── */
$conditionOptions = [
    'Diabetes',
    'Hypertension',
    'Asthma',
    'Heart Disease',
    'Thyroid Disorder',
    'Kidney Disease',
    'Cancer (any)',
    'Mental Health Condition',
    'None of the above',
];

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
    <p class="page-subtitle">Step 2 of 3 — Medical history and lifestyle information.</p>
  </div>

  <div style="max-width:680px; margin:0 auto;">

    <!-- Step progress indicator -->
    <div class="step-progress fade-in anim-delay-1">

      <div class="step-wrapper step-item done">
        <div class="step-circle done">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div class="step-label">Personal Info</div>
      </div>

      <div class="step-line done"></div>

      <div class="step-wrapper step-item active">
        <div class="step-circle active">2</div>
        <div class="step-label">Medical Info</div>
      </div>

      <div class="step-line"></div>

      <div class="step-wrapper step-item">
        <div class="step-circle">3</div>
        <div class="step-label">Review</div>
      </div>

    </div>

    <!-- Patient name reminder banner -->
    <div class="alert alert-info fade-in anim-delay-1" style="margin-bottom:20px;">
      <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
        <circle cx="12" cy="7" r="4"/>
      </svg>
      <div class="alert-content">
        Completing intake for: <strong>
          <?php
            $s1 = $_SESSION['step1'];
            echo htmlspecialchars($s1['first_name'] . ' ' . $s1['last_name']);
          ?>
        </strong>
      </div>
    </div>

    <!-- Errors -->
    <?php if (!empty($errors)): ?>
      <div class="alert alert-error fade-in" role="alert">
        <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <div class="alert-content">
          <div class="alert-title">Please fix the following:</div>
          <ul>
            <?php foreach ($errors as $err): ?>
              <li><?php echo htmlspecialchars($err); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php endif; ?>

    <!-- Step 2 form card -->
    <div class="card fade-in anim-delay-2" id="stepForm">

      <div class="card-title">Step 2 of 3 — Medical Information</div>
      <div class="card-subtitle">All fields marked <span style="color:var(--error)">*</span> are required.</div>

      <form action="step2.php" method="POST" novalidate>

        <!-- Height + Weight -->
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="height">
              Height (cm) <span class="required">*</span>
            </label>
            <input
              type="number"
              id="height"
              name="height"
              class="form-control <?php echo (!empty($errors) && $height === '') ? 'is-invalid' : ''; ?>"
              placeholder="e.g. 170"
              value="<?php echo htmlspecialchars($height); ?>"
              min="50" max="250" step="0.1"
            />
            <div class="form-hint">Enter in centimetres (50 – 250 cm)</div>
          </div>
          <div class="form-group">
            <label class="form-label" for="weight">
              Weight (kg) <span class="required">*</span>
            </label>
            <input
              type="number"
              id="weight"
              name="weight"
              class="form-control <?php echo (!empty($errors) && $weight === '') ? 'is-invalid' : ''; ?>"
              placeholder="e.g. 70"
              value="<?php echo htmlspecialchars($weight); ?>"
              min="1" max="300" step="0.1"
            />
            <div class="form-hint">Enter in kilograms (1 – 300 kg)</div>
          </div>
        </div>

        <!-- Known allergies -->
        <div class="form-group">
          <label class="form-label" for="allergies">Known Allergies</label>
          <input
            type="text"
            id="allergies"
            name="allergies"
            class="form-control"
            placeholder="e.g. Penicillin, Peanuts, Latex (or 'None')"
            value="<?php echo htmlspecialchars($allergies); ?>"
            maxlength="255"
          />
        </div>

        <!-- Pre-existing conditions (checkboxes) -->
        <div class="form-group">
          <label class="form-label">Pre-existing Conditions</label>
          <div style="display:grid; grid-template-columns: 1fr 1fr; gap:8px; margin-top:4px;">
            <?php foreach ($conditionOptions as $cond): ?>
              <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:0.875rem; padding:8px 12px; border:1px solid var(--border); border-radius:var(--radius-sm); transition:background 0.15s;">
                <input
                  type="checkbox"
                  name="conditions[]"
                  value="<?php echo htmlspecialchars($cond); ?>"
                  <?php echo in_array($cond, $conditions) ? 'checked' : ''; ?>
                  style="width:16px; height:16px; accent-color:var(--primary);"
                />
                <?php echo htmlspecialchars($cond); ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Current medications -->
        <div class="form-group">
          <label class="form-label" for="current_meds">Current Medications</label>
          <textarea
            id="current_meds"
            name="current_meds"
            class="form-control"
            placeholder="List any medications you are currently taking, or 'None'…"
            rows="3"
            maxlength="500"
          ><?php echo htmlspecialchars($currentMeds); ?></textarea>
        </div>

        <!-- Smoking + Alcohol -->
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="smoking">
              Smoking Status <span class="required">*</span>
            </label>
            <select
              id="smoking"
              name="smoking"
              class="form-control <?php echo (!empty($errors) && $smoking === '') ? 'is-invalid' : ''; ?>"
            >
              <option value="">— Select —</option>
              <?php foreach (['Non-smoker','Former smoker','Occasional smoker','Regular smoker'] as $s): ?>
                <option value="<?php echo htmlspecialchars($s); ?>"
                  <?php echo $smoking === $s ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($s); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label" for="alcohol">
              Alcohol Use <span class="required">*</span>
            </label>
            <select
              id="alcohol"
              name="alcohol"
              class="form-control <?php echo (!empty($errors) && $alcohol === '') ? 'is-invalid' : ''; ?>"
            >
              <option value="">— Select —</option>
              <?php foreach (['None','Occasional','Moderate','Heavy'] as $a): ?>
                <option value="<?php echo htmlspecialchars($a); ?>"
                  <?php echo $alcohol === $a ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($a); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- Past surgeries -->
        <div class="form-group">
          <label class="form-label" for="surgeries">Previous Surgeries / Hospitalizations</label>
          <textarea
            id="surgeries"
            name="surgeries"
            class="form-control"
            placeholder="List any past surgeries or hospital admissions, or 'None'…"
            rows="2"
            maxlength="500"
          ><?php echo htmlspecialchars($surgeries); ?></textarea>
        </div>

        <div class="card-divider"></div>

        <!-- Back + Continue -->
        <div class="d-flex flex-between align-center flex-wrap gap-3">
          <a href="step1.php" class="btn btn-ghost btn-lg">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
              <polyline points="15 18 9 12 15 6"/>
            </svg>
            Back to Step 1
          </a>
          <button type="submit" class="btn btn-primary btn-lg">
            Continue to Review
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
              <polyline points="9 18 15 12 9 6"/>
            </svg>
          </button>
        </div>

      </form>

    </div><!-- end card -->

  </div>

</div>
</div>

<?php include 'includes/footer.php'; ?>
