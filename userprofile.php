<?php 
require_once __DIR__ . '/components/check_auth.php';
require_once __DIR__ . '/classes/Officer.php';
require_once __DIR__ . '/classes/Committee.php';
require_once __DIR__ . '/classes/AuditLog.php';

$officerModel   = new Officer();
$committeeModel = new Committee();
$auditLogModel  = new AuditLog();

$officer    = $officerModel->getOfficerById($_SESSION['officer_id']);
$committees = $committeeModel->getCommitteesByOfficer($_SESSION['officer_id']);
$activity   = $auditLogModel->getLogsByOfficer($_SESSION['officer_id']);

$pageTitle  = 'Profile'; 
$activePage = 'profile'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/head.php'; ?>
    <link rel="stylesheet" href="profile.css?v=<?= time() ?>">
</head>
<body>
    <!-- HEADER START -->
        <?php include 'components/header.php'; ?>
    <!-- HEADER END -->

    <!-- ADD COMMITTEE MODAL -->
    <div id="addCommitteeModal" class="modal-overlay">
        <div class="modal-content wide-modal">
            <div class="modal-header">
                <h2>Add Committee Member</h2>
                <button class="close-modal">&times;</button>
            </div>
            <form id="addCommitteeForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" id="firstName" placeholder="First name..." required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" id="lastName" placeholder="Last name..." required>
                    </div>
                    <div class="form-group">
                        <label>Age</label>
                        <input type="number" id="age" placeholder="Age...">
                    </div>
                    <div class="form-group">
                        <label>Course</label>
                        <input type="text" id="course" placeholder="e.g., BSIT-IS...">
                    </div>
                    <div class="form-group">
                        <label>Year Level</label>
                        <select id="yearLevel">
                            <option value="" disabled selected>Select Year</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                            <option value="5">5th Year</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="tel" id="contactNumber" placeholder="Contact number...">
                    </div>
                    <div class="form-group full-width">
                        <label>School Email</label>
                        <input type="email" id="schoolEmail" placeholder="School email...">
                    </div>
                    <div class="form-group full-width">
                        <label>Committee Type</label>
                        <select id="committeeType">
                            <option value="" disabled selected>Select Type</option>
                            <option value="Executive">Executive</option>
                            <option value="Logistics">Logistics</option>
                            <option value="Finance">Finance</option>
                            <option value="Documentation">Documentation</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-delete close-modal">Cancel</button>
                    <button type="submit" class="btn-upload">Add Member</button>
                </div>
            </form>
        </div>
    </div>
    <!-- END ADD COMMITTEE MODAL -->

    <!-- EDIT COMMITTEE MODAL -->
    <div id="editCommitteeModal" class="modal-overlay">
        <div class="modal-content wide-modal">
            <div class="modal-header">
                <h2>Edit Committee Member</h2>
                <button class="close-modal">&times;</button>
            </div>
            <form id="editCommitteeForm">
                <input type="hidden" id="editCommitteeId">
                <div class="form-grid">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" id="editFirstName" placeholder="First name..." required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" id="editLastName" placeholder="Last name..." required>
                    </div>
                    <div class="form-group">
                        <label>Age</label>
                        <input type="number" id="editAge" placeholder="Age...">
                    </div>
                    <div class="form-group">
                        <label>Course</label>
                        <input type="text" id="editCourse" placeholder="e.g., BSIT-IS...">
                    </div>
                    <div class="form-group">
                        <label>Year Level</label>
                        <select id="editYearLevel">
                            <option value="" disabled selected>Select Year</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                            <option value="5">5th Year</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="tel" id="editContactNumber" placeholder="Contact number...">
                    </div>
                    <div class="form-group full-width">
                        <label>School Email</label>
                        <input type="email" id="editSchoolEmail" placeholder="School email...">
                    </div>
                    <div class="form-group full-width">
                        <label>Committee Type</label>
                        <select id="editCommitteeType">
                            <option value="" disabled selected>Select Type</option>
                            <option value="Executive">Executive</option>
                            <option value="Logistics">Logistics</option>
                            <option value="Finance">Finance</option>
                            <option value="Documentation">Documentation</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-delete close-modal">Cancel</button>
                    <button type="submit" class="btn-upload">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <!-- END EDIT COMMITTEE MODAL -->

    <!-- DELETE COMMITTEE MODAL -->
    <div id="deleteCommitteeModal" class="delete-modal">
        <div class="delete-modal-content">
            <h3>Confirm Deletion</h3>
            <p>Are you sure you want to remove <strong id="deleteCommitteeName"></strong> from the committee?</p>
            <div class="delete-modal-actions">
                <button type="button" class="btn-delete" id="cancelDeleteCommittee">Cancel</button>
                <button type="button" class="btn-confirm" id="confirmDeleteCommittee">Delete</button>
            </div>
        </div>
    </div>
    <!-- END DELETE COMMITTEE MODAL -->

    <!-- PFP MODAL -->
    <div id="pfpModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Update Profile Picture</h2>
                <button class="close-modal">&times;</button>
            </div>
            <form id="pfpForm">
                <div class="pfp-upload-container">
                    <div class="pfp-preview" id="imagePreview">
                        <span>No file selected</span>
                    </div>
                    <div class="form-group">
                        <label for="pfpInput">Choose Image</label>
                        <input type="file" id="pfpInput" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-delete close-modal">Cancel</button>
                    <button type="submit" class="btn-upload">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <!-- END PFP MODAL -->

    <!-- USER PROFILE START -->
    <main class="profile-content">
        <section class="profile-container">
            <div class="profile-pic-wrapper">
                <img src="pfp.png" alt="Profile Picture" class="profile-pic-large" id="currentPfp">
                <button class="edit-pfp-btn" title="Change Profile Picture"><i>📷</i></button>
            </div>
            <div class="user-details">
                <h1><?= htmlspecialchars(($officer['firstname'] ?? '') . ' ' . ($officer['lastname'] ?? '')) ?></h1>
                <p><strong>Student ID:</strong> <?= htmlspecialchars($officer['studentid'] ?? 'N/A') ?></p>
                <p><strong>Contact:</strong> <?= htmlspecialchars($officer['contactnumber'] ?? 'N/A') ?></p>
                <p><strong>Year Level:</strong> <?= htmlspecialchars($officer['yearlevel'] ?? 'N/A') ?></p>
                <p><strong>Course:</strong> <?= htmlspecialchars($officer['course'] ?? 'N/A') ?></p>
                <p><strong>Term:</strong> <?= htmlspecialchars($officer['termyear'] ?? 'N/A') ?></p>
                <span class="badge"><?= htmlspecialchars($officer['position'] ?? 'Member') ?></span>
            </div>
        </section>

        <!-- COMMITTEE PORTION START -->
        <section>
            <h2 class="section-title">Committee Members</h2>
            <table class="file-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Committee Type</th>
                        <th style="width: 100px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="committeeTableBody">
                    <?php if (empty($committees)): ?>
                    <tr class="empty-row">
                        <td colspan="4" style="text-align:center; color:#888; padding:24px;">No committee members yet.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($committees as $cm): ?>
                    <tr class="committee-row" data-id="<?= $cm['committeeid'] ?>" data-info='<?= htmlspecialchars(json_encode([
                        'id'            => $cm['committeeid'],
                        'firstName'     => $cm['firstname'],
                        'lastName'      => $cm['lastname'],
                        'age'           => $cm['age'],
                        'course'        => $cm['course'],
                        'yearLevel'     => $cm['yearlevel'],
                        'contactNumber' => $cm['contactnumber'],
                        'schoolEmail'   => $cm['schoolemail'],
                        'committeeType' => $cm['committeetype'],
                        'termYear'      => $cm['termyear'],
                    ]), ENT_QUOTES) ?>'>
                        <td data-label="Student Name"><?= htmlspecialchars($cm['firstname'] . ' ' . $cm['lastname']) ?></td>
                        <td data-label="Email"><?= htmlspecialchars($cm['schoolemail'] ?? 'N/A') ?></td>
                        <td data-label="Committee Type"><?= htmlspecialchars($cm['committeetype'] ?? 'N/A') ?></td>
                        <td class="actions-cell" data-label="Actions">
                            <div class="dropdown">
                                <button class="action-button dropdown-toggle" title="Actions">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item edit-member-btn">
                                        <span class="material-symbols-outlined">edit</span>
                                        <span>Edit Member</span>
                                    </a>
                                    <a href="#" class="dropdown-item delete-member-btn">
                                        <span class="material-symbols-outlined" style="color:#d93025">delete</span>
                                        <span style="color:#d93025">Delete Member</span>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="table-footer">
                <button class="action-button add-committee-btn">+ Add Committee Member</button>
            </div>
        </section>
        <!-- COMMITTEE PORTION END -->

        <!-- ACTIVITY LOG START -->
        <section>
            <h2 class="section-title">Recent Activity</h2>
            <table class="file-table">
                <thead>
                    <tr>
                        <th>Date and Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($activity)): ?>
                    <tr>
                        <td colspan="2" style="text-align:center; color:#888; padding:24px;">No recent activity.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($activity as $log): ?>
                    <tr>
                        <td data-label="Date and Time"><?= htmlspecialchars(($log['activitydate'] ?? '') . ' ' . ($log['activitytime'] ?? '')) ?></td>
                        <td data-label="Action"><?= htmlspecialchars($log['activity'] ?? 'N/A') ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
        <!-- ACTIVITY LOG END -->
    </main>

    <script src="archive.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        // ── Helpers ──────────────────────────────────────────────
        const $ = id => document.getElementById(id);
        const openModal  = id => { $(id).style.display = 'flex'; };
        const closeModal = id => { $(id).style.display = 'none'; };

        // Close any modal when .close-modal is clicked
        document.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.closest('.modal-overlay').style.display = 'none';
            });
        });

        // ── Add Committee ────────────────────────────────────────
        const addBtn  = document.querySelector('.add-committee-btn');
        const addForm = $('addCommitteeForm');
        const tbody   = $('committeeTableBody');

        if (addBtn) addBtn.addEventListener('click', () => openModal('addCommitteeModal'));

        if (addForm) {
            addForm.addEventListener('submit', async e => {
                e.preventDefault();
                const payload = {
                    firstName:     $('firstName').value.trim(),
                    lastName:      $('lastName').value.trim(),
                    age:           $('age').value,
                    course:        $('course').value.trim(),
                    yearLevel:     $('yearLevel').value,
                    contactNumber: $('contactNumber').value.trim(),
                    schoolEmail:   $('schoolEmail').value.trim(),
                    committeeType: $('committeeType').value,
                };
                const res  = await fetch('api/add_committee.php', { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify(payload) });
                const data = await res.json();
                if (data.success) {
                    closeModal('addCommitteeModal');
                    addForm.reset();
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }

        // ── Edit Committee ───────────────────────────────────────
        const editForm = $('editCommitteeForm');

        document.addEventListener('click', e => {
            const editBtn = e.target.closest('.edit-member-btn');
            if (!editBtn) return;
            e.preventDefault();
            // Close dropdown
            editBtn.closest('.dropdown').classList.remove('show');

            const row  = editBtn.closest('.committee-row');
            const info = JSON.parse(row.dataset.info);

            $('editCommitteeId').value   = info.id;
            $('editFirstName').value     = info.firstName;
            $('editLastName').value      = info.lastName;
            $('editAge').value           = info.age ?? '';
            $('editCourse').value        = info.course ?? '';
            $('editYearLevel').value     = info.yearLevel ?? '';
            $('editContactNumber').value = info.contactNumber ?? '';
            $('editSchoolEmail').value   = info.schoolEmail ?? '';
            $('editCommitteeType').value = info.committeeType ?? '';
            openModal('editCommitteeModal');
        });

        if (editForm) {
            editForm.addEventListener('submit', async e => {
                e.preventDefault();
                const payload = {
                    id:            $('editCommitteeId').value,
                    firstName:     $('editFirstName').value.trim(),
                    lastName:      $('editLastName').value.trim(),
                    age:           $('editAge').value,
                    course:        $('editCourse').value.trim(),
                    yearLevel:     $('editYearLevel').value,
                    contactNumber: $('editContactNumber').value.trim(),
                    schoolEmail:   $('editSchoolEmail').value.trim(),
                    committeeType: $('editCommitteeType').value,
                };
                const res  = await fetch('api/update_committee.php', { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify(payload) });
                const data = await res.json();
                if (data.success) {
                    closeModal('editCommitteeModal');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }

        // ── Delete Committee ─────────────────────────────────────
        let pendingDeleteId   = null;
        let pendingDeleteRow  = null;

        document.addEventListener('click', e => {
            const delBtn = e.target.closest('.delete-member-btn');
            if (!delBtn) return;
            e.preventDefault();
            delBtn.closest('.dropdown').classList.remove('show');

            const row  = delBtn.closest('.committee-row');
            const info = JSON.parse(row.dataset.info);
            pendingDeleteId  = info.id;
            pendingDeleteRow = row;
            $('deleteCommitteeName').textContent = info.firstName + ' ' + info.lastName;
            $('deleteCommitteeModal').style.display = 'flex';
        });

        $('cancelDeleteCommittee').addEventListener('click', () => {
            $('deleteCommitteeModal').style.display = 'none';
            pendingDeleteId  = null;
            pendingDeleteRow = null;
        });

        $('confirmDeleteCommittee').addEventListener('click', async () => {
            if (!pendingDeleteId) return;
            const res  = await fetch('api/delete_committee.php', { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify({ id: pendingDeleteId }) });
            const data = await res.json();
            if (data.success) {
                pendingDeleteRow.remove();
                $('deleteCommitteeModal').style.display = 'none';
                if (!tbody.querySelector('.committee-row')) {
                    tbody.innerHTML = '<tr class="empty-row"><td colspan="4" style="text-align:center;color:#888;padding:24px;">No committee members yet.</td></tr>';
                }
            } else {
                alert('Error: ' + data.message);
            }
            pendingDeleteId  = null;
            pendingDeleteRow = null;
        });

    });
    </script>
</body>
</html>