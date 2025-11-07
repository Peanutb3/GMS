import './bootstrap';

document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const iconExpand = document.getElementById('iconExpand');
    const iconCollapse = document.getElementById('iconCollapse');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-collapsed');

            // Toggle icons
            const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
            iconExpand.classList.toggle('hidden', !isCollapsed);
            iconCollapse.classList.toggle('hidden', isCollapsed);
        });
    }
});
