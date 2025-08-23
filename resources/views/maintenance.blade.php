<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Технические работы - {{ $site_name }}</title>
    <meta name="robots" content="noindex, nofollow">
    @vite(['resources/css/app.css'])
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .maintenance-container {
            text-align: center;
            color: white;
            max-width: 600px;
            padding: 2rem;
        }
        .maintenance-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        .maintenance-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .maintenance-description {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
        }
        .maintenance-contact {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .maintenance-contact h3 {
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }
        .contact-email {
            color: #ffd700;
            text-decoration: none;
            font-weight: 500;
        }
        .contact-email:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">🔧</div>
        
        <h1 class="maintenance-title">Технические работы</h1>
        
        <div class="maintenance-description">
            <p>Сайт {{ $site_name }} временно недоступен в связи с проведением технических работ.</p>
            <p>Мы улучшаем наш сервис, чтобы предоставить вам еще лучший опыт.</p>
            <p><strong>Пожалуйста, повторите попытку через некоторое время.</strong></p>
        </div>
        
        @if($contact_email)
        <div class="maintenance-contact">
            <h3>Связаться с нами</h3>
            <p>По вопросам срочных заказов обращайтесь:</p>
            <a href="mailto:{{ $contact_email }}" class="contact-email">{{ $contact_email }}</a>
        </div>
        @endif
        
        <div style="margin-top: 2rem; font-size: 0.9rem; opacity: 0.7;">
            @if($artist_name)
                <p>{{ $artist_name }} - Студия художественных работ</p>
            @endif
            <p>Благодарим за понимание!</p>
        </div>
    </div>
</body>
</html>