document.addEventListener("DOMContentLoaded", function() {
    var selectedContent = localStorage.getItem("selectedContent");
    var scrollPosition = localStorage.getItem("scrollPosition");
    
    if (selectedContent) {
        showContent(selectedContent);
    }
    
    if (scrollPosition) {
        window.scrollTo(0, scrollPosition);
    }

    function showContent(contentId) {
        var contents = document.querySelectorAll('.content > div');
        contents.forEach(function(content) {
            content.style.display = 'none';
        });

        document.getElementById(contentId).style.display = 'block';
        localStorage.setItem("selectedContent", contentId);
    }

    function storeScrollPosition() {
        localStorage.setItem("scrollPosition", window.scrollY);
    }

    window.addEventListener('beforeunload', storeScrollPosition);

    document.getElementById('link-listar-vendas').addEventListener('click', function(event) {
        event.preventDefault();
        showContent('listar-vendas-content');
    });

    document.getElementById('link-dashboard').addEventListener('click', function(event) {
        event.preventDefault();
        showContent('dashboard-content');
    });

    document.getElementById('link-clientes').addEventListener('click', function(event) {
        event.preventDefault();
        showContent('clientes-content');
    });

    document.getElementById('link-produtos').addEventListener('click', function(event) {
        event.preventDefault();
        showContent('produtos-content');
    });

    document.getElementById('link-vendas').addEventListener('click', function(event) {
        event.preventDefault();
        showContent('vendas-content');
    });

    document.getElementById('link-sair').addEventListener('click', function(event) {
        event.preventDefault();
        showContent('sair-content');
        localStorage.removeItem("selectedContent");
        localStorage.removeItem("scrollPosition");
        window.location.href = 'logout.php';
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var toggleSidebarBtn = document.getElementById('toggle-sidebar-btn');
    toggleSidebarBtn.addEventListener('click', function() {
        toggleSidebar();
    });

    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('show');
    }
});
