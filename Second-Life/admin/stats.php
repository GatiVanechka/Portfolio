<div class="card shadow-sm mb-4">
    <div class="card-header bg-orange text-white">
        <h5 class="mb-0 text-white"><i class="bi bi-graph-up"></i> Общая статистика</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            $stats = [
                'users' => $conn->query("SELECT COUNT(*) FROM users")->fetchColumn(),
                'animals' => $conn->query("SELECT COUNT(*) FROM animals")->fetchColumn(),
                'donations' => $conn->query("SELECT COUNT(*) FROM donations")->fetchColumn(),
                'meetings' => $conn->query("SELECT COUNT(*) FROM meetings")->fetchColumn()
            ];
            
            $totalDonations = $conn->query("SELECT SUM(amount) FROM donations")->fetchColumn();
            ?>
            
            <div class="col-md-3 mb-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h3><?= $stats['users'] ?></h3>
                        <p class="mb-0">Пользователей</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h3><?= $stats['animals'] ?></h3>
                        <p class="mb-0">Животных</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h3><?= $stats['donations'] ?></h3>
                        <p class="mb-0">Пожертвований</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h3><?= number_format($totalDonations, 0, '', ' ') ?> ₽</h3>
                        <p class="mb-0">Всего собрано</p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>