-- Создание таблицы пользователей
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    img VARCHAR(255) NOT NULL,
    gallery_date DATE NOT NULL,
    gallery_title VARCHAR(255) NOT NULL,
    gallery_description TEXT
);

CREATE TABLE goals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    timeline_date VARCHAR(100) NOT NULL,
    timeline_title VARCHAR(255) NOT NULL,
    timeline_description TEXT,
    progress_bar INT CHECK (progress_bar >= 0 AND progress_bar <= 100)
);

CREATE TABLE wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    checkbox_id VARCHAR(20) NOT NULL UNIQUE,
    wishlist_title VARCHAR(255) NOT NULL,
    wishlist_description TEXT,
    is_checked BOOLEAN DEFAULT FALSE
);

INSERT INTO users (username, password)
VALUES (
    'salihaidana',
    'taksim130625'
);
INSERT INTO gallery (img, gallery_date, gallery_title, gallery_description) VALUES
('images/230625.jpg', '2025-06-23', 'Sabah selfiesi', 'Salih, Aydana ve arkadaşını otogardan aldı. Gece boyunca birlikteydiler — Kız Kulesi manzaralı bir arabada. İstanbul’un sabahı, yorgun ama huzurlu uykularıyla onları karşıladı'),
('images/250625.jpg', '2025-06-25', 'Ekran görüntüsü', 'Ekran görüntüsü, görüntülü konuşma sırasında alındı'),
('images/270625.jpg', '2025-06-27', 'Pierre Loti', 'İlk randevu bir rüya gibiydi… Ve Salih Aidanaya İstanbul’un büyüleyici manzarasını gösterdin — her ışığı aşktan bahseden o güzel şehri.'),
('images/290625.jpg', '2025-06-29', 'Sıcak eller', 'Arabada el ele tutuşuyoruz, ve kalbim sıcacık oluyor… Sanki dünya bir an duruyor, sadece sen ve ben varız.'),
('images/030725.jpg', '2025-07-03', 'Tekirdağ', 'Tekirdağ’da deniz kenarında harika bir hafta sonu geçirdik. Sadece biz, dalgalar ve sıcak rüzgar… Gerçekten çok mutluyduk.'),
('images/060725.jpg', '2025-07-06', 'Camlica tepesi', 'Üsküdar’da, şehri yukarıdan görmek için harika bir yere çıktık. İstanbul, oradan bakınca bambaşka bir güzellikti.'),
('images/120725.jpg', '2025-07-12', 'Dyson', 'Salih, Aydana Dyson Airstrait hediye etti — sevgi, özen ve biraz da sihir bu hediyede saklıydı. Aydana çok mutlu oldu, gözleri sevinçle parlıyordu.'),
('images/240725.jpg', '2025-07-24', 'Papatya', 'Salih, Aydana papatyalar hediye etti. Aydana bu çiçekleri çok sever, çünkü papatya onun için güvenin ve özgürlüğün sembolüdür.'),
('images/250725.jpg', '2025-07-25', 'Kahvaltı', 'Büyülü bir gecenin ardından, sıcak çay, taze ekmekler ve birbirlerine bakan mutlu gözlerle geleneksel bir Türk kahvaltısının tadını çıkardılar.');

INSERT INTO goals (timeline_date, timeline_title, timeline_description, progress_bar) VALUES
('26 Temmuz, 2025 - Devam ediyor', 'Sabah sporu alışkanlığı', 'Her sabah 15 dakika yürüyüş yapmak ve güne zinde başlamak için hedef koyduk.', 10),
('01 Ağustos, 2025 - Devam ediyor', 'Birlikte kitap okumak', 'Her ay en az bir kitap okuyup birbirimizle paylaşmak istiyoruz.', 20),
('05 Ağustos, 2025 - Devam ediyor', 'Fotoğraf albümü oluşturmak', 'En güzel anılarımızdan bir dijital albüm hazırlamak için fotoğrafları düzenlemeye başladık.', 35),
('10 Ağustos, 2025 - Devam ediyor', 'Yeni şehir keşfetmek', 'Bu yaz yeni bir şehre küçük bir kaçamak planlıyoruz. Araştırmalar başladı!', 50),
('15 Ağustos, 2025 - Devam ediyor', 'Birlikte yemek yapmak', 'Haftada bir akşam birlikte farklı bir yemek tarifi deneyerek bağımızı güçlendirmek istiyoruz.', 70),
('20 Ağustos, 2025 - Devam ediyor', 'Sürpriz doğum günü planı', 'Özel bir günü unutulmaz hale getirmek için gizli hazırlıklara başlandı.', 90);

INSERT INTO wishlist (checkbox_id, wishlist_title, wishlist_description, is_checked) VALUES
('wish1', 'istek', 'Daha sonra yazacağım', FALSE);

