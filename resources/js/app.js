// resources/js/app.js
import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Dark mode toggle
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('dark-toggle');
    if (toggle) {
        toggle.addEventListener('click', function() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('dark-mode', 'false');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('dark-mode', 'true');
            }
        });
    }
});

// Real-time notification polling
if (document.getElementById('notification-bell')) {
    setInterval(() => {
        fetch('/api/notifications')
            .then(response => response.json())
            .then(data => {
                const count = document.getElementById('notification-count');
                if (data.count > 0) {
                    count.textContent = data.count;
                    count.classList.remove('hidden');
                } else {
                    count.classList.add('hidden');
                }
            });
    }, 30000); // Poll every 30 seconds
}

// File upload preview
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('attachments');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = '';

            Array.from(e.target.files).forEach(file => {
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                const reader = new FileReader();

                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded';

                    if (file.type.startsWith('image/')) {
                        div.innerHTML = `
                            <div class="flex items-center">
                                <img src="${e.target.result}" class="w-10 h-10 object-cover rounded mr-3">
                                <div>
                                    <p class="text-sm font-medium dark:text-gray-200">${file.name}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">${fileSize} MB</p>
                                </div>
                            </div>
                            <button type="button" class="text-red-500 hover:text-red-700 remove-file">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        `;
                    } else {
                        div.innerHTML = `
                            <div class="flex items-center">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium dark:text-gray-200">${file.name}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">${fileSize} MB</p>
                                </div>
                            </div>
                            <button type="button" class="text-red-500 hover:text-red-700 remove-file">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        `;
                    }

                    fileList.appendChild(div);

                    // Add remove functionality
                    div.querySelector('.remove-file').addEventListener('click', function() {
                        div.remove();
                    });
                }

                reader.readAsDataURL(file);
            });
        });
    }
});