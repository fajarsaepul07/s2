// ========== PRELOADER START ==========
window.onload = function () {
  window.setTimeout(fadeout, 500);
};

function fadeout() {
  document.querySelector(".preloader").style.opacity = "0";
  document.querySelector(".preloader").style.display = "none";
}
// ========== PRELOADER END ==========


// ========== DARK THEME START ==========
const html = document.querySelector("html");
const switcher = document.querySelector("#switch-theme");

if (switcher) {
  switcher.addEventListener("change", function () {
    html.classList.toggle("dark-theme");
  });
}
// ========== DARK THEME END ==========


// ========== SCROLL TO TOP START ==========
var scrollTop = document.querySelector(".scroll-top");

if (scrollTop) {
  window.addEventListener("scroll", function () {
    if (window.scrollY > 200) {
      scrollTop.classList.add("active");
    } else {
      scrollTop.classList.remove("active");
    }
  });

  scrollTop.addEventListener("click", function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  });
}
// ========== SCROLL TO TOP END ==========


// ========== NAVBAR TOGGLER (HEADER-5) ==========
let navbarToggler5 = document.querySelector(".header-5 .navbar-toggler");
var navbarCollapse5 = document.querySelector(".header-5 .navbar-collapse");

if (navbarToggler5) {
  document.querySelectorAll(".header-5 .page-scroll").forEach(e =>
    e.addEventListener("click", () => {
      navbarToggler5.classList.remove("active");
      if (navbarCollapse5) navbarCollapse5.classList.remove('show');
    })
  );

  navbarToggler5.addEventListener('click', function () {
    navbarToggler5.classList.toggle("active");
  });
}
// ========== END NAVBAR TOGGLER HEADER-5 ==========


// ========== NAVBAR TOGGLER (HEADER-6) ==========
let navbarToggler6 = document.querySelector(".header-6 .navbar-toggler");
var navbarCollapse6 = document.querySelector(".header-6 .navbar-collapse");

if (navbarToggler6) {
  document.querySelectorAll(".header-6 .page-scroll").forEach(e =>
    e.addEventListener("click", () => {
      navbarToggler6.classList.remove("active");
      if (navbarCollapse6) navbarCollapse6.classList.remove("show");
    })
  );

  navbarToggler6.addEventListener("click", function () {
    navbarToggler6.classList.toggle("active");
  });
}
// ========== END NAVBAR TOGGLER HEADER-6 ==========


// ========== COUNTER UP ==========
var counterItems = document.querySelectorAll('.counter');

counterItems.forEach(item => {
  var counterUp = window.counterUp["default"];
  var observer = new IntersectionObserver(function (entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting && !item.classList.contains('is-visible')) {
        counterUp(item, { duration: 2000, delay: 16 });
        item.classList.add('is-visible');
      }
    });
  }, {
    threshold: 1
  });

  observer.observe(item);
});
// ========== END COUNTER UP ==========



/* ============================
   MOBILE SWIPE SIDEBAR SUPPORT
   ============================ */

// FIX: Ganti 'sidebar' -> 'mobileSidebar'
let touchStartX = 0;
let touchEndX = 0;

const mobileSidebar = document.getElementById("sidebar");

document.addEventListener("touchstart", function(e) {
    touchStartX = e.changedTouches[0].screenX;
}, false);

document.addEventListener("touchend", function(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSidebarGesture();
}, false);

function handleSidebarGesture() {

    // Geser kanan — buka sidebar
    if (touchEndX > touchStartX + 80) {
        if (window.innerWidth < 992) {
            mobileSidebar.classList.add("show");
        }
    }

    // Geser kiri — tutup sidebar
    if (touchStartX > touchEndX + 80) {
        if (window.innerWidth < 992) {
            mobileSidebar.classList.remove("show");
        }
    }
}
