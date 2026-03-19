</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Script para marcar el enlace activo automáticamente
        document.querySelectorAll('.sidebar-nav a').forEach(link => {
            if(link.href === window.location.href){
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>