document.addEventListener('DOMContentLoaded', () => {
    // Set the current year in the footer
    document.getElementById('year').textContent = new Date().getFullYear();

    // --- Impact Counter Animation Logic (Keep existing code here) ---
    // ... (Your existing counter animation code goes here) ...

    const counters = document.querySelectorAll('.counter-value');
    const speed = 200; // Adjust speed for faster/slowwer count

    const animateCounter = (counter) => {
        const target = +counter.getAttribute('data-target');
        const initialCount = 0;
        const duration = Math.floor(speed / target);
        
        let count = initialCount;

        const updateCount = () => {
            if (count < target) {
                // Increment by 1 or a calculated step for smooth animation
                count++; 
                counter.textContent = count;
                setTimeout(updateCount, duration);
            } else {
                // Ensure it stops exactly on the target value
                counter.textContent = target; 
            }
        };

        updateCount();
    };

    const counterSection = document.querySelector('.impact-counters');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    counters.forEach(animateCounter);
                    observer.unobserve(entry.target); 
                }
            });
        }, {
            rootMargin: '0px 0px -100px 0px' 
        });

        if (counterSection) {
            observer.observe(counterSection);
        }

    } else {
        if (counterSection) {
             counters.forEach(animateCounter);
        }
    }


    // --- Navbar Dropdown and Mobile Toggle Logic (FINAL FIXED) ---
const dropdowns = document.querySelectorAll('.nav-item.dropdown');
const navbarCollapse = document.querySelector('.navbar-collapse');

// ✅ 1. Desktop: Hover to open dropdown
dropdowns.forEach(dropdown => {
  const toggle = dropdown.querySelector('.dropdown-toggle');
  const bsDropdown = new bootstrap.Dropdown(toggle);

  // Desktop hover logic
  if (window.matchMedia('(min-width: 992px)').matches) {
    dropdown.addEventListener('mouseenter', () => {
      bsDropdown.show();
    });
    dropdown.addEventListener('mouseleave', () => {
      bsDropdown.hide();
    });
  }

  // ✅ 2. Mobile: Tap to open dropdown
  toggle.addEventListener('click', (e) => {
    if (window.matchMedia('(max-width: 991px)').matches) {
      e.preventDefault(); // stop auto navigation
      const isShown = toggle.classList.contains('show');
      document.querySelectorAll('.dropdown-toggle.show').forEach(openToggle => {
        if (openToggle !== toggle) {
          bootstrap.Dropdown.getInstance(openToggle).hide();
        }
      });
      if (!isShown) {
        bsDropdown.show();
      } else {
        bsDropdown.hide();
      }
    }
  });
});



// ✅ 3. Mobile: Close menu only when link (non-dropdown) is clicked
const navLinks = document.querySelectorAll('.nav-link:not(.dropdown-toggle)');
navLinks.forEach(link => {
  link.addEventListener('click', () => {
    if (navbarCollapse.classList.contains('show')) {
      const bsCollapse = new bootstrap.Collapse(navbarCollapse, { toggle: true });
      bsCollapse.hide();
    }
  });
});

const navbarToggler = document.querySelector('.navbar-toggler');
const bsCollapse = new bootstrap.Collapse(navbarCollapse, { toggle: false });

navbarToggler.addEventListener('click', () => {
  if (navbarCollapse.classList.contains('show')) {
    bsCollapse.hide(); // Close menu
  } else {
    bsCollapse.show(); // Open menu
  }
});


});