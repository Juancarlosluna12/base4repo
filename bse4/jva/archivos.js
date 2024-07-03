document.addEventListener("DOMContentLoaded", function() {
    const fileTableBody = document.getElementById("file-table-body");
    const uploadStatus = document.getElementById("upload-status");

    function fetchFiles() {
        fetch('../php/consultas.php')
            .then(response => response.json())
            .then(data => {
                const archivos = data.archivos;
                fileTableBody.innerHTML = '';

                archivos.forEach(archivo => {
                    const row = document.createElement("tr");

                    row.innerHTML = `
                        <td>${archivo.nombre}</td>
                        <td>${archivo.tipo}</td>
                        <td>${archivo.fecha_subida}</td>
                        <td class="file-action-buttons">
                            <button class="download-button" onclick="downloadFile('${archivo.ruta}', '${archivo.nombre}')">Descargar</button>
                            <button class="print-button" onclick="printFile('${archivo.ruta}')">Imprimir</button>
                            <button class="delete-button" onclick="deleteFile(${archivo.id})">Eliminar</button>
                            <button class="share-button" onclick="shareFile(${archivo.id})">Compartir</button>
                        </td>
                    `;

                    fileTableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching files:', error));
    }

    fetchFiles();

    
    const uploadForm = document.getElementById("file-upload-form");
    uploadForm.addEventListener("submit", function(event) {
        event.preventDefault();

        const formData = new FormData(uploadForm);

        fetch('../php/consultas.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            uploadStatus.textContent = data.upload_status;
            fetchFiles();
        })
        .catch(error => {
            uploadStatus.textContent = 'Error al subir el archivo.';
            console.error('Error uploading file:', error);
        });
    });

   
    window.downloadFile = function(filePath, fileName) {
        fetch(filePath)
            .then(response => response.blob())
            .then(blob => {
                saveAs(blob, fileName);
            })
            .catch(error => console.error('Error downloading file:', error));
    };

    
    window.printFile = function(filePath) {
        const extension = filePath.split('.').pop().toLowerCase();

        if (extension === 'pdf') {
            fetch(filePath)
                .then(response => response.blob())
                .then(blob => {
                    const url = URL.createObjectURL(blob);
                    const iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    iframe.src = url;
                    document.body.appendChild(iframe);

                    iframe.onload = function() {
                        iframe.contentWindow.print();
                        URL.revokeObjectURL(url);
                        document.body.removeChild(iframe);
                    };
                })
                .catch(error => console.error('Error printing file:', error));
        } else {
           
            const printWindow = window.open(filePath, '_blank');
            printWindow.onload = function() {
                printWindow.print();
            };
        }
    };


    window.deleteFile = function(id) {
        fetch(`../php/consultas.php?delete_id=${id}`)
            .then(response => response.json())
            .then(data => {
                alert(data.delete_status);
                fetchFiles();
            })
            .catch(error => console.error('Error deleting file:', error));
    };

    
    window.shareFile = function(id) {
        fetch(`../php/consultas.php?share_id=${id}`)
            .then(response => response.json())
            .then(data => {
                prompt("Enlace para compartir:", data.share_link);
            })
            .catch(error => console.error('Error sharing file:', error));
    };
});
