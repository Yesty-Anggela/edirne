document.getElementById('toggle-btn').addEventListener('click', function () {
    var sidebar = document.getElementById('sidebar');
    var content = document.getElementById('content');
    sidebar.classList.toggle('collapsed');
    content.classList.toggle('collapsed');
});
