document.addEventListener("DOMContentLoaded", function () {
  const toggleSidebar = document.getElementById("toggleSidebar");
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");

  toggleSidebar.addEventListener("click", function () {
    // Mobile (pakai overlay)
    if (window.innerWidth <= 991) {
      sidebar.classList.toggle("active");
      overlay.classList.toggle("active");
    } else {
      // Desktop: show/hide sidebar
      if (sidebar.style.left === "0px" || sidebar.style.left === "") {
        sidebar.style.left = "-280px";
        document.querySelector(".content").style.marginLeft = "0";
      } else {
        sidebar.style.left = "0";
        document.querySelector(".content").style.marginLeft = "280px";
      }
    }
  });

  // Klik overlay untuk menutup (mobile)
  overlay.addEventListener("click", function () {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
  });
});
