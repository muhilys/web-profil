<?php
require_once __DIR__ . '/../config.php';
session_start();

// Database connection
if ($conn->connect_error) {
  die("Koneksi database gagal: " . $conn->connect_error);
}

// Autentikasi admin
$login_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
      $_SESSION['admin_logged_in'] = true;
      header('Location: admin.php');
      exit;
    }
  }
  $login_error = 'Username atau password salah!';
  $stmt->close();
}

if (isset($_GET['logout'])) {
  session_destroy();
  header('Location: admin.php');
  exit;
}

$is_logged_in = $_SESSION['admin_logged_in'] ?? false;
$crud_message = '';
$edit_data = null;

if ($is_logged_in) {
  // Tambah data
  if (isset($_POST['add'])) {
    $id = uniqid();
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $project_link = $_POST['project_link'] ?? '';
    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
      $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
      $filename = $id . '.' . strtolower($ext);
      $target = __DIR__ . '/uploads/' . $filename;
      if (!is_dir(__DIR__ . '/uploads')) mkdir(__DIR__ . '/uploads', 0777, true);
      move_uploaded_file($_FILES['image']['tmp_name'], $target);
      $image_url = 'uploads/' . $filename;
    }
    $stmt = $conn->prepare("INSERT INTO portfolio (id, title, description, image_url, project_link) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $id, $_POST['title'], $_POST['desc'], $_POST['image'], $_POST['link']);
    $stmt->execute();
    $stmt->close();
    $crud_message = "Data berhasil ditambahkan!";
  }

  // Update data
  if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $project_link = $_POST['project_link'] ?? '';
    $image_url = $_POST['old_image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
      $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
      $filename = $id . '.' . strtolower($ext);
      $target = __DIR__ . '/uploads/' . $filename;
      if (!is_dir(__DIR__ . '/uploads')) mkdir(__DIR__ . '/uploads', 0777, true);
      move_uploaded_file($_FILES['image']['tmp_name'], $target);
      $image_url = 'uploads/' . $filename;
    }
    $stmt = $conn->prepare("UPDATE portfolio SET title = ?, description = ?, image_url = ?, project_link = ? WHERE id = ?");
    $stmt->bind_param("sssss", $_POST['title'], $_POST['desc'], $_POST['image'], $_POST['link'], $_POST['id']);
    $stmt->execute();
    $stmt->close();
    $crud_message = "Data berhasil diupdate!";
  }

  // Delete data
  if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM portfolio WHERE id = ?");
    $stmt->bind_param("s", $_GET['delete']);
    $stmt->execute();
    $stmt->close();
    $crud_message = "Data berhasil dihapus!";
  }

  // Edit data
  if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM portfolio WHERE id = ?");
    $stmt->bind_param("s", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_data = $result->fetch_assoc();
    $stmt->close();
  }

  // Load all data
  $portfolio = [];
  $result = $conn->query("SELECT * FROM portfolio ORDER BY id DESC");
  while ($row = $result->fetch_assoc()) {
    $portfolio[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Muhammad Ilyas - Admin Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-950 text-gray-100 font-[Poppins]">
  <nav class="bg-transparent fixed w-full z-50 py-4">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
      <a href="#" class="text-red-500 font-extrabold text-2xl">Muhammad Ilyas</a>
      <div class="hidden md:flex space-x-6">
        <a href="../index.php" class="text-gray-300 hover:text-red-400">Home</a>
      </div>
      <?php if ($is_logged_in): ?>
        <a href="?logout=1" class="text-red-500 hover:text-red-600 font-semibold">Logout</a>
      <?php else: ?>
        <a href="admin.php" class="text-red-500 hover:text-red-600 font-semibold">Admin Login</a>
      <?php endif; ?>
    </div>
  </nav>

  <div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-2xl mt-32">
      <?php if ($is_logged_in): ?>
        <div class="bg-green-900 text-green-200 p-4 rounded-lg shadow-lg text-center mb-4">
          <h2 class="text-2xl font-bold mb-2">Selamat datang, Admin!</h2>
          <p>Kelola data portofolio di bawah ini.</p>
        </div>
        <?php if ($crud_message): ?>
          <div class="bg-blue-900 text-blue-200 p-2 rounded mb-4 text-center"><?= htmlspecialchars($crud_message) ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-lg mb-6">
          <h3 class="text-xl font-bold mb-4"><?= $edit_data ? 'Edit' : 'Tambah' ?> Portofolio</h3>
          <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">
          <input type="hidden" name="old_image" value="<?= htmlspecialchars($edit_data['image_url'] ?? '') ?>">
          <div class="mb-3">
            <label for="title" class="block mb-1">Judul</label>
            <input type="text" name="title" id="title" class="w-full px-3 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700" required value="<?= htmlspecialchars($edit_data['title'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="desc" class="block mb-1">Deskripsi</label>
            <textarea name="desc" id="desc" rows="2" class="w-full px-3 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700" required><?= htmlspecialchars($edit_data['description'] ?? '') ?></textarea>
          </div>
          <div class="mb-3">
            <label for="project_link" class="block mb-1">Link Proyek</label>
            <input type="url" name="project_link" id="project_link" class="w-full px-3 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700" placeholder="https://contoh.com" value="<?= htmlspecialchars($edit_data['project_link'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="image" class="block mb-1">Upload Gambar</label>
            <input type="file" name="image" id="image" accept="image/*" class="w-full px-3 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700">
            <?php if (!empty($edit_data['image_url'])): ?>
              <div class="mt-2">
                <img src="<?= htmlspecialchars($edit_data['image_url']) ?>" alt="Preview" class="w-32 h-20 object-cover rounded border border-gray-700">
              </div>
            <?php endif; ?>
          </div>
          <button type="submit" name="<?= $edit_data ? 'update' : 'add' ?>" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded"><?= $edit_data ? 'Update' : 'Tambah' ?></button>
          <?php if ($edit_data): ?>
            <a href="admin.php" class="block text-center mt-2 text-gray-400 hover:text-red-400">Batal Edit</a>
          <?php endif; ?>
        </form>

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
          <h3 class="text-xl font-bold mb-4">Daftar Portofolio</h3>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead>
                <tr class="bg-gray-900">
                  <th class="py-2 px-3">Gambar</th>
                  <th class="py-2 px-3">Judul</th>
                  <th class="py-2 px-3">Deskripsi</th>
                  <th class="py-2 px-3">Proyek</th>
                  <th class="py-2 px-3">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($portfolio as $item): ?>
                  <tr class="border-b border-gray-700">
                    <td class="py-2 px-3"><img src="<?= htmlspecialchars($item['image_url']) ?>" alt="" class="w-20 h-12 object-cover rounded"></td>
                    <td class="py-2 px-3"><?= htmlspecialchars($item['title']) ?></td>
                    <td class="py-2 px-3"><?= htmlspecialchars($item['description']) ?></td>
                    <td class="py-2 px-3">
                      <?php if (!empty($item['project_link'])): ?>
                        <a href="<?= htmlspecialchars($item['project_link']) ?>" target="_blank" class="text-green-400 hover:underline">Lihat Proyek</a>
                      <?php else: ?>
                        <span class="text-gray-400">-</span>
                      <?php endif; ?>
                    </td>
                    <td class="py-2 px-3">
                      <a href="?edit=<?= $item['id'] ?>" class="text-blue-400 hover:underline mr-2">Edit</a>
                      <a href="?delete=<?= $item['id'] ?>" class="text-red-400 hover:underline" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <?php if (empty($portfolio)): ?>
                  <tr><td colspan="5" class="text-center py-4 text-gray-400">Belum ada data.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php else: ?>
        <form method="post" class="bg-gray-800 p-6 rounded-lg shadow-lg">
          <h2 class="text-2xl font-bold mb-4 text-center">Admin Login</h2>
          <?php if ($login_error): ?>
            <div class="bg-red-700 text-red-200 p-2 rounded mb-4 text-center"><?= htmlspecialchars($login_error) ?></div>
          <?php endif; ?>
          <div class="mb-4">
            <label for="username" class="block mb-1">Username</label>
            <input type="text" name="username" id="username" class="w-full px-3 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700" required>
          </div>
          <div class="mb-6">
            <label for="password" class="block mb-1">Password</label>
            <input type="password" name="password" id="password" class="w-full px-3 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700" required>
          </div>
          <button type="submit" name="login" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded">Login</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>