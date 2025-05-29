<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #ff0000;
        }

        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }



        .error-container {
            max-width: 600px;
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 10px;
            border: 1px solid #e5e5e5;
        }

        .error-illustration {
            font-size: 6rem;
            color: #f0f0f0;
            margin-bottom: 10px;
        }

        .error-icon {
            font-size: 4rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .error-title {
            font-size: 2rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 15px;
        }

        .error-message {
            font-size: 1rem;
            color: #555;
            margin-bottom: 25px;
        }

        .suggestions {
            background: #fff7f7;
            border: 1px solid #ffdddd;
            border-radius: 10px;
            padding: 20px;
            text-align: left;
        }

        .suggestions h5 {
            color: var(--primary);
            font-size: 1.1rem;
            margin-bottom: 12px;
        }

        .suggestions ul {
            padding-left: 20px;
        }

        .suggestions li {
            color: #6c757d;
            margin-bottom: 6px;
        }

        .btn-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .back-btn,
        .home-btn {
            background: var(--primary);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
        }

        .back-btn:hover,
        .home-btn:hover {
            background: #cc0000;
            text-decoration: none;
            color: white;
        }

        @media (max-width: 576px) {
            .error-container {
                margin: 20px;
                padding: 25px;
            }

            .error-illustration {
                font-size: 4rem;
            }

            .error-icon {
                font-size: 3rem;
            }

            .error-title {
                font-size: 1.5rem;
            }

            .error-message {
                font-size: 0.9rem;
            }

            .btn-container {
                flex-direction: column;
                align-items: center;
            }

            .back-btn,
            .home-btn {
                width: 100%;
                max-width: 220px;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        {{-- <div class="error-illustration">
            <i class="fas fa-search"></i>
        </div> --}}
        <i class="fas fa-exclamation-triangle error-icon"></i>
        <h1 class="error-title">404 - Page Not Found</h1>
        <p class="error-message">
            Oops! The page you're trying to reach doesn't exist or might have been moved.
            Let’s help you find your way back.
        </p>

        <div class="suggestions">
            <h5><i class="fas fa-lightbulb me-2"></i>Here are some tips:</h5>
            <ul>
                <li>Double-check the URL for typos</li>
                <li>Try using the back button</li>
                <li>Contact our support team if the issue persists</li>
            </ul>
        </div>

        <div class="btn-container">
            <a href="javascript:history.back()" class="back-btn">
                <i class="fas fa-arrow-left me-2"></i>Go Back
            </a>
            {{-- <a href="{{ url('/') }}" class="home-btn">
                <i class="fas fa-home me-2"></i>Go Home
            </a> --}}
        </div>
    </div>
</body>

</html>
