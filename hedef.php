<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'conn.php';

// Добавление цели
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_goal'])) {
    $date = $_POST['timeline_date'];
    $title = $_POST['timeline_title'];
    $description = $_POST['timeline_description'];
    $progress = intval($_POST['progress_bar']);
    
    try {
        $sql = "INSERT INTO goals (timeline_date, timeline_title, timeline_description, progress_bar) 
                VALUES (:date, :title, :description, :progress)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':date' => $date,
            ':title' => $title,
            ':description' => $description,
            ':progress' => $progress
        ]);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}

// Удаление цели
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    try {
        $sql = "DELETE FROM goals WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "Ошибка удаления: " . $e->getMessage();
    }
}

// Обновление прогресса
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_progress'])) {
    $id = intval($_POST['id']);
    $progress = intval($_POST['progress']);
    
    try {
        $sql = "UPDATE goals SET progress_bar = :progress WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':progress' => $progress,
            ':id' => $id
        ]);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "Ошибка обновления: " . $e->getMessage();
    }
}

// Получение целей
try {
    $sql = "SELECT * FROM goals ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    $goals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка получения данных: " . $e->getMessage());
}
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
        
        /* Стили для целей */
        .purpose-hero {
            text-align: center;
            padding: 60px 0 40px;
        }
        
        .purpose-hero h1 {
            font-size: 48px;
            color: #ff6b81;
            margin-bottom: 20px;
        }
        
        .purpose-hero p {
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Таймлайн целей */
        .purpose-timeline {
            position: relative;
            padding: 40px 0;
            margin: 60px 0;
        }
        
        .purpose-timeline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #ff6b81, #a2d5f2);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 50px;
            width: 100%;
        }
        
        .timeline-item:nth-child(odd) {
            padding-right: 50%;
            text-align: right;
            padding-right: 70px;
        }
        
        .timeline-item:nth-child(even) {
            padding-left: 50%;
            text-align: left;
            padding-left: 70px;
        }
        
        .timeline-content {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: transform 0.3s;
        }
        
        .timeline-item:hover .timeline-content {
            transform: translateY(-5px);
        }
        
        .timeline-content::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: linear-gradient(to right, #ff6b81, #a2d5f2);
            border-radius: 50%;
            top: 30px;
        }
        
        .timeline-item:nth-child(odd) .timeline-content::before {
            right: -60px;
        }
        
        .timeline-item:nth-child(even) .timeline-content::before {
            left: -60px;
        }
        
        .timeline-date {
            display: inline-block;
            background: linear-gradient(to right, #ff6b81, #a2d5f2);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: bold;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .timeline-title {
            font-size: 22px;
            color: #ff6b81;
            margin-bottom: 15px;
        }
        
        .timeline-description {
            color: #555;
            margin-bottom: 10px;
        }
        
        .progress-container {
            width: 100%;
            height: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
            margin-top: 15px;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            background: linear-gradient(to right, #ff6b81, #a2d5f2);
            border-radius: 5px;
            transition: width 0.5s;
        }
        
        /* Формы */
        .add-goal-form {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 30px;
            margin: 40px auto;
            max-width: 600px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #ff6b81;
            font-weight: bold;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        
        .submit-btn {
            background: linear-gradient(to right, #ff6b81, #a2d5f2);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 107, 129, 0.4);
        }
        
        .delete-btn {
            background-color: #ff6b81;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        
        .delete-btn:hover {
            background-color: #ff4757;
        }
        
        .progress-form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .progress-input {
            width: 60px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .update-btn {
            background-color: #a2d5f2;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .update-btn:hover {
            background-color: #7fb8e0;
        }
        
        /* Адаптивность */
        @media (max-width: 768px) {
            .purpose-hero h1 {
                font-size: 36px;
            }
            
            .purpose-timeline::before {
                left: 30px;
            }
            
            .timeline-item:nth-child(odd),
            .timeline-item:nth-child(even) {
                padding: 0 0 0 70px;
                text-align: left;
            }
            
            .timeline-item:nth-child(odd) .timeline-content::before,
            .timeline-item:nth-child(even) .timeline-content::before {
                left: -60px;
            }
        }
    </style>

    <?php include 'header.php'; ?>

    <section class="purpose-hero">
        <div class="container">
            <h1>Ortak<span class="heart">Hedefimiz</span></h1>
            <p>Birlikte sevgi ve özveriyle ulaşmaya çalıştığımız hedefler</p>
        </div>
    </section>

    <!-- Форма добавления цели -->
    <section class="container">
        <form class="add-goal-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <h2 style="color: #ff6b81; text-align: center; margin-bottom: 20px;">Yeni Hedef Ekle</h2>
            <div class="form-group">
                <label for="timeline_date">Tarih:</label>
                <input type="text" id="timeline_date" name="timeline_date" required placeholder="Örnek: 26 Temmuz, 2025 - Devam ediyor">
            </div>
            <div class="form-group">
                <label for="timeline_title">Hedef Adı:</label>
                <input type="text" id="timeline_title" name="timeline_title" required placeholder="Örnek: Sabah sporu alışkanlığı">
            </div>
            <div class="form-group">
                <label for="timeline_description">Açıklama:</label>
                <textarea id="timeline_description" name="timeline_description" required placeholder="Hedef hakkında detaylı açıklama"></textarea>
            </div>
            <div class="form-group">
                <label for="progress_bar">İlerleme (%):</label>
                <input type="number" id="progress_bar" name="progress_bar" min="0" max="100" required value="0">
            </div>
            <button type="submit" class="submit-btn" name="add_goal">Hedef Ekle</button>
        </form>
    </section>

    <!-- Таймлайн целей -->
    <section class="container">
        <div class="purpose-timeline">
            <?php if (count($goals) > 0): ?>
                <?php 
                $counter = 0;
                foreach($goals as $row): 
                    $counter++;
                    $oddEven = $counter % 2 == 0 ? 'even' : 'odd';
                ?>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date"><?php echo htmlspecialchars($row["timeline_date"]); ?></div>
                        <h3 class="timeline-title"><?php echo htmlspecialchars($row["timeline_title"]); ?></h3>
                        <p class="timeline-description"><?php echo htmlspecialchars($row["timeline_description"]); ?></p>
                        <div class="progress-container">
                            <div class="progress-bar" style="width: <?php echo $row["progress_bar"]; ?>%"></div>
                        </div>
                        
                        <!-- Форма обновления прогресса -->
                        <form class="progress-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                            <input type="number" name="progress" min="0" max="100" value="<?php echo $row["progress_bar"]; ?>" class="progress-input">
                            <button type="submit" class="update-btn" name="update_progress">Güncelle</button>
                        </form>
                        
                        <!-- Кнопка удаления -->
                        <a href="?delete=<?php echo $row["id"]; ?>" class="delete-btn" onclick="return confirm('Bu hedefi silmek istediğinize emin misiniz?')">Sil</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; color: #ff6b81;">Henüz hedef eklenmemiş.</p>
            <?php endif; ?>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-bar');
            
            const animateProgressBars = () => {
                progressBars.forEach(bar => {
                    const width = bar.style.width || '0%';
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 100);
                });
            };
            
            animateProgressBars();
        });
    </script>

    <?php include 'footer.php'; ?>
