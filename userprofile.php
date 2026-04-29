<?php 
$pageTitle = 'Profile'; 
$activePage = 'profile'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/head.php'; ?>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <!-- HEADER START -->
        <?php include 'components/header.php'; ?>
    <!-- HEADER END -->

    <!-- START MODAL -->
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
                        <input type="number" id="age" placeholder="Age..." required>
                    </div>
                    <div class="form-group">
                        <label>Course</label>
                        <input type="text" id="course" placeholder="e.g., BSIT-IS..." required>
                    </div>
                    <div class="form-group">
                        <label>Year Level</label>
                        <select id="yearLevel" required>
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
                        <input type="tel" id="contactNumber" placeholder="Contact number..." required>
                    </div>
                    <div class="form-group full-width">
                        <label>School Email</label>
                        <input type="email" id="schoolEmail" placeholder="School email..." required>
                    </div>
                    <div class="form-group full-width">
                        <label>Committee Type</label>
                        <select id="committeeType" required>
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
    <!-- END MODAL -->

    <!-- USER PROFILE START -->
    <main class="profile-content">
        <section class="profile-container">
    <div class="profile-pic-wrapper">
        <img src="pfp.png" alt="pfp large" class="profile-pic-large" id="currentPfp">
        <button class="edit-pfp-btn" title="Change Profile Picture">
            <i>📷</i> </button>
    </div>
    <div class="user-details">
        <h1>Harah Castedana</h1>
        <p><strong>Student ID:</strong> 2026-00123</p>
        <p><strong>Email:</strong> hcastedana@usep.edu.ph</p>
        <p><strong>Year Level:</strong> 3rd Year</p>
        <p><strong>Course:</strong> BSIT-IS</p>
        <p><strong>Term:</strong> 2025 - 2026</p>
        <span class="badge">Governor</span>
        </div>
</section>

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
        <!-- USER PROFILE END -->

        <!-- COMMITEE PORTION START -->
        <section>
            <h2 class="section-title">Committee Members</h2>
            <table class="file-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Email</th>
                        <th style="width: 100px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Student Name">Time Edwald</td>
                        <td data-label="Student ID">2025-0001</td>
                        <td data-label="Email">tedwald@usep.edu.ph</td>
                        <td class="actions-cell" data-label="Actions">
                        <div class="actions-menu">
                            <button class="dots-btn">•••</button> 
                            <div class="dropdown-action">
                                <button type="button" class="edit-btn">Edit Member</button>
                                <button type="button" class="delete-btn">Delete Member</button>
                            </div>
                        </div>
                    </td>
                    </tr>
                    <tr>
                        <td data-label="Student Name">Kylie Valence</td>
                        <td data-label="Student ID">2025-0002</td>
                        <td data-label="Email">kvalence@usep.edu.ph</td>
                        <td class="actions-cell" data-label="Actions">
                        <div class="actions-menu">
                            <button class="dots-btn">•••</button> 
                            <div class="dropdown-action">
                                <button type="button" class="edit-btn">Edit Member</button>
                                <button type="button" class="delete-btn">Delete Member</button>
                            </div>
                        </div>
                    </td>
                    </tr>
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
                        <th>File/Item</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Date and Time">03/31/2026, 9:30AM</td>
                        <td data-label="Action">Uploaded</td>
                        <td data-label="File/Item"><a href="#" class="file-link">monthly_report_v1.pdf</a></td>
                    </tr>
                    <tr>
                        <td data-label="Date and Time">03/30/2026, 2:15PM</td>
                        <td data-label="Action">Downloaded</td>
                        <td data-label="File/Item"><a href="#" class="file-link">committee_minutes.docx</a></td>
                    </tr>
                </tbody>
            </table>
        </section>
        <!-- ACTIVITY LOG END -->
    </main>
</body>
</html>