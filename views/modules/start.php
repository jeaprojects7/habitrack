<?php 
$base_dir = __DIR__ . '/modules';
$static_url = '/habitrack/views/Adminassets'; // Ensure this is the correct path

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HABITRACK</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Rajdhani:wght@600&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Rajdhani', sans-serif;
      background: url('/habitrack1/views/Adminassets/images/01.jpg') no-repeat center center / cover;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.7));
      z-index: 0;
    }

    .card {
      text-align: center;
      padding: 3rem 2.5rem;
      border: 1.5px solid #c8a84b;
      background: rgba(11, 30, 85, 0.55);
      backdrop-filter: blur(16px);
      width: min(420px, 90vw);
    }

    .card::before {
      content: '';
      display: block;
      border: 1px solid rgba(200,168,75,0.25);
      position: absolute;
      inset: 8px;
      pointer-events: none;
    }

    .card { position: relative; }

   
    h1 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 3rem;
      letter-spacing: 0.25em;
      color: #f0f4ff;
      margin-bottom: 2rem;
    }

    .btn {
      display: inline-block;
      padding: 0.75rem 3rem;
      background: #2244b0;
      border: 1px solid #5b9aff;
      color: #f0f4ff;
      font-family: 'Rajdhani', sans-serif;
      font-size: 1.1rem;
      font-weight: 600;
      letter-spacing: 0.3em;
      text-decoration: none;
      transition: background 0.2s;
    }

    .btn:hover { background: #3a6de1; }
  </style>
</head>
<body>

  <div class="card">
<img src="views/assets/images/jeaLogo.png"
     style="width:150px; height:150px; display:block; margin:0 auto;">

    <h1>HABITRACK</h1>
    <a class="btn" href="dashboard">START</a>
  </div>

</body>
</html>
