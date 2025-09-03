<footer style="background-color: #fdf5e6; position: relative;" class="">

  <div style="background-color: rgb(218,118,67); height:20px" class="text-center text-white py-1 mb-1 shadow p-3">
  </div>

  <div class="container mt-4">
    <div class="row justify-content-between align-items-start">
      <!-- Контакты -->
      <div class="col-lg-4 mb-4">
        <h4 class="fw-bold mb-3">Контакты</h4>
        <p><i class="bi bi-telephone-fill me-2"></i>+7(930)-270-28-37</p>
        <p><i class="bi bi-envelope-fill me-2"></i>second-life@mail.ru</p>
        <p><i class="bi bi-geo-alt-fill me-2"></i>пр. Ленина 8</p>
      </div>

      <!-- Карта -->
      <div class="col-lg-4 mb-4">
        <h4 class="fw-bold mb-3">Мы на карте</h4>
        <div class="ratio ratio-4x3 rounded shadow-sm overflow-hidden">
          <iframe 
            id="yandexMap"
            src="https://yandex.ru/map-widget/v1/?ll=43.913431%2C56.335736&z=16&pt=43.913431,56.335736,pm2rdm"
            allowfullscreen
            frameborder="0"
            loading="lazy"
          ></iframe>
        </div>
      </div>

      <!-- Полезные ссылки -->
      <div class="col-lg-4 mb-4">
        <h5 class="mb-3 fw-bold text-end">Полезные ссылки</h5>
        <ul class="list-unstyled text-end">
          <li><a href="documentation.php" class="text-decoration-none text-dark">Документация</a></li>
          <li><a href="reports.php" class="text-decoration-none text-dark">Финансовая отчётность</a></li>
          <li><a href="policy.php" class="text-decoration-none text-dark">Политика конфиденциальности</a></li>
          <li><a href="https://t.me/gativanechka" class="text-decoration-none text-dark">Разработка сайта</a></li>
        </ul>
      </div>
    </div>
  </div>
  <!-- Добавляем обертку для картинки перед основным содержимым футера -->
<!-- Картинка собаки -->
<div style="position: absolute; bottom: 100%; pointer-events: none;">
    <img 
        src="images/footer/dog.png" 
        alt="" 
        style="max-width: 400px; height: auto; transform: translateY(219%); z-index: 10;">
</div>
  <!-- Коричневая полоса -->
  <div style="background-color: rgb(218,118,67);" class="text-center text-white py-2 mt-4">
    © Вторая жизнь
  </div>
</footer>

<script>
// Инициализация карты после загрузки страницы
document.addEventListener('DOMContentLoaded', function() {
    const mapIframe = document.getElementById('yandexMap');
    if(mapIframe) {
        // Перезагружаем карту для корректного отображения
        const src = mapIframe.src;
        mapIframe.src = '';
        setTimeout(() => { mapIframe.src = src; }, 100);
    }
});
</script>