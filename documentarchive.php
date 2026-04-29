<?php 
require_once __DIR__ . '/components/check_auth.php';
require_once __DIR__ . '/classes/DocumentArchive.php';
$documentModel = new DocumentArchive();
$documents = $documentModel->getAllDocuments();

$pageTitle = 'Document Archive'; 
$activePage = 'archive'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/head.php'; ?>
    <link rel="stylesheet" href="archive.css?v=<?= time() ?>">
    <script src="archive.js?v=<?= time() ?>"></script>
</head>


<body>
    <!-- HEADER START -->
        <?php include 'components/header.php'; ?>
    <!-- HEADER END -->
     
    <!-- MAIN CONTENT START -->
    <div class="app-body">

        <!-- SIDE BAR START -->

        <aside class="sidebar">
            <button class="new-button"><span class="material-symbols-outlined">add</span> New</button>
            <nav class="nav-links">
                <a href="#" class="all-documents active"><span class="material-symbols-outlined">grid_view</span> <span>All Documents</span></a>
                <a href="#"><span class="material-symbols-outlined">description</span> <span>Financial Reports</span></a>
                <a href="#"><span class="material-symbols-outlined">groups</span> <span>Meeting Minutes</span></a>
                <a href="#"><span class="material-symbols-outlined">inventory_2</span> <span>Canvassing Files</span></a>
                <a href="#"><span class="material-symbols-outlined">assignment</span> <span>Project Proposals</span></a>
                <a href="#"><span class="material-symbols-outlined">gavel</span> <span>Resolutions</span></a>
                <a href="#"><span class="material-symbols-outlined">campaign</span> <span>Official Memorandums</span></a>
                <a href="#"><span class="material-symbols-outlined">mail</span> <span>Official Letters</span></a>
                <a href="#"><span class="material-symbols-outlined">more_horiz</span> <span>Miscellaneous</span></a>
            </nav>
        </aside>
        <!-- SIDE BAR END -->

        <!-- MODAL START -->
        <div id="newDocModal" class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Upload New Document</h2>
                    <button class="close-modal">&times;</button>
                </div>
                <form id="uploadForm">
                    <div id="dropZone" class="drop-zone">
                        <span class="drop-zone-text">Drag & drop file or click to browse</span>
                        <input type="file" name="fileInput" id="fileInput" accept=".pdf, .doc, .docx, .xls, .xlsx" required hidden>
                    </div>
                    
                    <small style="display: block; text-align: center; margin-bottom: 16px; margin-top: -16px; color: #5f6368; font-size: 12px;">
                        Max file size: 10MB. Allowed formats: PDF, Word, Excel.
                    </small>
                    
                    <div class="form-group">
                        <label>File Name</label>
                        <input type="text" id="fileName" name="fileName" placeholder="Enter custom name..." required>
                    </div>
                    <div class="form-group">
                        <label>Document Type</label>
                        <select id="docCategory" name="docCategory" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="Financial Reports">Financial Reports</option>
                            <option value="Meeting Minutes">Meeting Minutes</option>
                            <option value="Canvassing Files">Canvassing Files</option>
                            <option value="Project Proposals">Project Proposals</option>
                            <option value="Resolutions">Resolutions</option>
                            <option value="Official Memorandums">Official Memorandums</option>
                            <option value="Official Letters">Official Letters</option>
                            <option value="Miscellaneous">Miscellaneous</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Security Category</label>
                        <select id="securityCategory" name="securityCategory" required>
                            <option value="" disabled selected>Select Category</option>
                            <option value="Internal">Internal</option>
                            <option value="External">External</option>
                            <option value="Confidential">Confidential</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-delete close-modal">Cancel</button>
                        <button type="submit" class="btn-upload">Upload Document</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- MODAL END -->

        <!-- FILE TABLE START -->
        <main class="main-content">
            <!-- TOP BAR START -->
            <header class="content-header">
                <h1>All Documents</h1>
                
                <form class="search-form">
                    <div class="search-wrapper">
                        <span class="material-symbols-outlined search-icon">search</span>
                        <input type="text" class="search-input with-icon" placeholder="Search Drive...">
                    </div>
                </form>

                <div class="view-controls">
                    <button class="icon-button" title="List View">
                        <span class="material-symbols-outlined">view_list</span>
                    </button>
                    <button class="icon-button" title="Settings">
                        <span class="material-symbols-outlined">settings</span>
                    </button>
                    <button class="view-details-btn">
                        <span class="material-symbols-outlined">info</span>
                        <span>View Details</span>
                    </button>
                </div>
            </header>
            <!-- TOP BAR END -->

            <!-- FILES HERE START -->
            <section class="file-section">
                <p class="section-subtitle">Files</p>
                <table class="file-table">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>CATEGORY</th>
                            <th>LAST MODIFIED</th>
                            <th>OWNER</th>
                            <th style="width: 50px;"></th>
                        </tr>
                    </thead>
                    <tbody id="documentTableBody">
                        <?php if (empty($documents)): ?>
                        <tr class="empty-row">
                            <td colspan="5" style="text-align: center; color: #666;"><strong>NO DOCUMENTS YET!</strong></td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($documents as $doc): 
                                $fileSize = isset($doc['filesize']) ? round($doc['filesize'] / 1024, 2) . ' KB' : 'N/A';
                                $fileInfo = json_encode([
                                    'id' => $doc['documentid'],
                                    'name' => $doc['documentname'],
                                    'category' => $doc['category'],
                                    'type' => $doc['documenttype'],
                                    'modified' => date('M d, Y', strtotime($doc['creationdate'])),
                                    'owner' => $doc['lastname'] ?? 'N/A',
                                    'path' => $doc['documentfilepath'],
                                    'size' => $fileSize
                                ]);
                            ?>
                            <tr class="file-row" data-type="<?= htmlspecialchars($doc['documenttype'] ?? '') ?>" data-category="<?= htmlspecialchars($doc['category'] ?? '') ?>" data-info='<?= htmlspecialchars($fileInfo, ENT_QUOTES, 'UTF-8') ?>'>
                                <td data-label="Name">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span class="material-symbols-outlined" style="color: #5f6368;">description</span>
                                        <?= htmlspecialchars($doc['documentname']) ?>
                                    </div>
                                </td>
                                <td data-label="Category"><?= htmlspecialchars($doc['category']) ?></td>
                                <td data-label="Last modified"><?= htmlspecialchars(date('M d, Y', strtotime($doc['creationdate']))) ?></td>
                                <td data-label="Owner"><?= htmlspecialchars($doc['lastname'] ?? 'N/A') ?></td>
                                <td class="actions-cell">
                                    <div class="dropdown">
                                        <button class="action-button dropdown-toggle"><span class="material-symbols-outlined">more_vert</span></button>
                                        <div class="dropdown-menu">
                                            <a href="<?= htmlspecialchars($doc['documentfilepath']) ?>" download class="dropdown-item">
                                                <span class="material-symbols-outlined">download</span>
                                                <span>Download</span>
                                            </a>
                                            <a href="#" class="dropdown-item edit-doc">
                                                <span class="material-symbols-outlined">edit</span>
                                                <span>Edit</span>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item delete-doc" data-id="<?= $doc['documentid'] ?>" data-name="<?= htmlspecialchars($doc['documentname']) ?>">
                                                <span class="material-symbols-outlined" style="color: #d93025;">delete</span>
                                                <span style="color: #d93025;">Delete</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
            <!-- FILES HERE END -->
        </main>
        <!-- FILE TABLE END -->

        <!-- PREVIEW PANE START -->
        <aside class="preview-pane">
            <div class="preview-header">
                <h3>File Details</h3>
                <button class="close-preview">×</button>
            </div>
            <div class="preview-thumbnail">
                <span class="material-symbols-outlined" style="font-size: 64px; color: #dadce0;">description</span>
            </div>
            <div class="preview-details">
                <p><strong>Category:</strong> <span>-</span></p>
                <p><strong>Type:</strong> <span>-</span></p>
                <p><strong>Modified:</strong> <span>-</span></p>
                <p><strong>Owner:</strong> <span>-</span></p>
                <p><strong>Size:</strong> <span>-</span></p>
            </div>
            <div class="preview-actions">
                <button class="action-button delete-safe">Delete Document</button>
            </div>
        </aside>
        <!-- PREVIEW PANE END -->
        </div>
</body>
</html>