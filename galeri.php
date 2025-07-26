<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'conn.php';

// Обработка формы добавления
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_gallery'])) {
    try {
        // Проверяем и создаем папку для загрузок
        $uploadDir = __DIR__ . '/images/';
        
        // Создаем папку если не существует
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new Exception("Не удалось создать директорию для загрузок. Проверьте права доступа.");
            }
        }

        // Проверяем доступность папки для записи
        if (!is_writable($uploadDir)) {
            throw new Exception("Директория для загрузок недоступна для записи. Установите права 755.");
        }

        // Проверяем загруженный файл
        if (!isset($_FILES['gallery_image'])) {
            throw new Exception("Файл не был загружен.");
        }

        // Проверяем ошибки загрузки
        $fileError = $_FILES['gallery_image']['error'];
        if ($fileError !== UPLOAD_ERR_OK) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'Размер файла превышает upload_max_filesize',
                UPLOAD_ERR_FORM_SIZE => 'Размер файла превышает MAX_FILE_SIZE',
                UPLOAD_ERR_PARTIAL => 'Файл загружен только частично',
                UPLOAD_ERR_NO_FILE => 'Файл не был загружен',
                UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка',
                UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск',
                UPLOAD_ERR_EXTENSION => 'Загрузка остановлена расширением PHP'
            ];
            throw new Exception($errorMessages[$fileError] ?? "Неизвестная ошибка загрузки: $fileError");
        }

        // Проверяем тип файла
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['gallery_image']['tmp_name']);
        
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception("Разрешены только файлы JPG, PNG и GIF. Получен: $fileType");
        }

        // Проверяем размер файла (макс. 5MB)
        $maxSize = 5 * 1024 * 1024;
        if ($_FILES['gallery_image']['size'] > $maxSize) {
            throw new Exception("Размер файла превышает 5MB");
        }

        // Генерируем безопасное имя файла
        $originalName = basename($_FILES['gallery_image']['name']);
        $safeName = preg_replace('/[^a-zA-Z0-9\.\-_]/', '', $originalName);
        $fileName = uniqid() . '_' . $safeName;
        $targetPath = $uploadDir . $fileName;

        // Перемещаем загруженный файл
        if (!move_uploaded_file($_FILES['gallery_image']['tmp_name'], $targetPath)) {
            throw new Exception("Не удалось сохранить файл. Проверьте права доступа.");
        }

        // Сохраняем в БД относительный путь
        $relativePath = 'images/' . $fileName;
        
        $stmt = $pdo->prepare("INSERT INTO gallery (img, gallery_date, gallery_title, gallery_description) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $relativePath,
            $_POST['gallery_date'],
            $_POST['gallery_title'],
            $_POST['gallery_description']
        ]);
        
        // Перенаправляем с сообщением об успехе
        $_SESSION['success_message'] = "Изображение успешно загружено!";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();

    } catch (PDOException $e) {
        $error = "Ошибка базы данных: " . $e->getMessage();
    } catch (Exception $e) {
        $error = "Ошибка: " . $e->getMessage();
    }
}

// Получение данных из базы
try {
    $stmt = $pdo->query("SELECT * FROM gallery ORDER BY gallery_date DESC");
    $galleryItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка при получении данных: " . $e->getMessage());
}

require_once 'header.php';

// Выводим сообщения об ошибках/успехе
if (isset($error)) {
    echo '<div class="alert alert-error">' . htmlspecialchars($error) . '</div>';
}
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
    unset($_SESSION['success_message']);
}
?>

