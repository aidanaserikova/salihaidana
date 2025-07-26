<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'conn.php';

// Обработка изменения статуса желания
if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    try {
        $stmt = $pdo->prepare("UPDATE wishlist SET is_checked = NOT is_checked WHERE checkbox_id = ?");
        $stmt->execute([$id]);
        header("Location: ".strtok($_SERVER['REQUEST_URI'], '?'));
        exit();
    } catch (PDOException $e) {
        die("Ошибка обновления: " . $e->getMessage());
    }
}

// Обработка удаления желания
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM wishlist WHERE checkbox_id = ?");
        $stmt->execute([$id]);
        header("Location: ".strtok($_SERVER['REQUEST_URI'], '?'));
        exit();
    } catch (PDOException $e) {
        die("Ошибка удаления: " . $e->getMessage());
    }
}

// Обработка добавления нового желания
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_wish'])) {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    
    if (!empty($title)) {
        try {
            $id = 'wish_' . uniqid();
            $stmt = $pdo->prepare("INSERT INTO wishlist (checkbox_id, wishlist_title, wishlist_description, is_checked) VALUES (?, ?, ?, FALSE)");
            $stmt->execute([$id, $title, $description]);
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        } catch (PDOException $e) {
            die("Ошибка добавления: " . $e->getMessage());
        }
    }
}

// Получение данных из базы
try {
    $stmt = $pdo->query("SELECT * FROM wishlist ORDER BY is_checked, checkbox_id");
    $wishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка получения данных: " . $e->getMessage());
}

require_once 'header.php';
?>

<style>
    * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .heart {
            color: #ff6b81;
        }
   
        
        /* Wish List Hero */
        .wishlist-hero {
            text-align: center;
            padding: 60px 0 40px;
        }
        
        .wishlist-hero h1 {
            font-size: 48px;
            color: #ff6b81;
            margin-bottom: 20px;
        }
        
        .wishlist-hero p {
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Wish List Section */
        .wishlist-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 40px;
            margin: 40px 0 60px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .wishlist-container::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background-color: #a2d5f2;
            border-radius: 50%;
            opacity: 0.1;
            z-index: -1;
        }
        
        .wishlist-container::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 150px;
            height: 150px;
            background-color: #ff9a9e;
            border-radius: 50%;
            opacity: 0.1;
            z-index: -1;
        }
        
        .wishlist {
            list-style: none;
            margin-top: 30px;
        }
        
        .wishlist-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s;
            position: relative;
        }
        
        .wishlist-item:last-child {
            border-bottom: none;
        }
        
        .wishlist-item:hover {
            background-color: rgba(255, 235, 238, 0.5);
            transform: translateX(10px);
        }
        
        .wishlist-checkbox {
            margin-right: 20px;
            appearance: none;
            width: 25px;
            height: 25px;
            border: 2px solid #a2d5f2;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .wishlist-checkbox:checked {
            background-color: #ff6b81;
            border-color: #ff6b81;
        }
        
        .wishlist-checkbox:checked::after {
            content: '✓';
            color: white;
            font-size: 14px;
        }
        
        .wishlist-content {
            flex: 1;
        }
        
        .wishlist-title {
            font-size: 20px;
            color: #ff6b81;
            margin-bottom: 5px;
        }
        
        .wishlist-description {
            color: #666;
            font-size: 15px;
        }
        
        .wishlist-priority {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 15px;
        }
        
        .priority-high {
            background-color: #ffebee;
            color: #ff6b81;
        }
        
        .priority-medium {
            background-color: #e3f2fd;
            color: #64b5f6;
        }
        
        .priority-low {
            background-color: #e8f5e9;
            color: #81c784;
        }
        
        .add-wish {
            margin-top: 30px;
            display: flex;
        }
        
        .add-wish input {
            flex: 1;
            padding: 15px 20px;
            border: 2px solid #ddd;
            border-radius: 50px 0 0 50px;
            font-size: 16px;
            outline: none;
        }
        
        .add-wish button {
            background: linear-gradient(to right, #ff6b81, #a2d5f2);
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 0 50px 50px 0;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .add-wish button:hover {
            opacity: 0.9;
        }
        
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                text-align: center;
            }
            
            nav ul {
                margin-top: 20px;
                justify-content: center;
                flex-wrap: wrap;
            }
            
            nav ul li {
                margin: 0 10px 10px;
            }
            
            .wishlist-hero h1 {
                font-size: 36px;
            }
            
            .wishlist-container {
                padding: 30px 20px;
            }
            
            .wishlist-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .wishlist-checkbox {
                margin-bottom: 15px;
            }
        }
    .wishlist-actions {
        display: flex;
        gap: 10px;
        margin-left: 15px;
    }
    
    .delete-btn {
        background: #ff6b81;
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .delete-btn:hover {
        background: #ff4757;
        transform: scale(1.1);
    }
</style>

<!-- Wish List Hero -->
<section class="wishlist-hero">
    <div class="container">
        <h1><span class="heart">İstek Listesi</span></h1>
        <p>Eğer Salih bu anlaşmayı bozarsa, Aydana'nın hazırladığı özel listedeki dileklerden birini yerine getirmekle yükümlüdür.
Aydana, bu listedeki herhangi bir dileği tereddütsüz seçme hakkına sahiptir.</p>
    </div>
</section>

<!-- Wish List Container -->
<section class="container">
    <div class="wishlist-container">
        <h2>Tüm dileklerin kalpten gerçek olsun<span class="heart">❤</span></h2>
        
        <ul class="wishlist">
            <?php foreach ($wishes as $wish): ?>
                <li class="wishlist-item" style="<?= $wish['is_checked'] ? 'opacity: 0.7;' : '' ?>">
                    <input type="checkbox" 
                           class="wishlist-checkbox" 
                           id="<?= htmlspecialchars($wish['checkbox_id']) ?>" 
                           <?= $wish['is_checked'] ? 'checked' : '' ?>
                           onclick="window.location.href='?toggle=<?= $wish['checkbox_id'] ?>'">
                    
                    <div class="wishlist-content">
                        <div class="wishlist-title"><?= htmlspecialchars($wish['wishlist_title']) ?></div>
                        <p class="wishlist-description"><?= htmlspecialchars($wish['wishlist_description']) ?></p>
                    </div>
                    
                    <div class="wishlist-actions">
                        <a href="?delete=<?= $wish['checkbox_id'] ?>" class="delete-btn" 
                           onclick="return confirm('Bu isteği silmek istediğinize emin misiniz?')">×</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        
        <!-- Add New Wish Form -->
        <form method="POST" class="add-wish">
            <input type="text" name="title" placeholder="İstek başlığı..." required>
            <input type="text" name="description" placeholder="Açıklama (opsiyonel)">
            <button type="submit" name="new_wish">Ekle <span class="heart">❤</span></button>
        </form>
    </div>
</section>

<?php
require_once 'footer.php';
?>