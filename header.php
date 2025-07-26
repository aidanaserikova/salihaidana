<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Salih&Aidana</title>
    <link rel="icon" type="image/png" href="images/pink.gif">
    <link type="text/css" rel="stylesheet" href="./index_files/default.css">
    <script type="text/javascript" src="./index_files/jquery.min.js"></script>
    <script type="text/javascript" src="./index_files/jscex.min.js"></script>
    <script type="text/javascript" src="./index_files/jscex-parser.js"></script>
    <script type="text/javascript" src="./index_files/jscex-jit.js"></script>
    <script type="text/javascript" src="./index_files/jscex-builderbase.min.js"></script>
    <script type="text/javascript" src="./index_files/jscex-async.min.js"></script>
    <script type="text/javascript" src="./index_files/jscex-async-powerpack.min.js"></script>
    <script type="text/javascript" src="./index_files/functions.js" charset="utf-8"></script>
    <script type="text/javascript" src="./index_files/love.js" charset="utf-8"></script>
    <script type="text/javascript" src="./config.js"></script>
    <style type="text/css">
    header {
            background-color: #fad0c4;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 20px;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #ff6b81;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .logo span {
            margin: 0 5px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 30px;
        }
        
        nav ul li a {
            text-decoration: none;
            color: #555;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
            padding: 5px 0;
        }
        
        nav ul li a:hover {
            color: #ff6b81;
        }
        
        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(to right, #ff6b81, #a2d5f2);
            transition: width 0.3s;
        }
        
        nav ul li a:hover::after {
            width: 100%;
        }

          @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                text-align: center;
            }
            
            nav ul {
                margin-top: 20px;
                justify-content: center;
            }
            
            nav ul li {
                margin: 0 10px;
            }
            
            .about-content {
                flex-direction: column;
            }
            
            section {
                padding: 30px;
            } 
        }
        .STYLE1 {
            color: #666666
        }
    </style>
</head>
<body>
    <img src="https://ajlovechina.github.io/loveBalloon/static/music.png" style="position: fixed;z-index: 10001;top:100px;right:10px;" onclick="let m = document.querySelector('.song-audio-autoplay'); if (m.paused ) {m.play(); this.className = 'rotateImages'} else {m.pause(); this.className = ''}">
<audio class="song-audio-autoplay" controls loop style="display: none;visibility: hidden">
    <source src="./index_files/music.mp3" type="audio/mp3"/>
</audio>
   <header>
        <div class="container header-container">
            <a href="./main.php" class="logo">
                <span class="heart">❤</span><span class="heart">❤ </span><span class="heart">❤</span>
            </a>
            <nav>
                <ul>
                    <li><a href="./galeri.php">Galeri</a></li>
                    <li><a href="./anlasma.php">Anlaşma</a></li>
                    <li><a href="./istek.php">İstek listesi</a></li>
                    <li><a href="./hedef.php">Hedef</a></li>
                </ul>
            </nav>
        </div>
    </header>