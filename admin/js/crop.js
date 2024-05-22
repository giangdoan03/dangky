document.getElementById('uploadZip').addEventListener('change', handleZipFile);

function handleZipFile(event) {
    const file = event.target.files[0];
    if (file) {
        JSZip.loadAsync(file).then(function (zip) {
            const output = document.getElementById('output');
            output.innerHTML = ''; // Clear previous output
            const fileNames = [];
            const imgPromises = [];

            zip.forEach(function (relativePath, zipEntry) {
                if (!zipEntry.dir && /\.(jpe?g|png)$/i.test(zipEntry.name)) {
                    fileNames.push(zipEntry.name);
                    imgPromises.push(
                        zipEntry.async('blob').then(function (blob) {
                            return createImageFromBlob(blob, zipEntry.name);
                        })
                    );
                }
            });

            Promise.all(imgPromises).then(function (imgElements) {
                imgElements.forEach(function (img) {
                    output.appendChild(img);
                });
            });
        });
    }
}

function createImageFromBlob(blob, fileName) {
    return new Promise(function (resolve) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(blob);
        img.classList.add('preview');
        img.dataset.fileName = fileName; // Save original file name in dataset
        img.onload = function () {
            URL.revokeObjectURL(this.src); // Free memory
            resolve(img);
        }
    });
}

function processImages() {
    const images = document.getElementById('output').getElementsByTagName('img');
    const targetWidth = 300;
    const targetHeight = 400;
    const croppedOutput = document.getElementById('croppedOutput');
    const zip = new JSZip();
    croppedOutput.innerHTML = ''; // Clear previous cropped output

    for (let i = 0; i < images.length; i++) {
        const img = images[i];
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        const originalWidth = img.naturalWidth;
        const originalHeight = img.naturalHeight;

        canvas.width = targetWidth;
        canvas.height = targetHeight;

        const scale = Math.min(originalWidth / targetWidth, originalHeight / targetHeight);
        const cropWidth = targetWidth * scale;
        const cropHeight = targetHeight * scale;

        const offsetX = (originalWidth - cropWidth) / 2;
        const offsetY = (originalHeight - cropHeight) / 2;

        ctx.drawImage(img, offsetX, offsetY, cropWidth, cropHeight, 0, 0, targetWidth, targetHeight);

        canvas.toBlob(function (blob) {
            const croppedImg = new Image();
            croppedImg.src = URL.createObjectURL(blob);
            croppedImg.classList.add('cropped');
            croppedImg.dataset.fileName = img.dataset.fileName; // Preserve original file name
            croppedOutput.appendChild(croppedImg);

            zip.file(img.dataset.fileName, blob); // Add blob to zip with original file name

            if (croppedOutput.childElementCount === images.length) {
                zip.generateAsync({ type: 'blob' }).then(function (content) {
                    const downloadLink = document.getElementById('downloadLink');
                    downloadLink.href = URL.createObjectURL(content);
                    downloadLink.download = 'cropped_images.zip';
                    downloadLink.style.display = 'block';
                    downloadLink.textContent = 'Download Cropped Images';
                });
            }
        }, 'image/png');
    }
}
