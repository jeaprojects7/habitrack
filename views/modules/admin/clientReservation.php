<?php

require_once __DIR__ . "/../../../controllers/clientReservation.controller.php";

$status = $_GET['status'] ?? 'All';
$reservations = ClientReservationController::ctrGetReservations($status);

function htAdminReservationListE($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function htAdminReservationListMoney($value) {
    if ($value === null || $value === '') {
        return 'Not provided';
    }

    return 'PHP ' . number_format((float) $value, 2);
}
?>

<div
    id="main-area"
    class="fixed top-[90px] right-0 mb-10 overflow-y-auto px-6 transition-all duration-300"
    style="left:300px;bottom:0;z-index:20;"
>
    <div class="mb-5">
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-white"><?= htAdminReservationListE($status) ?> Reservations</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400">Click a reservation to view the client, property, prequalification, and financing details.</p>
    </div>

    <?php if (empty($reservations)): ?>
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-8 text-center">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">No reservations found</h2>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">There are no <?= htAdminReservationListE(strtolower($status)) ?> reservations.</p>
        </div>
    <?php endif; ?>

    <div class="grid lg:grid-cols-2 grid-cols-1 gap-5">
        <?php foreach ($reservations as $reservation): ?>
            <?php
                $reserveStatus = $reservation['reserveStatus'] ?? 'Pending';
                $prequalStatus = $reservation['prequalStatus'] ?? 'Pending';
                $reserveStatusColor = match ($reserveStatus) {
                    'Approved' => 'bg-green-600',
                    'Rejected' => 'bg-red-600',
                    'Archived' => 'bg-gray-500',
                    default => 'bg-yellow-500',
                };
                $prequalStatusColor = match ($prequalStatus) {
                    'Approved' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                    'Rejected' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                    default => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                };
            ?>

            <form method="post" action="index.php?route=clientReservationDetails" class="block">
                <input type="hidden" name="reservation_id" value="<?= htAdminReservationListE($reservation['reservationID']) ?>">

                <button type="submit" class="group w-full text-left bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <div class="p-4 flex justify-between items-start gap-4">
                        <div>
                            <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                                <?= htAdminReservationListE(trim(($reservation['clientFName'] ?? '') . ' ' . ($reservation['clientLName'] ?? '')) ?: 'Client') ?>
                            </h3>
                            <p class="text-sm text-slate-400">
                                <?= htAdminReservationListE($reservation['propertyName'] ?? $reservation['propertyID']) ?>
                            </p>
                        </div>

                        <span class="<?= $reserveStatusColor ?> text-white text-xs px-2.5 py-1 rounded-full whitespace-nowrap">
                            <?= htAdminReservationListE($reserveStatus) ?>
                        </span>
                    </div>

                    <div class="px-4 pb-4 text-sm text-slate-500">
                        <p class="line-clamp-1">
                            Property: <?= htAdminReservationListE($reservation['propertyType'] ?? '') ?>
                            <?= !empty($reservation['propertyCity']) || !empty($reservation['propertyBrgy']) ? ' - ' . htAdminReservationListE(trim(($reservation['propertyCity'] ?? '') . ', ' . ($reservation['propertyBrgy'] ?? ''), ', ')) : '' ?>
                        </p>
                        <p class="mt-1">
                            Price: <?= htAdminReservationListMoney($reservation['propertyPrice'] ?? null) ?>
                        </p>
                        <p class="mt-1">
                            Reserved: <?= htAdminReservationListE($reservation['reserveDate'] ?? 'Not recorded') ?>
                            <?= !empty($reservation['reserveTime']) ? ' at ' . htAdminReservationListE($reservation['reserveTime']) : '' ?>
                        </p>
                        <p class="mt-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium <?= $prequalStatusColor ?>">
                                Prequal: <?= htAdminReservationListE($prequalStatus) ?>
                            </span>
                        </p>
                    </div>
                </button>
            </form>
        <?php endforeach; ?>
    </div>
</div>
