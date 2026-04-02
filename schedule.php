<?php
/**
 * schedule.php — Task 4: Doctor Schedule
 *
 * - Array of 5+ doctors with details
 * - Function getDoctorsByDay() to filter by weekday
 * - Displays Wednesday doctors by default
 * - Calculates average consultation fee
 * - Styled table with zebra striping
 */

$pageTitle = 'Doctor Schedule';

/* ══════════════════════════════════════════════════════════
   DOCTOR DATA ARRAY
   Each doctor: name, specialty, days, times, fee, experience
   ══════════════════════════════════════════════════════════ */
$doctors = [
    [
        'name'       => 'Dr. Sarah Mitchell',
        'specialty'  => 'Cardiology',
        'days'       => ['Monday', 'Wednesday', 'Friday'],
        'hours'      => '9:00 AM – 3:00 PM',
        'fee'        => 120.00,
        'experience' => 14,
        'available'  => true,
    ],
    [
        'name'       => 'Dr. James Okonkwo',
        'specialty'  => 'General Practice',
        'days'       => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
        'hours'      => '8:00 AM – 5:00 PM',
        'fee'        => 75.00,
        'experience' => 9,
        'available'  => true,
    ],
    [
        'name'       => 'Dr. Priya Sharma',
        'specialty'  => 'Paediatrics',
        'days'       => ['Tuesday', 'Thursday', 'Saturday'],
        'hours'      => '10:00 AM – 4:00 PM',
        'fee'        => 95.00,
        'experience' => 11,
        'available'  => true,
    ],
    [
        'name'       => 'Dr. Liam Torres',
        'specialty'  => 'Orthopaedics',
        'days'       => ['Monday', 'Wednesday'],
        'hours'      => '8:00 AM – 1:00 PM',
        'fee'        => 140.00,
        'experience' => 17,
        'available'  => true,
    ],
    [
        'name'       => 'Dr. Amara Hassan',
        'specialty'  => 'Neurology',
        'days'       => ['Thursday', 'Friday', 'Saturday'],
        'hours'      => '11:00 AM – 6:00 PM',
        'fee'        => 160.00,
        'experience' => 20,
        'available'  => false,
    ],
    [
        'name'       => 'Dr. David Chen',
        'specialty'  => 'Dermatology',
        'days'       => ['Tuesday', 'Wednesday', 'Friday'],
        'hours'      => '9:00 AM – 2:00 PM',
        'fee'        => 110.00,
        'experience' => 8,
        'available'  => true,
    ],
    [
        'name'       => 'Dr. Elena Rossi',
        'specialty'  => 'Psychiatry',
        'days'       => ['Monday', 'Thursday'],
        'hours'      => '1:00 PM – 7:00 PM',
        'fee'        => 130.00,
        'experience' => 12,
        'available'  => true,
    ],
];

/* ══════════════════════════════════════════════════════════
   FUNCTION: getDoctorsByDay($doctors, $day)
   Returns an array of doctors available on the given weekday.
   ══════════════════════════════════════════════════════════ */
function getDoctorsByDay(array $doctors, string $day): array {
    $result = [];
    foreach ($doctors as $doctor) {
        // Case-insensitive comparison for day name
        foreach ($doctor['days'] as $d) {
            if (strcasecmp($d, $day) === 0) {
                $result[] = $doctor;
                break; // avoid duplicates if day listed twice
            }
        }
    }
    return $result;
}

/* ── Calculate average fee across ALL doctors ─────────────── */
function calculateAverageFee(array $doctors): float {
    if (empty($doctors)) return 0.0;
    $total = array_sum(array_column($doctors, 'fee'));
    return $total / count($doctors);
}

/* ── Selected day (from GET param or default to Wednesday) ── */
$selectedDay = isset($_GET['day']) ? trim($_GET['day']) : 'Wednesday';

$validDays = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
if (!in_array($selectedDay, $validDays)) {
    $selectedDay = 'Wednesday';
}

/* ── Doctors for the selected day ────────────────────────── */
$filteredDoctors = getDoctorsByDay($doctors, $selectedDay);

/* ── Average fee (all doctors) ───────────────────────────── */
$averageFee = calculateAverageFee($doctors);

/* ── Specialty badge color map ───────────────────────────── */
$specialtyColors = [
    'Cardiology'      => 'badge-error',
    'General Practice'=> 'badge-success',
    'Paediatrics'     => 'badge-info',
    'Orthopaedics'    => 'badge-warning',
    'Neurology'       => 'badge-primary',
    'Dermatology'     => 'badge-neutral',
    'Psychiatry'      => 'badge-primary',
];

include 'includes/header.php';
?>

