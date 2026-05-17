<?php


require_once __DIR__ . '/../../controllers/edit-property.controller.php';

$properties = PropertyController::ctrGetProperties();

?>

<?php foreach ($properties as $item): ?>

<div class="group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500">

    <div class="relative">

        <img src="/habitrack<?php echo $item['imagePath']; ?>" alt="">

        <div class="absolute top-4 end-4">
            <a href="javascript:void(0)"
               class="btn btn-icon bg-white dark:bg-slate-900 shadow rounded-full text-slate-100 dark:text-slate-700">

                <i class="mdi mdi-heart text-[20px]"></i>

            </a>
        </div>

    </div>

    <div class="p-6">

        <div class="pb-6">

            <a href="property-detail.php?id=<?php echo $item['propertyID']; ?>"
               class="text-lg hover:text-green-600 font-medium ease-in-out duration-500">

                <?php echo $item['propertyName']; ?>

            </a>

        </div>

        <ul class="py-6 border-y border-slate-100 dark:border-gray-800 flex items-center list-none">

            <li class="flex items-center me-4">
                <i class="mdi mdi-arrow-expand-all text-2xl me-2 text-green-600"></i>

                <span>
                    <?php echo $item['propertyCity']; ?> City
                </span>
            </li>

            <li class="flex items-center me-4">
                <i class="mdi mdi-bed text-2xl me-2 text-green-600"></i>

                <span>
                    <?php echo $item['propertyBrgy']; ?> Brgy
                </span>
            </li>

            <li class="flex items-center">
                <i class="mdi mdi-shower text-2xl me-2 text-green-600"></i>

                <span>
                    <?php echo $item['propertyLotArea']; ?> sqm
                </span>
            </li>

        </ul>

        <ul class="pt-6 flex justify-between items-center list-none">

            <li>

                <span class="text-slate-400">Price</span>

                <p class="text-lg font-medium">
                    ₱<?php echo number_format($item['propertyPrice']); ?>
                </p>

            </li>

        </ul>

    </div>

</div>

<?php endforeach; ?>