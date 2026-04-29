/* ARCHIVE.JS - REFINED AND CONSOLIDATED */
document.addEventListener('DOMContentLoaded', () => {
    // 1. DOM ELEMENTS
    const modal = document.getElementById('newDocModal');
    const newBtn = document.querySelector('.new-button');
    const closeBtns = document.querySelectorAll('.close-modal');
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const fileNameInput = document.getElementById('fileName');
    
    const tbody = document.getElementById('documentTableBody');
    const previewPane = document.querySelector('.preview-pane');
    const closePreviewBtn = document.querySelector('.close-preview');
    const viewDetailsBtn = document.querySelector('.view-details-btn');
    
    const searchInput = document.querySelector('.search-input');
    const navLinks = document.querySelectorAll('.nav-links a');
    const headerTitle = document.querySelector('.content-header h1');
    
    let currentFilter = 'All Documents';

    // ==========================================
    // 2. MODAL LOGIC (NEW DOCUMENT)
    // ==========================================
    if(newBtn) newBtn.onclick = () => modal.style.display = 'flex';
    if(closeBtns) closeBtns.forEach(btn => btn.onclick = () => modal.style.display = 'none');
    
    window.addEventListener('click', (e) => { 
        if (e.target == modal) modal.style.display = 'none'; 
    });

    if(dropZone && fileInput) dropZone.onclick = () => fileInput.click();

    const maxSizeInMB = 10;
    const maxSizeInBytes = maxSizeInMB * 1024 * 1024;

    function processAndValidateFile(file) {
        if (!file) return;
        if (file.size > maxSizeInBytes) {
            alert(`File is too large! Maximum allowed size is ${maxSizeInMB}MB.`);
            fileInput.value = '';
            fileNameInput.value = '';
            dropZone.querySelector('.drop-zone-text').innerText = 'Drag & drop file or click to browse';
            return;
        }
        fileNameInput.value = file.name;
        dropZone.querySelector('.drop-zone-text').innerText = file.name;
    }

    if(fileInput) {
        fileInput.onchange = () => {
            if (fileInput.files.length > 0) processAndValidateFile(fileInput.files[0]);
        };
    }

    if(dropZone) {
        ['dragover', 'dragleave', 'drop'].forEach(event => {
            dropZone.addEventListener(event, (e) => {
                e.preventDefault();
                if (event === 'dragover') dropZone.classList.add('active');
                else dropZone.classList.remove('active');
            });
        });
        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                processAndValidateFile(files[0]);
            }
        });
    }

    const uploadForm = document.getElementById('uploadForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(uploadForm);
            fetch('api/upload_document.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            })
            .catch(err => alert('Request failed: ' + err));
        });
    }

    // ==========================================
    // 3. SELECTION & PREVIEW LOGIC
    // ==========================================
    function updatePreview(row, openPane = false) {
        if (!row || !previewPane) return;
        tbody.querySelectorAll('tr').forEach(r => r.classList.remove('selected'));
        row.classList.add('selected');

        try {
            const info = JSON.parse(row.getAttribute('data-info'));
            const previewName = previewPane.querySelector('h3');
            const detailSpans = previewPane.querySelectorAll('.preview-details span');

            if (previewName) previewName.textContent = info.name;
            if (detailSpans.length >= 5) {
                detailSpans[0].textContent = info.category;
                detailSpans[1].textContent = info.type;
                detailSpans[2].textContent = info.modified;
                detailSpans[3].textContent = info.owner;
                detailSpans[4].textContent = info.size || 'N/A';
            }
            if (openPane) previewPane.classList.add('active');
        } catch (err) { console.error('Error parsing file info:', err); }
    }

    if (tbody && previewPane) {
        tbody.addEventListener('click', (e) => {
            const row = e.target.closest('tr.file-row');
            if (row) updatePreview(row, previewPane.classList.contains('active'));
        });
    }

    if (viewDetailsBtn && previewPane) {
        viewDetailsBtn.addEventListener('click', () => {
            const selectedRow = tbody.querySelector('tr.file-row.selected');
            if (selectedRow) {
                previewPane.classList.toggle('active');
            } else {
                const firstRow = tbody.querySelector('tr.file-row');
                if (firstRow) updatePreview(firstRow, true);
            }
        });
    }

    if (closePreviewBtn && previewPane) {
        closePreviewBtn.addEventListener('click', () => {
            previewPane.classList.remove('active');
            if (tbody) tbody.querySelectorAll('tr').forEach(r => r.classList.remove('selected'));
        });
    }

    // ==========================================
    // 4. DROPDOWN & DELETE LOGIC
    // ==========================================
    function deleteDocument(id, name, rowToRemove) {
        if (confirm(`Are you sure you want to delete "${name}"?`)) {
            const formData = new FormData();
            formData.append('id', id);
            fetch('api/delete_document.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    if (rowToRemove) rowToRemove.remove();
                    previewPane.classList.remove('active');
                    if (tbody.querySelectorAll('tr.file-row').length === 0) location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            })
            .catch(err => alert('Request failed: ' + err));
        }
    }

    if (tbody) {
        tbody.addEventListener('click', (e) => {
            const toggle = e.target.closest('.dropdown-toggle');
            if (toggle) {
                e.stopPropagation();
                const dropdown = toggle.closest('.dropdown');
                document.querySelectorAll('.dropdown.show').forEach(d => {
                    if (d !== dropdown) d.classList.remove('show');
                });
                dropdown.classList.toggle('show');
                return;
            }

            const delItem = e.target.closest('.delete-doc');
            if (delItem) {
                e.preventDefault();
                e.stopPropagation();
                deleteDocument(delItem.getAttribute('data-id'), delItem.getAttribute('data-name'), delItem.closest('tr.file-row'));
            }
        });
    }

    window.addEventListener('click', (e) => {
        document.querySelectorAll('.dropdown.show').forEach(d => d.classList.remove('show'));
        // Unselect rows if clicking blank space (Added .view-details-btn fix)
        if (tbody && !e.target.closest('tr.file-row') && !e.target.closest('.view-details-btn') && !e.target.closest('.dropdown') && !e.target.closest('.new-button')) {
            tbody.querySelectorAll('tr').forEach(r => r.classList.remove('selected'));
            if (previewPane) previewPane.classList.remove('active');
        }
    });

    // ==========================================
    // 5. FILTER & SEARCH LOGIC
    // ==========================================
    function applyFilters() {
        if (!tbody) return;
        const rows = tbody.querySelectorAll('tr:not(.empty-row)');
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        let visibleCount = 0;

        rows.forEach(row => {
            const docType = row.getAttribute('data-type') || '';
            const fileName = row.querySelector('td:first-child')?.textContent.toLowerCase() || '';
            let showRow = true;

            if (currentFilter !== 'All Documents' && docType !== currentFilter) showRow = false;
            if (searchTerm && !fileName.includes(searchTerm)) showRow = false;

            row.style.display = showRow ? '' : 'none';
            if (showRow) visibleCount++;
        });

        let emptyRow = tbody.querySelector('.empty-row');
        if (visibleCount === 0 && !emptyRow && rows.length > 0) {
            emptyRow = document.createElement('tr');
            emptyRow.className = 'empty-row';
            emptyRow.innerHTML = '<td colspan="7" style="color: #c872b5; text-align: center;"> <strong> NO DOCUMENTS FOUND! </strong></td>';
            tbody.appendChild(emptyRow);
        } else if (visibleCount > 0 && emptyRow) {
            emptyRow.remove();
        }
    }

    if (searchInput) searchInput.addEventListener('input', applyFilters);

    if (navLinks) {
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                navLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');
                // Read text from the label span, not the full anchor (which includes icon text)
                const labelSpan = link.querySelector('span:last-child');
                currentFilter = labelSpan ? labelSpan.textContent.trim() : link.textContent.trim();
                if (headerTitle) headerTitle.textContent = currentFilter;
                applyFilters();
            });
        });
    }

    // ==========================================
    // 3. GLOBAL DROPDOWN HANDLER
    // ==========================================
    document.addEventListener('click', (e) => {
        const toggleBtn = e.target.closest('.dropdown-toggle');
        if (toggleBtn) {
            e.stopPropagation();
            const menu = toggleBtn.closest('.dropdown');
            
            // Close all other open menus
            document.querySelectorAll('.dropdown.show').forEach(m => {
                if (m !== menu) m.classList.remove('show');
            });
            
            menu.classList.toggle('show');
            return;
        }

        // Close all menus if clicking outside
        document.querySelectorAll('.dropdown.show').forEach(m => m.classList.remove('show'));
    });
});