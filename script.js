function initializeMobileMenu() {
            const btn = document.querySelector("button.mobile-menu-button");
            const menu = document.querySelector(".mobile-menu");

            if (btn && menu) {
                btn.addEventListener("click", () => {
                    menu.classList.toggle("hidden");
                });

                // Close mobile menu when a link is clicked
                menu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        menu.classList.add('hidden');
                        // Update active state when a mobile menu link is clicked
                        const targetId = link.getAttribute('href').substring(1);
                        setActiveNavLink(targetId);
                    });
                });
            }
        }

        // Function to set the active navigation link styling
        function setActiveNavLink(activeLinkId) {
            // Remove active styling from all desktop nav links
            document.querySelectorAll('#main-header .md\\:flex a').forEach(link => {
                link.classList.remove('text-red-500', 'font-semibold', 'border-b-2', 'border-red-500');
                link.classList.add('text-gray-300'); // Atur kembali ke warna default
            });

            // Add active styling to the specified desktop nav link
            const activeLink = document.getElementById(activeLinkId + '-nav-link');
            if (activeLink) {
                activeLink.classList.remove('text-gray-300'); // Hapus warna default
                activeLink.classList.add('text-red-500', 'font-semibold', 'border-b-2', 'border-red-500'); // Tambahkan gaya aktif
            }

            // Also update active styling for mobile menu links (if applicable)
            document.querySelectorAll('.mobile-menu a').forEach(link => {
                link.classList.remove('bg-red-500', 'text-white', 'font-semibold');
                link.classList.add('text-gray-300', 'hover:bg-gray-800'); // Default mobile link style
            });
            const activeMobileLink = document.querySelector(`.mobile-menu a[href="#${activeLinkId}"]`);
            if (activeMobileLink) {
                activeMobileLink.classList.remove('text-gray-300', 'hover:bg-gray-800');
                activeMobileLink.classList.add('bg-red-500', 'text-white', 'font-semibold');
            }
        }

        // Function to handle section fade-in animation on scroll (removed fade-out)
        function initializeScrollAnimations() {
            const elementsToAnimate = document.querySelectorAll('.animate-on-scroll');

            const sectionObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        // Stop observing this element once it's visible to prevent it from fading out again
                        sectionObserver.unobserve(entry.target);
                    }
                    // Removed the 'else' block that removed 'is-visible' class,
                    // so elements remain visible once they have animated in.
                });
            }, {
                root: null,
                rootMargin: '0px',
                threshold: 0.1 // Trigger when 10% of the element is visible
            });

            elementsToAnimate.forEach(element => {
                sectionObserver.observe(element);
            });

            // Observer for updating active navigation link based on scroll position
            const sections = document.querySelectorAll('section[id]');
            const navLinkObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        setActiveNavLink(entry.target.id);
                    }
                });
            }, {
                root: null,
                rootMargin: '-50% 0px -49% 0px', // Adjust this to control when the active state changes
                threshold: 0 // Threshold 0 means it triggers as soon as any part of the element enters/leaves
            });

            sections.forEach(section => {
                navLinkObserver.observe(section);
            });
        }

        // Function to handle navbar blur effect on scroll
        function initializeNavbarBlur() {
            const mainHeader = document.getElementById('main-header');
            if (mainHeader) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 80) { // Apply blur after scrolling 80px (adjust as needed)
                        mainHeader.classList.add('navbar-blurred');
                    } else {
                        mainHeader.classList.remove('navbar-blurred');
                    }
                });
            }
        }

        // Function to handle portfolio filter functionality
        function initializePortfolioFilter() {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const portfolioItems = document.querySelectorAll('.portfolio-item');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    filterBtns.forEach(b => {
                        b.classList.remove('bg-red-600', 'text-white');
                        b.classList.add('bg-transparent', 'text-gray-300');
                    });
                    btn.classList.remove('bg-transparent', 'text-gray-300');
                    btn.classList.add('bg-red-600', 'text-white');

                    const filter = btn.getAttribute('data-filter');
                    
                    // Animate out current visible items, then filter and animate in new ones
                    const itemsToHide = Array.from(portfolioItems).filter(item => 
                        item.classList.contains('is-visible') && (filter !== 'all' && item.getAttribute('data-category') !== filter)
                    );
                    const itemsToShow = Array.from(portfolioItems).filter(item => 
                        !item.classList.contains('is-visible') && (filter === 'all' || item.getAttribute('data-category') === filter)
                    );

                    // Fade out items that should be hidden
                    itemsToHide.forEach(item => {
                        item.classList.remove('is-visible');
                        // Hide after transition
                        setTimeout(() => {
                            item.style.display = 'block'; // Keep display as block for smooth transition out
                            item.style.opacity = '0'; // Start fade out
                            item.style.transform = 'translateY(30px)'; // Start moving out
                            setTimeout(() => {
                                item.style.display = 'none'; // Then hide
                            }, 1000); // Match transition duration
                        }, 0); // Start immediately
                    });

                    // Show and fade in items that should be visible
                    itemsToShow.forEach(item => {
                        item.style.display = 'block'; // Or 'grid', 'flex' depending on layout
                        // Reset opacity and transform before animating in
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(30px)';
                        setTimeout(() => {
                            item.classList.add('is-visible'); // Trigger fade in
                        }, 50); // Small delay to allow display change to register
                    });
                });
            });
        }

        // Initialize all functionalities when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', () => {
            initializeMobileMenu();
            initializeScrollAnimations();
            initializeNavbarBlur();
            initializePortfolioFilter();
            
            // Set initial active link based on current URL hash or default to home
            const initialSection = window.location.hash ? window.location.hash.substring(1) : 'home';
            setActiveNavLink(initialSection);

            // Add click listeners to desktop navigation links
            document.querySelectorAll('#main-header .md\\:flex a').forEach(link => {
                link.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevent default anchor jump
                    const targetId = link.getAttribute('href').substring(1);
                    setActiveNavLink(targetId);
                    // Smooth scroll to the target section
                    document.getElementById(targetId).scrollIntoView({ behavior: 'smooth' });
                });
            });
        });

    // --- CRUD Portfolio LocalStorage ---
