<!DOCTYPE html>
<html>
<head>
  <title>hrkacang</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      height: 90vh;
      margin: 0;
      padding: 0;
    }
    
    img {
      max-width: 100%;
      max-height: 100%;
      cursor: pointer;
    }
    
    .counter {
      font-size: 18px;
      margin-bottom: 20px;
    }

    .footer {
      background-color: #99CDFF;
      width: 100%;
      height: 10vh;
      position: fixed;
      bottom: 0;
      left: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px 0;
    }

    .footer a {
      text-decoration: none;
      color: #000;
      font-weight: bold;
      font-size: 20px;
      margin: 0 20px;
    }
  </style>
  
  <script>
    var counter = <?php echo getCounterFromDatabase(); ?>;
    var counterplus;
    var currentImageIndex = 0;
    var images = [
      "https://media.discordapp.net/attachments/645626727183155223/1125047892516802600/hrkacang1.png",
      "https://media.discordapp.net/attachments/645626727183155223/1125047892776865854/hrkacang2.png",
      "https://media.discordapp.net/attachments/645626727183155223/1125047892990767165/hrkacang3.png"
    ];
    
    function toggleImage() {
      var image = document.getElementById("image");
      var counterElement = document.getElementById("counter");
      
      currentImageIndex = (currentImageIndex + 1) % images.length;
      image.src = images[currentImageIndex];
      
      if (currentImageIndex === 2) {
        counter++;
        counterplus = counter;
        updateCounterInDatabase(counter);
      }
      
      counterElement.textContent = "hrkacang counter: " + counter;
    }
    
    function updateCounterInDatabase(counter) {
      var countergap = counter - counterplus;
      if (countergap === 0){
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              // Do something after updating counter in the database
            }
          };
          console.log("Nilai counter diperbarui di server.");
          xhr.send("counter=" + counter);
      }
      else {
          console.log("Nilai counter tidak valid.");
      }
    }
    
    function setLightMode() {
      document.body.style.backgroundColor = "#FFFFFF";
      document.body.style.color = "#000000";
    }
    
    function setDarkMode() {
      document.body.style.backgroundColor = "#000000";
      document.body.style.color = "#FFFFFF";
    }
    
    window.onload = function() {
      var counterElement = document.getElementById("counter");
      counterElement.textContent = "hrkacang counter: " + counter;
      
      // Set initial image size based on screen size
      setInitialImageSize();
      
      // Update image size on window resize
      window.addEventListener('resize', setInitialImageSize);
    }
    
    function setInitialImageSize() {
      var image = document.getElementById("image");
      var maxWidth = window.innerWidth;
      var maxHeight= window.innerHeight * 0.7; // Menggunakan 80% tinggi layar
      
      image.style.maxWidth = maxWidth + 'px';
      image.style.maxHeight = maxHeight + 'px';
    }
  </script>
</head>
<body>
  <br>
  <div class="counter" id="counter">
    <?php
    $counter = isset($_POST['counter']) ? $_POST['counter'] : getCounterFromDatabase();
    echo "hrkacang counter: " . $counter;
    ?>
  </div>
  <img id="image" src="https://media.discordapp.net/attachments/645626727183155223/1125047892516802600/hrkacang1.png" alt="Gambar" onclick="toggleImage()">
  
  <!-- Bagian bawah halaman -->
  <div class="footer">
    <a href="https://www.youtube.com/c/farhanalharits" target="_blank">Youtube</a>
    <a href="https://trakteer.id/farhanalharits" target="_blank">Trakteer</a>
    <!-- Tombol Light Mode -->
    <a onclick="setLightMode()">Light Mode</a>
    <!-- Tombol Dark Mode -->
    <a onclick="setDarkMode()">Dark Mode</a>
  </div>
</body>
</html>


<?php
function getCounterFromDatabase() {
  // Koneksi ke database
  $host = 'host';
  $username = 'username';
  $password = 'password';
  $database = 'database';

  $conn = mysqli_connect($host, $username, $password, $database);

  // Periksa koneksi
  if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
  }

  // Query untuk mendapatkan nilai counter dari database
  $query = "SELECT counter FROM counters WHERE id = 1";
  $result = mysqli_query($conn, $query);

  // Periksa apakah query berhasil dieksekusi
  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $counter = $row['counter'];
  } else {
    $counter = 0;
  }

  // Tutup koneksi ke database
  mysqli_close($conn);

  return $counter;
}

if (isset($_POST['counter'])) {
  $counter = $_POST['counter'];

  // Koneksi ke database
  $host = 'host';
  $username = 'username';
  $password = 'password';
  $database = 'database';

  $conn = mysqli_connect($host, $username, $password, $database);

  // Periksa koneksi
  if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
  }

  // Query untuk memperbarui nilai counter di database
  $query = "UPDATE counters SET counter = $counter WHERE id = 1";
  $result = mysqli_query($conn, $query);

  // Periksa apakah query berhasil dieksekusi
  if (!$result) {
    die("Gagal memperbarui counter: " . mysqli_error($conn));
  }

  // Tutup koneksi ke database
  mysqli_close($conn);
}
?>