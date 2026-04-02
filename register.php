<?php
/**
 * register.php — Task 2: Patient Registration Form
 *
 * Displays the patient registration form.
 * Form submits to process_register.php via POST.
 */

$pageTitle = 'Register Patient';
include 'includes/header.php';
?>

<div class="page-wrapper">
<div class="container">

  <!-- Page header -->
  <div class="page-header fade-in">
    <div class="page-header-badge">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
      Task 2
    </div>
    <h1 class="page-title">Register New Patient</h1>
    <p class="page-subtitle">Fill in all required fields to create a new patient record.</p>
  </div>

  <!-- Registration form card -->
  <div class="card fade-in anim-delay-1" style="max-width:720px; margin:0 auto;">

    <div class="card-title">Patient Information</div>
    <div class="card-subtitle">All fields marked with <span style="color:var(--error);">*</span> are required.</div>

    <form action="process_register.php" method="POST" novalidate>

      <!-- Full Name + Date of Birth -->
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="full_name">
            Full Name <span class="required">*</span>
          </label>
          <input
            type="text"
            id="full_name"
            name="full_name"
            class="form-control"
            placeholder="e.g. John Michael Doe"
            maxlength="100"
            required
          />
        </div>
        <div class="form-group">
          <label class="form-label" for="dob">
            Date of Birth <span class="required">*</span>
          </label>
          <input
            type="date"
            id="dob"
            name="dob"
            class="form-control"
            max="<?php echo date('Y-m-d'); ?>"
            required
          />
        </div>
      </div>

      <!-- Gender + Blood Type -->
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="gender">
            Gender <span class="required">*</span>
          </label>
          <select id="gender" name="gender" class="form-control" required>
            <option value="">— Select Gender —</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
            <option value="Prefer not to say">Prefer not to say</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="blood_type">Blood Type</label>
          <select id="blood_type" name="blood_type" class="form-control">
            <option value="">— Select Blood Type —</option>
            <option value="A+">A+</option>
            <option value="A-">A−</option>
            <option value="B+">B+</option>
            <option value="B-">B−</option>
            <option value="O+">O+</option>
            <option value="O-">O−</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB−</option>
            <option value="Unknown">Unknown</option>
          </select>
        </div>
      </div>

      <!-- Phone + Email -->
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="phone">
            Phone Number <span class="required">*</span>
          </label>
          <input
            type="tel"
            id="phone"
            name="phone"
            class="form-control"
            placeholder="+1 (555) 000-0000"
            maxlength="20"
            required
          />
        </div>
        <div class="form-group">
          <label class="form-label" for="email">Email Address</label>
          <input
            type="email"
            id="email"
            name="email"
            class="form-control"
            placeholder="patient@example.com"
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
          placeholder="Street, City, State / Province"
          maxlength="255"
        />
      </div>

      <!-- Emergency contact -->
      <div class="card-divider"></div>
      <p class="text-sm font-semibold" style="margin-bottom:16px; color:var(--text);">Emergency Contact</p>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="emergency_name">Contact Name</label>
          <input
            type="text"
            id="emergency_name"
            name="emergency_name"
            class="form-control"
            placeholder="Full name"
            maxlength="100"
          />
        </div>
        <div class="form-group">
          <label class="form-label" for="emergency_phone">Contact Phone</label>
          <input
            type="tel"
            id="emergency_phone"
            name="emergency_phone"
            class="form-control"
            placeholder="+1 (555) 000-0000"
            maxlength="20"
          />
        </div>
      </div>

      <!-- Notes -->
      <div class="form-group">
        <label class="form-label" for="notes">Additional Notes</label>
        <textarea
          id="notes"
          name="notes"
          class="form-control"
          placeholder="Any relevant medical history, allergies, or special notes…"
          rows="3"
          maxlength="500"
        ></textarea>
      </div>

      <!-- Actions -->
      <div class="card-divider"></div>
      <div class="d-flex gap-3 flex-wrap">
        <button type="submit" class="btn btn-primary btn-lg">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>
          </svg>
          Register Patient
        </button>
        <a href="index.php" class="btn btn-ghost btn-lg">Cancel</a>
      </div>

    </form>

  </div><!-- end card -->

</div>
</div>

<?php include 'includes/footer.php'; ?>
