/*NEW DOCUMENT MODAL*/
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('newDocModal');
    const newBtn = document.querySelector('.new-button');
    const closeBtns = document.querySelectorAll('.close-modal');
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const fileNameInput = document.getElementById('fileName');

    // 1. Open/Close Modal
    newBtn.onclick = () => modal.style.display = 'flex';
    closeBtns.forEach(btn => btn.onclick = () => modal.style.display = 'none');

    // Close on outside click
    window.onclick = (e) => { if (e.target == modal) modal.style.display = 'none'; }

    // 2. Trigger file browser on click
    dropZone.onclick = () => fileInput.click();

    // 3. Handle File Selection (Auto-fill Name)
    fileInput.onchange = () => {
        if (fileInput.files.length > 0) {
            fileNameInput.value = fileInput.files[0].name;
            dropZone.querySelector('.drop-zone-text').innerText = fileInput.files[0].name;
        }
    };

    // 4. Drag and Drop Logic
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
            fileNameInput.value = files[0].name;
            dropZone.querySelector('.drop-zone-text').innerText = files[0].name;
        }
    });
});

/*VIEW BUTTON*/
document.addEventListener('DOMContentLoaded', () => {
    const viewDetailsBtn = document.querySelector('.view-button');
    const previewPane = document.querySelector('.preview-pane');
    const closePreviewBtn = document.querySelector('.close-preview');

    // 1. Open Preview Pane
    if (viewDetailsBtn) {
        viewDetailsBtn.addEventListener('click', () => {
            previewPane.classList.add('active');
        });
    }

    // 2. Close Preview Pane
    if (closePreviewBtn) {
        closePreviewBtn.addEventListener('click', () => {
            previewPane.classList.remove('active');
        });
    }
}); 

