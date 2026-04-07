/*NEW DOCUMENT MODAL*/
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('newDocModal');
    const newBtn = document.querySelector('.new-button');
    const closeBtns = document.querySelectorAll('.close-modal');
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const fileNameInput = document.getElementById('fileName');

    // 1. Open/Close Modal
    if(newBtn) newBtn.onclick = () => modal.style.display = 'flex';
    if(closeBtns) closeBtns.forEach(btn => btn.onclick = () => modal.style.display = 'none');

    // Close on outside click
    window.onclick = (e) => { if (e.target == modal) modal.style.display = 'none'; }

    // 2. Trigger file browser on click
    if(dropZone && fileInput) dropZone.onclick = () => fileInput.click();

    // ==========================================
    // VALIDATION HELPER FUNCTION
    // ==========================================
    const maxSizeInMB = 10;
    const maxSizeInBytes = maxSizeInMB * 1024 * 1024;

    function processAndValidateFile(file) {
        if (!file) return;

        // Check if file exceeds size limit
        if (file.size > maxSizeInBytes) {
            alert(`File is too large! Maximum allowed size is ${maxSizeInMB}MB.`);
            fileInput.value = ''; // Clear the hidden input
            fileNameInput.value = ''; // Clear the text box
            dropZone.querySelector('.drop-zone-text').innerText = 'Drag & drop file or click to browse'; // Reset UI
            return;
        }

        // If valid, update the UI
        fileNameInput.value = file.name;
        dropZone.querySelector('.drop-zone-text').innerText = file.name;
    }

    // 3. Handle File Selection (Via Click/Browse)
    if(fileInput) {
        fileInput.onchange = () => {
            if (fileInput.files.length > 0) {
                processAndValidateFile(fileInput.files[0]);
            }
        };
    }

    // 4. Drag and Drop Logic
    if(dropZone) {
        ['dragover', 'dragleave', 'drop'].forEach(event => {
            dropZone.addEventListener(event, (e) => {
                e.preventDefault();
                if (event === 'dragover') dropZone.classList.add('active');
                else dropZone.classList.remove('active');
            });
        });

        // Handle File Selection (Via Drag & Drop)
        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files; // Assign dropped files to the hidden input
                processAndValidateFile(files[0]);
            }
        });
    }
});

/*VIEW BUTTON*/
document.addEventListener('DOMContentLoaded', () => {
    const viewDetailsBtn = document.querySelector('.view-button');
    const previewPane = document.querySelector('.preview-pane');
    const closePreviewBtn = document.querySelector('.close-preview');

    // 1. Open Preview Pane
    if (viewDetailsBtn && previewPane) {
        viewDetailsBtn.addEventListener('click', () => {
            previewPane.classList.add('active');
        });
    }

    // 2. Close Preview Pane
    if (closePreviewBtn && previewPane) {
        closePreviewBtn.addEventListener('click', () => {
            previewPane.classList.remove('active');
        });
    }
});