<!-- Остальная часть вашего HTML-кода -->
<style>
    body {
        background: rgba(255, 255, 255, 0.9);
        color: #333;
        line-height: 1.6;
    }
    
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .heart {
        color: #ff6b81;
    }
    
    .gallery-hero {
        text-align: center;
        padding: 80px 0 40px;
    }
    
    .gallery-hero h1 {
        font-size: 48px;
        color: #ff6b81;
        margin-bottom: 20px;
    }
    
    .gallery-container {
        padding: 40px 0;
        position: relative;
    }
    
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 40px;
    }
    
    .gallery-card {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .gallery-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }
    
    .gallery-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        display: block;
    }
    
    .gallery-details {
        padding: 25px;
        position: relative;
    }
    
    .gallery-date {
        position: absolute;
        top: -20px;
        right: 20px;
        background: linear-gradient(to right, #ff6b81, #a2d5f2);
        color: white;
        padding: 8px 15px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: bold;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .gallery-title {
        color: #ff6b81;
        font-size: 22px;
        margin-bottom: 15px;
        padding-right: 80px;
    }
    
    .gallery-description {
        color: #555;
        margin-bottom: 20px;
    }
    
    .gallery-decoration {
        position: absolute;
        font-size: 24px;
        color: #ff6b81;
        opacity: 0.3;
        z-index: -1;
    }
    .add-button {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: linear-gradient(to right, #ff6b81, #a2d5f2);
        color: white;
        border: none;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1001;
        align-items: center;
        justify-content: center;
    }
    
    .modal-content {
        background-color: white;
        padding: 30px;
        border-radius: 15px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .modal-title {
        color: #ff6b81;
        font-size: 24px;
        margin: 0;
    }
    
    .close-modal {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #666;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
    }
    
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
    }
    
    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }
    
    .submit-btn {
        background: linear-gradient(to right, #ff6b81, #a2d5f2);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
    }
    
    .file-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        border: 2px dashed #ddd;
        border-radius: 8px;
        margin-bottom: 20px;
        cursor: pointer;
    }
    
    .file-upload:hover {
        border-color: #a2d5f2;
    }
    
    .file-upload input {
        display: none;
    }
    
    .file-upload-label {
        color: #555;
        font-size: 16px;
        text-align: center;
    }
    
    .file-upload-icon {
        font-size: 40px;
        color: #a2d5f2;
        margin-bottom: 10px;
    }
    .decoration-1 { top: 10%; left: 5%; }
    .decoration-2 { top: 30%; right: 8%; }
    .decoration-3 { bottom: 15%; left: 7%; }
    .decoration-4 { bottom: 25%; right: 5%; }
    
    @media (max-width: 768px) {
        .gallery-hero h1 {
            font-size: 36px;
        }
        
        .gallery-grid {
            grid-template-columns: 1fr;
        }
        
        .gallery-image {
            height: 250px;
        }
    }
</style>

<section class="gallery-hero">
    <div class="container">
        <h1>Birlikteki <span class="heart">Anılarımız</span></h1>
    </div>
</section>

<section class="gallery-container">
    <div class="container">
        <div class="gallery-decoration decoration-1">❤</div>
        <div class="gallery-decoration decoration-2">❤</div>
        <div class="gallery-decoration decoration-3">❤</div>
        <div class="gallery-decoration decoration-4">❤</div>
        
        <div class="gallery-grid">
            <?php foreach ($galleryItems as $item): 
                // Проверяем существование файла
                $imagePath = $item['img'];
                $imageExists = file_exists($imagePath);
            ?>
                <div class="gallery-card">
                    <?php if ($imageExists): ?>
                        <img src="<?= htmlspecialchars($imagePath) ?>" 
                             alt="<?= htmlspecialchars($item['gallery_title']) ?>" 
                             class="gallery-image">
                    <?php else: ?>
                        <div class="image-placeholder" style="height:300px; background:#f0f0f0; display:flex; align-items:center; justify-content:center;">
                            <span>Resim bulunamadı: <?= htmlspecialchars(basename($imagePath)) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="gallery-details">
                        <div class="gallery-date">
                            <?= date('d F, Y', strtotime($item['gallery_date'])) ?>
                        </div>
                        <h3 class="gallery-title"><?= htmlspecialchars($item['gallery_title']) ?></h3>
                        <p class="gallery-description"><?= htmlspecialchars($item['gallery_description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<button class="add-button" id="openModal">+</button>

<div class="modal" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Yeni Anı Ekle</h3>
            <button class="close-modal" id="closeModal">&times;</button>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <div class="file-upload" id="fileUpload">
                <div class="file-upload-icon">📷</div>
                <span class="file-upload-label">Resim Yükle</span>
                <input type="file" id="galleryImage" name="gallery_image" accept="image/*">
                <input type="hidden" id="imagePath" name="image_path">
            </div>
            
            <div class="form-group">
                <label for="gallery_date">Tarih</label>
                <input type="date" id="gallery_date" name="gallery_date" required>
            </div>
            
            <div class="form-group">
                <label for="gallery_title">Başlık</label>
                <input type="text" id="gallery_title" name="gallery_title" required>
            </div>
            
            <div class="form-group">
                <label for="gallery_description">Açıklama</label>
                <textarea id="gallery_description" name="gallery_description" required></textarea>
            </div>
            
            <button type="submit" class="submit-btn" name="add_gallery">Kaydet</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('addModal');
    const openBtn = document.getElementById('openModal');
    const closeBtn = document.getElementById('closeModal');
    const fileUpload = document.getElementById('fileUpload');
    const fileInput = document.getElementById('galleryImage');
    const imagePath = document.getElementById('imagePath');
    
    openBtn.addEventListener('click', function() {
        modal.style.display = 'flex';
    });
    
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    fileUpload.addEventListener('click', function() {
        fileInput.click();
    });
    
    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            const fileName = fileInput.files[0].name;
            imagePath.value = 'images/' + fileName;
            fileUpload.querySelector('.file-upload-label').textContent = fileName;
        }
    });
});
</script>

<?php
require_once 'footer.php';
?>