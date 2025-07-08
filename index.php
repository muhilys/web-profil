<?php
require_once 'config.php';
$nama = "Muhammad Ilyas";
$umur = 20;
$email = "muhammadilyas10p@gmail.com";
$kota = "Semarang, Jawa Tengah";
$portfolio = [];
$result = $conn->query("SELECT * FROM portfolio ORDER BY id DESC");
while ($row = $result->fetch_assoc()) {
    $portfolio[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nama; ?> - Pengembang Web Kreatif</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom Tailwind CSS Output -->
    <link href="./output.css" rel="stylesheet">
</head>
<body class="bg-gray-950 text-gray-100 font-[Poppins]">

    <!-- Navigation -->
    <nav id="main-header" class="bg-transparent fixed w-full z-50 transition-all duration-300 py-4">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center">
                <a href="#" class="flex items-center py-2 px-2">
                    <span class="font-extrabold text-2xl text-red-500 tracking-wide"><?php echo $nama; ?></span>
                </a>
                <!-- Desktop Navbar -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="#home" id="home-nav-link" class="py-2 px-3 text-red-500 font-semibold border-b-2 border-red-500 transition duration-300 hover:text-red-400">Home</a>
                    <a href="#about" id="about-nav-link" class="py-2 px-3 text-gray-300 hover:text-red-400 transition duration-300">About</a>
                    <a href="#skills" id="skills-nav-link" class="py-2 px-3 text-gray-300 hover:text-red-400 transition duration-300">Skills</a>
                    <a href="#portfolio" id="portfolio-nav-link" class="py-2 px-3 text-gray-300 hover:text-red-400 transition duration-300">Portfolio</a>
                    <a href="#contact" id="contact-nav-link" class="py-2 px-3 text-gray-300 hover:text-red-400 transition duration-300">Contact</a>
                </div>
                <a href="./admin/admin.php" class="text-red-500 hover:text-red-600 font-semibold">Admin Login</a>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="outline-none mobile-menu-button p-2 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <svg class="w-7 h-7 text-gray-300" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div class="hidden mobile-menu md:hidden absolute w-full left-0 top-full shadow-lg rounded-b-lg bg-gray-900">
            <ul class="py-4">
                <li><a href="#home" class="block text-sm px-6 py-3 text-red-500 font-semibold hover:bg-gray-800 transition duration-300">Home</a></li>
                <li><a href="#about" class="block text-sm px-6 py-3 text-gray-300 hover:bg-gray-800 transition duration-300">About</a></li>
                <li><a href="#skills" class="block text-sm px-6 py-3 text-gray-300 hover:bg-gray-800 transition duration-300">Skills</a></li>
                <li><a href="#portfolio" class="block text-sm px-6 py-3 text-gray-300 hover:bg-gray-800 transition duration-300">Portfolio</a></li>
                <li><a href="#contact" class="block text-sm px-6 py-3 text-gray-300 hover:bg-gray-800 transition duration-300">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen flex items-center justify-center pt-24 pb-12 bg-gray-950 overflow-hidden">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-center px-6 relative z-10 text-center md:text-left">
            <div class="md:w-1/2 flex flex-col items-center md:items-start mb-10 md:mb-0 animate-on-scroll">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">Halo, Ini <span class="text-red-600"><?php echo $nama; ?></span></h1>
                <p class="text-xl md:text-3xl font-light mb-6 text-gray-300">Saya seorang <span class="font-semibold text-red-400">Pengembang Web Kreatif</span></p>
                <p class="text-gray-400 mb-8 max-w-lg">
                    Saya berpengalaman dalam membangun website modern dan interaktif, siap membantu Anda mewujudkan ide digital terbaik!
                </p>
                <div class="flex space-x-4">
                    <a href="#contact" class="bg-red-600 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-red-700 transition duration-300 shadow-lg">Rekrut Saya</a>
                    <a href="#portfolio" class="bg-transparent border-2 border-red-500 text-red-500 px-8 py-3 rounded-full text-lg font-semibold hover:bg-red-500 hover:text-white transition duration-300 shadow-lg">Portofolio</a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center animate-on-scroll">
                <img src="fotoku.jpg" onerror="this.onerror=null;this.src='https://placehold.co/384x384/667EEA/FFFFFF?text=Foto%20Anda';" alt="Professional portrait of <?php echo $nama; ?>" class="rounded-full border-8 border-gray-800 shadow-2xl w-72 h-72 md:w-96 md:h-96 object-cover transform hover:scale-105 transition duration-500">
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-900">
        <div class="container mx-auto px-6 max-w-6xl">
            <h2 class="text-4xl font-bold text-center mb-16 text-gray-100 animate-on-scroll">Tentang <span class="text-red-500">Saya</span></h2>
            <div class="flex flex-col md:flex-row items-center md:space-x-12">
                <div class="md:w-1/3 mb-10 md:mb-0 flex justify-center animate-on-scroll">
                    <img src="fotoku.jpg" onerror="this.onerror=null;this.src='https://placehold.co/300x300/A78BFA/FFFFFF?text=Ilustrasi';" alt="<?php echo $nama; ?>" class="rounded-xl shadow-xl w-72 md:w-full transform transition-transform duration-500 hover:scale-105">
                </div>
                <div class="md:w-2/3 md:pl-8 animate-on-scroll">
                    <h3 class="text-3xl font-semibold mb-6 text-gray-100">Siapa Saya?</h3>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Saya seorang pengembang web yang bersemangat dengan pengalaman lebih dari 5 tahun dalam menciptakan situs web yang indah dan fungsional. Saya berspesialisasi dalam pengembangan front-end tetapi juga memiliki pengalaman dengan teknologi back-end. Tujuan saya adalah membangun aplikasi yang tidak hanya menarik secara visual tetapi juga memberikan pengalaman pengguna yang luar biasa.
                    </p>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Di luar coding, saya menikmati fotografi. Saya percaya bahwa kehidupan yang seimbang di luar pekerjaan menjadikan saya pengembang yang lebih baik.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <div>
                            <p class="text-gray-200"><span class="font-semibold text-red-400">Nama:</span> <?php echo $nama; ?></p>
                            <p class="text-gray-200"><span class="font-semibold text-red-400">Umur:</span> <?php echo $umur; ?></p>
                        </div>
                        <div>
                            <p class="text-gray-200"><span class="font-semibold text-red-400">Email:</span> <?php echo $email; ?></p>
                            <p class="text-gray-200"><span class="font-semibold text-red-400">Dari:</span> <?php echo $kota; ?></p>
                        </div>
                    </div>
                    <a href="Profile.cv.pdf" class="bg-red-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-red-700 transition duration-300 shadow-lg">Download CV</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-20 bg-gray-950">
        <div class="container mx-auto px-6 max-w-6xl">
            <h2 class="text-4xl font-bold text-center mb-16 text-gray-100 animate-on-scroll">Keahlian <span class="text-red-500">Saya</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-900 p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 animate-on-scroll">
                    <h3 class="text-2xl font-semibold text-red-400 mb-4">Pengembangan Front-end</h3>
                    <p class="text-gray-300 mb-4">HTML, CSS, JavaScript, React, Vue.js, Tailwind CSS, Bootstrap.</p>
                    <div class="w-full bg-gray-700 rounded-full h-2.5">
                        <div class="bg-red-600 h-2.5 rounded-full" style="width: 90%"></div>
                    </div>
                    <p class="text-right text-gray-400 text-sm mt-1">90%</p>
                </div>
                <div class="bg-gray-900 p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 animate-on-scroll">
                    <h3 class="text-2xl font-semibold text-red-400 mb-4">Pengembangan Back-end</h3>
                    <p class="text-gray-300 mb-4">PHP, Node.js, Express, MySQL, MongoDB.</p>
                    <div class="w-full bg-gray-700 rounded-full h-2.5">
                        <div class="bg-red-600 h-2.5 rounded-full" style="width: 75%"></div>
                    </div>
                    <p class="text-right text-gray-400 text-sm mt-1">75%</p>
                </div>
                <div class="bg-gray-900 p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 animate-on-scroll">
                    <h3 class="text-2xl font-semibold text-red-400 mb-4">Desain UI/UX</h3>
                    <p class="text-gray-300 mb-4">Figma, Adobe XD, Wireframing, Prototyping, User Research.</p>
                    <div class="w-full bg-gray-700 rounded-full h-2.5">
                        <div class="bg-red-600 h-2.5 rounded-full" style="width: 80%"></div>
                    </div>
                    <p class="text-right text-gray-400 text-sm mt-1">80%</p>
                </div>
            </div>
        </div>
    </section>

        <!-- Portfolio Section -->
        <section id="portfolio" class="py-20 bg-gray-900">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($portfolio as $item): ?>
                <div class="bg-gray-950 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 animate-on-scroll">
                <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-red-400 mb-2"><?= htmlspecialchars($item['title']) ?></h3>
                    <p class="text-gray-300 text-sm mb-4"><?= htmlspecialchars($item['description']) ?></p>
                    <a href="<?= htmlspecialchars($item['project_link']) ?>" target="_blank" class="text-red-500 hover:text-red-600 font-semibold text-sm">Lihat Proyek &rarr;</a>
                </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($portfolio)): ?>
                <div class="col-span-full text-center text-gray-400">Belum ada portofolio ditambahkan.</div>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-950">
        <div class="container mx-auto px-6 max-w-4xl">
            <h2 class="text-4xl font-bold text-center mb-16 text-gray-100 animate-on-scroll">Hubungi <span class="text-red-500">Saya</span></h2>
            <div class="bg-gray-900 p-10 rounded-lg shadow-lg animate-on-scroll">
                <p class="text-gray-300 text-center mb-8">
                    Tertarik untuk bekerja sama atau hanya ingin menyapa? Jangan ragu untuk menghubungi saya!
                </p>
                <form class="space-y-6">
                    <div>
                        <label for="name" class="block text-gray-200 text-sm font-semibold mb-2">Nama Anda</label>
                        <input type="text" id="name" name="name" class="w-full p-3 rounded-md bg-gray-800 border border-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Masukkan nama lengkap Anda">
                    </div>
                    <div>
                        <label for="email" class="block text-gray-200 text-sm font-semibold mb-2">Email Anda</label>
                        <input type="email" id="email" name="email" class="w-full p-3 rounded-md bg-gray-800 border border-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Masukkan alamat email Anda">
                    </div>
                    <div>
                        <label for="message" class="block text-gray-200 text-sm font-semibold mb-2">Pesan Anda</label>
                        <textarea id="message" name="message" rows="5" class="w-full p-3 rounded-md bg-gray-800 border border-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Tulis pesan Anda di sini..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-red-600 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-red-700 transition duration-300 shadow-lg">Kirim Pesan</button>
                </form>
            </div>
            <div class="flex justify-center space-x-6 mt-12">
                <!-- LinkedIn -->
                <a href="https://www.linkedin.com/in/muhammad-ilyas-454a732a4" class="bg-gray-800 p-4 rounded-full shadow-lg hover:bg-red-600 hover:text-white transition duration-300 transform hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z" />
                    </svg>
                </a>
                <!-- Instagram -->
                <a href="https://www.instagram.com/dmswsss?igsh=MWd6NG9tN2t5enVhcg%3D%3D&utm_source=qr" target="_blank" rel="noopener noreferrer" class="bg-gray-800 p-4 rounded-full shadow-lg hover:bg-red-600 hover:text-white transition duration-300 transform hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.206.056 2.003.248 2.466.415a4.92 4.92 0 011.675 1.087 4.918 4.918 0 011.088 1.675c.167.463.359 1.26.415 2.466.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.056 1.206-.248 2.003-.415 2.466a4.918 4.918 0 01-1.087 1.675 4.918 4.918 0 01-1.675 1.088c-.463.167-1.26.359-2.466.415-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.206-.056-2.003-.248-2.466-.415a4.918 4.918 0 01-1.675-1.087 4.918 4.918 0 01-1.088-1.675c-.167-.463-.359-1.26-.415-2.466C2.175 15.747 2.163 15.367 2.163 12s.012-3.584.07-4.85c.056-1.206.248-2.003.415-2.466a4.92 4.92 0 011.087-1.675A4.92 4.92 0 015.41 2.648c.463-.167 1.26-.359 2.466-.415C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.737 0 8.332.013 7.052.072 5.773.13 4.787.308 4.005.583A6.875 6.875 0 00.583 4.005C.308 4.787.13 5.773.072 7.052.013 8.332 0 8.737 0 12s.013 3.668.072 4.948c.058 1.279.236 2.265.511 3.047a6.873 6.873 0 003.422 3.422c.782.275 1.768.453 3.047.511C8.332 23.987 8.737 24 12 24s3.668-.013 4.948-.072c1.279-.058 2.265-.236 3.047-.511a6.873 6.873 0 003.422-3.422c.275-.782.453-1.768.511-3.047.059-1.28.072-1.685.072-4.948s-.013-3.668-.072-4.948c-.058-1.279-.236-2.265-.511-3.047a6.875 6.875 0 00-3.422-3.422c-.782-.275-1.768-.453-3.047-.511C15.668.013 15.263 0 12 0z"/>
                        <path d="M12 5.838A6.162 6.162 0 105.838 12 6.169 6.169 0 0012 5.838zm0 10.162A3.999 3.999 0 118.001 12 4.004 4.004 0 0112 16z"/>
                        <circle cx="18.406" cy="5.594" r="1.44"/>
                    </svg>
                </a>
                </a>
                <!-- GitHub -->
                <a href="https://github.com/muhilys" class="bg-gray-800 p-4 rounded-full shadow-lg hover:bg-red-600 hover:text-white transition duration-300 transform hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 py-8 text-center text-gray-400 text-sm">
        <div class="container mx-auto px-6">
            <p>&copy; <?php echo date("Y"); ?> <?php echo $nama; ?>. All rights reserved.</p>
        </div>
    </footer>

    <!-- JavaScript untuk fungsionalitas seperti mobile menu toggle dan scroll effects -->
    <script>
        // Mobile menu toggle
        const btn = document.querySelector('button.mobile-menu-button');
        const menu = document.querySelector('.mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Highlight nav link saat scroll
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('#main-header a[href^="#"]');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop && pageYOffset < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });
            navLinks.forEach(link => {
                link.classList.remove('text-red-500', 'border-b-2', 'border-red-500');
                link.classList.add('text-gray-300');
                if (link.getAttribute('href').includes(current)) {
                    link.classList.add('text-red-500', 'border-b-2', 'border-red-500');
                    link.classList.remove('text-gray-300');
                }
            });
        });

        // Animate on scroll
        const animateOnScrollElements = document.querySelectorAll('.animate-on-scroll');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                } else {
                    entry.target.classList.remove('fade-in-up');
                }
            });
        }, { threshold: 0.1 });
        animateOnScrollElements.forEach(element => {
            observer.observe(element);
        });

        // CSS for fade-in-up
        const style = document.createElement('style');
        style.innerHTML = `
            .animate-on-scroll {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.6s ease-out, transform 0.6s ease-out;
            }
            .animate-on-scroll.fade-in-up {
                opacity: 1;
                transform: translateY(0);
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>