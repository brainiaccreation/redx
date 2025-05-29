<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Denied</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
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

        .error-icon {
            font-size: 4rem;
            color: #ff0000;
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

        .back-btn {
            background: #ff0000;
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .back-btn:hover {
            background: #e60000;
        }

        @media (max-width: 576px) {
            .error-container {
                margin: 20px;
                padding: 20px;
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
        }
    </style>
</head>

<body>
    <div class="error-container">
        <i class="fas fa-ban error-icon"></i>
        <h1 class="error-title">403 - Access Denied</h1>
        <p class="error-message">Sorry, you do not have permission to access this page. Please contact an administrator
            if you believe this is an error.</p>
        <a href="javascript:history.back()" class="back-btn">
            <i class="fas fa-arrow-left me-2"></i>Go Back
        </a>
    </div>
</body>

</html>
