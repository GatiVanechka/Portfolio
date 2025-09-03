<?php include 'header.php'; 
require_once 'config/db.php';?>

<section class="delivery-section py-5">
    <div class="container">
        <h1 class="text-center mb-5">Доставка и оплата</h1>
        
        <div class="row align-items-center">
            <!-- Текст (70% ширины) -->
            <div class="col-lg-7">
                <div class="delivery-text pe-lg-5">
                    <h3 class="mb-4">У нас точно бесплатная доставка!</h3>
                    
                    <p class="mb-4">Оплата осуществляется картой на сайте, если товар вам не подойдет его можно вернуть в течении 14 дней.</p>
                    
                    <h4 class="mb-3">Способы доставки</h4>
                    
                    <h5 class="mt-4 mb-3">Курьерская доставка:</h5>
                    <ul class="delivery-list">
                        <li>Доставка осуществляется на следующий день после заказа при оформлении до 18:00 в будние дни</li>
                        <li>Курьерская служба работает с 9-00 до 22-00</li>
                        <li>Сроки доставки - 2-10 дней, в зависимости от города</li>
                    </ul>
                </div>
            </div>
            
            <!-- Изображение (30% ширины) -->
            <div class="col-lg-5 mt-4 mt-lg-0">
                <div class="delivery-image">
                    <img src="images/delivery/1.png" alt="Доставка" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>