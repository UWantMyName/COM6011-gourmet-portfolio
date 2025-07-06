  <footer class="footer animate-on-scroll">
    <div class="container">
      <p class="animate-on-scroll">&copy; 2025 Michelinfolio. All rights reserved.</p>
    </div>
  </footer>

  <!-- Handcrafted scroll animations -->
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-on-scroll').forEach(el => {
      observer.observe(el);
    });
  });
  </script>
</body>
</html>
