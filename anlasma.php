<?php
require_once 'header.php';
?>

<style>
    /* General Styles */
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
    
    /* Agreement Hero Section */
    .agreement-hero {
        text-align: center;
        padding: 60px 0 40px;
    }
    
    .agreement-hero h1 {
        font-size: 72px;
        color: #ff6b81;
        margin-bottom: 30px;
        text-shadow: 3px 3px 0 rgba(255, 255, 255, 0.7);
    }
    
    /* Agreement Photo Section */
    .agreement-photo {
        margin: 40px 0;
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }
    
    .agreement-photo img {
        width: 100%;
        height: 900px;
        object-fit: cover;
        display: block;
    }
    
    .agreement-date {
        position: absolute;
        bottom: 30px;
        left: 30px;
        background: linear-gradient(to right, #ff6b81, #a2d5f2);
        color: white;
        padding: 10px 25px;
        border-radius: 50px;
        font-size: 18px;
        font-weight: bold;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    /* Agreement Text Section */
    .agreement-text {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        padding: 50px;
        margin: 60px 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .agreement-text::before {
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
    
    .agreement-text::after {
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
    
    .agreement-text p {
        font-size: 18px;
        margin-bottom: 25px;
        line-height: 1.8;
    }
    
    .agreement-text p:first-child:first-letter {
        font-size: 60px;
        color: #ff6b81;
        float: left;
        line-height: 60px;
        padding-right: 10px;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .agreement-hero h1 {
            font-size: 48px;
        }
        
        .agreement-photo img {
            height: 350px;
        }
        
        .agreement-text {
            padding: 30px;
        }
    }
</style>

<!-- Agreement Hero -->
<section class="agreement-hero">
    <div class="container">
        <h1>Anlaşma</h1>
    </div>
</section>

<!-- Agreement Photo -->
<section class="container">
    <div class="agreement-photo">
        <img src="./images/anlasma.png" alt="Couple holding hands">
        <div class="agreement-date">22 Temmuz, 2025</div>
    </div>
</section>

<!-- Agreement Text -->
<section class="container">
    <div class="agreement-text">
        <p>Bu anlaşma Salih ile Aydana arasında yapılmıştır.</p>
        
        <p>Salih, her sabah uyandığında, öğleden sonra ve akşam Aydana'ya mesaj atacağına söz vermiştir.</p>
        
        <p>Eğer bu sözü bozarsa, Aydana'nın dilediği her isteği yerine getirmek zorundadır.</p>
    </div>
</section>

<?php
require_once 'footer.php';
?>