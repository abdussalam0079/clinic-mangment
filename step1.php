<?php
/**
 * step1.php — Task 6: Multi-Step Intake Form — Step 1
 *
 * Collects personal information and stores it in $_SESSION.
 * On success, redirects to step2.php.
 */

session_start();
$pageTitle = 'Intake Form — Step 1';

/* ── Pre-fill from session if back button was used ────────── */
$firstName = isset($_SESSION['step1']['first_name']) ? $_SESSION['step1']['first_name'] : '';
$lastName  = isset($_SESSION['step1']['last_name'])  ? $_SESSION['step1']['last_name']  : '';
$dob       = isset($_SESSION['step1']['dob'])        ? $_SESSION['step1']['dob']        : '';
$gender    = isset($_SESSION['step1']['gender'])     ? $_SESSION['step1']['gender']     : '';
$phone     = isset($_SESSION['step1']['phone'])      ? $_SESSION['step1']['phone']      : '';
$email     = isset($_SESSION['step1']['email'])      ? $_SESSION['step1']['email']      : '';
$address   = isset($_SESSION['step1']['address'])    ? $_SESSION['step1']['address']    : '';

$errors = [];

/* ── Handle POST ─────────────────────────────────────────── */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName  = trim($_POST['last_name']  ?? '');
    $dob       = trim($_POST['dob']        ?? '');
    $gender    = trim($_POST['gender']     ?? '');
    $phone     = trim($_POST['phone']      ?? '');
    $email     = trim($_POST['email']      ?? '');
    $address   = trim($_POST['address']    ?? '');

    // Validate
    if ($firstName === '') $errors[] = "First name is required.";
    if ($lastName  === '') $errors[] = "Last name is required.";
    if ($dob       === '') {
        $errors[] = "Date of birth is required.";
    } else {
        $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
        if (!$dobDate || $dobDate > new DateTime()) {
            $errors[] = "Please enter a valid date of birth.";
        }
    }
    if ($gender === '') $errors[] = "Gender is required.";
    if ($phone  === '') $errors[] = "Phone number is required.";
    elseif (!preg_match('/^[\d\s\+\-\(\)]{7,20}$/', $phone)) {
        $errors[] = "Please enter a valid phone number.";
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($errors)) {
        // Save step 1 data to session
        $_SESSION['step1'] = [
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'dob'        => $dob,
            'gender'     => $gender,
            'phone'      => $phone,
            'email'      => $email,
            'address'    => $address,
        ];

        // Move to step 2
        header('Location: step2.php');
        exit;
    }
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
    <p class="page-subtitle">Please complete all steps to submit your intake information.</p>
  </div>

  <div style="max-width:680px; margin:0 auto;">

    <!-- Step progress indicator -->
    <div class="step-progress fade-in anim-delay-1" style="margin-bottom:32px;">

      <div class="step-wrapper step-item active">
        <div class="step-circle active">1</div>
        <div class="step-label">Personal Info</div>
      </div>

      <div class="step-line"></div>

      <div class="step-wrapper step-item">
        <div class="step-circle">2</div>
        <div class="step-label">Medical Info</div>
      </div>

      <div class="step-line"></div>

      <div class="step-wrapper step-item">
        <div class="step-circle">3</div>
        <div class="step-label">Review</div>
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

    <!-- Step 1 form card -->
    <div class="card fade-in anim-delay-2" id="stepForm">

      <div class="card-title">Step 1 of 3 — Personal Information</div>
      <div class="card-subtitle">All fields marked <span style="color:var(--error)">*</span> are required.</div>

      <form action="step1.php" method="POST" novalidate>

        <!-- First name + Last name -->
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="first_name">
              First Name <span class="required">*</span>
            </label>
            <input
              type="text"
              id="first_name"
              name="first_name"
              class="form-control <?php echo (!empty($errors) && $firstName === '') ? 'is-invalid' : ''; ?>"
              placeholder="First name"
              value="<?php echo htmlspecialchars($firstName); ?>"
              maxlength="60"
            />
          </div>
          <div class="form-group">
            <label class="form-label" for="last_name">
              Last Name <span class="required">*</span>
            </label>
            <input
              type="text"
              id="last_name"
              name="last_name"
              class="form-control <?php echo (!empty($errors) && $lastName === '') ? 'is-invalid' : ''; ?>"
              placeholder="Last name"
              value="<?php echo htmlspecialchars($lastName); ?>"
              maxlength="60"
            />
          </div>
        </div>

        <!-- DOB + Gender -->
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="dob">
              Date of Birth <span class="required">*</span>
            </label>
            <input
              type="date"
              id="dob"
              name="dob"
              class="form-control <?php echo (!empty($errors) && $dob === '') ? 'is-invalid' : ''; ?>"
              value="<?php echo htmlspecialchars($dob); ?>"
              max="<?php echo date('Y-m-d'); ?>"
            />
          </div>
          <div class="form-group">
            <label class="form-label" for="gender">
              Gender <span class="required">*</span>
            </label>
            <select
              id="gender"
              name="gender"
              class="form-control <?php echo (!empty($errors) && $gender === '') ? 'is-invalid' : ''; ?>"
            >
              <option value="">— Select —</option>
              <?php foreach (['Male','Female','Non-binary','Prefer not to say'] as $g): ?>
                <option value="<?php echo htmlspecialchars($g); ?>"
                  <?php echo $gender === $g ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($g); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- Phone + Email -->
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="phone">
              Phone <span class="required">*</span>
            </label>
            <input
              type="tel"
              id="phone"
              name="phone"
              class="form-control <?php echo (!empty($errors) && $phone === '') ? 'is-invalid' : ''; ?>"
              placeholder="+1 (555) 000-0000"
              value="<?php echo htmlspecialchars($phone); ?>"
              maxlength="20"
            />
          </div>
          <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              class="form-control"
              placeholder="you@example.com"
              value="<?php echo htmlspecialchars($email); ?>"
              maxlength="150"
            />
          </div>
        </div>

        <!-- Address -->
        <div class="form-group">
          <label class="form-label" for="address">Home Address</label>
          <input
            type="text"
            id="address"
            name="address"
            class="form-control"
            placeholder="Street, City, State"
            value="<?php echo htmlspecialchars($address); ?>"
            maxlength="255"
          />
        </div>

        <div class="card-divider"></div>

        <div class="d-flex flex-between align-center flex-wrap gap-3">
          <a href="index.php" class="btn btn-ghost">← Cancel</a>
          <button type="submit" class="btn btn-primary btn-lg">
            Continue to Step 2
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
              <polyline points="9 18 15 12 9 6"/>
            </svg>
          </button>
        </div>

      </form>

    </div><!-- end card -->

  </div><!-- end max-width wrapper -->

</div>
</div>

<?php include 'includes/footer.php'; ?>