<div class="page-wrapper">
<div class="container">

  <!-- Page header -->
  <div class="page-header fade-in">
    <div class="page-header-badge">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      Task 4
    </div>
    <h1 class="page-title">Doctor Schedule</h1>
    <p class="page-subtitle">View all <?php echo count($doctors); ?> doctors and filter by weekday availability.</p>
  </div>

  <!-- Stats row -->
  <div class="stat-grid fade-in anim-delay-1" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
      <div class="stat-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="8" r="4"/><path d="M12 2v2M12 14v8"/>
        </svg>
      </div>
      <div class="stat-info">
        <div class="stat-value"><?php echo count($doctors); ?></div>
        <div class="stat-label">Total Doctors</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
      </div>
      <div class="stat-info">
        <div class="stat-value"><?php echo count($filteredDoctors); ?></div>
        <div class="stat-label">Available <?php echo htmlspecialchars($selectedDay); ?></div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="1" x2="12" y2="23"/>
          <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
        </svg>
      </div>
      <div class="stat-info">
        <div class="stat-value">$<?php echo number_format($averageFee, 2); ?></div>
        <div class="stat-label">Average Fee</div>
      </div>
    </div>
  </div>

  <!-- Day filter tabs -->
  <div class="card fade-in anim-delay-2" style="margin-bottom: 24px; padding: 16px 20px;">
    <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
      <span class="text-sm font-semibold" style="color:var(--muted); margin-right:4px;">Filter by day:</span>
      <?php foreach (['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day): ?>
        <a
          href="schedule.php?day=<?php echo urlencode($day); ?>"
          class="btn btn-sm <?php echo $selectedDay === $day ? 'btn-primary' : 'btn-ghost'; ?>"
        >
          <?php echo htmlspecialchars($day); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Doctors on selected day -->
  <div class="card fade-in anim-delay-3">

    <div class="d-flex flex-between align-center mb-4">
      <div>
        <div class="card-title">
          Doctors Available on <?php echo htmlspecialchars($selectedDay); ?>
        </div>
        <div class="card-subtitle" style="margin-bottom:0;">
          Found <strong><?php echo count($filteredDoctors); ?></strong> doctor<?php echo count($filteredDoctors) !== 1 ? 's' : ''; ?> available
        </div>
      </div>
      <a href="appointment.php" class="btn btn-primary btn-sm">Book Now</a>
    </div>

    <?php if (empty($filteredDoctors)): ?>
      <div class="alert alert-info">
        <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <div class="alert-content">
          <div class="alert-title">No doctors scheduled on <?php echo htmlspecialchars($selectedDay); ?></div>
          Please select a different day.
        </div>
      </div>

    <?php else: ?>

      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Doctor</th>
              <th>Specialty</th>
              <th>Consulting Hours</th>
              <th>Experience</th>
              <th>Fee</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($filteredDoctors as $index => $doc): ?>
              <tr>
                <td><?php echo $index + 1; ?></td>
                <td>
                  <div class="font-semibold" style="font-size:0.875rem;">
                    <?php echo htmlspecialchars($doc['name']); ?>
                  </div>
                </td>
                <td>
                  <?php
                    $badge = $specialtyColors[$doc['specialty']] ?? 'badge-neutral';
                  ?>
                  <span class="badge <?php echo $badge; ?>">
                    <?php echo htmlspecialchars($doc['specialty']); ?>
                  </span>
                </td>
                <td><?php echo htmlspecialchars($doc['hours']); ?></td>
                <td><?php echo htmlspecialchars($doc['experience']); ?> yrs</td>
                <td>
                  <strong>$<?php echo number_format($doc['fee'], 2); ?></strong>
                </td>
                <td>
                  <?php if ($doc['available']): ?>
                    <span class="badge badge-success">
                      <svg width="8" height="8" viewBox="0 0 8 8" fill="currentColor"><circle cx="4" cy="4" r="4"/></svg>
                      Available
                    </span>
                  <?php else: ?>
                    <span class="badge badge-error">Unavailable</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5" style="text-align:right;">
                Average Consultation Fee (all doctors):
              </td>
              <td colspan="2">
                $<?php echo number_format($averageFee, 2); ?>
              </td>
            </tr>
          </tfoot>
        </table>
      </div><!-- end table-wrap -->

    <?php endif; ?>

  </div><!-- end card -->

  <!-- Full doctor roster -->
  <div class="card fade-in anim-delay-4" style="margin-top:24px;">

    <div class="card-title">Complete Doctor Roster</div>
    <div class="card-subtitle">All registered doctors and their weekly schedules</div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Doctor</th>
            <th>Specialty</th>
            <th>Available Days</th>
            <th>Hours</th>
            <th>Fee</th>
            <th>Exp.</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($doctors as $i => $doc): ?>
            <tr>
              <td><?php echo $i + 1; ?></td>
              <td class="font-semibold"><?php echo htmlspecialchars($doc['name']); ?></td>
              <td>
                <?php $badge = $specialtyColors[$doc['specialty']] ?? 'badge-neutral'; ?>
                <span class="badge <?php echo $badge; ?>"><?php echo htmlspecialchars($doc['specialty']); ?></span>
              </td>
              <td>
                <?php
                  // Show days as small tags
                  foreach ($doc['days'] as $d) {
                      $isSelected = ($d === $selectedDay) ? 'badge-primary' : 'badge-neutral';
                      echo '<span class="badge ' . $isSelected . '" style="margin:2px 2px 2px 0;">' . htmlspecialchars(substr($d, 0, 3)) . '</span>';
                  }
                ?>
              </td>
              <td style="font-size:0.8rem;"><?php echo htmlspecialchars($doc['hours']); ?></td>
              <td><strong>$<?php echo number_format($doc['fee'], 2); ?></strong></td>
              <td><?php echo htmlspecialchars($doc['experience']); ?> yr<?php echo $doc['experience'] !== 1 ? 's' : ''; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" style="text-align:right;">Average Fee across all <?php echo count($doctors); ?> doctors:</td>
            <td colspan="2">$<?php echo number_format($averageFee, 2); ?></td>
          </tr>
        </tfoot>
      </table>
    </div>

  </div><!-- end full roster card -->

</div>
</div>

<?php include 'includes/footer.php'; ?>