function getPortfolioData() {
    return JSON.parse(localStorage.getItem('portfolioData') || '[]');
}
function setPortfolioData(data) {
    localStorage.setItem('portfolioData', JSON.stringify(data));
}
function renderPortfolio() {
    const container = document.querySelector('#portfolio .grid');
    if (!container) return;
    container.innerHTML = '';
    const data = getPortfolioData();
    data.forEach((item, idx) => {
        const div = document.createElement('div');
        div.className = `card portfolio-item animate-on-scroll is-visible`;
        div.setAttribute('data-category', item.category);
        div.innerHTML = `
            <div class="bg-gray-800 rounded-xl overflow-hidden shadow-xl relative">
                <img src="${item.image}" alt="${item.title}" class="w-full h-52 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-100">${item.title}</h3>
                    <p class="text-gray-400 mt-2">${item.desc}</p>
                    <div class="flex mt-4 space-x-2">
                        <button onclick="editPortfolio(${idx})" class="text-yellow-400 hover:underline">Edit</button>
                        <button onclick="deletePortfolio(${idx})" class="text-red-400 hover:underline">Delete</button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(div);
    });
}
window.editPortfolio = function(idx) {
    const data = getPortfolioData();
    const item = data[idx];
    document.getElementById('portfolio-id').value = idx;
    document.getElementById('portfolio-title').value = item.title;
    document.getElementById('portfolio-category').value = item.category;
    document.getElementById('portfolio-image').value = item.image;
    document.getElementById('portfolio-desc').value = item.desc;
    document.getElementById('portfolio-cancel').classList.remove('hidden');
}
window.deletePortfolio = function(idx) {
    if (!confirm('Delete this item?')) return;
    const data = getPortfolioData();
    data.splice(idx, 1);
    setPortfolioData(data);
    renderPortfolio();
}
document.addEventListener('DOMContentLoaded', () => {
    // CRUD Form
    const form = document.getElementById('portfolio-form');
    if (form) {
        form.onsubmit = function(e) {
            e.preventDefault();
            const id = document.getElementById('portfolio-id').value;
            const title = document.getElementById('portfolio-title').value;
            const category = document.getElementById('portfolio-category').value;
            const image = document.getElementById('portfolio-image').value;
            const desc = document.getElementById('portfolio-desc').value;
            let data = getPortfolioData();
            if (id) {
                data[id] = { title, category, image, desc };
            } else {
                data.push({ title, category, image, desc });
            }
            setPortfolioData(data);
            renderPortfolio();
            form.reset();
            document.getElementById('portfolio-id').value = '';
            document.getElementById('portfolio-cancel').classList.add('hidden');
        };
        document.getElementById('portfolio-cancel').onclick = function() {
            form.reset();
            document.getElementById('portfolio-id').value = '';
            this.classList.add('hidden');
        };
    }
    renderPortfolio();
});